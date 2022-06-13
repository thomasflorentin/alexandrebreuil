<?php
/**
 * Add WooCommerce support.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
add_action( 'woocommerce_before_main_content', 'flow_woocommerce_wrapper_start', 10 );
add_action( 'woocommerce_after_main_content', 'flow_woocommerce_wrapper_end', 10 );

function flow_woocommerce_wrapper_start() {
	echo '<div class="site-content site-woocommerce clearfix" role="main">';
}

function flow_woocommerce_wrapper_end() {
	echo '</div>';
}

add_theme_support( 'woocommerce' );

function flow_woocommerce_body_class( $classes ) {

	if ( function_exists( 'is_shop' ) && is_shop() ) {
		$classes[] = 'flow-woocommerce-shop';
	}

	return $classes;
}
add_action( 'body_class', 'flow_woocommerce_body_class' );

function flow_woocommerce_related_products_args( $args ) {
	$args['posts_per_page'] = 5;
	$args['columns'] = 5;
	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'flow_woocommerce_related_products_args' );

function flow_woocommerce_product_thumbnails_columns() {
	return 4;
}
add_filter( 'woocommerce_product_thumbnails_columns', 'flow_woocommerce_product_thumbnails_columns' );

function flow_woocommerce_scripts() {
	wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/js/owl.carousel.min.js', array( 'jquery' ), false, true );
	wp_enqueue_script( 'jquery-magnific-popup', get_template_directory_uri() . '/js/jquery.magnific-popup.js', false, true );
	wp_enqueue_script( 'flow-woocommerce', get_template_directory_uri() . '/js/woocommerce.js', array( 'jquery', 'owl-carousel', 'jquery-magnific-popup' ), false, true );
	wp_enqueue_style( 'owl-carousel', get_template_directory_uri() . '/css/owl.carousel.css' );
	wp_enqueue_style( 'jquery-magnific-popup', get_template_directory_uri() . '/css/magnific-popup.css' );
	wp_enqueue_style( 'flow-woocommerce', get_template_directory_uri() . '/css/woocommerce.css', array( 'woocommerce-layout', 'woocommerce-smallscreen', 'woocommerce-general', 'jquery-magnific-popup', 'owl-carousel', 'flow-style' ) );
}
add_filter( 'wp_enqueue_scripts', 'flow_woocommerce_scripts' );
