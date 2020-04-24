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
		add_theme_page( __( 'Inclusive Setup Help', 'inclusive' ), __( 'Inclusive Setup Help', 'inclusive' ), 'edit_theme_options', 'inclusive-theme', [ $this, 'docs' ] );
	}

	/**
	 * Enqueue styles for the theme setup help page.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
	public function action_admin_scripts( $hook ) {
		if ( 'appearance_page_inclusive-theme' !== $hook ) {
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
		<?php esc_html_e( 'Thank you for chosing Inclusive', 'inclusive' ); ?><br>
		<?php esc_html_e( 'For support, please email support@themesbycarolina.com.', 'inclusive' ); ?><br><br>
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
			<?php esc_html_e( 'Click the "Copy" button to copy the pattern.', 'inclusive' ); ?> <?php esc_html_e( 'Open or create a new page. Open the Code Editor mode. Paste the code into your page and preview the results.', 'inclusive' ); ?><br>
			<?php esc_html_e( "Don't forget to save your changes.", 'inclusive' ); ?><br>
			<ul>
				<li>
					<h3><?php esc_html_e( 'Heading with two colors', 'inclusive' ); ?></h3><br>
					<img src="<?php echo esc_url( get_theme_file_uri( '/assets/images/heading-preview.png' ) ); ?>" alt="<?php esc_attr_e( 'A preview of a heading block with two colors, black and dark pink.', 'inclusive' ); ?>" width="300"><br>
					<?php esc_html_e( 'Code:', 'inclusive' ); ?><br>
					<div id="inclusive-heading-preview">
						<code>&lt!-- wp:heading {"level":2,"className":"inclusive-split-heading is-style-inclusive-text-shadow"} --&gt;
							&lth2 class="is-style-inclusive is-style-inclusive-text-shadow"&gt
							<?php
							printf(
								__( 'Heading with %1$stwo colors', 'inclusive' ),
								'&ltspan style="color:#b6007c" class="has-inline-color"&gt;'
							);
							?>
							&lt/span&gt;&lt/h2>&lt!-- /wp:heading --&gt
						</code>
					</div>
					<br><a class="button button-primary inclusive-copy" data-clipboard-target="#inclusive-heading-preview"><?php esc_html_e( 'Copy', 'inclusive' ); ?></a>
					<div class="success" aria-hidden="true"><?php esc_html_e( 'Copied!', 'inclusive' ); ?></div>
				</li>
				<li>
					<h3><?php esc_html_e( 'Cover block with background image, heading and button', 'inclusive' ); ?></h3><br>
					<img src="<?php echo esc_url( get_theme_file_uri( '/assets/images/coverblock-preview.png' ) ); ?>" alt="<?php esc_attr_e( 'A preview of a cover block with a flower background image, a blue overlay, a heading and a button.', 'inclusive' ); ?>" width="300"><br>
					<?php esc_html_e( 'Code:', 'inclusive' ); ?>
					<br>
					<div id="inclusive-cover-preview">
						<code>
							&lt;!-- wp:cover {"url":"<?php echo esc_url( get_theme_file_uri( 'assets/images/flora.png' ) ); ?>","id":48,"customOverlayColor":"#e3eff5","className":"inclusive-cover-block-with-large-button"} --&gt;
							&lt;div class="wp-block-cover has-background-dim inclusive-cover-block-with-large-button" style="background-image:url(' <?php echo esc_url( get_theme_file_uri( 'assets/images/flora.png' ) ); ?>');background-color:#e3eff5"&gt;
							&lt;div class="wp-block-cover__inner-container"&gt;
							&lt;!-- wp:heading {"align":"center","level":2,"customTextColor":"#000000","className":"is-style-inclusive-text-shadow"} --&gt;
							&lt;h2 class="has-text-color has-text-align-center is-style-inclusive-text-shadow" style="color:#000000"&gt;<?php echo _x( 'Inclusive', 'Theme starter content, theme name', 'inclusive' ); ?>&lt;/h2&gt;
							&lt;!-- /wp:heading --&gt;
							&lt;!-- wp:buttons {"align":"center"} --&gt;
							&lt;div class="wp-block-buttons aligncenter"&gt;&lt;!-- wp:button {"className":"is-style-inclusive-large-button"} --&gt;
							&lt;div class="wp-block-button is-style-inclusive-large-button">&lt;a href="#" class="wp-block-button__link"&gt;<?php echo _x( 'Sign up for our Newsletter', 'Theme starter content', 'inclusive' ); ?>&lt;/a&gt;&lt;/div&gt;
							&lt;!-- /wp:button --&gt;&lt;/div&gt;
							&lt;!-- /wp:buttons --&gt;&lt;/div&gt;&lt;/div&gt;
							&lt;!-- /wp:cover --&gt;
						</code>
					</div>
					<br><a class="button button-primary inclusive-copy" data-clipboard-target="#inclusive-cover-preview"><?php esc_html_e( 'Copy', 'inclusive' ); ?></a>
					<div class="success" aria-hidden="true"><?php esc_html_e( 'Copied!', 'inclusive' ); ?></div>
				</li>
				<li>
					<h3><?php esc_html_e( 'Event list', 'inclusive' ); ?></h3><br>
					<img src="<?php echo esc_url( get_theme_file_uri( '/assets/images/eventlist-preview.png' ) ); ?>" alt="<?php esc_attr_e( 'A preview of an event list with descriptions, date, live stream buttons, and separators between each event.', 'inclusive' ); ?>" width="400"><br>
					<?php esc_html_e( 'Code:', 'inclusive' ); ?>
					<br>
					<div id="inclusive-eventlist-preview">
						<code>
							&lt;!-- wp:group --&gt;
							&lt;div class="wp-block-group"&gt;&lt;div class="wp-block-group__inner-container"&gt;&lt;!-- wp:columns {"verticalAlignment":"top","align":"full"} --&gt;
							&lt;div class="wp-block-columns alignfull are-vertically-aligned-top"&gt;&lt;!-- wp:column {"verticalAlignment":"top","width":70} --&gt;
							&lt;div class="wp-block-column is-vertically-aligned-top" style="flex-basis:70%"&gt;&lt;!-- wp:paragraph --&gt;
							&lt;p&gt;&lt;strong&gt;<?php echo _x( 'June 4', 'Block pattern content', 'inclusive' ); ?>&lt;/strong&gt; <?php echo _x( 'WordCamp Europe Online', 'Block pattern content', 'inclusive' ); ?>&lt;/p&gt;&lt;!-- /wp:paragraph --&gt;&lt;/div&gt;
							&lt;!-- /wp:column --&gt;
							&lt;!-- wp:column {"verticalAlignment":"top"} --&gt;
							&lt;div class="wp-block-column is-vertically-aligned-top"&gt;&lt;!-- wp:button --&gt;
							&lt;div class="wp-block-button"&gt;&lt;a class="wp-block-button__link" href="#"&gt;<?php echo _x( 'View Live Stream', 'Block pattern content', 'inclusive' ); ?>&lt;/a&gt;&lt;/div&gt;
							&lt;!-- /wp:button --&gt;&lt;/div&gt;
							&lt;!-- /wp:column --&gt;&lt;/div&gt;
							&lt;!-- /wp:columns --&gt;
							&lt;!-- wp:separator {"className":"is-style-wide"} --&gt;
							&lt;hr class="wp-block-separator is-style-wide"/&gt;
							&lt;!-- /wp:separator --&gt;&lt;/div&gt;&lt;/div&gt;
							&lt;!-- /wp:group --&gt;

							&lt;!-- wp:group --&gt;
							&lt;div class="wp-block-group"&gt;&lt;div class="wp-block-group__inner-container"&gt;&lt;!-- wp:columns {"verticalAlignment":"top","align":"full"} --&gt;
							&lt;div class="wp-block-columns alignfull are-vertically-aligned-top"&gt;&lt;!-- wp:column {"verticalAlignment":"top","width":70} --&gt;
							&lt;div class="wp-block-column is-vertically-aligned-top" style="flex-basis:70%"&gt;&lt;!-- wp:paragraph --&gt;
							&lt;p&gt;&lt;strong&gt;<?php echo _x( 'June 5', 'Block pattern content', 'inclusive' ); ?>&lt;/strong&gt; <?php echo _x( 'WordCamp Europe Online', 'Block pattern content', 'inclusive' ); ?>&lt;/p&gt;&lt;!-- /wp:paragraph --&gt;&lt;/div&gt;
							&lt;!-- /wp:column --&gt;
							&lt;!-- wp:column {"verticalAlignment":"top"} --&gt;
							&lt;div class="wp-block-column is-vertically-aligned-top"&gt;&lt;!-- wp:button --&gt;
							&lt;div class="wp-block-button"&gt;&lt;a class="wp-block-button__link" href="#"&gt;<?php echo _x( 'View Live Stream', 'Block pattern content', 'inclusive' ); ?>&lt;/a&gt;&lt;/div&gt;
							&lt;!-- /wp:button --&gt;&lt;/div&gt;
							&lt;!-- /wp:column --&gt;&lt;/div&gt;
							&lt;!-- /wp:columns --&gt;
							&lt;!-- wp:separator {"className":"is-style-wide"} --&gt;
							&lt;hr class="wp-block-separator is-style-wide"/&gt;
							&lt;!-- /wp:separator --&gt;&lt;/div&gt;&lt;/div&gt;
							&lt;!-- /wp:group --&gt;

							&lt;!-- wp:group --&gt;
							&lt;div class="wp-block-group"&gt;&lt;div class="wp-block-group__inner-container"&gt;&lt;!-- wp:columns {"verticalAlignment":"top","align":"full"} --&gt;
							&lt;div class="wp-block-columns alignfull are-vertically-aligned-top"&gt;&lt;!-- wp:column {"verticalAlignment":"top","width":70} --&gt;
							&lt;div class="wp-block-column is-vertically-aligned-top" style="flex-basis:70%"&gt;&lt;!-- wp:paragraph --&gt;
							&lt;p&gt;&lt;strong&gt;<?php echo _x( 'June 6', 'Block pattern content', 'inclusive' ); ?>&lt;/strong&gt; <?php echo _x( 'WordCamp Europe Online', 'Block pattern content', 'inclusive' ); ?>&lt;/p&gt;&lt;!-- /wp:paragraph --&gt;&lt;/div&gt;
							&lt;!-- /wp:column --&gt;
							&lt;!-- wp:column {"verticalAlignment":"top"} --&gt;
							&lt;div class="wp-block-column is-vertically-aligned-top"&gt;&lt;!-- wp:button --&gt;
							&lt;div class="wp-block-button"&gt;&lt;a class="wp-block-button__link" href="#"&gt;<?php echo _x( 'View Live Stream', 'Block pattern content', 'inclusive' ); ?>&lt;/a&gt;&lt;/div&gt;
							&lt;!-- /wp:button --&gt;&lt;/div&gt;
							&lt;!-- /wp:column --&gt;&lt;/div&gt;
							&lt;!-- /wp:columns --&gt;
							&lt;!-- wp:separator {"className":"is-style-wide"} --&gt;
							&lt;hr class="wp-block-separator is-style-wide"/&gt;
							&lt;!-- /wp:separator --&gt;&lt;/div&gt;&lt;/div&gt;
							&lt;!-- /wp:group --&gt;
						</code>
					</div>
					<br><a class="button button-primary inclusive-copy" data-clipboard-target="#inclusive-eventlist-preview"><?php esc_html_e( 'Copy', 'inclusive' ); ?></a>
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
				<li><?php esc_html_e( 'Paragraph: Rounced corners (Requires a background color to be visible)', 'inclusive' ); ?> <code>.is-style-inclusive-rounded-corner-paragraph</code></li>
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
						esc_html_e( 'If you would like to add an online store, please install and activate WooCommerce.', 'inclusive' ); ?>
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
