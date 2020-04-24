<?php
/**
 * Template part for displaying the social menu in the footer
 *
 * @package Inclusive
 * @since 1.0.0
 */

?>
<nav id="social-navigation" class="" role="navigation" aria-label="<?php esc_attr_e( 'Social menu', 'inclusive' ); ?>">
	<?php
	wp_nav_menu(
		[
			'theme_location' => 'social',
			'menu_id'        => 'social-menu',
			'menu_class'     => 'social-links-menu',
			'link_before'    => '<span class="screen-reader-text">',
			'link_after'     => '</span>',
			'depth'          => 1,
			'container'      => false,
		]
	);
	?>
</nav><!-- #social-navigation -->
