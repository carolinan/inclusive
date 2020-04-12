<?php
/**
 * Template part for displaying the next and previous posts.
 *
 * @package Inclusive
 * @since 1.0.0
 */

// Show post navigation only when the post type is 'post' or has an archive.
if ( 'post' === get_post_type() || get_post_type_object( get_post_type() )->has_archive ) {

	Inclusive\Styles::get_template_part( 'navigation', 'css', 'assets/css/min/navigation.min.css' );

	if ( get_theme_mod( 'show_navigation_text', true ) === true ) {
		the_post_navigation(
			[
				'prev_text' => '<div class="post-navigation-sub">' . esc_html__( 'Previous:', 'inclusive' ) . '</div><span>%title</span>',
				'next_text' => '<div class="post-navigation-sub">' . esc_html__( 'Next:', 'inclusive' ) . '</div><span>%title</span>',
			]
		);
	} else {
		the_post_navigation(
			[
				'prev_text' => '<div class="screen-reader-text">' . esc_html__( 'Previous:', 'inclusive' ) . '</div><span>%title</span>',
				'next_text' => '<div class="screen-reader-text">' . esc_html__( 'Next:', 'inclusive' ) . '</div><span>%title</span>',
			]
		);
	}
}
