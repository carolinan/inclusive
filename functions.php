<?php
/**
 * Inclusive backwards compatibility and setup.
 *
 * @package Inclusive
 * @since 1.0.0
 */

/**
 * The theme version.
 *
 * @since 1.0.0
 */
define( 'INCLUSIVE_VERSION', wp_get_theme()->get( 'Version' ) );

/** Check if the WordPress version is 5.4 or higher, and if the PHP version is at least 7.3. If not, do not activate. */
if ( version_compare( $GLOBALS['wp_version'], '5.4', '<' ) || version_compare( PHP_VERSION_ID, '70300', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}

require_once get_template_directory() . '/inc/setup.php';
