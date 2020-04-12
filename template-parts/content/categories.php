<?php
/**
 * Template part for displaying categories.
 *
 * @package Inclusive
 * @since 1.0.0
 */

?>
<div class="entry-meta">
	<?php

	/* translators: Used between list items, there is a space after the comma. */
	$categories_list = get_the_category_list( __( ', ', 'inclusive' ) );

	if ( $categories_list ) {
		if ( get_theme_mod( 'category_text', __( 'Published under:', 'inclusive' ) ) ) {
			$published_under = get_theme_mod( 'category_text', __( 'Published under:', 'inclusive' ) ) . ' %s';
			printf(
				$published_under, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				$categories_list // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			);
		} else {
			echo '&nbsp;' . $categories_list;  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}
	?>

</div>
