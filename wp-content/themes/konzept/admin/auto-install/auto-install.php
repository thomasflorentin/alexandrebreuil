<?php
/**
 * One click installation.
 *
 * Contains a set of functions for importing posts, pages, menus, sidebars, widgets etc.
 */

// Exit on direct entrance.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$out = '';
function konzept_import_everything( $demo_version ) {
	global $out;
	$importer = new WP_Import;
	$demo_versions = explode( '|', $demo_version );
	$demo_files = array(
		// 'acf' => get_template_directory() . '/admin/auto-install/konzept-acf-2017-07-22.xml',
		'default' => get_template_directory() . '/admin/auto-install/konzept-default-2017-08-03.xml',
		'wpcf7' => get_template_directory() . '/admin/auto-install/konzept-wpcf7-2017-08-03.xml',
		// 'wc' => get_template_directory() . '/admin/auto-install/konzept-woocommerce-2017-07-17.xml',
		// 'wc_media' => get_template_directory() . '/admin/auto-install/konzept-woocommerce-media-2017-07-17.xml',
	);
	
	ob_start();
	foreach ( $demo_versions as $key => $demo_name ) {
		if ( array_key_exists( $demo_name, $demo_files ) ) {
			$importer->import( $demo_files[ $demo_name ] );
		}
	}
	$out = ob_get_clean();
	
	if ( in_array( 'database', $demo_versions ) ) {
		konzept_demo_install();
		$out .= '<span style="color: #0a0;">The database (WordPress settings, theme settings and widgets) were updated.</span>';
	}
}

function konzept_auto_install_admin_init() {
	$available_importers = get_importers();

	if ( ! empty( $_GET['demo_version'] ) &&
		$_GET['import'] === 'wordpress' &&
		is_array( $available_importers ) &&
		array_key_exists( 'wordpress', $available_importers ) &&
		class_exists( 'WP_Import' ) &&
		wp_verify_nonce( $_GET['import_nonce'], 'install_demo' ) &&
		current_user_can( 'edit_theme_options' ) &&
		current_user_can( 'manage_options' ) &&
		current_user_can( 'import' )
	) {
		konzept_import_everything( $_GET[ 'demo_version' ] );
		flush_rewrite_rules();
	}
}
add_action( 'admin_init', 'konzept_auto_install_admin_init' );
