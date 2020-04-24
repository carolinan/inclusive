<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Inclusive Default Styles
 * Some custom styles are found in Colors.php
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
class Styles {

	/**
	 * An array of enqueued files.
	 *
	 * Prevents duplicate styles.
	 *
	 * @static
	 * @access protected
	 * @since 1.0.0
	 * @var array
	 */
	protected static $enqueued_files = [];

	/**
	 * An array of widgets for which the CSS has already been added.
	 *
	 * @static
	 * @access private
	 * @since 1.0.0
	 * @var array
	 */
	private static $widgets = [];

	/**
	 * The styles.
	 *
	 * @static
	 * @access protected
	 * @since 1.0.0
	 * @var string
	 */
	protected static $css = '';

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'action_global_styles' ] );
		// Add widget styles.
		add_filter( 'inclusive_widget_output', [ $this, 'filter_widget_output' ], 10, 4 );
	}

	/**
	 * Global styles.
	 *
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function action_global_styles() {
		wp_enqueue_style(
			'inclusive-variables',
			get_template_directory_uri() . '/assets/css/min/variables.min.css',
			null,
			INCLUSIVE_VERSION
		);

		wp_enqueue_style(
			'inclusive-global-styles',
			get_template_directory_uri() . '/assets/css/min/global.min.css',
			null,
			INCLUSIVE_VERSION
		);

		// Enqueue Google Fonts.
		if ( get_theme_mod( 'font_pairing', 'Libre Baskerville+Roboto' ) !== 'system' ) {
			$font_option  = explode( '+', get_theme_mod( 'font_pairing', 'Libre Baskerville+Roboto' ) );
			$google_fonts = '//fonts.googleapis.com/css?family=' . $font_option[0] . ':400,700|' . $font_option[1] . ':400,700&display=swap';
		}
		if ( ! empty( $google_fonts ) ) {
			wp_enqueue_style( // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
				'inclusive-fonts',
				$google_fonts,
				[],
				null
			);
		}
	}

	/**
	 * Prints inline CSS for template parts.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public static function get_template_part( $slug, $name = null, $stylesheet = null ) {
		// Print stylesheet.
		if ( $stylesheet ) {
			$stylename = ( $name ) ? "-$name" : '';
			echo "<style id='inclusive-{$slug}{$stylename}'>";
			include get_theme_file_path( $stylesheet );
			echo '</style>';
		}
		// Get the template-part.
		get_template_part( 'template-parts/' . $slug . '/' . $name );
	}

	/**
	 * Add CSS for widgets.
	 *
	 * @access public
	 * @since 1.0.0
	 * @param string $widget_output  The widget's output.
	 * @param string $widget_id_base The widget's base ID.
	 * @param string $widget_id      The widget's full ID.
	 * @param string $sidebar_id     The current sidebar ID.
	 * @return string
	 */
	public function filter_widget_output( $widget_output, $widget_id_base, $widget_id, $sidebar_id ) {

		// If CSS for this widget-type has already been added there's no need to add it again.
		if ( in_array( $widget_id_base, self::$widgets, true ) ) {
			return $widget_output;
		}

		$styles = '';

		$style_path = 'assets/css/min/widget-' . str_replace( '_', '-', $widget_id_base ) . '.min.css';
		if ( file_exists( get_theme_file_path( $style_path ) ) ) {
			self::get_template_part( $widget_id_base, 'css', $style_path );
		}

		// If this is the 1st widget we're adding, include the global styles for widgets.
		if ( empty( self::$widgets ) ) {
			self::get_template_part( 'base', 'widgets', 'assets/css/min/widgets.min.css' );
		}

		// Add the widget to the array of available widgets to prevent adding multiple instances of this CSS.
		self::$widgets[] = $widget_id_base;

		// Return the widget output, with the CSS prepended.
		return $styles . $widget_output;
	}
}
