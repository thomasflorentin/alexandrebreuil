<?php
function konzept_shortcode_content_slider($atts, $content = null) {
	$class = shortcode_atts( array('title' => '', 'icon' => '', 'image' => '', 'description' => '', 'link' => '', 'post_type' => '', 'posts_per_page' => '', 'arrows_top_position' => '120px'), $atts );

	$output = $image = $description = $icon = '';

	if($class['icon'] != ''){
		$icon = 'data-icon="' . $class['icon'] . '"';
	}

	if($class['image'] != ''){
		$image = '<img class="cb-image" src="' . $class['image'] . '" alt="" />';
	}

	if($class['description'] != ''){
		$description = '<span class="cb-description">'.$class['description'].'</span>';
	}

	$title = $class['title'];
	if($class['link'] != ''){
		$title = '<a class="cb-title-link" href="' . $class['link'] . '">' . $class['title'] . '</a>';
		if($image){
			$image = '<a class="cb-image-link" href="' . $class['link'] . '">' . $image . '</a>';
		}
	}

	// A carousel based on 'news' posts.
	if($class['post_type'] != ''){
		if(empty($class['posts_per_page'])){
			$post_per_page = -1; // -1 shows all posts
		}else{
			$post_per_page = $class['posts_per_page'];
		}
		$do_not_show_stickies = 1; // 0 to show stickies
		$args = array(
			'post_type' => 'news',
			'orderby' => 'date',
			'order' => 'DESC',
			'posts_per_page' => $post_per_page,
			'ignore_sticky_posts' => $do_not_show_stickies
		);
		$block_query = new WP_Query( $args );
		if( $block_query->have_posts() ) {
			while($block_query->have_posts()){
				$block_query->the_post();
				$output .= '<div class="grid_4 content-block" id="post-' . get_the_ID() . '" data-arrows-top-position="' . $class['arrows_top_position'] . '">';
					$output .= '<div class="cb-date">' . esc_html( get_the_date() ) . '</div>';
					$output .= '<div class="cb-title cb-news-title">';
						$output .= '<a href="' . get_permalink() . '" title="' . get_the_title() . '">' . get_the_title() . '</a>';
					$output .= '</div>';
					$output .= '<div class="cb-content"><p>' . get_the_excerpt() . '</p></div>';
					$output .= '<div style="clear: both;"></div>';
				$output .= '</div>';
			}
		}
		wp_reset_postdata();
	}else{
		$output = '<div class="grid_4 content-block" data-arrows-top-position="' . $class['arrows_top_position'] . '">';
			$output .= '<div class="cb-date"></div>';
			$output .= $image;
			$output .= '<div class="cb-title" ' . $icon . '>' . $title . $description . '</div>';
			$output .= '<div class="cb-content">';
				$output .= '<p>' . do_shortcode( $content ) . '</p>';
			$output .= '</div>';
		$output .= '</div>';
	}

	return $output;
}
add_shortcode('content_block', 'konzept_shortcode_content_slider');

function konzept_shortcode_content_slider_scripts() {
	wp_enqueue_script( 'konzept-content-slider', get_template_directory_uri() . '/js/content-slider.js', array( 'jquery' ), false, true );
	wp_enqueue_style( 'konzept-content-slider', get_template_directory_uri() . '/css/content-slider.css' );
}
add_action( 'wp_enqueue_scripts', 'konzept_shortcode_content_slider_scripts' );
