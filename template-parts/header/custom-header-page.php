<?php
/**
 * Template part for displaying the custom header media
 *
 * @package Inclusive
 * @since 1.0.0
 */

if ( ! is_front_page() && is_page() && get_theme_mod( 'show_header_area_on_pages', false ) === false ) {
	return;
}

if ( get_theme_mod( 'show_header_title', false ) === false &&
	get_theme_mod( 'show_tagline', false ) === false &&
	! has_header_image() &&
	get_theme_mod( 'header_content', 0 ) === 0 &&
	! has_custom_logo() ) {
	return;
}

if ( is_archive() && get_theme_mod( 'show_header_area_on_archives', false ) === false ||
	is_404() && get_theme_mod( 'show_header_area_on_archives', false ) === false ||
	is_search() && get_theme_mod( 'show_header_area_on_archives', false ) === false ) {
	return;
}

Inclusive\Styles::get_template_part( 'branding', 'css', 'assets/css/min/branding.min.css' );
?>
<header id="masthead" class="site-header" role="banner">
	<?php
	Inclusive\Header::header_image();

	get_template_part( 'template-parts/header/branding' );
	?>
</header><!-- #masthead -->
