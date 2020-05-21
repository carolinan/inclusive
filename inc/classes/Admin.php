<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Inclusive Admin class
 *
 * Adds a theme information page to the WordPress admin area
 *
 * @package Inclusive
 * @since 1.0.0
 */

namespace Inclusive;

/**
 * Admin Theme Information page
 *
 * @since 1.0.0
 */
class Admin {

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
	public function __construct() {
		add_action( 'admin_menu', [ $this, 'action_admin_page_menu' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'action_admin_scripts' ] );

	}

	/**
	 * Adds the menu item for the theme information page.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
	public function action_admin_page_menu() {
		add_theme_page( __( 'Inclusive Setup Help', 'inclusive' ), __( 'Inclusive Setup Help', 'inclusive' ), 'edit_theme_options', 'inclusive_theme', [ $this, 'docs' ] );
	}

	/**
	 * Enqueue styles for the theme setup help page.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
	public function action_admin_scripts( $hook ) {
		if ( 'appearance_page_inclusive_theme' !== $hook ) {
			return;
		}
		wp_enqueue_style(
			'inclusive-admin-style',
			get_template_directory_uri() . '/assets/css/min/admin.min.css',
			null,
			INCLUSIVE_VERSION
		);

		wp_enqueue_script(
			'inclusive-admin-script',
			get_template_directory_uri() . '/assets/js/admin.js',
			array( 'clipboard' ),
			INCLUSIVE_VERSION,
			true
		);
	}

	/**
	 * Create the documentation page.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
	public function docs() {
		?>
		<div class="wrap">
		<div class="welcome-panel">
		<div class="welcome-panel-content">
		<h1><?php esc_html_e( 'Inclusive Setup Help', 'inclusive' ); ?></h1><br>
		<?php esc_html_e( 'Thank you for chosing Inclusive <3', 'inclusive' ); ?><br>
		<?php esc_html_e( 'For support, please email support@themesbycarolina.com and I will reply as soon as I can.', 'inclusive' ); ?><br><br>
		<div class="welcome-panel-column-container">
		<h2><?php esc_html_e( 'Personalize your theme', 'inclusive' ); ?></h2>
		<a class="button button-primary button-hero load-customize" href="<?php echo esc_url( admin_url( 'customize.php?autofocus[control]=custom_logo' ) ); ?>">
		<?php esc_html_e( 'Add a logo', 'inclusive' ); ?></a>
		<a class="button button-primary button-hero load-customize" href="<?php echo esc_url( admin_url( 'customize.php?autofocus[control]=header_textcolor' ) ); ?>">
		<?php esc_html_e( 'Mix your favorite colors', 'inclusive' ); ?></a>
		<a class="button button-primary button-hero load-customize" href="<?php echo esc_url( admin_url( 'customize.php?autofocus[control]=font_pairing' ) ); ?>">
		<?php esc_html_e( 'Choose your fonts', 'inclusive' ); ?></a>
		<br><br>
		<details>
		<summary class="button button-primary button-hero"><?php esc_html_e( 'Custom Block Patterns', 'inclusive' ); ?></summary>
			<br><h2><?php esc_html_e( 'Block patterns', 'inclusive' ); ?></h2><br>
			<?php esc_html_e( 'Block patterns are available in the editor if you have enabled Gutenberg. You can copy the patterns below if you do not want to install the plugin.', 'inclusive' ); ?><br>
			<?php esc_html_e( 'These patterns can be added to any post or page.', 'inclusive' ); ?><br>
			<ol>
				<li><?php esc_html_e( 'Click the "Copy block code" button to copy the pattern.', 'inclusive' ); ?>
				<li><?php esc_html_e( 'Open or create a new post or page.', 'inclusive' ); ?></li>
				<li><?php esc_html_e( 'Open the Code Editor mode.', 'inclusive' ); ?></li>
				<li><?php esc_html_e( 'Paste the code into your page and preview the results.', 'inclusive' ); ?></li>
				<li><?php esc_html_e( "Don't forget to save your changes.", 'inclusive' ); ?></li>
			</ol>
			<ul>
				<li>
					<h3><?php esc_html_e( 'Left sidebar', 'inclusive' ); ?></h3><br>
					<img src="<?php echo esc_url( get_theme_file_uri( '/assets/images/left-column-preview.png' ) ); ?>" alt="<?php esc_attr_e( 'A preview of a heading block with two colors, black and dark pink.', 'inclusive' ); ?>" width="300"><br>
					<br><a class="button button-primary inclusive-copy" data-clipboard-text='
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
						<h2 class="is-style-inclusive-text-shadow"><?php echo _x( 'Example -Main column', 'Block pattern content', 'inclusive' ); ?></h2>
						<!-- /wp:heading -->

						<!-- wp:paragraph -->
						<p><em><?php echo _x( 'This is a content placeholder.', 'Block pattern content', 'inclusive' ); ?></em></p>
						<!-- /wp:paragraph -->
						</div><!-- /wp:column -->
						</div><!-- /wp:columns -->
					'>
					<?php esc_html_e( 'Copy block code', 'inclusive' ); ?></a>
					<div class="success" aria-hidden="true"><?php esc_html_e( 'Copied!', 'inclusive' ); ?></div>
				</li>
				<li>
					<h3><?php esc_html_e( 'Right sidebar', 'inclusive' ); ?></h3><br>
					<img src="<?php echo esc_url( get_theme_file_uri( '/assets/images/right-column-preview.png' ) ); ?>" alt="<?php esc_attr_e( 'A preview of a heading block with two colors, black and dark pink.', 'inclusive' ); ?>" width="300"><br>
					<br><a class="button button-primary inclusive-copy" data-clipboard-text='<!-- wp:columns {"align":"full"} -->
						<div class="wp-block-columns alignfull"><!-- wp:column {"width":80,"className":"is-inclusive-main-column"} -->
						<div class="wp-block-column is-inclusive-main-column" style="flex-basis:80%"><!-- wp:group -->
						<div class="wp-block-group"><div class="wp-block-group__inner-container"><!-- wp:heading {"className":"is-style-inclusive-text-shadow"} -->
						<h2 class="is-style-inclusive-text-shadow"><?php echo _x( 'Example -Main column', 'Block pattern content', 'inclusive' ); ?></h2>
						<!-- /wp:heading -->

						<!-- wp:paragraph -->
						<p><em><?php echo _x( 'This is a content placeholder.', 'Block pattern content', 'inclusive' ); ?></em></p>
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
						<!-- /wp:columns -->
					'>
					<?php esc_html_e( 'Copy block code', 'inclusive' ); ?></a>
					<div class="success" aria-hidden="true"><?php esc_html_e( 'Copied!', 'inclusive' ); ?></div>
				</li>
				<li>
					<h3><?php esc_html_e( 'Heading with two colors', 'inclusive' ); ?></h3><br>
					<img src="<?php echo esc_url( get_theme_file_uri( '/assets/images/heading-preview.png' ) ); ?>" alt="<?php esc_attr_e( 'A preview of a heading block with two colors, black and dark pink.', 'inclusive' ); ?>" width="300"><br>
					<br><a class="button button-primary inclusive-copy" data-clipboard-text='<!-- wp:heading {"level":2,"className":"inclusive-split-heading is-style-inclusive-text-shadow"} --> <h2 class="is-style-inclusive is-style-inclusive-text-shadow"><?php _e( 'Heading with <span style="color:#b6007c" class="has-inline-color">two colors</span>', 'inclusive' ); ?></h2><!-- /wp:heading -->'>
					<?php esc_html_e( 'Copy block code', 'inclusive' ); ?></a>
					<div class="success" aria-hidden="true"><?php esc_html_e( 'Copied!', 'inclusive' ); ?></div>
				</li>
				<li>
					<h3><?php esc_html_e( 'Cover block with background image, heading and button', 'inclusive' ); ?></h3><br>
					<img src="<?php echo esc_url( get_theme_file_uri( '/assets/images/coverblock-preview.png' ) ); ?>" alt="<?php esc_attr_e( 'A preview of a cover block with a flower background image, a blue overlay, a heading and a button.', 'inclusive' ); ?>" width="300"><br>
					<br><a class="button button-primary inclusive-copy" data-clipboard-text='<!-- wp:cover {"url":"<?php echo esc_url( get_theme_file_uri( 'assets/images/flora.png' ) ); ?>","id":48,"customOverlayColor":"#e3eff5","className":"inclusive-cover-block-with-large-button"} -->
					<div class="wp-block-cover has-background-dim inclusive-cover-block-with-large-button" style="background-image:url(<?php echo esc_url( get_theme_file_uri( 'assets/images/flora.png' ) ); ?>);background-color:#e3eff5">
					<div class="wp-block-cover__inner-container">
					<!-- wp:heading {"align":"center","level":2,"customTextColor":"#000000","className":"is-style-inclusive-text-shadow"} -->
					<h2 class="has-text-color has-text-align-center is-style-inclusive-text-shadow" style="color:#000000"><?php echo _x( 'Example heading', 'Theme starter content', 'inclusive' ); ?></h2>
					<!-- /wp:heading -->
					<!-- wp:buttons {"align":"center"} -->
					<div class="wp-block-buttons aligncenter"><!-- wp:button {"className":"is-style-inclusive-large-button"} -->
					<div class="wp-block-button is-style-inclusive-large-button"><a href="#" class="wp-block-button__link"><?php echo _x( 'Sign up for our Newsletter', 'Theme starter content', 'inclusive' ); ?></a></div>
					<!-- /wp:button --></div>
					<!-- /wp:buttons --></div></div>
					<!-- /wp:cover -->'>
					<?php esc_html_e( 'Copy block code', 'inclusive' ); ?></a>
					<div class="success" aria-hidden="true"><?php esc_html_e( 'Copied!', 'inclusive' ); ?></div>
				</li>
				<li>
					<h3><?php esc_html_e( 'Presentation', 'inclusive' ); ?></h3><br>
					<?php esc_html_e( 'A two column block with an image, a heading and styled paragraphs.', 'inclusive' ); ?></a><br>
					<img src="<?php echo esc_url( get_theme_file_uri( '/assets/images/presentation-preview.png' ) ); ?>" alt="<?php esc_attr_e( 'A preview of a column block with two colums. The left column has an image and the right column has a heading and a couple of styled paragraphs.', 'inclusive' ); ?>" width="400"><br>
					<br><a class="button button-primary inclusive-copy" data-clipboard-text='
					<!-- wp:columns {"align":"wide"} -->
					<div class="wp-block-columns alignwide"><!-- wp:column {"width":25} -->
					<div class="wp-block-column" style="flex-basis:25%"><!-- wp:image {"align":"center","id":71,"sizeSlug":"large"} -->
					<div class="wp-block-image"><figure class="aligncenter size-large"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/flora-narrow.png' ) ); ?>" alt="<?php echo _x( 'A pencil drawing of three peonies.', 'Block pattern content', 'inclusive' ); ?>" class="wp-image-71"/></figure></div>
					<!-- /wp:image --></div>
					<!-- /wp:column -->

					<!-- wp:column {"width":74} -->
					<div class="wp-block-column" style="flex-basis:74%"><!-- wp:heading {"className":"is-style-inclusive-text-shadow","style":{"typography":{"lineHeight":"1.8"}}} -->
					<h2 class="is-style-inclusive-text-shadow" style="line-height:1.8"><?php echo _x( 'Presentation', 'Block pattern content', 'inclusive' ); ?></h2>
					<!-- /wp:heading -->

					<!-- wp:paragraph {"style":{"typography":{"lineHeight":"2"}}} -->
					<p style="line-height:2"><strong><?php echo _x( 'This is an example place holder text. Edit it to make it your own.', 'Block pattern content', 'inclusive' ); ?></strong></p>
					<!-- /wp:paragraph -->

					<!-- wp:paragraph -->
					<p><?php echo _x( 'You can change the image by selecting the block and clicking "Replace".', 'Block pattern content', 'inclusive' ); ?></p>
					<!-- /wp:paragraph -->

					<!-- wp:paragraph {"className":"is-style-inclusive-rounded-corners","backgroundColor":"secondary"} -->
					<p class="is-style-inclusive-rounded-corners has-secondary-background-color has-background"><?php echo _x( 'This paragraph block uses the secondary background color and the "Rounded corners" style.', 'Block pattern content', 'inclusive' ); ?></p>
					<!-- /wp:paragraph -->

					<!-- wp:paragraph -->
					<p><?php echo _x( 'Did you know that you can adjust how wide you want your columns to be?', 'Block pattern content', 'inclusive' ); ?></p>
					<!-- /wp:paragraph --></div>
					<!-- /wp:column --></div>
					<!-- /wp:columns -->
					'><?php esc_html_e( 'Copy block code', 'inclusive' ); ?></a>
					<div class="success" aria-hidden="true"><?php esc_html_e( 'Copied!', 'inclusive' ); ?></div>
				</li>
				<li>
					<h3><?php esc_html_e( 'Event list', 'inclusive' ); ?></h3><br>
					<img src="<?php echo esc_url( get_theme_file_uri( '/assets/images/eventlist-preview.png' ) ); ?>" alt="<?php esc_attr_e( 'A preview of an event list with descriptions, date, live stream buttons, and separators between each event.', 'inclusive' ); ?>" width="400"><br>
					<br><a class="button button-primary inclusive-copy" data-clipboard-text='
					<!-- wp:group -->
					<div class="wp-block-group"><div class="wp-block-group__inner-container"><!-- wp:columns {"verticalAlignment":"top","align":"full"} -->
					<div class="wp-block-columns alignfull are-vertically-aligned-top"><!-- wp:column {"verticalAlignment":"top","width":100} -->
					<div class="wp-block-column is-vertically-aligned-top" style="flex-basis:100%"><!-- wp:paragraph --><?php echo _x( '<p><strong>June 4, </strong> WordCamp Europe Online</p>', 'Block pattern content', 'inclusive' ); ?><!-- /wp:paragraph --></div>
					<!-- /wp:column -->

					<!-- wp:column {"verticalAlignment":"top"} -->
					<div class="wp-block-column is-vertically-aligned-top"><!-- wp:button -->
					<div class="wp-block-button"><a class="wp-block-button__link" href="#"><?php echo _x( 'View Live Stream', 'Block pattern content', 'inclusive' ); ?></a></div>
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
					<?php echo _x( '<p><strong>June 5, </strong> WordCamp Europe Online</p>', 'Block pattern content', 'inclusive' ); ?><!-- /wp:paragraph --></div>
					<!-- /wp:column -->

					<!-- wp:column {"verticalAlignment":"top"} -->
					<div class="wp-block-column is-vertically-aligned-top"><!-- wp:button -->
					<div class="wp-block-button"><a class="wp-block-button__link" href="#"><?php echo _x( 'View Live Stream', 'Block pattern content', 'inclusive' ); ?></a></div>
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
					<?php echo _x( '<p><strong>June 6, </strong> WordCamp Europe Online</p>', 'Block pattern content', 'inclusive' ); ?><!-- /wp:paragraph --></div>
					<!-- /wp:column -->

					<!-- wp:column {"verticalAlignment":"top"} -->
					<div class="wp-block-column is-vertically-aligned-top"><!-- wp:button -->
					<div class="wp-block-button"><a class="wp-block-button__link" href="#"><?php echo _x( 'View Live Stream', 'Block pattern content', 'inclusive' ); ?></a></div>
					<!-- /wp:button --></div>
					<!-- /wp:column --></div>
					<!-- /wp:columns -->
					<!-- wp:separator {"className":"is-style-wide"} -->
					<hr class="wp-block-separator is-style-wide"/>
					<!-- /wp:separator --></div></div>
					<!-- /wp:group -->
					'><?php esc_html_e( 'Copy block code', 'inclusive' ); ?></a>
					<div class="success" aria-hidden="true"><?php esc_html_e( 'Copied!', 'inclusive' ); ?></div>
				</li>
			<ul>
			<br>
		</details>
		<details>
		<summary class="button button-primary button-hero"><?php esc_html_e( 'Custom Block Styles', 'inclusive' ); ?></summary>
		<br><h2><?php esc_html_e( 'Custom Block Styles', 'inclusive' ); ?></h2><br>
		<?php esc_html_e( 'The following custom block styles are available in the editor. You can also use some of the CSS classes for other blocks, using the "Additional CSS class(es)" option.', 'inclusive' ); ?>
		<br>
			<ul>
				<li><?php esc_html_e( 'Gallery: Hide captions', 'inclusive' ); ?> <code>.is-style-inclusive-hide-caption figcaption</code></li>
				<li><?php esc_html_e( 'Gallery: Rounded corners', 'inclusive' ); ?> <code>.is-style-inclusive-gallery-rounded img</code></li>
				<li><?php esc_html_e( 'Separator: Ornaments one and two', 'inclusive' ); ?> <code>.wp-block-separator.is-style-inclusive-separator-ornament1</code> <code>.wp-block-separator.is-style-inclusive-separator-ornament2</code></li>
				<li><?php esc_html_e( 'Button: Large', 'inclusive' ); ?> <code>.is-style-inclusive-large-button</code></li>
				<li><?php esc_html_e( 'Rounced corners (Requires a background color to be visible)', 'inclusive' ); ?> <code>.is-style-inclusive-rounded-corners</code></li>
				<li><?php esc_html_e( 'Paragraph: Box shadow', 'inclusive' ); ?> <code>.is-style-inclusive-box-shadow</code></li>
				<li><?php esc_html_e( 'Paragraph: Border', 'inclusive' ); ?> <code>.is-style-inclusive-border</code></li>
				<li><?php esc_html_e( 'Heading: Text shadow', 'inclusive' ); ?> <code>.is-style-inclusive-text-shadow</code></li>
			</ul>
		</details>
		</div><br>
		</div>
		</div>

			<div class="welcome-panel">
				<div class="welcome-panel-content">
					<h2><?php esc_html_e( 'Recommended Plugins', 'inclusive' ); ?></h2>
					<br>
					<?php
					esc_html_e( 'To make use of additional blocks and block patterns, please install and activate Gutenberg.', 'inclusive' );
					?>
					<br><a class="button button-primary button-hero load-customize" href="<?php echo esc_url( 'https://wordpress.org/plugins/gutenberg/' ); ?>"><?php esc_html_e( 'Gutenberg', 'inclusive' ); ?></a>
					<br><br>
					<?php
					if ( ! class_exists( 'WooCommerce' ) ) {
						esc_html_e( 'If you would like to add an online store, please install and activate WooCommerce.', 'inclusive' );
						?>
						<br><a class="button button-primary button-hero load-customize" href="<?php echo esc_url( 'https://wordpress.org/plugins/woocommerce/' ); ?>"><?php esc_html_e( 'WooCommerce', 'inclusive' ); ?></a>
						<br><br>
						<?php
					}
					?>
				</div>
			</div>

			<div class="welcome-panel">
				<div class="welcome-panel-content">
					<h2><?php esc_html_e( 'Tips for creating an accessible website', 'inclusive' ); ?></h2>
					<ul>
						<li><?php esc_html_e( 'Add alt texts to images. You can do this in the media library or by selecting the image in the edtior.', 'inclusive' ); ?></li>
						<li><?php esc_html_e( 'Add text alternatives for videos and sound.', 'inclusive' ); ?></li>
						<li><?php esc_html_e( 'When adding headings, do not skip heading levels. H2 should be followed by H3 and so on.', 'inclusive' ); ?></li>
						<li><?php esc_html_e( 'Keep your text simple. Paragraphs with more than four lines are more difficult to read. Use lists and spacing in your content.', 'inclusive' ); ?></li>
						<li><?php esc_html_e( 'Adding images to posts and pages makes your content easier to remember.', 'inclusive' ); ?></li>
					</ul>
				</div>
			</div>
		</div>
		<?php
	}
}
