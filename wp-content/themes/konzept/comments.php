<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains comments and the comment form.
 */

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() )
	return;
?>

<div id="comments" class="comments-area clearfix">

	<?php if ( have_comments() ) { ?>
		<div class="comments-title clearfix">
			<h2><?php printf( _n( 'One Comment', '%s Comments', get_comments_number(), 'konzept' ), number_format_i18n( get_comments_number() ) ); ?></h2>
			<a href="#commentform"><?php _e( 'Post Comment', 'konzept' ); ?></a>
		</div>
		
		<ol class="comment-list">
			<?php wp_list_comments( array( 'style' => 'ol', 'short_ping' => true, 'avatar_size' => 74 ) ); ?>
		</ol>
		
		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) { ?>
			<nav class="comment-navigation clearfix" role="navigation">
				<h1 class="screen-reader-text section-heading"><?php _e( 'Comment navigation', 'konzept' ); ?></h1>
				<div class="nav-previous"><?php previous_comments_link( __( 'Older Comments', 'konzept' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments', 'konzept' ) ); ?></div>
			</nav>
		<?php } ?>

		<?php if ( ! comments_open() && get_comments_number() ) { ?>
			<p class="comments-closed"><?php _e( 'Comments are closed.' , 'konzept' ); ?></p>
		<?php } ?>

	<?php } else { ?>
		<?php if ( $post->comment_status == 'open' ) { ?>
			<div class="no-comments"><?php _e( 'There are no comments yet, add one below.', 'konzept' ); ?></div>
		<?php } ?>
	<?php } ?>

	<?php comment_form(); ?>
	
</div>