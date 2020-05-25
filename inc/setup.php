<?php
/**
 * Inclusive Setup.
 *
 * @package Inclusive
 */

namespace Inclusive;

/**
 * Autoloader. The prefix is our name space.
 *
 * @param string $class The fully-qualified class name.
 * @return void
 */
spl_autoload_register(
	function( $class ) {
		$prefix   = 'Inclusive\\';
		$base_dir = __DIR__ . '/classes/';

		$len = strlen( $prefix );
		if ( 0 !== strncmp( $prefix, $class, $len ) ) {
			return;
		}
		$relative_class = substr( $class, $len );
		$file           = $base_dir . str_replace( '\\', '/', $relative_class ) . '.php';
		if ( file_exists( $file ) ) {
			require $file; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
		}
	}
);

new Theme_Support();
new Scripts();
new Styles();
new Admin();
new BBPress();
new Biography();
new Reusable_Blocks();
new Block_Styles();
Block_Styles::register_custom_block_styles();
new Blog_Options();
new Branding();
new Colors();
new Copyright();
new Customizer();
new Editor();
new Font_Pairs();
new Font_Styles();
new Go_To_Top();
new Header();
new Icons();
new Layout();
new Menus();
new Meta_Options();
new Page_Options();
new Pagination();
new Post_Options();
new Privacy_Policy_Link();
new Related_Posts();
new Social_Sharing();
new Starter_Content();
new Widget_Areas();
new WooCommerce();
new Widget_Output_Filters();

/**
 * Custom CSS should be at the end of everything else in order to override existing styles.
 * We need to unhook it from wp_head and hook it in wp_footer.
 */
add_action(
	'wp_head',
	function() {
		remove_action( 'wp_head', 'wp_custom_css_cb', 101 );
		add_action( 'wp_footer', 'wp_custom_css_cb', PHP_INT_MAX );
	},
	10
);
