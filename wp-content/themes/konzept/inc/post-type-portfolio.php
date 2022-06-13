<?php
function create_portfolio_post_type() {
	register_post_type( 'portfolio',
		array(
			'labels' => array(
				'name' => _x( 'Portfolio', 'Portfolio post type general name', 'konzept' ),
				'singular_name' => _x( 'Portfolio Item', 'Portfolio post type singular name', 'konzept' ),
				'add_new' => _x( 'Add New', 'Portfolio post type', 'konzept' ),
				'add_new_item' => __( 'Add New Portfolio Item', 'konzept' ),
				'edit_item' => __( 'Edit Portfolio Item', 'konzept' ),
				'new_item' => __( 'New Portfolio Item', 'konzept' ),
				'view_item' => __( 'View Portfolio Item', 'konzept' ),
				'search_items' => __( 'Search Portfolio Items', 'konzept' ),
				'not_found' =>  __( 'No portfolio items found', 'konzept' ),
				'not_found_in_trash' => __( 'No portfolio items found in Trash', 'konzept' ), 
				'parent_item_colon' => '',
				'menu_name' => _x( 'Portfolio', 'Portfolio menu name', 'konzept' ),
			),
			'public' => true,
			'exclude_from_search' => true,
			'has_archive' => false,
			'supports' => array( 'title', 'editor', 'author', 'trackbacks', 'custom-fields', 'comments', 'revisions' ),
			'rewrite' => array( 'slug' => 'portfolio' )
		)
	);
	register_taxonomy( 'portfolio_category', 'portfolio',
		array(
			'hierarchical' => true,
			'labels' => array(
				'name' => _x( 'Portfolio Categories', 'Portfolio taxonomy general name', 'konzept' ),
				'singular_name' => _x( 'Portfolio Category', 'Portfolio taxonomy singular name', 'konzept' ),
				'search_items' =>  __( 'Search Categories', 'konzept' ),
				'popular_items' => __( 'Popular Categories', 'konzept' ),
				'all_items' => __( 'All Categories', 'konzept' ),
				'parent_item' => null,
				'parent_item_colon' => null,
				'edit_item' => __( 'Edit Portfolio Category', 'konzept' ), 
				'update_item' => __( 'Update Portfolio Category', 'konzept' ),
				'add_new_item' => __( 'Add New Portfolio Category', 'konzept' ),
				'new_item_name' => __( 'New Portfolio Category Name', 'konzept' ),
				'separate_items_with_commas' => __( 'Separate Portfolio category with commas', 'konzept' ),
				'add_or_remove_items' => __( 'Add or remove portfolio category', 'konzept' ),
				'choose_from_most_used' => __( 'Choose from the most used portfolio category', 'konzept' )
			),
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => false,
		)
	);
}
add_action( 'init', 'create_portfolio_post_type' );
