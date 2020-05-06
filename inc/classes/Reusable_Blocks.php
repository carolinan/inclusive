<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Options for reusable blocks
 *
 * @package Inclusive
 * @since 1.0.0
 */

namespace Inclusive;

use WP_Customize_Manager;

/**
 * Reusable blocks
 *
 * @since 1.0.0
 */
class Reusable_Blocks {

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
	 * @since 1.0.0
	 */
	public function action_register_customizer_control( WP_Customize_Manager $wp_customize ) {

		$wp_customize->add_section(
			'block_areas',
			[
				'title'    => __( 'Block areas', 'inclusive' ),
				'panel'    => 'theme_options',
				'priority' => 2,
			]
		);

		/**
		 * Register the setting.
		 */
		$wp_customize->add_setting(
			'header_content',
			[
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'default'           => 0,
				'transport'         => 'refresh',
				/**
				 * Sanitize callback for the post-ID.
				 *
				 * Check if the post-ID is an integer and a post-ID of a reusable block.
				 *
				 * @param int $post_id The post-ID we want to save.
				 * @return int
				 */
				'sanitize_callback' => function( $post_id ) {
					$post_id = absint( $post_id );
					if ( $post_id && 'wp_block' === get_post_type( $post_id ) ) {
						return $post_id;
					}
					return 0;
				},
			]
		);

		/**
		 * Get an array of reusable-blocks formatted as [ ID => Title ].
		 */
		$blocks = get_posts(
			[
				'post_type'   => 'wp_block',
				'numberposts' => 100,
			]
		);

		$choices = [ 0 => __( 'Select a block', 'inclusive' ) ];
		foreach ( $blocks as $block ) {
			$choices[ $block->ID ] = $block->post_title;
		}

		/**
		 * Register the control.
		 */
		$wp_customize->add_control(
			'header_content',
			[
				'type'        => 'select',
				'priority'    => 10,
				'section'     => 'block_areas',
				'label'       => esc_html__( 'Select Header Content', 'inclusive' ),
				'description' => sprintf(
					/* translators: %s: URL to the reusable-blocks admin page. */
					__( 'You can edit or create your header content in the <a href="%s" target="_blank">Reusable Blocks manager (opens in a new window)</a>.', 'inclusive' ),
					esc_url_raw( admin_url( 'edit.php?post_type=wp_block' ) )
				),
				'choices'     => $choices,
			]
		);

		/**
		 * Register the setting.
		 */
		$wp_customize->add_setting(
			'footer_content',
			[
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'default'           => 0,
				'transport'         => 'refresh',
				/**
				 * Sanitize callback for the post-ID.
				 *
				 * Check if the post-ID is an integer and a post-ID of a reusable block.
				 *
				 * @param int $post_id The post-ID we want to save.
				 * @return int
				 */
				'sanitize_callback' => function( $post_id ) {
					$post_id = absint( $post_id );
					if ( $post_id && 'wp_block' === get_post_type( $post_id ) ) {
						return $post_id;
					}
					return 0;
				},
			]
		);

		/**
		 * Get an array of reusable-blocks formatted as [ ID => Title ].
		 */
		$blocks = get_posts(
			[
				'post_type'   => 'wp_block',
				'numberposts' => 100,
			]
		);

		$choices = [ 0 => __( 'Select a block', 'inclusive' ) ];
		foreach ( $blocks as $block ) {
			$choices[ $block->ID ] = $block->post_title;
		}

		/**
		 * Register the control.
		 */
		$wp_customize->add_control(
			'footer_content',
			[
				'type'        => 'select',
				'priority'    => 10,
				'section'     => 'block_areas',
				'label'       => esc_html__( 'Select Footer Content', 'inclusive' ),
				'description' => sprintf(
					/* translators: %s: URL to the reusable-blocks admin page. */
					__( 'You can edit or create your footer content in the <a href="%s" target="_blank">Reusable Blocks manager (opens in a new window).</a>', 'inclusive' ),
					esc_url_raw( admin_url( 'edit.php?post_type=wp_block' ) )
				),
				'choices'     => $choices,
			]
		);
	}

}
