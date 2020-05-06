<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Page Options
 *
 * @package Inclusive
 * @since 1.0.0
 */

namespace Inclusive;

use WP_Customize_Manager;

/**
 * Page Options
 *
 * @since 1.0.0
 */
class Page_Options {

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
	 */
	public function action_register_customizer_control( WP_Customize_Manager $wp_customize ) {

		$wp_customize->add_section(
			'page_options',
			[
				'title'    => __( 'Page options', 'inclusive' ),
				'panel'    => 'theme_options',
				'priority' => 5,
			]
		);

		$wp_customize->add_setting(
			'page_show_author',
			[
				'default'           => false,
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_checkbox',
			]
		);

		$wp_customize->add_control(
			'page_show_author',
			[
				'type'        => 'checkbox',
				'label'       => __( 'Show "Written by" and [author name]".', 'inclusive' ),
				'description' => __( 'Show or hide the text and the author name below the title. ', 'inclusive' ),
				'section'     => 'page_options',
			]
		);

		$wp_customize->selective_refresh->add_partial(
			'page_show_author',
			[
				'selector' => '.type-page .posted-by',
			]
		);

		$wp_customize->add_setting(
			'page_hide_title',
			[
				'default'           => true,
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_checkbox',
			]
		);

		$wp_customize->add_control(
			'page_hide_title',
			[
				'type'        => 'checkbox',
				'label'       => __( 'Hide Page Title on Homepage.', 'inclusive' ),
				'description' => __( 'Hide the page title when the page is set as the homepage.', 'inclusive' ),
				'section'     => 'page_options',
			]
		);

	}

}
