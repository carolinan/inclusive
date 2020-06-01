<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Inclusive Menus.
 *
 * @package Inclusive
 * @since 1.0.0
 */

namespace Inclusive;

use WP_Customize_Manager;
use WP_Post;
use Inclusive\Icons;

/**
 * Setup our main navigation.
 *
 * @since 1.0.0
 */
class Menus {
	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		add_filter( 'walker_nav_menu_start_el', [ $this, 'filter_add_nav_sub_menu_buttons' ], 10, 4 );
		add_filter( 'body_class', [ $this, 'filter_body_classes' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'action_menu_scripts' ] );
		add_action( 'customize_register', [ $this, 'action_register_customizer_control' ] );
	}

	/**
	 * Filter the HTML output of a nav menu item to add the dropdown button that reveal the sub-menu.
	 *
	 * @access public
	 * @since 1.0.0
	 * @param string $item_output Nav menu item HTML.
	 * @param object $item        Nav menu item.
	 * @param int    $depth       The depth of the menu.
	 * @param array  $args        Array of menu args, such as theme location.
	 * @return string Modified nav menu item HTML.
	 */
	public function filter_add_nav_sub_menu_buttons( $item_output, $item, $depth, $args ) {
		// Only add the sub menu button to our main navigation. Was: ⌵, replaced with dashicon 2020-04-10.
		if ( 'menu-1' === $args->theme_location ) {
			$html = '<span>';

			// Skip when the item has no sub-menu.
			if ( in_array( 'menu-item-has-children', $item->classes, true ) ) {
				$html         = '<span>';
				$item_output .= '<button onClick="InclusiveMenuItemExpand(this)"><span class="screen-reader-text">' . esc_html__( 'Toggle Child Menu', 'inclusive' ) . '</span>' . Icons::get_svg( 'ui', 'arrow-down', '20' ) . '</button>';
			}

			$html .= $item_output;

			$html .= '</span>';

			return $html;
		} else {
			return $item_output;
		}
	}

	/**
	 * Enqueue JavaScript for the menu.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function action_menu_scripts() {
		wp_enqueue_script(
			'inclusive-navigation',
			get_template_directory_uri() . '/assets/js/nav.min.js',
			[],
			INCLUSIVE_VERSION,
			true
		);
	}

	/**
	 * Adds custom classes to indicate whether a menu is sticky or has a
	 * specific postition to the array of body classes.
	 *
	 * @param array $classes Classes for the body element.
	 * @return array Filtered body classes.
	 * @since 1.0.0
	 * @access public
	 */
	public function filter_body_classes( array $classes ) : array {
		if ( get_theme_mod( 'sticky_menu', 'static' ) === 'sticky' ) {
			$classes[] = 'has-sticky-menu';
		}

		if ( get_theme_mod( 'align_menu', 'center' ) === 'left' ) {
			$classes[] = 'has-left-align-menu';
		} elseif ( get_theme_mod( 'align_menu', 'center' ) === 'right' ) {
			$classes[] = 'has-right-align-menu';
		}

		if ( get_theme_mod( 'menu_search', true ) === true ) {
			$classes[] = 'has-menu-search';
		}

		return $classes;
	}

	/**
	 * Customizer option for positioning the main menu and selecting an icon.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer manager instance.
	 * @since 1.0.0
	 * @access public
	 */
	public function action_register_customizer_control( WP_Customize_Manager $wp_customize ) {

		$wp_customize->add_section(
			'menu_options',
			array(
				'title'    => __( 'Header menu options', 'inclusive' ),
				'panel'    => 'theme_options',
				'priority' => 2,
			)
		);

		$wp_customize->add_setting(
			'sticky_menu',
			array(
				'default'           => 'static',
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_select',
			)
		);

		$wp_customize->add_control(
			'sticky_menu',
			array(
				'label'    => __( 'Select how to display the primary menu', 'inclusive' ),
				'section'  => 'menu_options',
				'type'     => 'radio',
				'choices'  =>
				[
					'static' => __( 'Let the menu scroll with the page (default).', 'inclusive' ),
					'sticky' => __( 'Stick the menu to the top of the page.', 'inclusive' ),
				],
				'priority' => 40,
			)
		);

		$wp_customize->selective_refresh->add_partial(
			'sticky_menu',
			array(
				'selector'            => '#site-navigation',
				'container_inclusive' => true,
			)
		);

		$wp_customize->add_setting(
			'align_menu',
			array(
				'default'           => 'center',
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_select',
			)
		);

		$wp_customize->add_control(
			'align_menu',
			array(
				'label'    => __( 'Menu Position', 'inclusive' ),
				'section'  => 'menu_options',
				'type'     => 'radio',
				'choices'  =>
				[
					'center' => __( 'Center (Default)', 'inclusive' ),
					'left'   => __( 'Left', 'inclusive' ),
					'right'  => __( 'Right', 'inclusive' ),
				],
				'priority' => 40,
			)
		);

		$wp_customize->selective_refresh->add_partial(
			'align_menu',
			array(
				'selector'            => '.main-navigation',
				'container_inclusive' => true,
			)
		);

		$wp_customize->add_setting(
			'menu_icon',
			array(
				'default'           => 'none',
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_select',
			)
		);

		$wp_customize->add_control(
			'menu_icon',
			array(
				'label'    => __( 'Select an icon for the mobile menu', 'inclusive' ),
				'section'  => 'menu_options',
				'type'     => 'radio',
				'choices'  =>
				[
					'none' => __( 'No icon, only text.', 'inclusive' ),
					'menu' => __( 'Hamburger menu icon (3 lines).', 'inclusive' ),
					'plus' => __( 'Plus icon.', 'inclusive' ),
				],
				'priority' => 40,
			)
		);


		$wp_customize->add_setting(
			'menu_search',
			array(
				'default'           => true,
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'menu_search',
			array(
				'label'   => __( 'Display search.', 'inclusive' ),
				'section' => 'menu_options',
				'type'    => 'checkbox',
			)
		);

		$wp_customize->selective_refresh->add_partial(
			'menu_search',
			array(
				'selector'            => '.topsearch',
				'container_inclusive' => true,
			)
		);
	}
}
