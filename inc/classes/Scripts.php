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
		add_action( 'wp_print_footer_scripts', [ $this, 'action_skip_link_focus_fix' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'action_comment_reply' ] );
	}

	/**
	 * Prints an inline script to fix skip link focus in IE11.
	 *
	 * The script is not enqueued because it is tiny and because it is only for IE11,
	 * thus it does not warrant having an entire dedicated blocking script being loaded.
	 *
	 * Since it will never need to be changed, it is simply printed in its minified version.
	 *
	 * @link https://git.io/vWdr2
	 */
	public function action_skip_link_focus_fix() {
		?>
		<script>
		/(trident|msie)/i.test(navigator.userAgent)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",function(){var t,e=location.hash.substring(1);/^[A-z0-9_-]+$/.test(e)&&(t=document.getElementById(e))&&(/^(?:a|select|input|button|textarea)$/i.test(t.tagName)||(t.tabIndex=-1),t.focus())},!1);
		</script>
		<?php
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

		wp_enqueue_script(
			'inclusive-custom',
			get_template_directory_uri() . '/assets/js/custom.js',
			[],
			INCLUSIVE_VERSION,
			true
		);
	}

}
