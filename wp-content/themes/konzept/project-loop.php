<?php
$portfolio_page = get_option('flow_portfolio_page'); // empty on none

if(is_page_template('template-portfolio.php')){
	$exclude_include = get_post_meta($wp_query->queried_object_id, 'page_portfolio_tax_query_operator', true); // Operator for exclude box, false = exlude, true = include
	$flow_portfolio_home_exclude = get_post_meta($wp_query->queried_object_id, 'page_portfolio_exclude', true); // Array of portfolio categories slugs
	$orderby = get_post_meta($wp_query->queried_object_id, 'page_portfolio_orderby', true);
	$order = get_post_meta($wp_query->queried_object_id, 'page_portfolio_order', true);
	$shuffle_button = get_post_meta($wp_query->queried_object_id, 'page_portfolio_shuffle', true);
	$loop_through = get_post_meta($wp_query->get_queried_object_id(), 'page_portfolio_loop_through', true);
	$boundary_arrows = get_post_meta($wp_query->get_queried_object_id(), 'page_portfolio_boundary_arrows', true);
	$portfolio_mode = get_post_meta($wp_query->get_queried_object_id(), 'page_portfolio_mode', true);
}else if(is_singular('portfolio') && ($parent_page = get_post_meta($post->ID, 'portfolio_back_button', true)) && !empty($parent_page) && ($parent_page != 'none')){ // we assume that parent page is portfolio
	$exclude_include = get_post_meta($parent_page, 'page_portfolio_tax_query_operator', true);
	$flow_portfolio_home_exclude = get_post_meta($parent_page, 'page_portfolio_exclude', true);
	$orderby = get_post_meta($parent_page, 'page_portfolio_orderby', true);
	$order = get_post_meta($parent_page, 'page_portfolio_order', true);
	$shuffle_button = get_post_meta($parent_page, 'page_portfolio_shuffle', true);
	$loop_through = get_post_meta($parent_page, 'page_portfolio_loop_through', true);
	$boundary_arrows = get_post_meta($parent_page, 'page_portfolio_boundary_arrows', true);
	$portfolio_mode = get_post_meta($parent_page, 'page_portfolio_mode', true);
}else if( ! empty( $portfolio_page ) ) { // load main portfolio page if no parent page is set for this item
	$exclude_include = get_post_meta($portfolio_page, 'page_portfolio_tax_query_operator', true);
	$flow_portfolio_home_exclude = get_post_meta($portfolio_page, 'page_portfolio_exclude', true);
	$orderby = get_post_meta($portfolio_page, 'page_portfolio_orderby', true);
	$order = get_post_meta($portfolio_page, 'page_portfolio_order', true);
	$shuffle_button = get_post_meta($portfolio_page, 'page_portfolio_shuffle', true);
	$loop_through = get_post_meta($portfolio_page, 'page_portfolio_loop_through', true);
	$boundary_arrows = get_post_meta($portfolio_page, 'page_portfolio_boundary_arrows', true);
	$portfolio_mode = get_post_meta($portfolio_page, 'page_portfolio_mode', true);
}else{
	$exclude_include = false;
	$flow_portfolio_home_exclude = array();
	$orderby = 'date';
	$order = 'DESC';
	$shuffle_button = false;
	$loop_through = false;
	$boundary_arrows = false;
	$portfolio_mode = 'thumbnails';
}

