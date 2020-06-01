<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Branding
 *
 * @package Inclusive
 * @since 1.0.0
 */

namespace Inclusive;

use WP_Customize_Manager;

/**
 * Branding and header Options
 *
 * @since 1.0.0
 */
class Branding {

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		add_action( 'customize_register', [ $this, 'action_register_customizer_control' ] );
		add_filter( 'body_class', [ $this, 'filter_body_classes' ] );
	}

	/**
	 * Adds custom classes to indicate the branding position to the array of body classes.
	 *
	 * @param array $classes Classes for the body element.
	 * @return array Filtered body classes.
	 */
	public function filter_body_classes( array $classes ) : array {
		if ( get_theme_mod( 'align_branding', 'center' ) === 'left' ) {
			$classes[] = 'has-left-align-branding';
		} elseif ( get_theme_mod( 'align_branding', 'center' ) === 'right' ) {
			$classes[] = 'has-right-align-branding';
		}

		if ( get_theme_mod( 'full_screen_header_image', false ) === true ) {
			$classes[] = 'has-fullscreen-header';
		}

		return $classes;
	}

	/**
	 * Adds a Customizer setting and control
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer manager instance.
	 * @access public
	 * @since 1.0.0
	 */
	public function action_register_customizer_control( WP_Customize_Manager $wp_customize ) {
		/* Rename options */
		$wp_customize->get_section( 'title_tagline' )->title       = __( 'Site Identity & Branding', 'inclusive' );
		$wp_customize->get_control( 'display_header_text' )->label = __( 'Display Site Title in the primary menu.', 'inclusive' );

		$wp_customize->add_setting(
			'show_header_title',
			array(
				'default'           => false,
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'show_header_title',
			array(
				'label'   => __( 'Display Site Title in the header.', 'inclusive' ),
				'section' => 'title_tagline',
				'type'    => 'checkbox',
			)
		);

		$wp_customize->add_setting(
			'show_tagline',
			array(
				'default'           => false,
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'show_tagline',
			array(
				'type'     => 'checkbox',
				'label'    => __( 'Display Tagline in the header.', 'inclusive' ),
				'section'  => 'title_tagline',
				'priority' => 40,
			)
		);

		$wp_customize->add_setting(
			'menu_logo',
			array(
				'default'           => false,
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'menu_logo',
			array(
				'label'       => __( 'Display a small version of the logo to the left of the menu.', 'inclusive' ),
				'description' => __( 'Requires a logo. Links to the homepage.', 'inclusive' ),
				'section'     => 'title_tagline',
				'type'        => 'checkbox',
				'priority'    => 45,
			)
		);

		$wp_customize->add_setting(
			'show_header_logo',
			array(
				'default'           => true,
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'show_header_logo',
			array(
				'label'       => __( 'Display the logo in the header.', 'inclusive' ),
				'description' => __( 'Requires a logo. Links to the homepage.', 'inclusive' ),
				'section'     => 'title_tagline',
				'type'        => 'checkbox',
				'priority'    => 45,
			)
		);

		$wp_customize->add_setting(
			'show_header_area_on_archives',
			array(
				'default'           => false,
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'show_header_area_on_archives',
			array(
				'type'     => 'checkbox',
				'label'    => __( 'Show header area on archives and search pages.', 'inclusive' ),
				'section'  => 'title_tagline',
				'priority' => 45,
			)
		);

		$wp_customize->add_setting(
			'show_header_area_on_posts',
			array(
				'default'           => false,
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'show_header_area_on_posts',
			array(
				'type'     => 'checkbox',
				'label'    => __( 'Show header area on single posts.', 'inclusive' ),
				'section'  => 'title_tagline',
				'priority' => 50,
			)
		);

		$wp_customize->add_setting(
			'show_header_area_on_pages',
			array(
				'default'           => false,
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'show_header_area_on_pages',
			array(
				'type'     => 'checkbox',
				'label'    => __( 'Show header area on single pages.', 'inclusive' ),
				'section'  => 'title_tagline',
				'priority' => 55,
			)
		);

		$branding_align_choices = [
			'center' => __( 'Center (Default)', 'inclusive' ),
			'left'   => __( 'Left', 'inclusive' ),
			'right'  => __( 'Right', 'inclusive' ),
		];

		$wp_customize->add_setting(
			'align_branding',
			array(
				'default'           => 'center',
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_select',
			)
		);

		$wp_customize->add_control(
			'align_branding',
			array(
				'label'       => __( 'Branding Position', 'inclusive' ),
				'description' => __( 'The branding is centered by default.', 'inclusive' ),
				'section'     => 'title_tagline',
				'type'        => 'radio',
				'choices'     =>
				[
					'center' => __( 'Center (Default)', 'inclusive' ),
					'left'   => __( 'Left', 'inclusive' ),
					'right'  => __( 'Right', 'inclusive' ),
				],
				'priority'    => 60,
			)
		);

	}
}


