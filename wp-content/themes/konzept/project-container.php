<?php
/**
 * We load projects dynamically but for direct entrance it's advisable to print the content with PHP.
 * This improves search engine and sharing services compatibility.
 */
$title = $description = $slides = $sharing_url = $sharing_text = $date = $client = $agency = $ourrole = '';
$share_url = esc_url( get_home_url() );
$share_text = urlencode( get_bloginfo( 'name' ) );
if(is_singular('portfolio')){

	// TITLE
	$title = get_the_title();
	
	// DESCRIPTION
	$description = apply_filters('the_content', get_post_meta($post->ID, 'flow_post_description', true));
	
	// SLIDES
	$slides = apply_filters('the_content', get_post_field('post_content', $post->ID));
	
	$date = get_post_meta($post->ID, 'portfolio_date', true);
	$client = get_post_meta($post->ID, 'portfolio_client', true);
	$agency = get_post_meta($post->ID, 'portfolio_agency', true);
	$ourrole = get_post_meta($post->ID, 'portfolio_ourrole', true);
	
	// SHARE DATA
	$share_url = get_permalink( $post->ID );
	$share_text = urlencode( $title );
}

$portfolio_page = get_option( 'flow_portfolio_page' );
$back_link_class = '';
$back_link = home_url( '/' );

if ( is_singular( 'portfolio' ) && ( $portfolio_back_button = get_post_meta( $post->ID, 'portfolio_back_button', true ) ) && ! empty( $portfolio_back_button ) && $portfolio_back_button != 'none' ) {
	$back_link = get_permalink( $portfolio_back_button );
	if ( ! in_array( strtolower( get_post_meta( $portfolio_back_button, '_wp_page_template', true ) ), array( 'template-portfolio.php' ) ) ) {
		$back_link_class = 'back-link-external';
	}
} else if ( is_singular( 'portfolio' ) && ! empty( $portfolio_page ) ) {
	$back_link = get_permalink( $portfolio_page );
}
?>

<div class="portfolio-loadingbar">
	<div class="portfolio-loadinghr"></div>
	<div class="portfolio-indicator">0%</div>
</div>

<div class="flow_slideshow_box portfolio_box <?php if(is_singular('portfolio')){ echo 'portfolio_box-visible'; } ?>">

		<div class="project-arrow-left project-arrow-left-visible"></div>
		<div class="project-arrow-right project-arrow-right-visible"></div>
		
		<a class="portfolio-cancelclose <?php echo $back_link_class; ?>" href="<?php echo $back_link; ?>"></a>
		
		<div class="sharing-icons">
			<a href="https://twitter.com/share?url=<?php echo $share_url; ?>&amp;text=<?php echo $share_text; ?>" target="_blank" class="sharing-icons-twitter">
				<span class="sharing-icons-icon">t</span>
				<span class="sharing-icons-tooltip" data-tooltip="Twitter"></span>
			</a>
			<a href="http://www.facebook.com/sharer.php?u=<?php echo $share_url; ?>&amp;t=<?php echo $share_text; ?>" target="_blank" class="sharing-icons-facebook">
				<span class="sharing-icons-icon">f</span>
				<span class="sharing-icons-tooltip" data-tooltip="Facebook"></span>
			</a>
			<a href="https://plus.google.com/share?url=<?php echo $share_url; ?>" target="_blank" class="sharing-icons-googleplus">
				<span class="sharing-icons-icon">g</span>
				<span class="sharing-icons-tooltip" data-tooltip="Google+"></span>
			</a>
		</div>

		<div id="project-slides" class="flow_slideshow_init">
			<ul id="thelist" class="project-slides clearfix">
				<?php $display_cover_slide = get_post_meta($post->ID, 'display_cover_slide', true); ?>
				<?php if($display_cover_slide == 'yes' || empty($display_cover_slide)){ ?>
					<div class="project-slide project-slide-cover">
						<div class="cover-wrapper">
							<div class="cover-inner">
								<div class="project-meta clearfix">
									<div class="project-meta-col-1">
										<div class="project-meta-data project-date clearfix" <?php if(!$date){ echo 'style="display: none;"'; } ?>>
											<div class="project-meta-heading"><?php _e('Date', 'konzept'); ?></div>
											<div class="project-meta-description project-exdate"><?php echo $date; ?></div>
										</div>
										<div class="project-meta-data project-client clearfix" <?php if(!$client){ echo 'style="display: none;"'; } ?>>
											<div class="project-meta-heading"><?php _e('Client', 'konzept'); ?></div>
											<div class="project-meta-description project-exclient"><?php echo $client; ?></div>
										</div>
										<div class="project-meta-data project-agency clearfix" <?php if(!$agency){ echo 'style="display: none;"'; } ?>>
											<div class="project-meta-heading"><?php _e('Agency', 'konzept'); ?></div>
											<div class="project-meta-description project-exagency"><?php echo $agency; ?></div>
										</div>
									</div>
									<div class="project-meta-col-2">
										<div class="project-meta-data project-ourrole clearfix" <?php if(!$ourrole){ echo 'style="display: none;"'; } ?>>
											<div class="project-meta-heading"><?php _e('Our Role', 'konzept'); ?></div>
											<div class="project-meta-description project-exourrole"><?php echo $ourrole; ?></div>
										</div>
									</div>
								</div>
								<h2 class="project-title"><?php echo $title; ?></h2>
								<div class="project-description"><?php echo $description; ?></div>
							</div>
						</div>
					</div>
				<?php }else{ ?>
					<div class="project-slide project-slide-cover project-slide-cover-empty">
						<div class="cover-wrapper">
							<div class="cover-inner"></div>
						</div>
					</div>
				<?php } ?>
				<?php if ( post_password_required() ) { ?>
					<?php the_content(); ?>
				<?php } else { ?>
					<?php echo $slides; ?>
				<?php } ?>
			</ul>
		</div>
</div>

<nav class="project-navigation clearfix" role="navigation">
	<a class="portfolio-arrowleft portfolio-arrowleft-visible"><?php _e( 'Previous', 'konzept' ); ?></a>
	<a class="portfolio-arrowright portfolio-arrowright-visible"><?php _e( 'Next', 'konzept' ); ?></a>
</nav>

<div class="project-coverslide <?php if(is_singular('portfolio')){ echo 'project-coverslide-visible'; } ?>"></div>