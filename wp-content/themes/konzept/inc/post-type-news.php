<?php
function konzept_create_news_post_type() {
	register_post_type( 'news',
		array(
			'labels' => array(
				'name' => _x( 'News', 'News post type general name', 'konzept' ),
				'singular_name' => _x( 'News Item', 'News post type singular name', 'konzept' ),
				'add_new' => _x( 'Add New', 'News post type', 'konzept' ),
				'add_new_item' => __( 'Add New News Item', 'konzept' ),
				'edit_item' => __( 'Edit News Item', 'konzept' ),
				'new_item' => __( 'New News Item', 'konzept' ),
				'view_item' => __( 'View News Item', 'konzept' ),
				'search_items' => __( 'Search News Items', 'konzept' ),
				'not_found' =>  __( 'No news items found', 'konzept' ),
				'not_found_in_trash' => __( 'No news items found in Trash', 'konzept' ),
				'parent_item_colon' => '',
				'menu_name' => _x( 'News', 'News menu name', 'konzept' ),
			),
			'public' => true,
			'has_archive' => true,
			'supports' => array('title', 'editor', 'author', 'custom-fields', 'revisions', 'page-attributes', 'post-formats', 'comments', 'trackbacks', 'excerpt' ),
			'rewrite' => array('slug' => 'news')
		)
	);

	register_taxonomy( 'news_category', 'news', array(
		'hierarchical' => true,
		'labels' => array(
			'name' => _x( 'News Categories', 'News taxonomy general name', 'konzept' ),
			'singular_name' => _x( 'News Category', 'News taxonomy singular name', 'konzept' ),
			'search_items' =>  __( 'Search Categories', 'konzept' ),
			'popular_items' => __( 'Popular Categories', 'konzept' ),
			'all_items' => __( 'All Categories', 'konzept' ),
			'parent_item' => null,
			'parent_item_colon' => null,
			'edit_item' => __( 'Edit News Category', 'konzept' ),
			'update_item' => __( 'Update News Category', 'konzept' ),
			'add_new_item' => __( 'Add New News Category', 'konzept' ),
			'new_item_name' => __( 'New News Category Name', 'konzept' ),
			'separate_items_with_commas' => __( 'Separate News category with commas', 'konzept' ),
			'add_or_remove_items' => __( 'Add or remove news category', 'konzept' ),
			'choose_from_most_used' => __( 'Choose from the most used news category', 'konzept' )
		),
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => false,
	) );
}
add_action( 'init', 'konzept_create_news_post_type' );
