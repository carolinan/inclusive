<?php
/**
 * Template part for displaying a page's header
 *
 * @package Inclusive
 * @since 1.0.0
 */

/**
 * Don't print the entry header if all the options are disabled,
 * because that would leave an empty header tag in the markup.
 */
if ( is_singular( get_post_type() ) ) {
	if ( is_front_page() &&
	'page' === get_option( 'show_on_front' ) &&
	get_theme_mod( 'page_hide_title', true ) === true &&
	! has_post_thumbnail() &&
	get_theme_mod( 'page_show_author', false ) === false ) {
		return;
	}
}
?>
<header class="entry-header">
	<?php
	get_template_part( 'template-parts/content/post-thumbnail' );
	get_template_part( 'template-parts/content/entry-title' );
	get_template_part( 'template-parts/content/posted-by', get_post_type() );
	?>
</header><!-- .entry-header -->
