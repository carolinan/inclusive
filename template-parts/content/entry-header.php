<?php
/**
 * Template part for displaying a post's header
 *
 * @package Inclusive
 * @since 1.0.0
 */

?>
<header class="entry-header">
	<?php
	get_template_part( 'template-parts/content/post-thumbnail' );
	get_template_part( 'template-parts/content/entry-title' );
	get_template_part( 'template-parts/content/posted-by', get_post_type() );

	if ( is_single() && get_theme_mod( 'show_categories', true ) === true ||
		is_archive() && get_theme_mod( 'archive_show_categories', true ) === true ||
		is_home() && get_theme_mod( 'archive_show_categories', true ) === true ||
		is_search() && get_theme_mod( 'archive_show_categories', true ) === true ) {
			get_template_part( 'template-parts/content/categories' );
	}
	?>
</header><!-- .entry-header -->
