<?php
// The demo WordPress settings.
$wordpress_settings = array(
	'page_on_front' => '3232',
	'page_for_posts' => '2482',
	'show_on_front' => 'page'
);

// The demo theme settings.
$theme_settings = array(
	'flow_portfolio_page' => '3232',
	'flow_logo' => 'https://demo.ikonize.com/konzept/wp-content/uploads/2013/04/logo-black.png',
	'flow_featured_slideshow' => 1,
	'flow_body_class' => '',
	'flow_slide_class_default' => 'fullscreen',
	'flow_slide_class' => '',
	'flow_styling' => array(),
	'footer_col_countcustom' => 'grid_12 last grid_responsive_only, grid_6 widget_no_margin, grid_6 widget_no_margin last',
);

// The demo widgets.
$theme_widgets = array(
	'widget_custom_html' => array(
		1 => array(
			'title' => false,
			'content' => '<hr>',
			'filter' => false,
		),
		2 => array(
			'title' => '',
			'content' => '<div class="copyright_notice">COPYRIGHT &copy; 1995 KONZEPT. ALL RIGHTS RESERVED.</div>',
			'filter' => false,
		),
		3 => array(
			'title' => false,
			'content' => '<div class="footer-fa clearfix">
	<a class="fa fa-twitter" href="https://example.com/"></a>
	<a class="fa fa-facebook-square" href="https://example.com/"></a>
	<a class="fa fa-skype" href="https://example.com/"></a>
	<a class="fa fa-vimeo-square" href="https://example.com/"></a>
	<a class="fa fa-envelope-o" href="mailto:example@example.com"></a>
</div>',
			'filter' => false,
		),
		'_multiwidget' => 1,
	),
	'widget_categories' => array(
		1 => array(
			'title' => 'Categories',
			'count' => 0,
			'hierarchical' => 0,
			'dropdown' => 0,
		),
		'_multiwidget' => 1,
	),
	'widget_tag_cloud' => array(
		1 => array(
			'title' => false,
			'taxonomy' => 'post_tag',
		),
		'_multiwidget' => 1,
	),
);

// The demo widget areas.
$theme_sidebars = array( // not ok
	'wp_inactive_widgets' => array(),
	'sidebar-1' => array(
		0 => 'categories-1',
		1 => 'tag_cloud-1',
	),
	'footer-1' => array( 0 => 'custom_html-1', ),
	'footer-2' => array( 0 => 'custom_html-2', ),
	'footer-3' => array( 0 => 'custom_html-3', ),
);

// Additional CSS.
$theme_custom_css = '/*
You can add your own CSS here.

Click the help icon above to learn more.
*/

/* Uncomment the below if you have the dark skin enabled. */
/* body { background-image: url(https://demo.ikonize.com/konzept/wp-content/uploads/2013/04/konzept_wallpaper_shade.jpg); background-size: cover; background-attachment: fixed; } */';

/**
 * Accepts an array of options and values and updates the database with them.
 *
 * @param {array} An array of option names as keys and option values as values.
 * @param {string} Install (default) or uninstall.
 * @return {array|boolean} True on success, false on failure or array of settings and their values.
 */
function daisho_demo_update_settings( $settings, $action = 'install' ) {

	if ( $action === 'install' && current_user_can( 'manage_options' ) && current_user_can( 'edit_theme_options' ) ) {
		foreach ( $settings as $k => $v ) {
			update_option( $k, $v );
		}

		return true;
	}

	if ( $action === 'uninstall' && current_user_can( 'manage_options' ) && current_user_can( 'edit_theme_options' ) ) {
		foreach ( $settings as $k => $v ) {
			delete_option( $k );
		}

		return true;
	}

	return false;
}

/**
 * Updates the theme settings and imports widgets.
 */
function konzept_demo_install() {
	global $wordpress_settings;
	global $theme_settings;
	global $theme_widgets;
	global $theme_sidebars;
	global $theme_custom_css;

	daisho_demo_update_settings( $wordpress_settings, 'install' );
	daisho_demo_update_settings( $theme_settings, 'install' );
	update_option( 'widget_custom_html', $theme_widgets[ 'widget_custom_html' ] );
	update_option( 'widget_categories', $theme_widgets[ 'widget_categories' ] );
	update_option( 'widget_tag_cloud', $theme_widgets[ 'widget_tag_cloud' ] );
	update_option( 'sidebars_widgets', $theme_sidebars );
	wp_update_custom_css_post( $theme_custom_css );
}

function konzept_demo_settings_list( $settings ) {
	$output = '<table class="demo-content-list">';

	foreach ( $settings as $key => $value ) {
		$output .= '<tr>
				<td>' . $key . '</td>
				<td>' . $value . '</td>
				<td>This setting will be updated.</td>
			</tr>';
	}

	$output .= '</table>';

	return $output;
}

/**
 * The below block of code allows attaching menus.
 * It's currently disabled but may be re-enabled if
 * necessary.
 */
// $menu_obj = get_terms( 'nav_menu' );
// $menu_locations = get_nav_menu_locations();
// if(is_array($menu_obj) && !empty($menu_obj)){
	// foreach($menu_obj as $single_menu){
		// if($single_menu->slug == 'main-menu'){
			// $menu_locations['main_menu'] = $single_menu->term_id;
		// }
	// }
	// set_theme_mod( 'nav_menu_locations', $menu_locations );
// }
