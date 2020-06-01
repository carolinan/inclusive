<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Copyright
 *
 * @package Inclusive
 * @since 1.0.0
 */

namespace Inclusive;

use WP_Customize_Manager;

/**
 *  Copyright Options
 */
class Copyright {

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
	 * @access public
	 */
	public function action_register_customizer_control( WP_Customize_Manager $wp_customize ) {

		$wp_customize->add_setting(
			'show_copyright',
			array(
				'default'           => true,
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'show_copyright',
			array(
				'type'    => 'checkbox',
				'label'   => __( 'Show the copyright text.', 'inclusive' ),
				'section' => 'footer_options',
			)
		);

		$wp_customize->add_setting(
			'copyright_text',
			array(
				'transport'         => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'copyright_text',
			array(
				'description' => __( 'Customize the Copyright text.', 'inclusive' ),
				'section'     => 'footer_options',
				'type'        => 'text',
				'input_attrs' => array(
					'placeholder' => __( 'Placeholder: Copyright', 'inclusive' ) . ' ' . date( 'Y' ) . ' ' . get_bloginfo( 'name' ),
				),
			)
		);

		$wp_customize->selective_refresh->add_partial(
			'copyright_text',
			array(
				'selector'            => '.footer-copyright',
				'container_inclusive' => true,
			)
		);
	}

	/**
	 * Output the copyright or the placeholder text, if the option is enabled.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public static function copyright() {
		if ( get_theme_mod( 'show_copyright', true ) === true ) {
			if ( get_theme_mod( 'copyright_text' ) ) {
				echo '<div class="footer-copyright">' . esc_html( get_theme_mod( 'copyright_text' ) ) . '</div>';
			} else {
				echo '<div class="footer-copyright">' . esc_html__( 'Copyright', 'inclusive' ) . ' ';
				/* translators: Copyright date format, see https://www.php.net/date */
				echo esc_html( date_i18n( _x( 'Y', 'copyright date format', 'inclusive' ) ) );
				echo ' ' . esc_html( get_bloginfo( 'name' ) ) . '</div>';
			}
		}
	}
}

