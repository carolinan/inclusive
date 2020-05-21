<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Print block styles.
 *
 * @package Inclusive
 * @since 1.0.0
 */

namespace Inclusive;

/**
 * Template handler.
 *
 * @since 1.0.0
 */
class Block_Styles {

	/**
	 * An array of blocks used in this page.
	 *
	 * @static
	 * @access private
	 * @since 1.0.0
	 * @var array
	 */
	private static $block_styles_added = [];

	/**
	 * A string containing all blocks styles
	 *
	 * @static
	 * @access private
	 * @since 3.0.0
	 * @var string
	 */
	private static $footer_block_styles = '';

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'action_dequeue_scripts' ] );
		add_filter( 'render_block', [ $this, 'filter_add_inline_styles' ], 10, 2 );
		add_action( 'enqueue_block_assets', [ $this, 'enqueue_block_assets' ] );
		add_action( 'wp_footer', [ $this, 'action_add_footer_styles' ] );
	}

	/**
	 * Get an array of block styles.
	 *
	 * @static
	 * @access public
	 * @since 1.0.0
	 * @return array
	 */
	public static function get_styled_blocks() {
		return [
			'core/audio',
			'core/button',
			'core/buttons',
			'core/calendar',
			'core/code',
			'core/columns',
			'core/cover',
			'core/embed',
			'core/file',
			'core/gallery',
			'core/group',
			'core/image',
			'core/latest-comments',
			'core/latest-posts',
			'core/media-text',
			// 'core/navigation-link' is now placed inside core/navigation.min.css
			'core/navigation',
			'core/paragraph',
			'core/preformatted',
			'core/pullquote',
			'core/quote',
			'core/rss',
			'core/search',
			'core/separator',
			'core/social-links',
			'core/spacer',
			'core/subhead',
			'core/table',
			'core/tag-cloud',
			'core/text-columns',
			'core/verse',
			'core/video',
			// This is a fake block to help me load styles in the editor.
			'core/sidebar',
		];
	}

	/**
	 * Enqueue scripts.
	 *
	 * @access public
	 * @since 1.0.0
	 */
	public function action_dequeue_scripts() {

		// Dequeue wp-core blocks styles. These will be added inline.
		wp_dequeue_style( 'wp-block-library' );
		wp_dequeue_style( 'wp-block-library-theme' );
	}

	/**
	 * Filters the content of a single block.
	 *
	 * Adds inline styles to blocks. Styles will only be added the 1st time we encounter the block.
	 *
	 * @since 1.0.0
	 * @access public
	 * @param string $block_content The block content about to be appended.
	 * @param array  $block         The full block, including name and attributes.
	 * @return string               Returns $block_content with our modifications.
	 */
	public function filter_add_inline_styles( $block_content, $block ) {
		$block_attr = $block['attrs'];

		if ( isset( $block_attr['className'] ) ) {
			$block_classnames = $block_attr['className'];
			// Add the ornament class to block names.
			if ( strpos( $block_classnames, 'is-style-inclusive-separator-ornament' ) !== false ) {
				$block['blockName'] = 'core/ornament';
			}

			// Add the sidebar class to block names.
			if ( strpos( $block_classnames, 'is-style-inclusive-sidebar' ) !== false ) {
				$block['blockName'] = 'core/sidebar';
			}
		}

		if ( $block['blockName'] ) {
			if ( strpos( $block['blockName'], 'core-embed' ) !== false ) {
				$block['blockName'] = 'core/embed';
			}

			if ( ! in_array( $block['blockName'], self::$block_styles_added, true ) ) {
				self::$block_styles_added[] = $block['blockName'];

				$styles_path = get_theme_file_path( "/assets/css/blocks/{$block['blockName']}.min.css" );

				ob_start();

				if ( file_exists( $styles_path ) ) {
					include $styles_path; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
				}
				self::$footer_block_styles .= ob_get_clean();
			}
		}

		return $block_content;
	}


	/**
	 * Enqueue block assets.
	 *
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function enqueue_block_assets() {

		// We only need this in the editor.
		if ( ! is_admin() ) {
			return;
		}

		wp_enqueue_style(
			'inclusive-editor-variables',
			get_template_directory_uri() . '/assets/css/min/variables.min.css',
			null,
			INCLUSIVE_VERSION
		);

		wp_enqueue_style(
			'inclusive-editor-styles',
			get_template_directory_uri() . '/assets/css/min/editor.min.css',
			null,
			INCLUSIVE_VERSION
		);

		// Get an array of blocks.
		$blocks = self::get_styled_blocks();

		// Add blocks styles.
		foreach ( $blocks as $block ) {
			wp_enqueue_style(
				"inclusive-$block",
				get_theme_file_uri( "assets/css/blocks/$block.min.css" ),
				null,
				INCLUSIVE_VERSION
			);
		}
	}

	/**
	 * Print block styles in the footer.
	 *
	 * @access public
	 * @since 1.0.1
	 * @return void
	 */
	public function action_add_footer_styles() {
		/** Stripping tags is enough to escape the content in the CSS files. */
		echo '<style id="inclusive-block-styles">' . wp_strip_all_tags( self::$footer_block_styles ) . '</style>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Add custom block styles for core blocks.
	 * Note to reviewer: Registering block styles is allowed. Registering blocks are not <3
	 *
	 * @access public
	 * @since 1.0.0
	 */
	public static function register_custom_block_styles() {
		register_block_style( // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.editor_blocks_register_block_style
			'core/gallery',
			array(
				'name'         => 'inclusive-hide-caption',
				'label'        => __( 'Hide caption', 'inclusive' ),
				'inline_style' => '.is-style-inclusive-hide-caption figcaption {display:none;}',
			)
		);

		register_block_style( // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.editor_blocks_register_block_style
			'core/gallery',
			array(
				'name'         => 'inclusive-gallery-rounded',
				'label'        => __( 'Rounded corners', 'inclusive' ),
				'inline_style' => '.is-style-inclusive-gallery-rounded img {border-radius:50%;} .is-style-inclusive-gallery-rounded figcaption {display:none;}',
			)
		);

		register_block_style( // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.editor_blocks_register_block_style
			'core/separator',
			array(
				'name'         => 'inclusive-separator-ornament1',
				'label'        => __( 'Ornament', 'inclusive' ),
				'inline_style' => '.wp-block-separator.is-style-inclusive-separator-ornament1 {
					background: #ccc;
					width: 130px;
					height: 70px !important;
					padding-left: 0;
					padding-right: 0;
					-webkit-mask-image: url(\'data:image/svg+xml; utf8, <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 81.52 29.9"><path d="M39.5 29.59a1.7 1.7 0 0 0-1.73-.5 6.64 6.64 0 0 1-1.05.12c-1.47-.17-1.81-1.3-1.72-4.29s-1.77-4-1.77-4c4.08.25 5.09 2.61 5.39 3.11s.25 1.56.88 1.77a.43.43 0 0 0 .63-.42c-1.6-8.84-7.07-8.67-8.54-8.67s-1.34-.25-1.43-.29a4.41 4.41 0 0 1 3.37-2.65 6.47 6.47 0 0 0-8-.8 3.54 3.54 0 0 0-1.39 4.5c-4 .67-3.58-4.67-3.58-4.67-1.34.93-2.06 1.35-3 4.54s.25 4 .25 4a6.08 6.08 0 0 1 3.45-1.94c1-.17 1.39 0 2.52 1.64s2.78 2.91 4.08 2.44 1.43-4.12 1.43-4.12c.72 1 2.48 2.57.34 5.43S24.27 27.7 21 27.07s-4.51-3.54-5.18-6.65 1.81-6.31 1.81-6.31c-1.81.42-2.78 1.6-4 2.65s-.3 3.2-.38 3.91-1.68 2-2.44 2.15-1 .88-1.77 1.14-.8-.22-1.3-.89-.63-.21-1.18-.38-.17-1 .21-1.38.63-.38.17-1.6.5-2.48 1.56-3 3 0 4-.5a10.67 10.67 0 0 0 2.53-2.57 33.3 33.3 0 0 1-9.3 1.81C-.92 15.12.05 8.94.05 8.94c1.6 1.18 1.55 1.89 3.19 1.47S4.93 9.36 6 8.65s3.85-1.39 4.73.35 0 4.42 0 4.42a23.23 23.23 0 0 0 3.83-1.09 19 19 0 0 1 4.08-.72c-2.78-4.92.71-5.89.71-5.89.09 2.86 2 3.2 4.08 3.79s5.68-.21 9.68 2.31 6.73 8.2 6.73 8.37a6 6 0 0 0 .16-2.63 5.93 5.93 0 0 0-1.61-2.79h1.87l.1-3.79s-2 1.7-3.12 1.31-2.73-3.42-5.08-3.66a6 6 0 0 1 6.14-2.5s-1.38-1.34-1.1-2.23A1.47 1.47 0 0 1 39 2.65S39.17 0 40.76 0s1.74 2.65 1.74 2.65a1.47 1.47 0 0 1 1.82 1.25c.28.89-1.1 2.23-1.1 2.23a6 6 0 0 1 6.12 2.52c-2.35.24-3.92 3.28-5.08 3.66S41.14 11 41.14 11l.1 3.79h1.88a5.86 5.86 0 0 0-1.62 2.79 5.92 5.92 0 0 0 .19 2.61c0-.17 2.73-5.85 6.73-8.37s7.58-1.74 9.67-2.33 4-.93 4.08-3.79c0 0 3.49 1 .71 5.89a19 19 0 0 1 4.08.72 23.51 23.51 0 0 0 3.83 1.09s-.88-2.69 0-4.42 3.62-1.05 4.71-.33 1.14 1.34 2.78 1.76 1.59-.29 3.19-1.47c0 0 1 6.18-5.8 6.52a33.3 33.3 0 0 1-9.3-1.81 10.67 10.67 0 0 0 2.53 2.57c1 .46 3 0 4 .5s2 1.77 1.55 3-.21 1.22.17 1.6.76 1.22.21 1.38-.67-.29-1.18.38-.54 1.14-1.3.89-1-1-1.77-1.14-2.35-1.43-2.44-2.15.8-2.86-.38-3.91-2.14-2.23-3.95-2.65c0 0 2.48 3.2 1.81 6.31s-1.94 6-5.17 6.65-6.52.59-8.67-2.27-.38-4.42.34-5.43c0 0 .12 3.66 1.43 4.12s2.94-.8 4.08-2.44 1.55-1.81 2.52-1.64a6.08 6.08 0 0 1 3.45 1.94s1.18-.76.25-4-1.64-3.61-3-4.54c0 0 .46 5.34-3.58 4.67A3.53 3.53 0 0 0 55.94 13a6.47 6.47 0 0 0-7.95.8 4.41 4.41 0 0 1 3.37 2.65c-.08 0 0 .29-1.43.29s-6.94-.17-8.54 8.67a.43.43 0 0 0 .63.42c.63-.21.59-1.26.89-1.77s1.3-2.86 5.38-3.11c0 0-1.85 1-1.77 4s-.25 4.05-1.72 4.26a6.64 6.64 0 0 1-1-.12 1.7 1.7 0 0 0-1.73.5 1.15 1.15 0 0 1-1.26.21 1.15 1.15 0 0 1-1.26-.21z" fill-rule="evenodd"/></svg>\' );
					mask-mode: alpha;
					mask-image: url(\'data:image/svg+xml; utf8, <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 81.52 29.9"><path d="M39.5 29.59a1.7 1.7 0 0 0-1.73-.5 6.64 6.64 0 0 1-1.05.12c-1.47-.17-1.81-1.3-1.72-4.29s-1.77-4-1.77-4c4.08.25 5.09 2.61 5.39 3.11s.25 1.56.88 1.77a.43.43 0 0 0 .63-.42c-1.6-8.84-7.07-8.67-8.54-8.67s-1.34-.25-1.43-.29a4.41 4.41 0 0 1 3.37-2.65 6.47 6.47 0 0 0-8-.8 3.54 3.54 0 0 0-1.39 4.5c-4 .67-3.58-4.67-3.58-4.67-1.34.93-2.06 1.35-3 4.54s.25 4 .25 4a6.08 6.08 0 0 1 3.45-1.94c1-.17 1.39 0 2.52 1.64s2.78 2.91 4.08 2.44 1.43-4.12 1.43-4.12c.72 1 2.48 2.57.34 5.43S24.27 27.7 21 27.07s-4.51-3.54-5.18-6.65 1.81-6.31 1.81-6.31c-1.81.42-2.78 1.6-4 2.65s-.3 3.2-.38 3.91-1.68 2-2.44 2.15-1 .88-1.77 1.14-.8-.22-1.3-.89-.63-.21-1.18-.38-.17-1 .21-1.38.63-.38.17-1.6.5-2.48 1.56-3 3 0 4-.5a10.67 10.67 0 0 0 2.53-2.57 33.3 33.3 0 0 1-9.3 1.81C-.92 15.12.05 8.94.05 8.94c1.6 1.18 1.55 1.89 3.19 1.47S4.93 9.36 6 8.65s3.85-1.39 4.73.35 0 4.42 0 4.42a23.23 23.23 0 0 0 3.83-1.09 19 19 0 0 1 4.08-.72c-2.78-4.92.71-5.89.71-5.89.09 2.86 2 3.2 4.08 3.79s5.68-.21 9.68 2.31 6.73 8.2 6.73 8.37a6 6 0 0 0 .16-2.63 5.93 5.93 0 0 0-1.61-2.79h1.87l.1-3.79s-2 1.7-3.12 1.31-2.73-3.42-5.08-3.66a6 6 0 0 1 6.14-2.5s-1.38-1.34-1.1-2.23A1.47 1.47 0 0 1 39 2.65S39.17 0 40.76 0s1.74 2.65 1.74 2.65a1.47 1.47 0 0 1 1.82 1.25c.28.89-1.1 2.23-1.1 2.23a6 6 0 0 1 6.12 2.52c-2.35.24-3.92 3.28-5.08 3.66S41.14 11 41.14 11l.1 3.79h1.88a5.86 5.86 0 0 0-1.62 2.79 5.92 5.92 0 0 0 .19 2.61c0-.17 2.73-5.85 6.73-8.37s7.58-1.74 9.67-2.33 4-.93 4.08-3.79c0 0 3.49 1 .71 5.89a19 19 0 0 1 4.08.72 23.51 23.51 0 0 0 3.83 1.09s-.88-2.69 0-4.42 3.62-1.05 4.71-.33 1.14 1.34 2.78 1.76 1.59-.29 3.19-1.47c0 0 1 6.18-5.8 6.52a33.3 33.3 0 0 1-9.3-1.81 10.67 10.67 0 0 0 2.53 2.57c1 .46 3 0 4 .5s2 1.77 1.55 3-.21 1.22.17 1.6.76 1.22.21 1.38-.67-.29-1.18.38-.54 1.14-1.3.89-1-1-1.77-1.14-2.35-1.43-2.44-2.15.8-2.86-.38-3.91-2.14-2.23-3.95-2.65c0 0 2.48 3.2 1.81 6.31s-1.94 6-5.17 6.65-6.52.59-8.67-2.27-.38-4.42.34-5.43c0 0 .12 3.66 1.43 4.12s2.94-.8 4.08-2.44 1.55-1.81 2.52-1.64a6.08 6.08 0 0 1 3.45 1.94s1.18-.76.25-4-1.64-3.61-3-4.54c0 0 .46 5.34-3.58 4.67A3.53 3.53 0 0 0 55.94 13a6.47 6.47 0 0 0-7.95.8 4.41 4.41 0 0 1 3.37 2.65c-.08 0 0 .29-1.43.29s-6.94-.17-8.54 8.67a.43.43 0 0 0 .63.42c.63-.21.59-1.26.89-1.77s1.3-2.86 5.38-3.11c0 0-1.85 1-1.77 4s-.25 4.05-1.72 4.26a6.64 6.64 0 0 1-1-.12 1.7 1.7 0 0 0-1.73.5 1.15 1.15 0 0 1-1.26.21 1.15 1.15 0 0 1-1.26-.21z" fill-rule="evenodd"/></svg>\' );
					mask-mode: alpha;
					-webkit-mask-repeat: no-repeat;
					mask-repeat: no-repeat;
					-webkit-mask-size: contain;
					mask-size: contain;
					-webkit-mask-position: center;
					mask-position: center;
					border: none;
				}',
			)
		);

		register_block_style( // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.editor_blocks_register_block_style
			'core/separator',
			array(
				'name'         => 'inclusive-separator-ornament2',
				'label'        => __( 'Ornament 2', 'inclusive' ),
				'inline_style' => '.wp-block-separator.is-style-inclusive-separator-ornament2 {
					background: #ccc;
					width: 70px;
					height: 70px !important;
					padding-left: 0;
					padding-right: 0;
					-webkit-mask-image: url(\'data:image/svg+xml; utf8, <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 43.24 30.79"><path d="M37.74,30v.61a2,2,0,0,1-.67.15,8.11,8.11,0,0,1-.86.05,10.7,10.7,0,0,1-8.06-3.16,10.47,10.47,0,0,1-3.06-7.55,11,11,0,0,1,2.14-6.83,8.66,8.66,0,0,1,7.45-3.46,8.43,8.43,0,0,1,6.22,2.34,7.91,7.91,0,0,1,2.34,5.81,6.8,6.8,0,0,1-6.83,7,5.5,5.5,0,0,1-4.49-1.73A3.91,3.91,0,0,1,31,20.7q0-3.37,2.85-3.37a2.07,2.07,0,0,1,2.35,2.35,1.67,1.67,0,0,1-.56,1.17,3.87,3.87,0,0,1-1,.76,1.86,1.86,0,0,0,1,.77,3.79,3.79,0,0,0,1.38.25,4.13,4.13,0,0,0,2.8-1.12,4.29,4.29,0,0,0,1.28-3.37,5,5,0,0,0-2.45-4.69,7.71,7.71,0,0,0-4-1,6.93,6.93,0,0,0-4.59,1.63,7.41,7.41,0,0,0-2.45,6,8.39,8.39,0,0,0,4,7.55A21.41,21.41,0,0,0,37.74,30ZM23.15,19.47v1a22.53,22.53,0,0,0,.26,2.86A11,11,0,0,0,24,25.9c-.41.54-.83,1.15-1.28,1.83a12.4,12.4,0,0,0-1.07,2,6.6,6.6,0,0,0-1-2.14,13,13,0,0,0-1.33-1.73,11.6,11.6,0,0,0,.61-2.6,25.3,25.3,0,0,0,.41-2.81V19.27a11.8,11.8,0,0,0-3.37-8.57,15.53,15.53,0,0,0-5.4-3.47c.88-.47,1.63-.91,2.24-1.32.2-.14.82-.61,1.84-1.43a12.05,12.05,0,0,1,2.49,2.7,25.44,25.44,0,0,1,2,3.52l.21-1.52a10.44,10.44,0,0,0-.57-3.42,10,10,0,0,0-1.58-3L20,1.53A9.23,9.23,0,0,0,21.72,0a6.4,6.4,0,0,0,1.82,1.58c.91.58,1.48,1,1.76,1.17a10.93,10.93,0,0,0-1.53,3.06,10.43,10.43,0,0,0-.61,3.37V10.7a37.54,37.54,0,0,1,1.93-3.26,12.22,12.22,0,0,1,3-3,12.34,12.34,0,0,0,1.79,1.43A11.57,11.57,0,0,0,31.92,7a12.56,12.56,0,0,0-5.2,3.57,12.71,12.71,0,0,0-3.57,8.87ZM5.51,30.79v-.61a25.75,25.75,0,0,0,6.12-2.27,8.67,8.67,0,0,0,4.18-7.74c0-2.62-.75-4.55-2.25-5.83a7.52,7.52,0,0,0-5-1.91,7.61,7.61,0,0,0-3.88.94,5,5,0,0,0-2.55,4.69A4.86,4.86,0,0,0,3,21a3.87,3.87,0,0,0,3.26,1.67,3.37,3.37,0,0,0,2.55-.86A4.13,4.13,0,0,1,7.65,21,1.58,1.58,0,0,1,7,19.78c0-1.63.85-2.45,2.55-2.45s2.65,1.06,2.65,3.16a4,4,0,0,1-1.48,3.32A6.13,6.13,0,0,1,6.83,25a6.18,6.18,0,0,1-5.5-2.75A7.4,7.4,0,0,1,0,17.94a8,8,0,0,1,2.35-5.71A8.17,8.17,0,0,1,8.57,9.79,8.83,8.83,0,0,1,16,13.25a11.09,11.09,0,0,1,2.14,6.84,10.55,10.55,0,0,1-3,7.6A10.74,10.74,0,0,1,7,30.79Z" /></svg>\');
					mask-mode: alpha;
					mask-image: url(\'data:image/svg+xml; utf8, <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 43.24 30.79"><path d="M37.74,30v.61a2,2,0,0,1-.67.15,8.11,8.11,0,0,1-.86.05,10.7,10.7,0,0,1-8.06-3.16,10.47,10.47,0,0,1-3.06-7.55,11,11,0,0,1,2.14-6.83,8.66,8.66,0,0,1,7.45-3.46,8.43,8.43,0,0,1,6.22,2.34,7.91,7.91,0,0,1,2.34,5.81,6.8,6.8,0,0,1-6.83,7,5.5,5.5,0,0,1-4.49-1.73A3.91,3.91,0,0,1,31,20.7q0-3.37,2.85-3.37a2.07,2.07,0,0,1,2.35,2.35,1.67,1.67,0,0,1-.56,1.17,3.87,3.87,0,0,1-1,.76,1.86,1.86,0,0,0,1,.77,3.79,3.79,0,0,0,1.38.25,4.13,4.13,0,0,0,2.8-1.12,4.29,4.29,0,0,0,1.28-3.37,5,5,0,0,0-2.45-4.69,7.71,7.71,0,0,0-4-1,6.93,6.93,0,0,0-4.59,1.63,7.41,7.41,0,0,0-2.45,6,8.39,8.39,0,0,0,4,7.55A21.41,21.41,0,0,0,37.74,30ZM23.15,19.47v1a22.53,22.53,0,0,0,.26,2.86A11,11,0,0,0,24,25.9c-.41.54-.83,1.15-1.28,1.83a12.4,12.4,0,0,0-1.07,2,6.6,6.6,0,0,0-1-2.14,13,13,0,0,0-1.33-1.73,11.6,11.6,0,0,0,.61-2.6,25.3,25.3,0,0,0,.41-2.81V19.27a11.8,11.8,0,0,0-3.37-8.57,15.53,15.53,0,0,0-5.4-3.47c.88-.47,1.63-.91,2.24-1.32.2-.14.82-.61,1.84-1.43a12.05,12.05,0,0,1,2.49,2.7,25.44,25.44,0,0,1,2,3.52l.21-1.52a10.44,10.44,0,0,0-.57-3.42,10,10,0,0,0-1.58-3L20,1.53A9.23,9.23,0,0,0,21.72,0a6.4,6.4,0,0,0,1.82,1.58c.91.58,1.48,1,1.76,1.17a10.93,10.93,0,0,0-1.53,3.06,10.43,10.43,0,0,0-.61,3.37V10.7a37.54,37.54,0,0,1,1.93-3.26,12.22,12.22,0,0,1,3-3,12.34,12.34,0,0,0,1.79,1.43A11.57,11.57,0,0,0,31.92,7a12.56,12.56,0,0,0-5.2,3.57,12.71,12.71,0,0,0-3.57,8.87ZM5.51,30.79v-.61a25.75,25.75,0,0,0,6.12-2.27,8.67,8.67,0,0,0,4.18-7.74c0-2.62-.75-4.55-2.25-5.83a7.52,7.52,0,0,0-5-1.91,7.61,7.61,0,0,0-3.88.94,5,5,0,0,0-2.55,4.69A4.86,4.86,0,0,0,3,21a3.87,3.87,0,0,0,3.26,1.67,3.37,3.37,0,0,0,2.55-.86A4.13,4.13,0,0,1,7.65,21,1.58,1.58,0,0,1,7,19.78c0-1.63.85-2.45,2.55-2.45s2.65,1.06,2.65,3.16a4,4,0,0,1-1.48,3.32A6.13,6.13,0,0,1,6.83,25a6.18,6.18,0,0,1-5.5-2.75A7.4,7.4,0,0,1,0,17.94a8,8,0,0,1,2.35-5.71A8.17,8.17,0,0,1,8.57,9.79,8.83,8.83,0,0,1,16,13.25a11.09,11.09,0,0,1,2.14,6.84,10.55,10.55,0,0,1-3,7.6A10.74,10.74,0,0,1,7,30.79Z" /></svg>\');
					mask-mode: alpha;
					-webkit-mask-repeat: no-repeat;
					mask-repeat: no-repeat;
					-webkit-mask-size: contain;
					mask-size: contain;
					-webkit-mask-position: center;
					mask-position: center;
					border: none;
				}',
			)
		);

		register_block_style( // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.editor_blocks_register_block_style
			'core/button',
			array(
				'name'         => 'inclusive-large-button',
				'label'        => __( 'Large', 'inclusive' ),
				'inline_style' => '.wp-block-button.is-style-inclusive-large-button .wp-block-button__link{
					padding: 3em; margin: 1.5em;
				}',
			)
		);

		register_block_style( // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.editor_blocks_register_block_style
			'core/paragraph',
			array(
				'name'         => 'inclusive-rounded-corners',
				'label'        => __( 'Rounced corners (Requires background color)', 'inclusive' ),
				'inline_style' => '.is-style-inclusive-rounded-corners {
					border-radius: 6px;
				}',
			)
		);

		register_block_style( // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.editor_blocks_register_block_style
			'core/paragraph',
			array(
				'name'         => 'inclusive-box-shadow',
				'label'        => __( 'Box shadow', 'inclusive' ),
				'inline_style' => '.is-style-inclusive-box-shadow {
					box-shadow: 0 0 1em rgba(0, 0, 0, 0.08);
					padding: 0.5rem;
					border-radius: 2px;
				}',
			)
		);

		register_block_style( // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.editor_blocks_register_block_style
			'core/paragraph',
			array(
				'name'         => 'inclusive-border',
				'label'        => __( 'Border', 'inclusive' ),
				'inline_style' => '.is-style-inclusive-border {
					border: 2px solid currentColor;
					padding: 0.5rem;
				}',
			)
		);

		register_block_style( // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.editor_blocks_register_block_style
			'core/heading',
			array(
				'name'         => 'inclusive-text-shadow',
				'label'        => __( 'Text shadow', 'inclusive' ),
				'inline_style' => '.is-style-inclusive-text-shadow {
					text-shadow: var(--text-shadow);
				}',
			)
		);

		if ( function_exists( 'register_block_pattern' ) ) {
			register_block_pattern(
				'inclusive/split-heading',
				array(
					'title'   => __( 'Inclusive: Heading with two colors', 'inclusive' ),
					'content' => '<!-- wp:heading {"level":2,"className":"inclusive-split-heading is-style-inclusive-text-shadow"} -->
					<h2 class="is-style-inclusive is-style-inclusive-text-shadow">' .
					_x( 'Heading with <span style="color:#b6007c" class="has-inline-color">two colors</span></h2>', 'Block pattern content', 'inclusive' ) . '<!-- /wp:heading -->',
				)
			);

			register_block_pattern(
				'inclusive/cover-block-with-large-button',
				array(
					'title'   => __( 'Inclusive: Cover block with heading and large button', 'inclusive' ),
					'content' => '<!-- wp:cover {"url":"' . esc_url( get_theme_file_uri( 'assets/images/flora.png' ) ) . '","id":48,"customOverlayColor":"#e3eff5","className":"inclusive-cover-block-with-large-button"} -->
					<div class="wp-block-cover has-background-dim inclusive-cover-block-with-large-button" style="background-image:url(' . esc_url( get_theme_file_uri( 'assets/images/flora.png' ) ) . ');background-color:#e3eff5">
					<div class="wp-block-cover__inner-container">
					<!-- wp:heading {"align":"center","level":2,"customTextColor":"#000000","className":"is-style-inclusive-text-shadow"} -->
					<h2 class="has-text-color has-text-align-center is-style-inclusive-text-shadow" style="color:#000000">' . _x( 'Example heading', 'Theme starter content', 'inclusive' ) . '</h2>
					<!-- /wp:heading -->
					<!-- wp:buttons {"align":"center"} -->
					<div class="wp-block-buttons aligncenter"><!-- wp:button {"className":"is-style-inclusive-large-button"} -->
					<div class="wp-block-button is-style-inclusive-large-button"><a href="#" class="wp-block-button__link">' . _x( 'Sign up for our Newsletter', 'Theme starter content', 'inclusive' ) . '</a></div>
					<!-- /wp:button --></div>
					<!-- /wp:buttons --></div></div>
					<!-- /wp:cover -->',
				)
			);

			register_block_pattern(
				'inclusive/event-list',
				array(
					'title'   => __( 'Inclusive: Event list', 'inclusive' ),
					'content' => '<!-- wp:group -->
					<div class="wp-block-group"><div class="wp-block-group__inner-container"><!-- wp:columns {"verticalAlignment":"top","align":"full"} -->
					<div class="wp-block-columns alignfull are-vertically-aligned-top"><!-- wp:column {"verticalAlignment":"top","width":100} -->
					<div class="wp-block-column is-vertically-aligned-top" style="flex-basis:100%"><!-- wp:paragraph -->
					' . _x( '<p><strong>June 4, </strong> WordCamp Europe Online</p>', 'Block pattern content', 'inclusive' ) . '<!-- /wp:paragraph --></div>
					<!-- /wp:column -->

					<!-- wp:column {"verticalAlignment":"top"} -->
					<div class="wp-block-column is-vertically-aligned-top"><!-- wp:button -->
					<div class="wp-block-button"><a class="wp-block-button__link" href="#">' . _x( 'View Live Stream', 'Block pattern content', 'inclusive' ) . '</a></div>
					<!-- /wp:button --></div>
					<!-- /wp:column --></div>
					<!-- /wp:columns -->

					<!-- wp:separator {"className":"is-style-wide"} -->
					<hr class="wp-block-separator is-style-wide"/>
					<!-- /wp:separator --></div></div>
					<!-- /wp:group -->

					<!-- wp:group -->
					<div class="wp-block-group"><div class="wp-block-group__inner-container"><!-- wp:columns {"verticalAlignment":"top","align":"full"} -->
					<div class="wp-block-columns alignfull are-vertically-aligned-top"><!-- wp:column {"verticalAlignment":"top","width":100} -->
					<div class="wp-block-column is-vertically-aligned-top" style="flex-basis:100%"><!-- wp:paragraph -->
					' . _x( '<p><strong>June 5, </strong> WordCamp Europe Online</p>', 'Block pattern content', 'inclusive' ) . '<!-- /wp:paragraph --></div>
					<!-- /wp:column -->

					<!-- wp:column {"verticalAlignment":"top"} -->
					<div class="wp-block-column is-vertically-aligned-top"><!-- wp:button -->
					<div class="wp-block-button"><a class="wp-block-button__link" href="#">' . _x( 'View Live Stream', 'Block pattern content', 'inclusive' ) . '</a></div>
					<!-- /wp:button --></div>
					<!-- /wp:column --></div>
					<!-- /wp:columns -->

					<!-- wp:separator {"className":"is-style-wide"} -->
					<hr class="wp-block-separator is-style-wide"/>
					<!-- /wp:separator --></div></div>
					<!-- /wp:group -->

					<!-- wp:group -->
					<div class="wp-block-group"><div class="wp-block-group__inner-container"><!-- wp:columns {"verticalAlignment":"top","align":"full"} -->
					<div class="wp-block-columns alignfull are-vertically-aligned-top"><!-- wp:column {"verticalAlignment":"top","width":100} -->
					<div class="wp-block-column is-vertically-aligned-top" style="flex-basis:100%"><!-- wp:paragraph -->
					' . _x( '<p><strong>June 6, </strong> WordCamp Europe Online</p>', 'Block pattern content', 'inclusive' ) . '<!-- /wp:paragraph --></div>
					<!-- /wp:column -->

					<!-- wp:column {"verticalAlignment":"top"} -->
					<div class="wp-block-column is-vertically-aligned-top"><!-- wp:button -->
					<div class="wp-block-button"><a class="wp-block-button__link" href="#">' . _x( 'View Live Stream', 'Block pattern content', 'inclusive' ) . '</a></div>
					<!-- /wp:button --></div>
					<!-- /wp:column --></div>
					<!-- /wp:columns -->

					<!-- wp:separator {"className":"is-style-wide"} -->
					<hr class="wp-block-separator is-style-wide"/>
					<!-- /wp:separator --></div></div>
					<!-- /wp:group -->
				',
				)
			);

			register_block_pattern(
				'inclusive/presentation',
				array(
					'title'   => __( 'Inclusive: Presentation', 'inclusive' ),
					'content' => '<!-- wp:columns {"align":"wide"} -->
					<div class="wp-block-columns alignwide"><!-- wp:column {"width":25} -->
					<div class="wp-block-column" style="flex-basis:25%"><!-- wp:image {"align":"center","id":71,"sizeSlug":"large"} -->
					<div class="wp-block-image"><figure class="aligncenter size-large"><img src="' . esc_url( get_theme_file_uri( 'assets/images/flora-narrow.png' ) ) . '" alt="' . _x( 'A pencil drawing of three peonies.', 'Block pattern content', 'inclusive' ) . '" class="wp-image-71"/></figure></div>
					<!-- /wp:image --></div>
					<!-- /wp:column -->

					<!-- wp:column {"width":74} -->
					<div class="wp-block-column" style="flex-basis:74%"><!-- wp:heading {"className":"is-style-inclusive-text-shadow","style":{"typography":{"lineHeight":"1.8"}}} -->
					<h2 class="is-style-inclusive-text-shadow" style="line-height:1.8">' . _x( 'Presentation', 'Block pattern content', 'inclusive' ) . '</h2>
					<!-- /wp:heading -->

					<!-- wp:paragraph {"style":{"typography":{"lineHeight":"2"}}} -->
					<p style="line-height:2"><strong>' . _x( 'This is an example placeholder text. Edit it to make it your own.', 'Block pattern content', 'inclusive' ) . '</strong></p>
					<!-- /wp:paragraph -->

					<!-- wp:paragraph -->
					<p>' . _x( 'You can change the image by selecting the block and clicking "Replace".', 'Block pattern content', 'inclusive' ) . '</p>
					<!-- /wp:paragraph -->

					<!-- wp:paragraph {"className":"is-style-inclusive-rounded-corners","backgroundColor":"secondary"} -->
					<p class="is-style-inclusive-rounded-corners has-secondary-background-color has-background">' . _x( 'This paragraph block uses the secondary background color and the "Rounded corners" style.', 'Block pattern content', 'inclusive' ) . '</p>
					<!-- /wp:paragraph -->

					<!-- wp:paragraph -->
					<p>' . _x( 'Did you know that you can adjust how wide you want your columns to be?', 'Block pattern content', 'inclusive' ) . '</p>
					<!-- /wp:paragraph --></div>
					<!-- /wp:column --></div>
					<!-- /wp:columns -->
				',
				)
			);

			register_block_pattern(
				'inclusive/left-sidebar',
				array(
					'title'   => __( 'Inclusive: Left sidebar', 'inclusive' ),
					'content' => '
						<!-- wp:columns {"align":"full"} -->
						<div class="wp-block-columns alignfull"><!-- wp:column {"width":20,"className":"is-style-inclusive-sidebar"} -->
						<div class="wp-block-column is-style-inclusive-sidebar" style="flex-basis:20%"><!-- wp:group {"style":{"color":{"background":"#fafafa"}}} -->
						<div class="wp-block-group has-background" style="background-color:#fafafa"><div class="wp-block-group__inner-container"><!-- wp:search /-->

						<!-- wp:latest-posts /-->

						<!-- wp:latest-comments {"commentsToShow":3} /--></div></div>
						<!-- /wp:group --></div>
						<!-- /wp:column -->

						<!-- wp:column {"width":80,"className":"is-inclusive-main-column"} -->
						<div class="wp-block-column is-inclusive-main-column" style="flex-basis:80%"><!-- wp:heading {"className":"is-style-inclusive-text-shadow"} -->
						<h2 class="is-style-inclusive-text-shadow">' . _x( 'Example -Main column', 'Block pattern content', 'inclusive' ) . '</h2>
						<!-- /wp:heading -->

						<!-- wp:paragraph -->
						<p><em>' . _x( 'This is a content placeholder.', 'Block pattern content', 'inclusive' ) . '</em></p>
						<!-- /wp:paragraph -->
						</div><!-- /wp:column -->
						</div><!-- /wp:columns -->',
				)
			);

			register_block_pattern(
				'inclusive/right-sidebar',
				array(
					'title'   => __( 'Inclusive: Right sidebar', 'inclusive' ),
					'content' => '
						<!-- wp:columns {"align":"full"} -->
						<div class="wp-block-columns alignfull"><!-- wp:column {"width":80,"className":"is-inclusive-main-column"} -->
						<div class="wp-block-column is-inclusive-main-column" style="flex-basis:80%"><!-- wp:group -->
						<div class="wp-block-group"><div class="wp-block-group__inner-container"><!-- wp:heading {"className":"is-style-inclusive-text-shadow"} -->
						<h2 class="is-style-inclusive-text-shadow">' . _x( 'Example -Main column', 'Block pattern content', 'inclusive' ) . '</h2>
						<!-- /wp:heading -->

						<!-- wp:paragraph -->
						<p><em>' . _x( 'This is a content placeholder.', 'Block pattern content', 'inclusive' ) . '</em></p>
						<!-- /wp:paragraph -->

						</div></div>
						<!-- /wp:group --></div>
						<!-- /wp:column -->

						<!-- wp:column {"width":20,"className":"is-style-inclusive-sidebar is-inclusive-right-sidebar"} -->
						<div class="wp-block-column is-style-inclusive-sidebar is-inclusive-right-sidebar" style="flex-basis:20%"><!-- wp:group {"style":{"color":{"background":"#fafafa"}}} -->
						<div class="wp-block-group has-background" style="background-color:#fafafa"><div class="wp-block-group__inner-container"><!-- wp:search /-->
						
						<!-- wp:latest-posts /-->

						<!-- wp:latest-comments {"commentsToShow":3} /--></div></div>
						<!-- /wp:group --></div>
						<!-- /wp:column --></div>
						<!-- /wp:columns -->',
				)
			);

		}
	}
}
