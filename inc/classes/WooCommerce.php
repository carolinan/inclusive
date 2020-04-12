<?php // phpcs:ignore WordPress.Files.FileName
/**
 * WooCommerce settings
 *
 * @package Inclusive
 * @since 1.0.0
 */

namespace Inclusive;

use Inclusive\Styles;
use WP_Customize_Manager;

use is_woocommerce;
use is_checkout;
use is_cart;

/**
 * WooCommerce
 *
 * @since 1.0.0
 */
class WooCommerce {

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		add_action( 'after_setup_theme', [ $this, 'action_add_woocommerce_support' ] );
		add_action( 'init', [ $this, 'action_woo_remove_wrappers' ] );
		add_action( 'woocommerce_before_main_content', [ $this, 'action_woo_wrapper_start' ], 10 );
		add_action( 'woocommerce_after_main_content', [ $this, 'action_woo_wrapper_end' ], 10 );
		add_action( 'customize_register', [ $this, 'action_register_customizer_control' ] );
		add_action( 'wp_footer', [ $this, 'action_custom_css' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'action_enqueue_woocommerce_styles' ] );
	}

	/**
	 * Adds support for WooCommerce
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function action_add_woocommerce_support() {
		add_theme_support( 'woocommerce' );
	}

	/**
	 * Check if WooCommerce is actives
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public static function is_woocommerce_active() {
		if ( class_exists( 'WooCommerce' ) ) {
			if ( is_woocommerce() || is_checkout() || is_cart() ) {
				return true;
			}
		}
	}

	/**
	 * WooCommerce styles
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function action_enqueue_woocommerce_styles() {
		if ( $this->is_woocommerce_active() ) {
			wp_enqueue_style(
				'inclusive-woocommerce-styles',
				get_template_directory_uri() . '/assets/css/min/woocommerce.min.css',
				null,
				INCLUSIVE_VERSION
			);
		}
	}

	/**
	 * Remove the breadcrumbs and wrappers
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function action_woo_remove_wrappers() {
		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
		remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
	}

	/**
	 * Create a new wrapper for WooCommerce.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function action_woo_wrapper_start() {
		echo '<main id="primary" class="site-main" role="main">';
	}

	/**
	 * Close the wrapper for WooCommerce.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function action_woo_wrapper_end() {
		echo '</main>';
	}

	/**
	 * Adds a Customizer setting and control.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer manager instance.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function action_register_customizer_control( WP_Customize_Manager $wp_customize ) {

		$wp_customize->add_section(
			'woo_breadcrumbs',
			array(
				'title' => __( 'WooCommerce Breadcrumbs', 'inclusive' ),
				'panel' => 'woocommerce',
			)
		);

		$wp_customize->add_setting(
			'disable_woo_breadcrumbs',
			array(
				'default'           => false,
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'disable_woo_breadcrumbs',
			array(
				'label'   => __( 'Disable WooCommerce Breadcrumbs', 'inclusive' ),
				'section' => 'woo_breadcrumbs',
				'type'    => 'checkbox',
			)
		);

		$wp_customize->selective_refresh->add_partial(
			'disable_woo_breadcrumbs',
			array(
				'selector'            => '.woocommerce-breadcrumb',
				'container_inclusive' => true,
			)
		);

	}

	/**
	 * Check if the WooCommerce Breadcrumbs are enabled or not.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public static function action_custom_css() {
		if ( get_theme_mod( 'disable_woo_breadcrumbs', false ) === true ) {
			echo '<style id="inclusive-disable-breadcrumbs">';
			echo '.woocommerce-breadcrumb {display:none;}';
			echo '</style>';
		}
	}

}

