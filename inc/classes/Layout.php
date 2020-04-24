<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Layout Options
 *
 * @package Inclusive
 * @since 1.0.0
 */

namespace Inclusive;

use Inclusive\Styles;
use WP_Customize_Manager;

/**
 * Layout Options
 *
 * @since 1.0.0
 */
class Layout {

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		add_action( 'customize_register', [ $this, 'action_register_customizer_control' ] );
		add_filter( 'body_class', [ $this, 'filter_body_classes' ] );
		add_action( 'wp_footer', [ $this, 'action_custom_css' ], 10 );
	}

	/**
	 * Adds custom classes to indicate whether the boxed layout is enabled to the array of body classes.
	 *
	 * @param array $classes Classes for the body element.
	 * @return array Filtered body classes.
	 * @since 1.0.0
	 * @access public
	 */
	public function filter_body_classes( array $classes ) : array {
		if ( get_theme_mod( 'boxed_layout', false ) === true ) {
			$classes[] = 'has-boxed-layout';
		}
		if ( get_theme_mod( 'blog_layout', 'one-column' ) === 'two-columns' ) {
			$classes[] = 'has-two-column-layout';
		}
		return $classes;
	}

	/**
	 * Adds a Customizer section, settings, controls and partials.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer manager instance.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function action_register_customizer_control( WP_Customize_Manager $wp_customize ) {

		$wp_customize->add_section(
			'layout_section',
			array(
				'title'    => __( 'Layout', 'inclusive' ),
				'panel'    => 'theme_options',
				'priority' => 1,
			)
		);

		$wp_customize->add_setting(
			'boxed_layout',
			array(
				'default'           => false,
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'boxed_layout',
			array(
				'type'    => 'checkbox',
				'label'   => __( 'Enable boxed layout', 'inclusive' ),
				'section' => 'layout_section',
			)
		);

		$wp_customize->add_setting(
			'boxed_width',
			array(
				'default'           => 99,
				'sanitize_callback' => 'absint',
			)
		);

		$wp_customize->add_control(
			'boxed_width',
			array(
				'type'        => 'range',
				'label'       => __( 'Boxed Layout Width', 'inclusive' ),
				'description' => __( 'Select a custom width for the boxed layout. This will also constrain the width for full width blocks. Note: When enabled, the width on smaller screens such as mobiles will be 95%.', 'inclusive' ),
				'section'     => 'layout_section',
				'input_attrs' => array(
					'min' => 60,
					'max' => 99,
				),
			)
		);

		$wp_customize->add_setting(
			'blog_layout',
			array(
				'default'           => 'one-column',
				'transport'         => 'postMessage',
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_select',
			)
		);

		$wp_customize->add_control(
			'blog_layout',
			array(
				'label'       => __( 'Blog Layout & Content Visibility', 'inclusive' ),
				'description' => __( 'Choose whether to show the excerpt or the full content.', 'inclusive' ),
				'section'     => 'layout_section',
				'type'        => 'radio',
				'choices'     =>
				[
					'one-column'  => __( 'One column with excerpts (Default).', 'inclusive' ),
					'full'        => __( 'One column with full content (Great for full width blocks).', 'inclusive' ),
					'two-columns' => __( 'Two column grid with excerpts.', 'inclusive' ),
				],
			)
		);

		$wp_customize->selective_refresh->add_partial(
			'blog_layout',
			array(
				'selector'            => '.entry-summary',
				'container_inclusive' => true,
			)
		);

	}

	/**
	 * Output our custom width. This is so tiny, we won't use a file for this part.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function action_custom_css() {
		if ( get_theme_mod( 'boxed_width', 80 ) !== 80 && get_theme_mod( 'boxed_layout', false ) === true ) {
			echo '<style id="inclusive-boxed-layout">';
			echo '.has-boxed-layout .site{max-width:' . esc_html( get_theme_mod( 'boxed_width', 80 ) ) . '%; box-shadow: var(--small-shadow);}';
			echo '@media screen and (max-width: 37.5em) {.has-boxed-layout .site{max-width:95%;}}';
			echo '</style>';
		}

	}
}

