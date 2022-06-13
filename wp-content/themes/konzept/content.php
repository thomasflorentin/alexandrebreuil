<?php
/**
 * The default template for displaying content. Used for single, index, archive, search.
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix entry-container' ); ?>>

	<?php $page_layout = get_post_meta( $wp_query->queried_object_id, 'flow_post_layout', true ); ?>
	<?php if ( ( $page_layout == 'sidebar-left' || $page_layout == 'sidebar-right' ) && ! post_password_required() ) { ?>
		<div class="entry-thumbnail clearfix">
			<?php the_post_thumbnail(); ?>
		</div>
	<?php } ?>
	
	<header class="entry-header">

		<h1 class="entry-title">
			<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h1>
		
		<div class="entry-meta">
			<?php if ( $page_layout != 'sidebar-left' ) { ?>
				<div class="blog-comments-wrapper <?php if ( get_comments_number() == '0' || ! comments_open() ) { echo 'blog-comments-wrapper-zero'; } ?>">
					<div class="blog-comments-icon">
						<svg version="1.1" class="blog-comments-icon-shape" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="25px" height="24.083px" viewBox="0 0 25 24.083" enable-background="new 0 0 25 24.083" xml:space="preserve"><g><path fill-rule="evenodd" clip-rule="evenodd" fill="none" d="M8.013,17H4c-2.072,0-3-1.507-3-3V4c0-1.822,1.178-3,3-3h17 c1.767,0,3,1.233,3,3v10c0,1.475-1.122,3-3,3h-8.265l-4.737,4.681L8.013,17z"/></g></svg>
						<?php if ( comments_open() ) { ?>
							<?php if ( get_comments_number() > 999 ) { $comments_number = __( '1k+', 'konzept' ); }else{ $comments_number = '%'; } ?>
							<div class="blog-comments-value"><?php comments_popup_link( '0', '1', $comments_number, '', '' ); ?></div>
						<?php } ?>
					</div>
				</div>
			<?php } ?>
			<?php if ( is_multi_author() ) { ?>
				<span class="author vcard"><?php printf( __( 'Written by <a href="%1$s" title="View all posts by %2$s" rel="author">%2$s</a>', 'konzept' ), get_author_posts_url( get_the_author_meta( 'ID' ) ), get_the_author() ); ?></span>
			<?php } ?>
			<?php
				$date = sprintf( '<span class="date"><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a></span>',
					esc_url( get_permalink() ),
					esc_attr( sprintf( __( 'Permalink to %s', 'konzept' ), the_title_attribute( 'echo=0' ) ) ),
					esc_attr( get_the_date( 'c' ) ),
					esc_html( get_the_date() )
				);

				echo $date;
			?>
			<?php edit_post_link( __( 'Edit', 'konzept' ), '<span class="edit-link">', '</span>' ); ?>
			<?php if ( has_tag() ) { ?>
				<span class="entry-tags"><?php the_tags( ' ', ' ' ); ?></span>
			<?php } ?>
		</div>
	</header>
	
	<div class="entry-summary clearfix">
		<?php if ( $page_layout != 'sidebar-left' && $page_layout != 'sidebar-right' ) { ?>
			<div class="entry-thumbnail clearfix">
				<?php the_post_thumbnail(); ?>
			</div>
		<?php } ?>
		<?php
		if( has_excerpt() ) {
			the_excerpt();
		} else {
			the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'konzept' ) );
			wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'konzept' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
		} ?>
	</div>
</article>
