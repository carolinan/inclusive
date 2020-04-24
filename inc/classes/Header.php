<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Header Settings
 *
 * @package Inclusive
 * @since 1.0.0
 */

namespace Inclusive;

use WP_Customize_Manager;

/**
 * Header Settings
 *
 * @since 1.0.0
 */
class Header {

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		add_action( 'customize_register', [ $this, 'action_register_customizer_control' ] );
	}

	/**
	 * Adds a Customizer setting and control
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer manager instance.
	 * @since 1.0.0
	 * @access public
	 */
	public function action_register_customizer_control( WP_Customize_Manager $wp_customize ) {

		/* Rename header media options */
			$wp_customize->get_control( 'header_image' )->label = __( 'Header Background Image', 'inclusive' );

		$wp_customize->add_setting(
			'header_height',
			[
				'default'           => '400',
				'sanitize_callback' => 'absint',
			]
		);

		$wp_customize->add_control(
			'header_height',
			[
				'type'    => 'number',
				'label'   => __( 'Select a minimum height for the header background image', 'inclusive' ),
				'section' => 'header_image',
			]
		);

		$wp_customize->add_setting(
			'full_screen_header_image',
			[
				'default'           => false,
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_checkbox',
			]
		);

		$wp_customize->add_control(
			'full_screen_header_image',
			[
				'type'    => 'checkbox',
				'label'   => __( 'Enable a fullscreen header image', 'inclusive' ),
				'section' => 'header_image',
			]
		);
	}

	/**
	 * Output custom header.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public static function header_image() {
		if ( ! has_header_image() ) {
			echo '<div class="site-branding">';
		} elseif ( get_theme_mod( 'full_screen_header_image', false ) === true ) {
			echo '<div class="site-branding" style="background: url(' . esc_url( get_header_image() ) . ') no-repeat top center; background-size: cover; height: 100vh;">';
		} else {
			echo '<div class="site-branding" style="background: url(' . esc_url( get_header_image() ) . ') no-repeat top center; background-size: cover; min-height:' . esc_attr( get_theme_mod( 'header_height', '400' ) ) . 'px;">';
		}

	}

}
