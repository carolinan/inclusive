<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Inclusive Scripts
 *
 * @package Inclusive
 * @since 1.0.0
 */

namespace Inclusive;

/**
 * Add scripts
 *
 * @since 1.0.0
 */
class Scripts {

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		add_action( 'wp_head', [ $this, 'action_pingback' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'action_comment_reply' ] );
	}

	/**
	 * Check if pings are open, and add link to the header.
	 */
	public function action_pingback() {
		if ( is_singular() && pings_open() ) {
			echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
		}
	}

	/**
	 * Check if comments are open and enqueue the comment reply script.
	 * Enqueue the responsive video script, including the JS for video headers.
	 */
	public function action_comment_reply() {
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
		wp_enqueue_script(
			'inclusive-responsive-video',
			get_template_directory_uri() . '/assets/js/responsive-videos.min.js',
			[],
			INCLUSIVE_VERSION,
			true
		);
	}

}
