<?php
/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function konzept_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on this theme, use a find and replace
	 * to change 'konzept' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'konzept', get_template_directory() . '/languages' );

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	//set_post_thumbnail_size( 825, 510, true ); // Disabled because there is no limit.

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array( 'main_menu' => 'Main Menu' ) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

	/*
	 * This theme does not support post formats by default.
	 *
	 * See: http://codex.wordpress.org/Post_Formats
	 */
	//add_theme_support( 'post-formats', array(
	//	'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video'
	//) );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background' );

	// This theme uses its own gallery styles.
	add_filter( 'use_default_gallery_style', '__return_false' );
}
add_action( 'after_setup_theme', 'konzept_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 * @link http://core.trac.wordpress.org/ticket/5777 the purpose of $content_width.
 * @link https://core.trac.wordpress.org/ticket/27863 why it's in a separate setup callback.
 */
function konzept_content_width() {
	$GLOBALS[ 'content_width' ] = apply_filters( 'konzept_content_width', 1920 );
}
add_action( 'after_setup_theme', 'konzept_content_width', 0 );

/**
 * Adjusts content_width value for WordPress embeds like videos.
 *
 * @return void
 */
function konzept_template_redirect() {
	global $content_width;

	if ( is_singular( 'post' ) ) {
		$content_width = 900;
	}

	if ( is_page() ) {
		$content_width = 1200;
	}
}
add_action( 'template_redirect', 'konzept_template_redirect' );

function konzept_scripts() {
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'jquery-ui-core' );
	wp_enqueue_script( 'jquery-ui-widget' );
	wp_enqueue_script( 'jquery-ui-accordion' );
	wp_enqueue_script( 'jquery-ui-tabs' );

	// Load other libraries.
	wp_enqueue_script( 'iscroll', get_template_directory_uri() . '/js/iscroll.js', array( 'jquery' ), '4.1.9', true );

	// Load JavaScript files with functionality specific to this theme.
	wp_enqueue_script( 'konzept-scripts', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), false, true );
	wp_enqueue_script( 'konzept-portfolio-script', get_template_directory_uri() . '/js/portfolio.js', array( 'jquery' ), false, true );

	/*
	 * Adds JavaScript to pages with the comment form to support sites with
	 * threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Loads our main stylesheet.
	wp_enqueue_style( 'konzept-style', get_stylesheet_uri() );

	// Loads other stylesheets.
	wp_enqueue_style( 'konzept-fonts', get_template_directory_uri() . '/css/fonts.css' );
	wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/css/fontawesome/font-awesome.css' );
	wp_enqueue_style( 'konzept-slideshow-style', get_template_directory_uri() . '/css/slideshow.css' );
}
add_action( 'wp_enqueue_scripts', 'konzept_scripts' );

/**
 * Returns and loads the Google font stylesheet URL, if available.
 *
 * To disable in a child theme, use wp_dequeue_style()
 * function mytheme_dequeue_fonts() {
 *     wp_dequeue_style( 'konzept-google-fonts' );
 * }
 * add_action( 'wp_enqueue_scripts', 'mytheme_dequeue_fonts', 11 );
 *
 * @return void
 */
function konzept_google_fonts() {
	$fonts_url = '';
	$font_families = array();
	$font_families[] = 'Roboto:400,300,100,400italic,300italic,900,700,500,100italic';
	$protocol = is_ssl() ? 'https' : 'http';
	$query_args = array(
		'family' => implode( '|', $font_families ),
		'subset' => 'latin,latin-ext',
	);
	$fonts_url = add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" );

	wp_enqueue_style( 'konzept-google-fonts', esc_url_raw( $fonts_url ), array(), null );
}
add_action( 'wp_enqueue_scripts', 'konzept_google_fonts' );

/**
 * Registers widget areas.
 *
 * 1. One sidebar called 'sidebar-1'.
 * 2. Multiple footer widget areas based on user configuration
 * in admin panel.
 *
 * @return void
 */
function konzept_widgets_init() {

	// Create Sidebar Widget Area
	if ( function_exists( 'register_sidebar' ) ) {
		$i = 1;
		$args = array(
			'name'          => sprintf( __('Sidebar %d', 'konzept'), $i ),
			'id'            => "sidebar-$i",
			'description'   => '',
			'class'         => '',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>'
		);
		register_sidebars( 1, $args );
	}

	// Create Footer Widget Areas
	$footer_col_countcustom = get_option( 'footer_col_countcustom' );
	$footer_columns_count_t = array();
	if ( $footer_col_countcustom ) {
		$footer_columns_count_t = explode( ',', $footer_col_countcustom );
	}

	$r = $footer_columns_count_t;
	$r_items_count = count( $r );

	for ( $i = 1; $r_items_count >= $i; $i++ ) {
		$args = array(
			'name'          => sprintf( __('Footer %d', 'konzept'), $i ),
			'id'            => "footer-$i",
			'description'   => sprintf( __( 'This footer column has the following CSS classes: %s', 'konzept' ), $r[$i-1] ),
			'class'         => '',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>'
		);

		register_sidebar( $args );
	}
}
add_action( 'widgets_init', 'konzept_widgets_init' );

