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
		add_action( 'customize_register', [ $this, 'action_register_customizer_control' ] );
		add_action( 'wp_head', [ $this, 'action_custom_css' ], 11 );
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
				'description' => __( 'Note that these setting are applied to the site title in the header area, not the menu. Adjust the font size using the rem unit.', 'inclusive' ) . ' ' . __( 'Different fonts may need different sizes to look their best.', 'inclusive' ) . ' ' . __( 'Sizes may also be adjusted for you, depending on screen size, to ensure that your website is responsive.', 'inclusive' ),
				'section'     => 'font_styles',
				'type'        => 'number',
				'input_attrs' => [
					'min'  => 0.5,
					'max'  => 7,
					'step' => 0.1,
				],
			]
		);

		$wp_customize->selective_refresh->add_partial(
			'site_title_font_size',
			[
				'selector' => '.site-title a',
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

		$wp_customize->add_setting(
			'menu_font_size',
			[
				'default'           => '1.25',
				'transport'         => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field',
			]
		);

		$wp_customize->add_control(
			'menu_font_size',
			[
				'label'       => __( 'Menu font size', 'inclusive' ),
				'description' => __( 'Adjust the font size using the rem unit. ', 'inclusive' ),
				'section'     => 'font_styles',
				'type'        => 'number',
				'input_attrs' => [
					'min'  => 1,
					'max'  => 2,
					'step' => 0.1,
				],
			]
		);

		$wp_customize->add_setting(
			'menu_text_shadow',
			[
				'default'           => true,
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_checkbox',
			]
		);

		$wp_customize->add_control(
			'menu_text_shadow',
			[
				'label'       => __( 'Menu text shadow', 'inclusive' ),
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

	/**
	 * Output our custom font styles.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function action_custom_css() {
		echo '<style id="inclusive-font-css">';

		if ( get_theme_mod( 'site_title_shadow', true ) === false ) {
			echo '.site-title { text-shadow: none;}';
		}

		if ( get_theme_mod( 'menu_text_shadow', true ) === false ) {
			echo '.main-navigation { text-shadow: none !important;}';
		}

		if ( get_theme_mod( 'widgetarea_title_shadow', true ) === false ) {
			echo '.widget-title { text-shadow: none !important;}';
		}

		if ( get_theme_mod( 'entry_title_shadow', true ) === false ) {
			echo '.entry-title { text-shadow: none !important;}';
		}

		if ( get_theme_mod( 'site_title_font_size', '3' ) !== '3' ) {
			echo '.site-title { font-size:' . esc_html( get_theme_mod( 'site_title_font_size' ) ) . 'rem; }';
		}

		if ( get_theme_mod( 'site_title_font_weight', '700' ) !== '700' ) {
			echo '.site-title { font-weight:' . esc_html( get_theme_mod( 'site_title_font_weight' ) ) . '; }';
		}

		if ( get_theme_mod( 'menu_font_size', '1.25' ) !== '1.25' ) {
			echo '.main-navigation, .main-navigation .menu-extras .menu-title { font-size:' . esc_html( get_theme_mod( 'menu_font_size' ) ) . 'rem; }';
		}

		if ( get_theme_mod( 'widgetarea_title_font_size', '1.5' ) !== '1.5' ) {
			echo 'body { .widget-title: ' . esc_html( get_theme_mod( 'widgetarea_title_font_size' ) ) . 'em; }';
		}

		if ( get_theme_mod( 'widgetarea_title_font_weight', '400' ) !== '400' ) {
			echo '.widget-title { font-weight:' . esc_html( get_theme_mod( 'widgetarea_title_font_weight' ) ) . ' !important; }';
		}

		if ( get_theme_mod( 'entry_title_font_size', '2.5' ) !== '2.5' ) {
			echo '.entry-header .entry-title { font-size: ' . esc_html( get_theme_mod( 'entry_title_font_size' ) ) . 'rem !important; }';
		}

		if ( get_theme_mod( 'entry_title_font_weight', '700' ) !== '700' ) {
			echo '.entry-title { font-weight:' . esc_html( get_theme_mod( 'entry_title_font_weight' ) ) . '; }';
		}

		if ( get_theme_mod( 'meta_font_size', '1' ) !== '1' ) {
			echo '.posted-by, .posted-on, .entry-meta, .entry-comments-link { font-size: ' . esc_html( get_theme_mod( 'meta_font_size' ) ) . 'rem !important; }';
		}

		if ( get_theme_mod( 'site_info_font_size', '0.9' ) !== '0.9' ) {
			echo '.footer-copyright, .go-to-top { font-size: ' . esc_html( get_theme_mod( 'site_info_font_size' ) ) . 'rem !important; }';
		}
		echo '</style>';
	}

}

