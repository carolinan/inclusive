<?php
/**
 * Template part for displaying a post's content
 *
 * @package Inclusive
 * @since 1.0.0
 */

?>

<div class="entry-content">
	<?php
	Inclusive\Post_Options::lead_text();

	the_content();

	wp_link_pages(
		[
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'inclusive' ),
			'after'  => '</div>',
		]
	);
	?>
</div><!-- .entry-content -->