/**
 * Extends the default WordPress body classes.
 *
 * @param array $classes A list of existing body class values.
 * @return array The filtered body class list.
 */
function konzept_body_class( $classes ) {
	global $wp_query, $post;

	if ( ! is_multi_author() ) {
		$classes[] = 'single-author';
	}

	if ( is_active_sidebar( 'sidebar-1' ) && ! is_attachment() && ! is_404() ) {
		$classes[] = 'sidebar-active';
	}

	if ( ( is_home() || is_singular() ) && 'sidebar-left' == get_post_meta( $wp_query->queried_object_id, 'flow_post_layout', true ) ) {
		$classes[] = 'sidebar-left';
	}

	if ( ( is_home() || is_singular() ) && 'sidebar-right' == get_post_meta( $wp_query->queried_object_id, 'flow_post_layout', true ) ) {
		$classes[] = 'sidebar-right';
	}

	if ( is_singular() && 'no-boundaries' == get_post_meta( $wp_query->queried_object_id, 'flow_post_layout', true ) ) {
		$classes[] = 'no-boundaries';
	}

	// WooCommerce with sidebar
	if ( function_exists( 'is_woocommerce' ) && is_woocommerce() && ( is_shop() || is_product_category() || is_product_tag() ) ) {
		$classes[] = 'sidebar-left';
	}

	// Thumbnail view
	if ( is_page_template( 'template-portfolio.php' ) or is_singular( 'portfolio' ) ) {
		$classes[] = 'viewing-portfolio-grid';
	}

	// Classic Homepage
	if ( is_page_template( 'template-classic.php' ) ) {
		if ( get_post_meta( $post->ID, 'classic_slideshow', true ) != 'disable' ) {
			$classes[] = 'daisho-classic-has-slideshow';
		}
		if ( get_post_meta( $post->ID, 'page_portfolio_welcome_text', true ) ) {
			$classes[] = 'daisho-classic-has-welcome-text';
		}
	}

	if ( is_singular( 'post' ) || ( is_home() && get_option( 'page_for_posts' ) ) ) {
		//$classes[] = 'compact-header';
	}

	if ( is_singular( 'portfolio' ) ) {
		$classes[] = 'daisho-portfolio-viewing-project';
	}

	if ( ( get_option('flow_featured_slideshow') == 0 && is_front_page() && wp_count_posts('slideshow')->publish >= 1 ) || (is_front_page() && isset( $_GET['featured'] ) ) ) {
		$classes[] = 'has-featured-slideshow';
	}

	//$classes[] = 'page-refresh';
	$classes[] = 'cursor-in-viewport';

	return $classes;
}
add_filter( 'body_class', 'konzept_body_class' );

/**
 * Sets new excerpt length.
 *
 * @param integer Old excerpt length.
 * @return integer New excerpt length.
 */
function konzept_new_excerpt_length( $length ) {
	return 80;
}
add_filter( 'excerpt_length', 'konzept_new_excerpt_length' );

/**
 * Sets new excerpt ending.
 *
 * @param string Old excerpt ellipsis.
 * @return string New excerpt ellipsis.
 */
function konzept_new_excerpt_more( $more ) {
	return '...';
}
add_filter( 'excerpt_more', 'konzept_new_excerpt_more' );

/**
 * Search feature in this theme is supposed to search in 'post' only.
 * Excludes additional post types from search.
 *
 * @return object Filtered $query.
 */
function konzept_remove_pages_from_search() {
    global $wp_post_types;
	$wp_post_types['page']->exclude_from_search = true;
	$wp_post_types['attachment']->exclude_from_search = true;
}
add_action( 'pre_get_posts', 'konzept_remove_pages_from_search' );

require_once( get_template_directory() . '/admin/admin.php' );
require_once( get_template_directory() . '/inc/woocommerce.php' );
require_once( get_template_directory() . '/inc/post-type-news.php' );
require_once( get_template_directory() . '/inc/post-type-portfolio.php' );
require_once( get_template_directory() . '/inc/post-type-slideshow.php' );
require_once( get_template_directory() . '/inc/attachment.php' );
require_once( get_template_directory() . '/inc/comments.php' );
require_once( get_template_directory() . '/inc/nav.php' );
require_once( get_template_directory() . '/inc/shortcodes.php' );
require_once( get_template_directory() . '/inc/wpml-language-switcher.php' );
require_once( get_template_directory() . '/inc/content-slider.php' );
