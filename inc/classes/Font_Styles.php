<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Font Styles
 *
 * @package Inclusive
 * @since 1.0.0
 */

namespace Inclusive;

use WP_Customize_Manager;
use WP_Customize_Control;

/**
 * Font Styles
 *
 * @since 1.0.0
 */
class Font_Styles {

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		add_action( 'customize_register', array( $this, 'action_register_customizer_control' ) );
	}

	/**
	 * Adds a Customizer section, settings, controls and partials.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer manager instance.
	 * @since 1.0.0
	 * @access public
	 */
	public function action_register_customizer_control( WP_Customize_Manager $wp_customize ) {

		$wp_customize->add_section(
			'font_styles',
			[
				'title' => __( 'Font sizes, weights & text shadows', 'inclusive' ),
				'panel' => 'theme_options',
			]
		);

		$wp_customize->add_setting(
			'site_title_font_size',
			[
				'default'           => '3',
				'transport'         => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field',
			]
		);

		$wp_customize->add_control(
			'site_title_font_size',
			[
				'label'       => __( 'Site title font size', 'inclusive' ),
				'description' => __( 'Adjust the font size using the rem unit.', 'inclusive' ) . ' ' . __( 'Different fonts may need different sizes to look their best.', 'inclusive' ) . ' ' . __( 'Sizes may also be adjusted for you, depending on screen size.', 'inclusive' ),
				'section'     => 'font_styles',
				'type'        => 'number',
				'input_attrs' => [
					'min'  => 0.3,
					'max'  => 7,
					'step' => 0.1,
				],
			]
		);

		$wp_customize->selective_refresh->add_partial(
			'site_title_font_size',
			[
				'selector' => '.site-title, .site-title a',
			]
		);

		$weight_choices = [
			'400' => __( '400 Normal.', 'inclusive' ),
			'700' => __( '700 Bold.', 'inclusive' ),
		];

		$wp_customize->add_setting(
			'site_title_font_weight',
			[
				'default'           => '700',
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_select',
			]
		);

		$wp_customize->add_control(
			'site_title_font_weight',
			[
				'label'       => __( 'Site title font weight', 'inclusive' ),
				'description' => __( 'A higher number means a bolder text style. ', 'inclusive' ),
				'section'     => 'font_styles',
				'type'        => 'radio',
				'choices'     => $weight_choices,
			]
		);

		$wp_customize->add_setting(
			'site_title_shadow',
			[
				'default'           => true,
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_checkbox',
			]
		);

		$wp_customize->add_control(
			'site_title_shadow',
			[
				'label'       => __( 'Site title text shadow', 'inclusive' ),
				'description' => __( 'Show a text shadow.', 'inclusive' ),
				'section'     => 'font_styles',
				'type'        => 'checkbox',
			]
		);

		/* widgets */
		$wp_customize->add_setting(
			'widgetarea_title_font_size',
			[
				'default'           => '1.5',
				'transport'         => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field',
			]
		);

		$wp_customize->add_control(
			'widgetarea_title_font_size',
			[
				'label'       => __( 'Widget title font size', 'inclusive' ),
				'description' => __( 'Adjust the font size using the em unit.', 'inclusive' ),
				'section'     => 'font_styles',
				'type'        => 'number',
				'input_attrs' => [
					'min'  => 0.3,
					'max'  => 7,
					'step' => 0.1,
				],
			]
		);

		$wp_customize->selective_refresh->add_partial(
			'widgetarea_title_font_size',
			[
				'selector' => '.widget-title',
			]
		);

		$wp_customize->add_setting(
			'widgetarea_title_font_weight',
			[
				'default'           => '400',
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_select',
			]
		);

		$wp_customize->add_control(
			'widgetarea_title_font_weight',
			[
				'label'   => __( 'Widget title font weight', 'inclusive' ),
				'section' => 'font_styles',
				'type'    => 'radio',
				'choices' => $weight_choices,
			]
		);

		$wp_customize->add_setting(
			'widgetarea_title_shadow',
			[
				'default'           => true,
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_checkbox',
			]
		);

		$wp_customize->add_control(
			'widgetarea_title_shadow',
			[
				'label'       => __( 'Widget title text shadow', 'inclusive' ),
				'description' => __( 'Show a text shadow.', 'inclusive' ),
				'section'     => 'font_styles',
				'type'        => 'checkbox',
			]
		);

		/** Post and page titles */
		$wp_customize->add_setting(
			'entry_title_font_size',
			[
				'default'           => '2.5',
				'transport'         => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field',
			]
		);

		$wp_customize->add_control(
			'entry_title_font_size',
			[
				'label'       => __( 'Post & page title font size', 'inclusive' ),
				'description' => __( 'Adjust the font size using the rem unit. ', 'inclusive' ),
				'section'     => 'font_styles',
				'type'        => 'number',
				'input_attrs' => [
					'min'  => 0.3,
					'max'  => 7,
					'step' => 0.1,
				],
			]
		);

		$wp_customize->selective_refresh->add_partial(
			'entry_title_font_size',
			[
				'selector' => '.entry-title',
			]
		);

		$wp_customize->add_setting(
			'entry_title_font_weight',
			[
				'default'           => '700',
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_select',
			]
		);

		$wp_customize->add_control(
			'entry_title_font_weight',
			[
				'label'   => __( 'Post & page title font weight', 'inclusive' ),
				'section' => 'font_styles',
				'type'    => 'radio',
				'choices' => $weight_choices,
			]
		);

		$wp_customize->add_setting(
			'entry_title_shadow',
			[
				'default'           => true,
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_checkbox',
			]
		);

		$wp_customize->add_control(
			'entry_title_shadow',
			[
				'label'       => __( 'Post & page title text shadow', 'inclusive' ),
				'description' => __( 'Show a text shadow.', 'inclusive' ),
				'section'     => 'font_styles',
				'type'        => 'checkbox',
			]
		);

		/** Meta font sizes */
		$wp_customize->add_setting(
			'meta_font_size',
			[
				'default'           => '1',
				'transport'         => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field',
			]
		);

		$wp_customize->add_control(
			'meta_font_size',
			[
				'label'       => __( 'Meta information font size', 'inclusive' ),
				'description' => __( 'Adjust the font size using the rem unit. ', 'inclusive' ),
				'section'     => 'font_styles',
				'type'        => 'number',
				'input_attrs' => [
					'min'  => 0.3,
					'max'  => 7,
					'step' => 0.1,
				],
			]
		);

		$wp_customize->selective_refresh->add_partial(
			'meta_font_size',
			[
				'selector' => '.posted-by, .posted-on, .entry-meta',
			]
		);

		/** Site info font sizes */
		$wp_customize->add_setting(
			'site_info_font_size',
			[
				'default'           => '0.9',
				'transport'         => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field',
			]
		);

		$wp_customize->add_control(
			'site_info_font_size',
			[
				'label'       => __( 'Site info font size', 'inclusive' ),
				'description' => __( 'Adjust the font size using the rem unit. ', 'inclusive' ),
				'section'     => 'font_styles',
				'type'        => 'number',
				'input_attrs' => [
					'min'  => 0.3,
					'max'  => 4,
					'step' => 0.1,
				],
			]
		);

		$wp_customize->selective_refresh->add_partial(
			'site_info_font_size',
			[
				'selector' => '.posted-by, .posted-on, .entry-meta',
			]
		);

	}

}