if(empty($orderby)){
	$orderby = 'date';
}
if(empty($order)){
	$orderby = 'DESC';
}
if(empty($exclude_include)){
	$exclude_include = false; //exclude - default, include = true
}
if(empty($loop_through)){
	$loop_through = false; // false = Loop, true = Do not loop
}
if(empty($boundary_arrows)){
	$boundary_arrows = false;
}
?>
<div class="tn-grid-container <?php if($portfolio_mode != 'thumbnails'){ ?>text-grid<?php } ?> portfolio-container clearfix">
	<div id="container" class="variable-sizes clearfix">
		<?php
		// Set variables
		$i = -1;
		$projectsArray = array();
		
		// Projects Loop
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$post_per_page = -1;
		$do_not_show_stickies = 1; // 0 to show stickies
		
		$args = array(
			'post_type' => array('portfolio'),
			'orderby' => $orderby,
			'order' => $order,
			'paged' => $paged,
			'posts_per_page' => $post_per_page,
			'ignore_sticky_posts' => $do_not_show_stickies
		);
		
		// Exclude or Include categories
		if($exclude_include){ // include
			$exclude_include_sign = 'IN';
		}else{ // exclude - default
			$exclude_include_sign = 'NOT IN';
		}
		if(isset($flow_portfolio_home_exclude) && is_array($flow_portfolio_home_exclude)){
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'portfolio_category',
					'field' => 'slug',
					'terms' => $flow_portfolio_home_exclude,
					'operator' => $exclude_include_sign
				)
			);
		}

		$portfolio_query = new WP_Query($args);
		if($portfolio_query->have_posts()){
			while($portfolio_query->have_posts()){ $portfolio_query->the_post();
				
				// Thumbnail and its mouse over color
				$thumbnail_image = get_post_meta($post->ID, '300-160-image', true);
				$thumbnail_hover_color = get_post_meta($post->ID, 'thumbnail_hover_color', true);
				if($thumbnail_image or $thumbnail_hover_color){
				}else{
					$thumbnail_hover_color = '#888';
				}
				
				/*
				 * Get project categories
				 *
				 * 1. Get project categories display names (for thumbnails)
				 * 2. Get project categories slugs (for PHP/JS/CSS use)
				 */
				$project_categories = array();
				$project_categories = wp_get_object_terms($post->ID, "portfolio_category");

				$project_categories_ids_array = array();
				$project_categories_names_array = array();
				foreach($project_categories as $project_category_index => $project_category_object){
					$project_categories_ids_array[] = $project_category_object->term_id;
					$project_categories_names_array[] = $project_category_object->name;
				}
				$project_categories_ids = array();
				foreach($project_categories_ids_array as $k => $v){
					$project_categories_ids[$k] = 'portfolio-category-' . $v;
				}
				$project_categories_ids = implode(" ", $project_categories_ids);
				$project_categories_names = implode(", ", $project_categories_names_array);
					
				// Project title
				$thumb_title = get_the_title();
				
				// Project description
				$thumb_descr = '';
				if ( ! post_password_required() && ( $thumb_descr = get_post_meta( $post->ID, 'flow_post_description', true ) ) ) {
					$thumb_descr = apply_filters( 'the_content', $thumb_descr );
				}
				
				// Project meta data
				$tmpdddisplay = get_post_meta($post->ID, 'thumbnail_meta', true);
				if($tmpdddisplay == 1){
					$tmpdddisplay = 'tn-display-meta';
				}else{
					$tmpdddisplay = '';
				}
				$thumb_ourrole = get_post_meta($post->ID, 'portfolio_ourrole', true);
				$thumb_date = get_post_meta($post->ID, 'portfolio_date', true);
				$thumb_client = get_post_meta($post->ID, 'portfolio_client', true);
				$thumb_agency = get_post_meta($post->ID, 'portfolio_agency', true);
				
				// Thumbnail link
				$thumb_link = get_post_meta($post->ID, 'thumbnail_link', true);
				$thumb_link_target_blank = get_post_meta($post->ID, 'thumbnail_link_newwindow', true);
				if($thumb_link_target_blank == 1){
					$thumb_link_target_blank = 'target="_blank"';
				}else{
					$thumb_link_target_blank = '';
				}
				if ( ! $thumb_link ) {
					$i++;
				}
				
				// Project slides
				$display_cover_slide = get_post_meta($post->ID, 'display_cover_slide', true);
				if($display_cover_slide == 'yes' || empty($display_cover_slide)){
					$project_content = '<div class="project-slide project-slide-cover">
						<div class="cover-wrapper">
							<div class="cover-inner">
								<div class="project-meta clearfix">
									<div class="project-meta-col-1">
										<div class="project-meta-data project-date clearfix">
											<div class="project-meta-heading">' . __('Date', 'konzept') . '</div>
											<div class="project-meta-description project-exdate"></div>
										</div>
										<div class="project-meta-data project-client clearfix">
											<div class="project-meta-heading">' . __('Client', 'konzept') . '</div>
											<div class="project-meta-description project-exclient"></div>
										</div>
										<div class="project-meta-data project-agency clearfix">
											<div class="project-meta-heading">' . __('Agency', 'konzept') . '</div>
											<div class="project-meta-description project-exagency"></div>
										</div>
									</div>
									<div class="project-meta-col-2">
										<div class="project-meta-data project-ourrole clearfix">
											<div class="project-meta-heading">' . __('Our role', 'konzept') . '</div>
											<div class="project-meta-description project-exourrole"></div>
										</div>
									</div>
								</div>
								<h2 class="project-title"></h2>
								<div class="project-description"></div>
								<div class="clear"></div>
							</div>
						</div>
					</div>';
				}else{
					$project_content = '<div class="project-slide project-slide-cover project-slide-cover-empty">
						<div class="cover-wrapper">
							<div class="cover-inner"></div>
						</div>
					</div>';
				}
				$project_content .= apply_filters( 'the_content', get_the_content() );
				
				$element_text = '';
				if($portfolio_mode != 'thumbnails'){
					$element_text = 'element-text';
				}
				?>
				
				<div id="post-<?php the_ID(); ?>" <?php post_class( array( 'element', $element_text, $project_categories_ids, $tmpdddisplay ) ); ?> data-id="<?php if ( ! $thumb_link ) { echo esc_attr( $i ); } ?>">
					<?php 
					if ( $thumb_link ) {
						echo '<a class="thumbnail-link thumbnail-link-title" data-title="' . esc_attr( $thumb_title ) . '" href="' . esc_url( $thumb_link ) . '" ' . $thumb_link_target_blank . '>' . $thumb_title . '</a>'; 
					} else {
						echo '<a class="thumbnail-project-link thumbnail-link-title" data-title="' . esc_attr( $thumb_title ) . '" href="' . get_permalink() . '">' . $thumb_title . '</a>';
					} 
					?>
					<div class="thumbnail-meta-data-wrapper">
						<div class="symbol"><?php the_title(); ?></div>
						<div class="categories"><?php echo $project_categories_names; ?></div>
					</div>
					<div class="thumbnail-plus">+</div>
					<div style="background-color: <?php echo $thumbnail_hover_color ?>;" class="thumbnail-hover"></div>
					<?php if ( esc_url( $thumbnail_image ) ) { ?>
							<img class="project-img" src="<?php echo esc_url( $thumbnail_image ); ?>" alt="<?php echo esc_attr( $thumb_title ); ?>" />
					<?php } ?>
					<div class="project-thumbnail-background"></div>
				</div>
				<div class="thumbnail-separator">/</div>
					
				<?php
				if ( ! $thumb_link ) {
					$projectsArray[ $i ] = array( $thumb_title, $thumb_descr, $thumb_date, $thumb_client, $thumb_agency, $thumb_ourrole, $project_content, get_permalink( $post->ID ), $thumb_link, $project_categories_ids_array, $post->ID );
				} // Exclude external link thumbnails
			}
		}
		wp_reset_query();
		wp_reset_postdata();
		?>
	</div>
