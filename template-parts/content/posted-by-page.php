<?php
/**
 * Template part for displaying a page's metadata
 *
 * @package Inclusive
 * @since 1.0.0
 */

if ( Inclusive\WooCommerce::is_woocommerce_active() && is_cart() || Inclusive\WooCommerce::is_woocommerce_active() && is_checkout() ) {
	return;
} else {

	$author_string = sprintf(
		'<span class="author vcard"><a class="url fn n" href="%1$s">%2$s</a></span>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_html( get_the_author() )
	);

	if ( ! empty( $author_string ) ) {
		if ( is_page() && get_theme_mod( 'page_show_author', false ) === true ) {
			?>
			<span class="posted-by">
				<?php
				if ( get_theme_mod( 'posted_by' ) ) {
					$author_string = esc_html( get_theme_mod( 'posted_by' ) ) . ' ' . $author_string;
				}

				echo $author_string; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				?>
			</span>
			<?php
		}
	}
}
