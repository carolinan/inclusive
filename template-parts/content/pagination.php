<?php
/**
 * Template part for displaying a pagination
 *
 * @package Inclusive
 * @since 1.0.0
 */

if ( get_theme_mod( 'pagination', 'numeric' ) === 'hide_pagination' ) {
	return;
} elseif ( get_theme_mod( 'pagination', 'numeric' ) === 'numeric' ) {
	the_posts_pagination(
		[
			'mid_size'           => 1,
			'prev_text'          => _x( 'Previous', 'previous set of search results', 'inclusive' ),
			'next_text'          => _x( 'Next', 'next set of search results', 'inclusive' ),
			'screen_reader_text' => __( 'Page navigation', 'inclusive' ),
		]
	);
} else {
	the_posts_navigation();
}
