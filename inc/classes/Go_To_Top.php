<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Go To Top Link
 *
 * @package Inclusive
 * @since 1.0.0
 */

namespace Inclusive;

use WP_Customize_Manager;

/**
 * Go to top link
 *
 * @since 1.0.0
 */
class Go_To_Top {

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
	 * Adds a Customizer setting, control and partial.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer manager instance.
	 * @since 1.0.0
	 * @access public
	 */
	public function action_register_customizer_control( WP_Customize_Manager $wp_customize ) {

		$wp_customize->add_setting(
			'go_to_top',
			[
				'default'           => true,
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_checkbox',
			]
		);

		$wp_customize->add_control(
			'go_to_top',
			[
				'label'       => __( 'Go to top link', 'inclusive' ),
				'description' => __( 'Enable a go to top link in the site footer. ', 'inclusive' ),
				'section'     => 'footer_options',
				'type'        => 'checkbox',
			]
		);

		$wp_customize->selective_refresh->add_partial(
			'go_to_top',
			[
				'selector'            => '.go-to-top',
				'container_inclusive' => true,
			]
		);

	}

	/**
	 * Outputs the back to top text.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public static function go_to_top() {
		if ( get_theme_mod( 'go_to_top', true ) === true ) {
			?>
			<div class="go-to-top">
				<a id="toTop" class="go-to-top" href="#" title="<?php esc_attr_e('Go to Top', 'inclusive'); ?>">
                <?php esc_html_e( 'Go to top', 'inclusive' ); ?>
            	</a>
			</div>
			<?php
		}
	}
}
