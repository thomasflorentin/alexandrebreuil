<?php
function create_slideshow_post_type(){
	register_post_type( 'slideshow',
		array(
			'labels' => array(
				'name' => _x( 'Slideshow', 'Slideshow post type general name', 'konzept'),
				'singular_name' => _x( 'Slideshow Item', 'Slideshow post type singular name', 'konzept'),
				'add_new' => _x('Add New Slide', 'Slideshow post type', 'konzept'),
				'add_new_item' => __('Add New Slide', 'konzept'),
				'edit_item' => __('Edit Slide', 'konzept'),
				'new_item' => __('New Slide', 'konzept'),
				'view_item' => __('View Slide', 'konzept'),
				'search_items' => __('Search Slides', 'konzept'),
				'not_found' =>  __('No slides found', 'konzept'),
				'not_found_in_trash' => __('No slides found in Trash', 'konzept'), 
				'parent_item_colon' => '',
				'menu_name' => _x('Slideshow', 'Slideshow menu name', 'konzept'),
			),
			'public' => true,
			'exclude_from_search' => true,
			'has_archive' => false,
			'supports' => array('title', 'author', 'custom-fields', 'revisions', 'page-attributes', 'post-formats' ),
			'rewrite' => array('slug' => 'slideshow')
		)
	);
}
add_action('init', 'create_slideshow_post_type');
