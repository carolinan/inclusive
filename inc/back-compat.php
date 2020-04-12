<?php
/**
 * Inclusive Backwards compatibility
 *
 * @package Inclusive
 * @since 1.0.0
 */

/**
 * Prevent switching to the theme on old versions of WordPress.
 *
 * Switches to the default theme.
 *
 * @since 1.0.0
 */
function inclusive_switch_theme() {
	switch_theme( WP_DEFAULT_THEME );
	unset( $_GET['activated'] );
	add_action( 'admin_notices', 'inclusive_upgrade_notice' );
}
add_action( 'after_switch_theme', 'inclusive_switch_theme' );

/**
 * Adds a message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to the theme.
 *
 * @since 1.0.0
 *
 * @global string $wp_version WordPress version.
 */
function inclusive_upgrade_notice() {
	/* translators: %s: WordPress version. */
	$message = sprintf( __( 'Inclusive requires at least WordPress version 5.4. You are running version %s. Please upgrade and try again.', 'inclusive' ), $GLOBALS['wp_version'] );
	printf( '<div class="error"><p>%s</p></div>', $message );
}

/**
 * Prevents the Customizer from being loaded on WordPress versions prior to 5.4.
 *
 * @since 1.0.0
 *
 * @global string $wp_version WordPress version.
 */
function inclusive_customize() {
	wp_die(
		sprintf(
			/* translators: %s: WordPress version. */
			__( 'Inclusive requires at least WordPress version 5.4. You are running version %s. Please upgrade and try again.', 'inclusive' ),
			$GLOBALS['wp_version']
		),
		'',
		array(
			'back_link' => true,
		)
	);
}
add_action( 'load-customize.php', 'inclusive_customize' );

/**
 * Prevents the Theme Preview from being loaded on WordPress versions prior to 5.4.
 *
 * @since Inclusive 1.0.0
 *
 * @global string $wp_version WordPress version.
 */
function inclusive_preview() {
	if ( isset( $_GET['preview'] ) ) {
		/* translators: %s: WordPress version. */
		wp_die( sprintf( __( 'Inclusive requires at least WordPress version 5.4. You are running version %s. Please upgrade and try again.', 'inclusive' ), $GLOBALS['wp_version'] ) );
	}
}
add_action( 'template_redirect', 'inclusive_preview' );
