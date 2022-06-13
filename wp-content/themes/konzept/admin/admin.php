<?php
require get_template_directory() . '/admin/tgm-plugin-activation-init.php';
require get_template_directory() . '/admin/auto-install/theme-settings.php';
require get_template_directory() . '/admin/auto-install/auto-install.php';
require get_template_directory() . '/admin/page-main.php';
require get_template_directory() . '/admin/page-demos.php';
require get_template_directory() . '/admin/page-styling.php';
require get_template_directory() . '/admin/metaboxes.php';

function konzept_admin_menu() {
	add_menu_page(
		__( 'Konzept', 'konzept' ),
		__( 'Konzept', 'konzept' ),
		'edit_theme_options',
		'konzept-theme-options-general',
		'konzept_theme_options_render_page',
		'',
		'40.4'
	);

	add_submenu_page(
		'konzept-theme-options-general',
		__( 'General', 'konzept' ),
		__( 'General', 'konzept' ),
		'edit_theme_options',
		'konzept-theme-options-general',
		'konzept_theme_options_render_page'
	);

	add_submenu_page( 'konzept-theme-options-general', __('Styling','konzept'), __('Styling','konzept'), 'manage_options', 'sub-page41', 'flow_styling_menu' );

	add_submenu_page(
		'konzept-theme-options-general',
		__( 'Demo', 'konzept' ),
		__( 'Demo', 'konzept' ),
		'edit_theme_options',
		'konzept-theme-options-demo',
		'konzept_theme_options_page_demo'
	);
}
add_action( 'admin_menu', 'konzept_admin_menu' );

function konzept_admin_enqueue_scripts() {
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'jquery-ui-core' );
	wp_enqueue_script( 'jquery-ui-widget' );

	// Styling page - UI Slider.
	wp_enqueue_script( 'jquery-ui-slider' );

	// WP3.5 Media Library.
	wp_enqueue_media();
	wp_enqueue_script( 'konzept-uploader', get_template_directory_uri() . '/admin/js/flow-uploader.js', array( 'jquery', 'media-upload' ) );
	wp_enqueue_style( 'konzept-uploader', get_template_directory_uri() . '/admin/css/flow-uploader.css' );
	wp_enqueue_script( 'thickbox' );
	wp_enqueue_style( 'thickbox' );

	// WordPress colorpicker.
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker' );

	// Admin styles.
	wp_register_style( 'konzept-admin', get_template_directory_uri() . '/admin/css/admin.css' );
	wp_enqueue_style( 'konzept-admin' );

	// Admin Scripts
	wp_register_script( 'konzept-admin', get_template_directory_uri() . '/admin/js/admin.js' );
	wp_enqueue_script( 'konzept-admin' );

	// SuperSlide, ImageSampler.
	wp_enqueue_style( 'konzept-superslide', get_template_directory_uri() . '/admin/superslide/style.css' );
	wp_enqueue_script( 'konzept-image-sampler', get_template_directory_uri() . '/admin/js/jquery.ImageColorPicker.js', array( 'jquery', 'jquery-ui-widget' ), '1.0', true );
	
	wp_localize_script( 'konzept-admin', 'konzeptAdmin', array(
		'siteUrl' => get_site_url(),
		'confirmMessage' => __( 'It is recommended that you backup your database before proceeding. Are you sure you wish to run the installer now? It can not be undone.', 'konzept' ),
	) );
}
add_action( 'admin_enqueue_scripts', 'konzept_admin_enqueue_scripts' );
