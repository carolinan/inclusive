<?php // phpcs:ignore WordPress.Files.FileName
/**
 * BBPress forum settings
 *
 * @package Inclusive
 * @since 1.0.4
 */

namespace Inclusive;

/**
 * BBPress
 *
 * @since 1.0.4
 */
class BBPress {

	/**
	 * Constructor.
	 *
	 * @since 1.0.4
	 * @access public
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'action_enqueue_bbp_styles' ] );
	}

	/**
	 * Check if BBPress is actives
	 *
	 * @since 1.0.4
	 * @access public
	 */
	public static function is_bbpress_active() {
		if ( class_exists( 'bbPress' ) ) {
			return true;
		}
	}

	/**
	 * BBPress styles
	 *
	 * @since 1.0.4
	 * @access public
	 */
	public function action_enqueue_bbp_styles() {
		if ( $this->is_bbpress_active() ) {
			wp_enqueue_style(
				'inclusive-bbpress-styles',
				get_template_directory_uri() . '/assets/css/min/bbpress.min.css',
				null,
				INCLUSIVE_VERSION
			);
		}
	}

}
