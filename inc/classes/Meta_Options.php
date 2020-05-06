<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Meta Options
 *
 * @package Inclusive
 * @since 1.0.0
 */

namespace Inclusive;

use WP_Customize_Manager;

/**
 * Meta Options
 *
 * @since 1.0.0
 */
class Meta_Options {

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
	 * @access public
	 * @param WP_Customize_Manager $wp_customize Customizer manager instance.
	 */
	public function action_register_customizer_control( WP_Customize_Manager $wp_customize ) {

		$wp_customize->add_section(
			'meta_options',
			[
				'title'    => __( 'Meta options', 'inclusive' ),
				'panel'    => 'theme_options',
				'priority' => 6,
			]
		);

		$wp_customize->add_setting(
			'align_entry_header',
			[
				'default'           => 'center',
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_select',
			]
		);

		$wp_customize->add_control(
			'align_entry_header',
			[
				'label'       => __( 'Title & Meta Position', 'inclusive' ),
				'description' => __( 'Select the alignment of the post and page title, author name and date.', 'inclusive' ),
				'section'     => 'meta_options',
				'type'        => 'radio',
				'choices'     =>
				[
					'center' => __( 'Center (Default)', 'inclusive' ),
					'left'   => __( 'Left', 'inclusive' ),
					'right'  => __( 'Right', 'inclusive' ),
				],
			]
		);

		$wp_customize->add_setting(
			'posted_by',
			[
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			]
		);

		$wp_customize->add_control(
			'posted_by',
			[
				'type'        => 'text',
				'label'       => __( 'Written by [author name] Text', 'inclusive' ),
				'description' => __( 'Add an optional text to show before the author name. Examples: Posted by, Published by. Leave the field empty to only show the author name.', 'inclusive' ),
				'section'     => 'meta_options',
			]
		);

		$wp_customize->add_setting(
			'publishing_date_text',
			[
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			]
		);

		$wp_customize->add_control(
			'publishing_date_text',
			[
				'type'        => 'text',
				'label'       => __( 'Posted on [date] Text', 'inclusive' ),
				'description' => __( 'Add an optional text to show before the publishing date. Examples: Posted on, Published on. Leave the field empty to only show the date.', 'inclusive' ),
				'section'     => 'meta_options',
			]
		);

		$wp_customize->add_setting(
			'category_text',
			[
				'default'           => __( 'Published under:', 'inclusive' ),
				'sanitize_callback' => 'sanitize_text_field',
			]
		);

		$wp_customize->add_control(
			'category_text',
			[
				'type'        => 'text',
				'label'       => __( 'Published under [category] Text', 'inclusive' ),
				'description' => __( 'Add an optional text to show before the categories. Examples: Categories:, Published under. Leave the field empty to only show the list of categories.', 'inclusive' ),
				'section'     => 'meta_options',
			]
		);

		$wp_customize->add_setting(
			'tag_separator',
			[
				'default'           => __( '#', 'inclusive' ),
				'sanitize_callback' => 'sanitize_text_field',
			]
		);

		$wp_customize->add_control(
			'tag_separator',
			[
				'type'        => 'text',
				'label'       => __( 'Separator before tags', 'inclusive' ),
				'description' => __( 'Add an optional separator before the tags. Examples: #, |, / . ', 'inclusive' ),
				'section'     => 'meta_options',
			]
		);

	}

}
