<?php
/**
 * Template part for displaying a post's title
 *
 * @package Inclusive
 * @since 1.0.0
 */

if ( is_singular( get_post_type() ) || get_post_type() === 'forum' ) {
	if ( is_front_page() && 'page' === get_option( 'show_on_front' ) && get_theme_mod( 'page_hide_title', true ) === true ) {
		return;
	} else {
		the_title( '<h1 class="entry-title">', '</h1>' );
	}
} elseif ( ! is_singular( get_post_type() ) ) {
	the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
}
