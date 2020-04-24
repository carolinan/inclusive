<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Add a link to the privacy policy page if one exists.
 *
 * @package Inclusive
 * @since 1.0.0
 */

namespace Inclusive;

use WP_Customize_Manager;

/**
 * Link to the privacy policy
 *
 * @since 1.0.0
 */
class Privacy_Policy_Link {

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
	 * Adds a Customizer setting, control and partial.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer manager instance.
	 * @since 1.0.0
	 * @access public
	 */
	public function action_register_customizer_control( WP_Customize_Manager $wp_customize ) {

		$wp_customize->add_setting(
			'show_privacy_policy_link',
			[
				'default'           => true,
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_checkbox',
			]
		);

		$wp_customize->add_control(
			'show_privacy_policy_link',
			[
				'type'    => 'checkbox',
				'label'   => __( 'Show the privacy policy link (Requires a Privacy Policy page).', 'inclusive' ),
				'section' => 'footer_options',
			]
		);

		$wp_customize->selective_refresh->add_partial(
			'show_privacy_policy_link',
			[
				'selector'            => '.footer-privacy-policy',
				'container_inclusive' => true,
			]
		);
	}

	/**
	 * Output the privacy policy link.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public static function privacy_policy() {
		if ( get_theme_mod( 'show_privacy_policy_link', true ) === true ) {
			the_privacy_policy_link( '<div class="footer-privacy-policy">', '</div>' );
		}
	}
}

