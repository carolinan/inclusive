<?php
/**
 * Template part for displaying tags
 *
 * @package Inclusive
 * @since 1.0.0
 */

?>
<div class="entry-meta">
	<?php
	/* translators: Used before tag names */
	$separator = ' ' . get_theme_mod( 'tag_separator', __( '#', 'inclusive' ) );

	$tags_list = get_the_tag_list( esc_html( $separator ), esc_html( $separator ), '' );

	if ( $tags_list ) {
		echo $tags_list; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
	?>
</div>
