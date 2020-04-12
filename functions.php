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

/** Check if the version is 5.4 or higher. If not, do not activate. */
if ( version_compare( $GLOBALS['wp_version'], '5.4', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}

require_once get_template_directory() . '/inc/setup.php';
