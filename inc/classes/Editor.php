<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Inclusive Color Options
 *
 * @package Inclusive
 * @since 1.0.0
 */

namespace Inclusive;

/**
 * Add custom fonts and styles to the block editor.
 *
 * @since 1.0.0
 */
class Editor {

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		add_action( 'enqueue_block_assets', [ $this, 'action_block_styles' ] );
		add_action( 'enqueue_block_editor_assets', [ $this, 'action_editor_google_fonts' ] );
	}

	/**
	 * Enqueue custom fonts for the editor.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function action_editor_google_fonts() {
		if ( get_theme_mod( 'font_pairing', 'Libre Baskerville+Roboto' ) !== 'system' ) {
			$font_option  = explode( '+', get_theme_mod( 'font_pairing', 'Libre Baskerville+Roboto' ) );
			$google_fonts = '//fonts.googleapis.com/css?family=' . $font_option[0] . ':400,700|' . $font_option[1] . ':400,700&display=swap';
		}
		if ( ! empty( $google_fonts ) ) {
			wp_enqueue_style( // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
				'inclusive-editor-fonts',
				$google_fonts,
				[],
				null
			);
		}
	}

	/**
	 * Add custom font families to elements in the editor.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function action_block_styles() {
		$font         = explode( '+', get_theme_mod( 'font_pairing', 'Libre Baskerville+Roboto' ) );
		$system_fonts = 'BlinkMacSystemFont, -apple-system, Helvetica, Arial, sans-serif';
		$custom_css   = '';
		if ( get_theme_mod( 'font_pairing', 'Libre Baskerville+Roboto' ) === 'system' ) {
			$custom_css .= ' .editor-styles-wrapper > * { font-family: ' . esc_html( $system_fonts ) . ';}';
		} else {
			$custom_css .= '.editor-styles-wrapper > * { font-family: ' . esc_html( $font[1] . ', ' . $system_fonts ) . ';} ';
			$custom_css .= '.editor-post-title__block .editor-post-title__input, .editor-styles-wrapper h1, .editor-styles-wrapper h2, .editor-styles-wrapper h3, .editor-styles-wrapper h4, .editor-styles-wrapper h5, .editor-styles-wrapper h6
			{ font-family:' . esc_html( $font[0] . ', ' . $system_fonts ) . ';}';
		}

		if ( get_theme_mod( 'align_entry_header', 'center' ) === 'center' ) {
			$custom_css .= ' .editor-styles-wrapper .editor-post-title__input{ text-align:center;} ';
		} elseif ( get_theme_mod( 'align_entry_header', 'center' ) === 'left' ) {
			$custom_css .= ' .editor-styles-wrapper .editor-post-title__input{ text-align:left;} ';
		} elseif ( get_theme_mod( 'align_entry_header', 'center' ) === 'right' ) {
			$custom_css .= ' .editor-styles-wrapper .editor-post-title__input{ text-align:right;} ';
		}

		if ( get_theme_mod( 'entry_title_shadow', true ) === true ) {
			$custom_css .= ' .editor-post-title__block .editor-post-title__input {text-shadow: 0.04em 0.04em 0 rgba(0, 0, 0, 0.1);}';
		}

		wp_add_inline_style( 'inclusive-editor-fonts', $custom_css );
	}

}
