<?php
/**
 * Template part for displaying reusable blocks in the header.
 */
if ( get_theme_mod( 'header_content', 0 ) !== 0 ) {
	$query = new WP_Query(
		[
			'p'         => get_theme_mod( 'header_content' ),
			'post_type' => 'wp_block',
		]
	);

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			echo '<div class="entry-content">';
			the_content();
			echo '</div>';
		}
		wp_reset_postdata();
	}
}
