<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Pagination Options
 *
 * @package Inclusive
 * @since 1.0.0
 */

namespace Inclusive;

use WP_Customize_Manager;

/**
 * Pagination Options
 *
 * @since 1.0.0
 */
class Pagination {

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
	 * Adds a Customizer setting and control.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer manager instance.
	 */
	public function action_register_customizer_control( WP_Customize_Manager $wp_customize ) {

		$wp_customize->add_setting(
			'pagination',
			[
				'default'           => 'numeric',
				'transport'         => 'postMessage',
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_select',
			]
		);

		$wp_customize->add_control(
			'pagination',
			[
				'label'       => __( 'Pagination', 'inclusive' ),
				'description' => __( 'Select the pagination type.', 'inclusive' ),
				'section'     => 'blog_options',
				'type'        => 'radio',
				'choices'     =>
				[
					'numeric'         => __( 'Numeric: Previous 1 2 3 Next (default)', 'inclusive' ),
					'text_only'       => __( 'Text only: Older Posts - Newer Posts', 'inclusive' ),
					'hide_pagination' => __( 'Hide -Do not show pagination', 'inclusive' ),
				],
			]
		);

		$wp_customize->selective_refresh->add_partial(
			'pagination',
			[
				'selector'            => '.navigation',
				'container_inclusive' => true,
			]
		);

	}
}

