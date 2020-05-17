<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Inclusive
 * @since 1.0.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

Inclusive\Styles::get_template_part( 'content', 'comments', 'assets/css/min/comments.min.css' );

?>
<div id="comments" class="comments-area">
	<?php
	if ( have_comments() ) {
		?>
		<h2 class="comments-title">
			<?php
			$comment_count = get_comments_number();
			if ( 1 === $comment_count ) {
				printf(
					/* translators: 1: title. */
					esc_html__( 'One thought on &ldquo;%1$s&rdquo;', 'inclusive' ),
					'<span>' . get_the_title() . '</span>' // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				);
			} else {
				printf(
					/* translators: 1: comment count number, 2: title. */
					esc_html( _nx( '%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $comment_count, 'comments title', 'inclusive' ) ),
					// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					number_format_i18n( $comment_count ),
					'<span>' . get_the_title() . '</span>' // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				);
			}
			?>
		</h2><!-- .comments-title -->

		<?php the_comments_navigation(); ?>

			<ol class="comment-list">
			<?php
			wp_list_comments(
				[
					'style'      => 'ol',
					'short_ping' => true,
				]
			);
			?>
		</ol><!-- .comment-list -->

		<?php the_comments_navigation(); ?>

		<?php
		if ( ! comments_open() ) {
			?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'inclusive' ); ?></p>
			<?php
		}
	} else {
		?>
		<h2 class="comments-title"><?php esc_html_e( 'Be the first to leave a comment', 'inclusive' ); ?> </h2>
		<?php
	}

	comment_form();
	?>
</div><!-- #comments -->
