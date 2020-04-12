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
	 * Constructor.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {

		add_action( 'wp_enqueue_scripts', [ $this, 'action_dequeue_scripts' ] );

		/**
		 * Use a filter to figure out which blocks are used.
		 * We'll use this to populate the $blocks property of this object
		 * and enque the CSS needed for them.
		 */
		add_filter( 'render_block', [ $this, 'filter_add_inline_styles' ], 10, 2 );
		add_filter( 'render_block', [ $this, 'filter_cover_styles' ], 10, 2 );

		/**
		 * Add admin styles for blocks.
		 */
		add_action( 'enqueue_block_assets', [ $this, 'enqueue_block_assets' ] );
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
			'core/navigation-link',
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
		if ( $block['blockName'] ) {
			if ( strpos( $block['blockName'], 'core-embed' ) !== false ) {
				$block['blockName'] = 'core/embed';
			}

			if ( ! in_array( $block['blockName'], self::$block_styles_added, true ) ) {
				self::$block_styles_added[] = $block['blockName'];

				$styles_path = get_template_directory_uri() . "/assets/css/blocks/{$block['blockName']}.min.css";

				if ( file_exists( get_theme_file_path( "/assets/css/blocks/{$block['blockName']}.min.css" ) ) ) {
					$block_content .= '<style id="incusive-block-styles-' . esc_attr( str_replace( '/', '-', $block['blockName'] ) ) . '">';
					// Not a remote URL, but we are required to use WordPress functions rather than file_get_contents.
					$styles_path = wp_remote_get( $styles_path );

					if ( ! is_wp_error( $styles_path ) ) {
						$block_content .= wp_remote_retrieve_body( $styles_path );
					}
					$block_content .= '</style>';
				}
			}
		}
		return $block_content;
	}

	/**
	 * Filters the content of a single block.
	 *
	 * Add CSS-Variables (--dimRatio) to the cover block.
	 *
	 * @since 1.0.0
	 * @access public
	 * @param string $block_content The block content about to be appended.
	 * @param array  $block         The full block, including name and attributes.
	 * @return string               Returns $block_content with our modifications.
	 */
	public function filter_cover_styles( $block_content, $block ) {
		if ( 'core/cover' === $block['blockName'] ) {
			$extra_styles = '';
			if ( isset( $block['attrs'] ) && isset( $block['attrs']['dimRatio'] ) ) {
				$extra_styles = '--dimRatio:' . ( absint( $block['attrs']['dimRatio'] ) / 100 ) . ';';
			}
			$block_content = str_replace(
				'style="',
				'style="' . $extra_styles,
				$block_content
			);
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
	 * Add custom block styles for core blocks.
	 */
	public static function register_custom_block_styles() {
		register_block_style(
			'core/gallery',
			array(
				'name'         => 'inclusive-hide-caption',
				'label'        => __( 'Hide caption', 'inclusive' ),
				'inline_style' => '.is-style-inclusive-hide-caption figcaption {display:none;}',
			)
		);

		register_block_style(
			'core/gallery',
			array(
				'name'         => 'inclusive-gallery-rounded',
				'label'        => __( 'Rounded corners', 'inclusive' ),
				'inline_style' => '.is-style-inclusive-gallery-rounded img {border-radius:50%;} .is-style-inclusive-gallery-rounded figcaption {display:none;}',
			)
		);

		register_block_style(
			'core/separator',
			array(
				'name'         => 'inclusive-separator-ornament1',
				'label'        => __( 'Ornament', 'inclusive' ),
				'inline_style' => '.wp-block-separator.is-style-inclusive-separator-ornament1 {
					width: 130px;
					height: 70px;
					padding-left: 0;
					padding-right: 0;
					-webkit-mask: url( ' . esc_url( get_template_directory_uri() . '/assets/images/ornament1.svg' ) . ') no-repeat top;
					mask: url(' . esc_url( get_template_directory_uri() . '/assets/images/ornament1.svg' ) . ') no-repeat top;
					border: none;
				}',
			)
		);

		register_block_style(
			'core/separator',
			array(
				'name'         => 'inclusive-separator-ornament2',
				'label'        => __( 'Ornament 2', 'inclusive' ),
				'inline_style' => '.wp-block-separator.is-style-inclusive-separator-ornament2 {
					width: 70px;
					height: 70px;
					padding-left: 0;
					padding-right: 0;
					-webkit-mask: url( ' . esc_url( get_template_directory_uri() . '/assets/images/ornament2.svg' ) . ') no-repeat top;
					mask: url(' . esc_url( get_template_directory_uri() . '/assets/images/ornament2.svg' ) . ') no-repeat top;
					border: none;
				}',
			)
		);

		register_block_style(
			'core/button',
			array(
				'name'         => 'inclusive-large-button',
				'label'        => __( 'Large', 'inclusive' ),
				'inline_style' => '.wp-block-button.is-style-inclusive-large-button .wp-block-button__link{
					padding: 3em; margin: 1.5em;
				}',
			)
		);

		register_block_style(
			'core/paragraph',
			array(
				'name'         => 'inclusive-rounded-corner-paragraph',
				'label'        => __( 'Rounced corners (Requires background color)', 'inclusive' ),
				'inline_style' => 'p.is-style-inclusive-rounded-corner-paragraph {
					border-radius: 6px;
				}',
			)
		);

		register_block_style(
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

		register_block_style(
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

		register_block_style(
			'core/heading',
			array(
				'name'         => 'inclusive-text-shadow',
				'label'        => __( 'Text shadow', 'inclusive' ),
				'inline_style' => '.is-style-inclusive-text-shadow {
					text-shadow: var(--text-shadow);
				}',
			)
		);

		if ( function_exists( 'register_pattern' ) ) {
			register_pattern(
				'inclusive/split-heading',
				array(
					'title'   => __( 'Inclusive: Heading with two colors', 'inclusive' ),
					'content' => '<!-- wp:heading {"level":2,"className":"inclusive-split-heading is-style-inclusive-text-shadow"} -->
					<h2 class="is-style-inclusive is-style-inclusive-text-shadow">' .
					_x( 'Heading with <span style="color:#b6007c" class="has-inline-color">two colors</span></h2>', 'Block pattern content', 'inclusive' ) . '<!-- /wp:heading -->',
				)
			);

			register_pattern(
				'inclusive/cover-block-with-large-button',
				array(
					'title'   => __( 'Inclusive: Cover block with heading and large button', 'inclusive' ),
					'content' => '<!-- wp:cover {"url":"' . esc_url( get_theme_file_uri( 'assets/images/flora.png' ) ) . '","id":48,"customOverlayColor":"#e3eff5","className":"inclusive-cover-block-with-large-button"} -->
					<div class="wp-block-cover has-background-dim inclusive-cover-block-with-large-button" style="background-image:url(' . esc_url( get_theme_file_uri( 'assets/images/flora.png' ) ) . ');background-color:#e3eff5">
					<div class="wp-block-cover__inner-container">
					<!-- wp:heading {"align":"center","level":2,"customTextColor":"#000000","className":"is-style-inclusive-text-shadow"} -->
					<h2 class="has-text-color has-text-align-center is-style-inclusive-text-shadow" style="color:#000000">' . _x( 'Inclusive', 'Theme starter content, theme name', 'inclusive' ) . '</h2>
					<!-- /wp:heading -->
					<!-- wp:buttons {"align":"center"} -->
					<div class="wp-block-buttons aligncenter"><!-- wp:button {"className":"is-style-inclusive-large-button"} -->
					<div class="wp-block-button is-style-inclusive-large-button"><a href="#" class="wp-block-button__link">' . _x( 'Sign up for our Newsletter', 'Theme starter content', 'inclusive' ) . '</a></div>
					<!-- /wp:button --></div>
					<!-- /wp:buttons --></div></div>
					<!-- /wp:cover -->',
				)
			);

			register_pattern(
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

		}
	}

}
