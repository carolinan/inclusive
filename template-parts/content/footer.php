<?php
/**
 * Template part for displaying a post's footer
 *
 * @package Inclusive
 * @since 1.0.0
 */

?>
<div class="entry-footer">
	<?php
	if ( is_single() && get_theme_mod( 'show_tags', false ) === true ||
		! is_single() && get_theme_mod( 'archive_show_tags', false ) === true ) {

		get_template_part( 'template-parts/content/tags' );
	}

	if ( is_single() && get_theme_mod( 'author_information', false ) === true ) {
		Inclusive\Biography::author_biography();
	}

	Inclusive\Social_Sharing::social_sharing();

	if ( ! is_singular( get_post_type() ) && ! post_password_required()
	&& post_type_supports( get_post_type(), 'comments' ) && comments_open()
	&& get_theme_mod( 'archive_show_comment_count', false ) === true ) {
		?>
		<span class="entry-comments-link">
			<?php
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'inclusive' ),
						[
							'span' => [
								'class' => [],
							],
						]
					),
					get_the_title()
				)
			);
			?>
		</span>
		<?php
	}

	edit_post_link(
		sprintf(
			wp_kses(
				/* translators: %s: post title */
				__( 'Edit <span class="screen-reader-text">%s</span>', 'inclusive' ),
				[
					'span' => [
						'class' => [],
					],
				]
			),
			get_the_title()
		),
		'<span class="edit-link">',
		' </span>'
	);
	?>
</div><!-- .entry-footer -->
