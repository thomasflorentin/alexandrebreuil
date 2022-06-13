<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
		
	<title><?php wp_title( '-', true, 'right' ); ?></title>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js" type="text/javascript"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<header id="header" class="site-header" role="banner">
		<div class="site-header-inner clearfix">
			<div class="logo">
				<div class="logo-inner">
					<a class="home-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
						<?php if ( esc_url( get_option( 'flow_logo' ) ) ) { ?>
							<img class="site-logo" src="<?php echo esc_url( get_option( 'flow_logo' ) ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" />
						<?php } ?>
						<h1 class="site-title"><?php bloginfo( 'name' ); ?></h1>
						<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
					</a>
				</div>
			</div>
			<?php if ( function_exists( 'flow_language_selector_flags' ) ) {
					$lng_switcher = flow_language_selector_flags();
					echo $lng_switcher;
				} ?>
			<nav class="site-navigation clearfix" role="navigation">
				<h3 class="menu-toggle"><?php _e( 'Menu', 'konzept' ); ?></h3>
				<?php wp_nav_menu( array( 'theme_location' => 'main_menu', 'container_class' => 'main-nav', 'menu_class' => 'nav-menu' ) ); ?>
				<?php
				$portfolio_page = get_option('flow_portfolio_page');
				if(is_page_template('template-portfolio.php')){
					$exclude_include = get_post_meta($wp_query->queried_object_id, 'page_portfolio_tax_query_operator', true); // Operator for exclude box, false = exlude, true = include
					$flow_portfolio_home_exclude = get_post_meta($wp_query->queried_object_id, 'page_portfolio_exclude', true); // Array of portfolio categories slugs
					$selected = 'selected';
				}else if(is_singular('portfolio') && ($parent_page = get_post_meta($post->ID, 'portfolio_back_button', true)) && !empty($parent_page) && ($parent_page != 'none')){ // we assume that parent page is portfolio
					$exclude_include = get_post_meta($parent_page, 'page_portfolio_tax_query_operator', true);
					$flow_portfolio_home_exclude = get_post_meta($parent_page, 'page_portfolio_exclude', true);
					$selected = 'selected';
				}else if(!empty($portfolio_page)){ // load main portfolio page if no parent page is set for this item
					$exclude_include = get_post_meta($portfolio_page, 'page_portfolio_tax_query_operator', true);
					$flow_portfolio_home_exclude = get_post_meta($portfolio_page, 'page_portfolio_exclude', true);
					$selected = '';
				}else{
					$exclude_include = false;
					$flow_portfolio_home_exclude = array();
					$selected = '';
				}
				if(empty($exclude_include)){
					$exclude_include = false; //exclude - default, include = true
				} ?>
				
				<ul class="pf_nav option-set menu-col-categories clearfix">
					<li><a href="javascript:void(null);" data-project-category-id="all" data-option-value="*" class="<?php echo $selected; ?>"><?php _e('All Works', 'konzept'); ?></a></li>
					<?php
					$tax_terms = get_terms( 'portfolio_category', array( 'hide_empty' => true ) );
					foreach($tax_terms as $tax_term){
						if ( ( ( is_array( $flow_portfolio_home_exclude ) ) && ( ( ( $exclude_include && in_array( $tax_term->slug, $flow_portfolio_home_exclude ) ) || ( ! $exclude_include && ! in_array( $tax_term->slug, $flow_portfolio_home_exclude ) ) ) ) ) || ( ! is_array( $flow_portfolio_home_exclude ) ) ) {
							echo '<li>' . '<a href="javascript:void(null);" data-project-category-id="' . $tax_term->term_id . '" data-option-value=".portfolio-category-' . $tax_term->term_id . '">' . $tax_term->name  . '</a></li>';
						}
					}
					?>
				</ul>
			</nav>
			<?php 
			if(is_home() or is_archive() or is_singular('post') or is_singular('news') or is_singular('product') or is_attachment() or is_search()){
			
				$back_link = home_url( '/' );

				if ( is_singular( 'post' ) && get_option( 'page_for_posts' ) ) {
					$blog_page = get_option( 'page_for_posts' );
					$back_link = get_permalink( $blog_page );
				}
				if ( function_exists( 'is_woocommerce' ) && function_exists( 'woocommerce_get_page_id' ) && is_singular( 'product' ) ) {
					$back_link = get_permalink( woocommerce_get_page_id( 'shop' ) );
				}
				?>
				<a class="back" href="<?php echo $back_link; ?>">
					<div class="icon">
						 <svg version="1.1" class="compact-header-arrow-back-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="19.201px" height="34.2px" viewBox="0 0 19.201 34.2" enable-background="new 0 0 19.201 34.2" xml:space="preserve">
							<polyline fill="none" points="17.101,2.1 2.1,17.1 17.101,32.1 "/>
						</svg>
					</div>
					<div class="label"><?php _e( 'Back', 'konzept' ); ?></div>
				</a>
				<div class="header-back-to-top">
					<svg version="1.1" class="compact-header-arrow-back-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="34px" height="19px" viewBox="0 0 34 19" enable-background="new 0 0 34 19" xml:space="preserve">
						<polyline fill="none" points="31,16.5 17,2.5 3,16.5 "/>
					</svg>
					<div class="header-back-to-blog-message"><?php _e('Back to Top', 'konzept'); ?></div>
				</div>
				<div class="compact-search"></div>
				<?php get_search_form(); ?>
			<?php } ?>
		</div>
	</header>
	
	<div class="header-search">
		<?php get_search_form(); ?>
		<div class="search-message"><?php _e( 'Press Enter to Search', 'konzept' ); ?></div>
	</div>
	
	<?php get_template_part('slideshow'); ?>
