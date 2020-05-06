<?php
/**
 * Template part for displaying reusable blocks in the footer.
 *
 * @package Inclusive
 * @since 1.0.0
 */

if ( get_theme_mod( 'footer_content', 0 ) !== 0 ) {
	$inclusive_footer_block_query = new WP_Query(
		[
			'p'         => get_theme_mod( 'footer_content' ),
			'post_type' => 'wp_block',
		]
	);

	if ( $inclusive_footer_block_query->have_posts() ) {
		while ( $inclusive_footer_block_query->have_posts() ) {
			$inclusive_footer_block_query->the_post();
			echo '<div class="entry-content">', the_content(), '</div>';
		}
	}
	wp_reset_postdata();
}
