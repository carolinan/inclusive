<?php // phpcs:ignore WordPress.Files.FileName
/**
 * CUstomizer
 *
 * @package Inclusive
 * @since 1.0.0
 */

namespace Inclusive;

use WP_Customize_Manager;

/**
 * Class for managing Customizer integration.
 *
 * @since 1.0.0
 */
class Customizer {

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		add_action( 'customize_register', [ $this, 'action_customize_register' ] );
		add_action( 'customize_preview_init', [ $this, 'action_enqueue_customize_preview_js' ] );
	}

	/**
	 * Adds postMessage support for site title and description, plus a custom Theme Options section.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer manager instance.
	 * @since 1.0.0
	 * @access public
	 */
	public function action_customize_register( WP_Customize_Manager $wp_customize ) {
		$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

		if ( isset( $wp_customize->selective_refresh ) ) {
			$wp_customize->selective_refresh->add_partial(
				'blogname',
				[
					'selector'        => '.site-title a',
					'render_callback' => function() {
						bloginfo( 'name' );
					},
				]
			);
			$wp_customize->selective_refresh->add_partial(
				'blogdescription',
				[
					'selector'        => '.site-description',
					'render_callback' => function() {
						bloginfo( 'description' );
					},
				]
			);
		}

		/**
		 * Theme options.
		 */
		$wp_customize->add_panel(
			'theme_options',
			[
				'title'    => __( 'Theme Options', 'inclusive' ),
				'priority' => 130, // Before Additional CSS.
			]
		);

		$wp_customize->add_panel(
			'colors',
			[
				'title'    => __( 'Colors', 'inclusive' ),
				'priority' => 130, // Before Additional CSS.
			]
		);

		$wp_customize->add_section(
			'colors',
			array(
				'title' => __( 'General Colors', 'inclusive' ),
				'panel' => 'colors',
			)
		);

		$wp_customize->add_section(
			'menu-colors',
			array(
				'title' => __( 'Menu colors', 'inclusive' ),
				'panel' => 'colors',
			)
		);

		$wp_customize->add_section(
			'post-colors',
			array(
				'title' => __( 'Post Colors', 'inclusive' ),
				'panel' => 'colors',
			)
		);

		$wp_customize->add_section(
			'button-colors',
			array(
				'title' => __( 'Button Colors & Style', 'inclusive' ),
				'panel' => 'colors',
			)
		);

		$wp_customize->add_section(
			'footer-colors',
			array(
				'title' => __( 'Footer Colors', 'inclusive' ),
				'panel' => 'colors',
			)
		);

		$wp_customize->add_section(
			'widget-colors',
			array(
				'title' => __( 'Homepage Widget Colors', 'inclusive' ),
				'panel' => 'colors',
			)
		);

		$wp_customize->add_section(
			'footer_options',
			array(
				'title' => __( 'Footer options', 'inclusive' ),
				'panel' => 'theme_options',
			)
		);

	}

	/**
	 * Enqueue JavaScript for the customizer preview.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function action_enqueue_customize_preview_js() {
		wp_enqueue_script(
			'inclusive-customizer',
			get_template_directory_uri() . '/assets/js/customizer.min.js',
			[ 'customize-preview' ],
			INCLUSIVE_VERSION,
			true
		);
	}

	/**
	 * Sanitize boolean for checkbox.
	 *
	 * @param bool $checked Whether or not a box is checked.
	 * @return bool
	 * @since 1.0.0
	 * @access public
	 */
	public static function sanitize_checkbox( $checked ) {
		return ( ( isset( $checked ) && true === $checked ) ? true : false );
	}

	/**
	 * Sanitize select.
	 *
	 * @param string $input The input from the setting.
	 * @param object $setting The selected setting.
	 *
	 * @return string $input|$setting->default The input from the setting or the default setting.
	 */
	public static function sanitize_select( $input, $setting ) {
		$input   = sanitize_key( $input );
		$choices = $setting->manager->get_control( $setting->id )->choices;
		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
	}

}
