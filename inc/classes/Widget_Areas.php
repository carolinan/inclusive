<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Widget_Areas
 *
 * @package Inclusive
 */

namespace Inclusive;

use WP_Customize_Manager;

/**
 * Widget areas/ panels / sidebars.
 *
 * @since 1.0.0
 */
class Widget_Areas {

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		add_action( 'widgets_init', [ $this, 'action_register_sidebars' ] );
	}

	/**
	 * Registers the sidebars.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function action_register_sidebars() {

		register_sidebar(
			[
				'name'          => esc_html__( 'Footer widget area', 'inclusive' ),
				'id'            => 'sidebar-1',
				'description'   => esc_html__( 'Add widgets here. The footer widget area is visible on all pages.', 'inclusive' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			]
		);

	}

}