</div>

<script>
// Projects array
<?php echo 'var projectsArray = ' . json_encode( $projectsArray ) . ';'; ?>

// This or main portfolio page title and URL
<?php if ( is_page_template( 'template-portfolio.php' ) ) { ?>
var portfolio_page_title = jQuery('title').text();
var portfolio_page_url = location.href;
<?php }else{ ?>
<?php
$title = get_the_title( $portfolio_page ) . ' - ' . get_bloginfo( 'name' );
$site_description = get_bloginfo( 'description', 'display' );
$page_on_front = get_option( 'page_on_front' );
if ( $site_description && $page_on_front == $portfolio_page ) {
	$title = get_bloginfo( 'name' ) . " - " . "$site_description";
}
?>
var portfolio_page_title = <?php echo json_encode( $title ); ?>;
var portfolio_page_url = <?php echo json_encode( get_permalink( $portfolio_page ) ); ?>;
<?php } ?>

var boundary_arrows = <?php echo json_encode( $boundary_arrows ); ?>;
var loop_through = <?php echo json_encode( $loop_through ); ?>;
var global_current_id = false;
var project_url = '';
<?php if ( is_singular( 'portfolio' ) ) { ?>
	var project_url = <?php echo json_encode( esc_url( get_permalink( $post->ID ) ) ); ?>;
	<?php foreach ( $projectsArray as $k => $v ) { ?>
		<?php if ( $v[10] == $post->ID ) { ?>
			var global_current_id = <?php echo json_encode( $k ); ?>;
		<?php } ?>
	<?php } ?>
<?php } ?>
</script>