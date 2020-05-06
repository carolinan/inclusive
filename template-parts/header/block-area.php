<?php
/**
 * Template part for displaying reusable blocks in the header.
 *
 * @package Inclusive
 * @since 1.0.0
 */

if ( get_theme_mod( 'header_content', 0 ) !== 0 ) {
	$inclusive_header_block_query = new WP_Query(
		[
			'p'         => get_theme_mod( 'header_content' ),
			'post_type' => 'wp_block',
		]
	);

	if ( $inclusive_header_block_query->have_posts() ) {
		while ( $inclusive_header_block_query->have_posts() ) {
			$inclusive_header_block_query->the_post();
			echo '<div class="entry-content">', the_content(), '</div>';
		}
	}
	wp_reset_postdata();
}
