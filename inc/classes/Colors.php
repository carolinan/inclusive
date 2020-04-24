<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Inclusive Color Options
 *
 * @package Inclusive
 * @since 1.0.0
 */

namespace Inclusive;

use WP_Customize_Manager;
use WP_Customize_Color_Control;

/**
 * Color Options
 *
 * @since 1.0.0
 */
class Colors {

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		add_action( 'customize_register', [ $this, 'action_register_customizer_control' ] );
		add_action( 'wp_footer', [ $this, 'action_custom_css' ], 11 );
	}

	/**
	 * Adds a Customizer setting and control for selecting colors.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer manager instance.
	 * @since 1.0.0
	 * @access public
	 */
	public function action_register_customizer_control( WP_Customize_Manager $wp_customize ) {

		$wp_customize->add_setting(
			'body_bgcolor',
			[
				'default'           => '#fff',
				'sanitize_callback' => 'sanitize_hex_color',
			]
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'body_bgcolor',
				[
					'label'    => __( 'Body Background Color', 'inclusive' ),
					'section'  => 'colors',
					'settings' => 'body_bgcolor',
				]
			)
		);

		$wp_customize->add_setting(
			'boxed_body_bgcolor',
			[
				'default'           => '#fff',
				'sanitize_callback' => 'sanitize_hex_color',
			]
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'boxed_body_bgcolor',
				[
					'label'       => __( 'Boxed Body Background Color', 'inclusive' ),
					'description' => __( 'Background Color for the area outside the box, when the boxed layout is enabled.', 'inclusive' ),
					'section'     => 'colors',
					'settings'    => 'boxed_body_bgcolor',
				]
			)
		);

		$wp_customize->add_setting(
			'header_bgcolor',
			array(
				'default'           => '#fff',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'header_bgcolor',
				array(
					'label'    => __( 'Header Background Color', 'inclusive' ),
					'section'  => 'colors',
					'settings' => 'header_bgcolor',
				)
			)
		);

		$wp_customize->add_setting(
			'branding_bgcolor',
			array(
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'branding_bgcolor',
				array(
					'label'       => __( 'Branding Background Color', 'inclusive' ),
					'description' => __( 'Adding a background color behind the site title and tag line in the header can improve readability if you are using a background image.', 'inclusive' ),
					'section'     => 'colors',
					'settings'    => 'branding_bgcolor',
				)
			)
		);

		$wp_customize->add_setting(
			'body_text_color',
			array(
				'default'           => '#333',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'body_text_color',
				array(
					'label'    => __( 'Body Text Color', 'inclusive' ),
					'section'  => 'colors',
					'settings' => 'body_text_color',
				)
			)
		);

		$wp_customize->add_setting(
			'link_color',
			array(
				'default'           => '#333',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'link_color',
				array(
					'label'    => __( 'Link Color', 'inclusive' ),
					'section'  => 'colors',
					'settings' => 'link_color',
				)
			)
		);

		$wp_customize->add_setting(
			'meta_color',
			array(
				'default'           => '#727272',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'meta_color',
				array(
					'label'    => __( 'Meta text and link color', 'inclusive' ),
					'section'  => 'colors',
					'settings' => 'meta_color',
				)
			)
		);

		$wp_customize->add_setting(
			'link_accent_color',
			array(
				'default'           => '#fdeee1',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'link_accent_color',
				array(
					'label'       => __( 'Link Underline Accent Color', 'inclusive' ),
					'description' => __( 'Select a color for the decorative underline. This is an accent color used only for some links.', 'inclusive' ),
					'section'     => 'colors',
					'settings'    => 'link_accent_color',
				)
			)
		);

		$wp_customize->add_setting(
			'link_accent_hover_color',
			array(
				'default'           => '#fdb698',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'link_accent_hover_color',
				array(
					'label'       => __( 'Link Hover Underline Accent Color', 'inclusive' ),
					'description' => __( 'Shows when the link is hovered, focused, or active.', 'inclusive' ),
					'section'     => 'colors',
					'settings'    => 'link_accent_hover_color',
				)
			)
		);

		$wp_customize->add_setting(
			'menubg_color',
			array(
				'default'           => '#fff',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'menubg_color',
				array(
					'label'    => __( 'Menu Background Color', 'inclusive' ),
					'section'  => 'menu-colors',
					'settings' => 'menubg_color',
				)
			)
		);

		$wp_customize->add_setting(
			'submenubg_color',
			array(
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'submenubg_color',
				array(
					'label'    => __( 'Submenu Background Color', 'inclusive' ),
					'section'  => 'menu-colors',
					'settings' => 'submenubg_color',
				)
			)
		);

		$wp_customize->add_setting(
			'submenu_hover_bg_color',
			array(
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'submenu_hover_bg_color',
				array(
					'label'    => __( 'Submenu Hover Background Color', 'inclusive' ),
					'section'  => 'menu-colors',
					'settings' => 'submenu_hover_bg_color',
				)
			)
		);

		$wp_customize->add_setting(
			'menu_link_color',
			array(
				'default'           => '#333',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'menu_link_color',
				array(
					'label'    => __( 'Menu Text & Link Color', 'inclusive' ),
					'section'  => 'menu-colors',
					'settings' => 'menu_link_color',
				)
			)
		);

		$wp_customize->add_setting(
			'current_menu_link_color',
			array(
				'default'           => '#333',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'current_menu_link_color',
				array(
					'label'    => __( 'Current Menu Item Link Color', 'inclusive' ),
					'section'  => 'menu-colors',
					'settings' => 'current_menu_link_color',
				)
			)
		);

		$wp_customize->add_setting(
			'menu_shadow',
			array(
				'default'           => true,
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'menu_shadow',
			array(
				'label'       => __( 'Menu Shadow', 'inclusive' ),
				'description' => __( 'Show a shadow below the menu.', 'inclusive' ),
				'section'     => 'menu-colors',
				'type'        => 'checkbox',
			)
		);

		$wp_customize->add_setting(
			'footerbg_color',
			array(
				'default'           => '#fcfcfc',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'footerbg_color',
				array(
					'label'    => __( 'Footer Background Color', 'inclusive' ),
					'section'  => 'footer-colors',
					'settings' => 'footerbg_color',
				)
			)
		);

		$wp_customize->add_setting(
			'footer_color',
			array(
				'default'           => '#333',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'footer_color',
				array(
					'label'    => __( 'Footer Text & Link Color', 'inclusive' ),
					'section'  => 'footer-colors',
					'settings' => 'footer_color',
				)
			)
		);

		$wp_customize->add_setting(
			'siteinfobg_color',
			array(
				'default'           => '#f9f9f9',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'siteinfobg_color',
				array(
					'label'    => __( 'Footer Site Info Background Color', 'inclusive' ),
					'section'  => 'footer-colors',
					'settings' => 'siteinfobg_color',
				)
			)
		);

		$wp_customize->add_setting(
			'siteinfo_color',
			array(
				'default'           => '#333',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'siteinfo_color',
				array(
					'label'    => __( 'Footer Site Info Text & Link Color', 'inclusive' ),
					'section'  => 'footer-colors',
					'settings' => 'siteinfo_color',
				)
			)
		);

		$wp_customize->add_setting(
			'button_bgcolor',
			array(
				'default'           => '#f9f9f9',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'button_bgcolor',
				array(
					'label'       => __( 'Button Background Color', 'inclusive' ),
					'description' => __( 'The options are applied on form buttons, such as submit buttons.', 'inclusive' ),
					'section'     => 'button-colors',
					'settings'    => 'button_bgcolor',
				)
			)
		);

		$wp_customize->add_setting(
			'button_color',
			array(
				'default'           => '#333',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'button_color',
				array(
					'label'    => __( 'Button Text Color', 'inclusive' ),
					'section'  => 'button-colors',
					'settings' => 'button_color',
				)
			)
		);

		$wp_customize->add_setting(
			'button_hover_bgcolor',
			array(
				'default'           => '#fcfcfc',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'button_hover_bgcolor',
				array(
					'label'       => __( 'Active Button Background Color', 'inclusive' ),
					'description' => __( 'Used when the button is hovered, focused or active', 'inclusive' ),
					'section'     => 'button-colors',
					'settings'    => 'button_hover_bgcolor',
				)
			)
		);

		$wp_customize->add_setting(
			'button_hover_color',
			array(
				'default'           => '#333',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'button_hover_color',
				array(
					'label'       => __( 'Active Button Text Color', 'inclusive' ),
					'description' => __( 'Used when the button is hovered, focused or active', 'inclusive' ),
					'section'     => 'button-colors',
					'settings'    => 'button_hover_color',
				)
			)
		);

		$wp_customize->add_setting(
			'button_border_color',
			array(
				'default'           => '#ccc',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'button_border_color',
				array(
					'label'    => __( 'Button Border Color', 'inclusive' ),
					'section'  => 'button-colors',
					'settings' => 'button_border_color',
				)
			)
		);

		$wp_customize->add_setting(
			'button_border_width',
			array(
				'default'           => 1,
				'sanitize_callback' => 'absint',
			)
		);

		$wp_customize->add_control(
			'button_border_width',
			array(
				'type'        => 'range',
				'label'       => __( 'Button Border Size', 'inclusive' ),
				'description' => __( 'Drag the lever to the left to hide the border. Select a higher value for a thicker border. Only visible on buttons that has borders.', 'inclusive' ),
				'section'     => 'button-colors',
				'input_attrs' => array(
					'min' => 0,
					'max' => 99,
				),
			)
		);

		$wp_customize->add_setting(
			'button_border_radius',
			array(
				'default'           => 6,
				'sanitize_callback' => 'absint',
			)
		);

		$wp_customize->add_control(
			'button_border_radius',
			array(
				'type'        => 'range',
				'label'       => __( 'Button Corners', 'inclusive' ),
				'description' => __( 'Select a higher value for more rounded corners.', 'inclusive' ),
				'section'     => 'button-colors',
				'input_attrs' => array(
					'min' => 0,
					'max' => 99,
				),
			)
		);

	}

	/**
	 * Output our colors and custom CSS.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function action_custom_css() {
		echo '<style id="inclusive-theme-mod-css">';

		if ( get_theme_mod( 'body_bgcolor', '#fff' ) !== '#fff' ) {
			echo 'body, .site { background: ' . esc_html( get_theme_mod( 'body_bgcolor' ) ) . ';}';
		}

		if ( get_theme_mod( 'boxed_body_bgcolor', '#fff' ) !== '#fff' && get_theme_mod( 'boxed_layout', false ) === true ) {
			echo 'body { background: ' . esc_html( get_theme_mod( 'boxed_body_bgcolor' ) ) . ';}';
		}

		if ( get_theme_mod( 'header_bgcolor', '#fff' ) !== '#fff' ) {
			echo '.site-branding { background: ' . esc_html( get_theme_mod( 'header_bgcolor' ) ) . ';}';
		}

		if ( get_theme_mod( 'branding_bgcolor' ) ) {
			echo '.inner-branding { background: ' . esc_html( get_theme_mod( 'branding_bgcolor' ) ) . ';}';
		}

		if ( get_theme_mod( 'body_text_color', '#333' ) !== '#333' ) {
			echo 'body { --global-font-color: ' . esc_html( get_theme_mod( 'body_text_color' ) ) . ';}';
		}

		/* Links */
		if ( get_theme_mod( 'link_color', '#333' ) !== '#333' ) {
			echo 'body {
				--color-link: ' . esc_html( get_theme_mod( 'link_color' ) ) . ';
				--color-link-active: ' . esc_html( get_theme_mod( 'link_color' ) ) . ';
			}';
		}

		if ( get_theme_mod( 'meta_color', '#727272' ) !== '#727272' ) {
			echo 'body { --color-meta: ' . esc_html( get_theme_mod( 'meta_color' ) ) . ';
			}';
		}

		if ( get_theme_mod( 'link_accent_color', '#fdeee1' ) !== '#fdeee1' ) {
			echo 'body { --color-theme-underline-accent: ' . esc_html( get_theme_mod( 'link_accent_color' ) ) . ';}';
		}

		if ( get_theme_mod( 'link_accent_hover_color', '#fdb698' ) !== '#fdb698' ) {
			echo 'body { --color-theme-hover-underline-accent: ' . esc_html( get_theme_mod( 'link_accent_hover_color' ) ) . ';}';
		}

		/* Buttons */
		if ( get_theme_mod( 'button_bgcolor', '#f9f9f9' ) !== '#f9f9f9' ) {
			echo 'body { --color-theme-button: ' . esc_html( get_theme_mod( 'button_bgcolor' ) ) . ';}';
		}

		if ( get_theme_mod( 'button_hover_bgcolor', '#fcfcfc' ) !== '#fcfcfc' ) {
			echo 'body { --color-theme-active-button: ' . esc_html( get_theme_mod( 'button_hover_bgcolor' ) ) . ';}';
		}

		if ( get_theme_mod( 'button_color', '#333' ) !== '#333' ) {
			echo 'body { --color-theme-button-text: ' . esc_html( get_theme_mod( 'button_color' ) ) . ';}';
		}

		if ( get_theme_mod( 'button_hover_color', '#333' ) !== '#333' ) {
			echo 'body { --color-theme-active-button-text: ' . esc_html( get_theme_mod( 'button_hover_color' ) ) . ';}';
		}

		if ( get_theme_mod( 'button_border_color', '#ccc' ) !== '#ccc' ) {
			echo 'body { --color-theme-button-border: ' . esc_html( get_theme_mod( 'button_border_color' ) ) . '; }';
		}

		if ( get_theme_mod( 'button_border_width', '1' ) !== '1' ) {
			echo 'body { --button-border-width: ' . esc_html( get_theme_mod( 'button_border_width' ) ) . 'px; }';
		}

		if ( get_theme_mod( 'button_border_radius', '6' ) !== '6' ) {
			echo 'body { --button-border-radius: ' . esc_html( get_theme_mod( 'button_border_radius' ) ) . 'px; }';
		}

		/* Menu */
		if ( get_theme_mod( 'menubg_color', '#fff' ) !== '#fff' ) {
			echo '.main-navigation, .nav--toggle-sub ul ul { background: ' . esc_html( get_theme_mod( 'menubg_color' ) ) . ';}';
		}

		if ( get_theme_mod( 'submenubg_color' ) ) {
			echo 'body { --color-submenu: ' . esc_html( get_theme_mod( 'submenubg_color' ) ) . '; }';
		}

		if ( get_theme_mod( 'submenu_hover_bg_color' ) ) {
			echo 'body { --color-submenu-hover: ' . esc_html( get_theme_mod( 'submenu_hover_bg_color' ) ) . '; }';
		}

		if ( get_theme_mod( 'menu_link_color', '#333' ) !== '#333' ) {
			echo 'body { --color-link-menu: ' . esc_html( get_theme_mod( 'menu_link_color' ) ) . '; }';
		}

		if ( get_theme_mod( 'current_menu_link_color', '#333' ) !== '#333' ) {
			echo 'body { --color-link-current-menu: ' . esc_html( get_theme_mod( 'current_menu_link_color' ) ) . '; }';
		}

		if ( get_theme_mod( 'menu_shadow', true ) === false ) {
			echo '.main-navigation { box-shadow: none; }';
		}

		/* Footer */
		if ( get_theme_mod( 'footerbg_color', '#fcfcfc' ) !== '#fcfcfc' ) {
			echo '.site-footer { background: ' . esc_html( get_theme_mod( 'footerbg_color', '#fcfcfc' ) ) . '; }';
		}

		if ( get_theme_mod( 'footer_color', '#333' ) !== '#333' ) {
			echo '.site-footer, .site-footer a{ color: ' . esc_html( get_theme_mod( 'footer_color', '#333' ) ) . '; }';
			echo '.site-footer a, .site-footer .widget a { border-color: ' . esc_html( get_theme_mod( 'footer_color', '#333' ) ) . '; }';
			echo '.site-footer a:focus, .site-footer a:hover, .site-footer .widget a:focus, .site-footer .widget a:hover{ border-color: transparent; }';
			echo '.site-info, .site-info a { color: ' . esc_html( get_theme_mod( 'siteinfo_color', '#333' ) ) . '; }';
			echo '.social-links-menu .svg-icon { fill: ' . esc_html( get_theme_mod( 'siteinfo_color', '#333' ) ) . '; }';
			echo '.social-links-menu a {border: 1px solid transparent;}';
			echo '.social-links-menu a:hover, .social-links-menu a:focus{ border: 1px solid ' . esc_html( get_theme_mod( 'siteinfo_color', '#333' ) ) . '; }';
		}

		if ( get_theme_mod( 'siteinfobg_color', '#f9f9f9' ) !== '#f9f9f9' ) {
			echo 'body { --color-theme-site-info: ' . esc_html( get_theme_mod( 'siteinfobg_color', '#f9f9f9' ) ) . '; }';
		}

		if ( get_theme_mod( 'siteinfo_color', '#333' ) !== '#333' ) {
			echo '.site-info, .site-info a { color: ' . esc_html( get_theme_mod( 'siteinfo_color', '#333' ) ) . '!important; }';
			echo '.social-links-menu .svg-icon { fill: ' . esc_html( get_theme_mod( 'siteinfo_color', '#333' ) ) . '!important;}';
			echo '.social-links-menu a {border: 1px solid transparent;}';
			echo '.social-links-menu a:hover, .social-links-menu a:focus{ border: 1px solid ' . esc_html( get_theme_mod( 'siteinfo_color', '#333' ) ) . '; }';
		}

		if ( get_theme_mod( 'align_entry_header', 'center' ) !== 'center' ) {
			echo '.type-post .entry-header, .type-page .entry-header { text-align: ' . esc_html( get_theme_mod( 'align_entry_header' ) ) . '; }';
		}

		echo '</style>';
	}

}


