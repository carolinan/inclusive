<?php
/**
 * Widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Inclusive
 * @since 1.0.0
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}

Inclusive\Styles::get_template_part( 'sidebar', 'css', 'assets/css/min/sidebars.min.css' );
?>
<div class="primary-sidebar footer-sidebar widget-area">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</div>
