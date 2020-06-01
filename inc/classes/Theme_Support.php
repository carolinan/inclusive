<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Inclusive Theme support
 *
 * @package Inclusive
 * @since 1.0.0
 */

namespace Inclusive;

/**
 * Add theme support
 *
 * @since 1.0.0
 */
class Theme_Support {

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		add_action( 'after_setup_theme', [ $this, 'action_setup' ] );
		add_action( 'after_setup_theme', [ $this, 'action_content_width' ], 0 );
	}

	/**
	 * Adds theme-supports.
	 *
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function action_setup() {

		load_theme_textdomain( 'inclusive', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		* Switch default core markup to output valid HTML5.
		*/
		add_theme_support(
			'html5',
			[
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			]
		);

		add_theme_support(
			'custom-header',
			apply_filters(
				'custom_header_args',
				[
					'default-text-color' => '333',
					'width'              => 2000,
					'height'             => 400,
					'flex-height'        => true,
					'flex-width'         => true,
					'video'              => false,
					'wp-head-callback'   => [ $this, 'header_style' ],
				]
			)
		);

		add_theme_support(
			'custom-logo',
			apply_filters(
				'custom_logo_args',
				[
					'height'      => 250,
					'width'       => 250,
					'flex-width'  => false,
					'flex-height' => false,
				]
			)
		);

		register_nav_menus(
			array(
				'menu-1' => __( 'Primary ', 'inclusive' ),
				'social' => __( 'Social Links', 'inclusive' ),
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for Block Styles.
		add_theme_support( 'wp-block-styles' );

		add_theme_support( 'editor-styles' );

		// Add support for full and wide align images.
		add_theme_support( 'align-wide' );

		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );

		add_theme_support(
			'editor-color-palette',
			array(
				array(
					'name'  => __( 'Primary', 'inclusive' ),
					'slug'  => 'primary',
					'color' => '#fdb698',
				),
				array(
					'name'  => __( 'Secondary', 'inclusive' ),
					'slug'  => 'secondary',
					'color' => '#fdeee1',
				),
			)
		);

		add_theme_support(
			'editor-font-sizes',
			array(
				array(
					'name'      => __( 'Small', 'inclusive' ),
					'shortName' => __( 'S', 'inclusive' ),
					'size'      => 16,
					'slug'      => 'small',
				),
				array(
					'name'      => __( 'Normal', 'inclusive' ),
					'shortName' => __( 'N', 'inclusive' ),
					'size'      => 20,
					'slug'      => 'normal',
				),
				array(
					'name'      => __( 'Medium', 'inclusive' ),
					'shortName' => __( 'M', 'inclusive' ),
					'size'      => 25,
					'slug'      => 'medium',
				),
				array(
					'name'      => __( 'Large', 'inclusive' ),
					'shortName' => __( 'L', 'inclusive' ),
					'size'      => 30,
					'slug'      => 'large',
				),
				array(
					'name'      => __( 'Larger', 'inclusive' ),
					'shortName' => __( 'XL', 'inclusive' ),
					'size'      => 40,
					'slug'      => 'larger',
				),
			)
		);
	}

	/**
	 * Set the content width based on the theme's design and stylesheet.
	 *
	 * Priority 0 to make it available to lower priority callbacks.
	 *
	 * @global int $content_width Content width.
	 * @since 1.0.0
	 * @access public
	 */
	public function action_content_width() {
		// This variable is intended to be overruled from themes.
		// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
		$GLOBALS['content_width'] = apply_filters( 'inclusive_content_width', 720 );
	}

	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function header_style() {
		$header_text_color = get_header_textcolor();

		/*
		 * If no custom options for text are set, let's bail.
		 * get_header_textcolor() options: Any hex value, 'blank' to hide text.
		 * Default: add_theme_support( 'custom-header' ).
		 */
		if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
			return;
		}

		// If we get this far, we have custom styles. Let's do this.
		?>
		<style type="text/css">
		<?php
		// Has the text been hidden?
		if ( ! display_header_text() ) {
			?>
			.site-title {
				position: absolute;
				clip: rect(1px, 1px, 1px, 1px);
			}
			<?php
			// If the user has set a custom color for the text use that.
		} else {
			?>
			.site-title a,
			.site-description {
				color: #<?php echo esc_attr( $header_text_color ); ?>!important;
			}
			<?php
		}
		?>
		</style>
		<?php
	}

}
