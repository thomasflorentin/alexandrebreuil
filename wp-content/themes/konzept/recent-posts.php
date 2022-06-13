<div class="recent-posts-single-container clearfix">
	<?php
		$post_per_page = 4;
		$do_not_show_stickies = 1; // 0 to show stickies
		$args = array(
			'orderby' => 'date',
			'order' => 'DESC',
			'post__not_in' => array( get_the_ID() ), // excludes this post
			'post_type' => array('post'),
			'posts_per_page' => $post_per_page,
			'ignore_sticky_posts' => $do_not_show_stickies
		);
		$other_posts_query = new WP_Query($args); 
		if($other_posts_query->have_posts()){
			echo '<div class="related-posts clearfix">';
			while ($other_posts_query->have_posts()){
				$other_posts_query->the_post();
		?>
				<div class="related-posts-title">
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
					<small><?php echo esc_html( get_the_date() ); ?></small>
				</div>
		<?php 
			}
			echo '</div>';
		}
		wp_reset_query(); ?>
</div>
