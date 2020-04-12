<?php
/**
 * Template part for displaying a pages's footer.
 *
 * @package Inclusive
 * @since 1.0.0
 */

if ( Inclusive\WooCommerce::is_woocommerce_active() && is_cart() || Inclusive\WooCommerce::is_woocommerce_active() && is_checkout() ) {
	return;
} else {

	if ( ! is_front_page() ) {
		?>
		<div class="entry-footer">
			<?php
			if ( is_singular() && get_theme_mod( 'page_author_information', false ) === true ) {
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
		<?php
	}
}
