<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Font Pairs
 *
 * @package Inclusive
 * @since 1.0.0
 */

namespace Inclusive;

use WP_Customize_Manager;
use WP_Customize_Control;

/**
 * Font Pairs
 *
 * @since 1.0.0
 */
class Font_Pairs {

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		add_action( 'customize_register', [ $this, 'action_register_customizer_control' ] );
		add_action( 'customize_preview_init', [ $this, 'action_customizer_fonts' ] );
		add_action( 'customize_controls_print_styles', [ $this, 'action_customizer_fonts' ] );
		add_action( 'customize_controls_print_styles', [ $this, 'action_font_pair_customizer_style' ] );
		add_action( 'wp_head', [ $this, 'action_custom_fonts_css' ], 12 );
	}

	/**
	 * Adds a Customizer setting and control
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer manager instance.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function action_register_customizer_control( WP_Customize_Manager $wp_customize ) {

		$wp_customize->add_section(
			'font_options',
			array(
				'title' => __( 'Font pairing', 'inclusive' ),
				'panel' => 'theme_options',
			)
		);

		$wp_customize->add_setting(
			'font_pairing',
			array(
				'default'           => 'Libre Baskerville+Roboto',
				'sanitize_callback' => function( $input, $setting ) {
					// Use sanitize_text_field instead of sanitize_key.
					$input = sanitize_text_field( $input );
					$choices = $setting->manager->get_control( $setting->id )->choices;
					return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
				},
			)
		);

		$wp_customize->add_control(
			new Font_Pairing(
				$wp_customize,
				'font_pairing',
				array(
					'label'       => __( 'Select a font pair', 'inclusive' ),
					'description' => __( 'Fonts can change the look and feel of your website.', 'inclusive' ),
					'section'     => 'font_options',
					'type'        => 'select',
					'choices'     => array(
						'Libre Baskerville+Roboto'  => '<span style="font-family:\'Libre Baskerville\'; font-size:28px;">' .
						__( 'Libre Baskerville for headings', 'inclusive' ) . '</span><br><span class="body-pair" style="font-family:Roboto; font-size:16px;">' .
						__( 'And Roboto for body text to combine elegant serif and sans-serif fonts.', 'inclusive' ) .
						'<br>' . __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'inclusive' ) . ' ' .
						__( 'Default.', 'inclusive' ) . '</span>',

						'Open Sans+Roboto'          => '<span style="font-family:Open Sans; font-size:28px;">' .
						__( 'Open Sans for headings', 'inclusive' ) . '</span><br><span class="body-pair" style="font-family:Roboto; font-size:16px;">' .
						__( 'And Roboto for body text for a clean professional look.', 'inclusive' ) .
						'<br>' . __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'inclusive' ) . '</span>',

						'Raleway+Montserrat'        => '<span style="font-family:Raleway; font-size:28px;">' .
						__( 'Raleway for headings', 'inclusive' ) . '</span><br><span class="body-pair" style="font-family:Montserrat; font-size:16px;">' .
						__( 'And Montserrat for body text for a light and spacious look.', 'inclusive' ) .
						'<br>' . __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'inclusive' ) . '</span>',

						'Merriweather+Merriweather' => '<span style="font-family:Merriweather; font-size:28px;">' .
						__( 'Merriweather for headings', 'inclusive' ) . '</span><br><span class="body-pair" style="font-family:Merriweather; font-size:16px;">' .
						__( 'As well as for body text for a classic condensed look.', 'inclusive' ) .
						'<br>' . __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'inclusive' ) . '</span>',

						'Libre Baskerville+Libre Baskerville' => '<span style="font-family:\'Libre Baskerville\'; font-size:28px;">' .
						__( 'Libre Baskerville for headings', 'inclusive' ) . '</span><br><span class="body-pair" style="font-family:Libre Baskerville; font-size:16px;">' .
						__( 'As well as for body text for a more personal feel.', 'inclusive' ) . '<br>' .
						__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'inclusive' ) . '</span>',

						'Roboto Slab+Roboto'        => '<span style="font-family:\'Roboto Slab\'; font-size:28px;">' .
						__( 'Roboto Slab for headings', 'inclusive' ) . '</span><br><span class="body-pair" style="font-family:Roboto; font-size:16px;">' .
						__( 'And Roboto for body text for matching serif slab and sans serif fonts.', 'inclusive' ) . '<br>' .
						__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'inclusive' ) . '</span>',

						'Lora+Oxygen'               => '<span style="font-family:Lora; font-size:28px;">' .
						__( 'Lora for headings', 'inclusive' ) . '</span><br><span class="body-pair" style="font-family:Oxygen; font-size:16px;">' .
						__( 'And Oxygen for body text is another stunning combination of serif slab and sans serif fonts.', 'inclusive' ) . '<br>' .
						__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'inclusive' ) . '</span>',

						'Karla+Roboto'              => '<span style="font-family:Karla; font-size:28px;">' .
						__( 'Karla for headings', 'inclusive' ) . '</span><br><span class="body-pair" style="font-family:Roboto; font-size:16px;">' .
						__( 'And Roboto for body text for a clean modern look.', 'inclusive' ) . '<br>' .
						__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'inclusive' ) . '</span>',

						'system'                    => '<span style="font-size:18px;">' .
						__( 'System fonts', 'inclusive' ) . '</span><br>' .
						'<span class="body-pair">' .
						__( 'System fonts are fonts that are already installed on your computer or device. They load faster than fonts that needs to be downloaded.', 'inclusive' ) . '<br>' .
						__( 'The selected system fonts are:', 'inclusive' ) . '<br>' .
						__( '-apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Oxygen-Sans, Ubuntu, Cantarell, Helvetica Neue, sans-serif', 'inclusive' )
						. '</span>',
					),
				)
			)
		);
	}

	/**
	 * Enqueue the list of fonts.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function action_customizer_fonts() {
		wp_enqueue_style(
			'inclusive-customizer-fonts',
			'https://fonts.googleapis.com/css?family=Karla|Libre+Baskerville|Lora|Montserrat|Merriweather|Open+Sans|Oxygen|Raleway|Roboto|Roboto+Slab',
			[],
			null
		);
	}

	/**
	 * Add styles to the font pairing control.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function action_font_pair_customizer_style() {
		?>
		<style>
		#customize-control-font-pairing .customize-inside-control-row {
			line-height: 1.6;
			margin-bottom: 1em;
		}
		</style>
		<?php
	}

	/**
	 * Overrides styles for various elements depending on the font settings.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function action_custom_fonts_css() {
		$font         = explode( '+', get_theme_mod( 'font_pairing', 'Libre Baskerville+Roboto' ) );
		$system_fonts = 'BlinkMacSystemFont, -apple-system, Helvetica, Arial, sans-serif';
		echo '<style id="inclusive-font-pairs">';
		if ( get_theme_mod( 'font_pairing', 'Libre Baskerville+Roboto' ) === 'system' ) {
			echo 'body{ --global-font-family: ' . esc_html( $system_fonts ) . ';';
			echo ' --highlight-font-family: ' . esc_html( $system_fonts ) . ';}';
		} else {
			echo 'body{ --global-font-family: ' . esc_html( $font[1] . ', ' . $system_fonts ) . ';';
			echo ' --highlight-font-family: ' . esc_html( $font[0] . ', ' . $system_fonts ) . ';}';
		}
		echo '</style>';
	}

}

if ( class_exists( 'WP_Customize_Control' ) ) {
	/**
	 * Add custom control for the font pairings.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	class Font_Pairing extends WP_Customize_Control {

		/**
		 * Render a basic control that allows html to be used so that we can preview the fonts.
		 *
		 * @since 1.0.0
		 */
		public function render_content() {
			if ( ! empty( $this->label ) ) {
				?>
				<label class="customize-control-title"><?php echo esc_html( $this->label ); ?></label>
				<?php
			}
			if ( ! empty( $this->description ) ) {
				?>
				<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<?php
			}
			foreach ( $this->choices as $value => $label ) {
				?>
				<span class="customize-inside-control-row">
					<input
						id="_customize-input-font-pair"
						type="radio"
						value="<?php echo esc_attr( $value ); ?>"
						name="font-pair"
						<?php $this->link(); ?>
						<?php checked( $this->value(), $value ); ?>
						/>
						<label data="<?php echo esc_attr( $value ); ?>" >
						<?php
						echo $label; /* Escaped later. */ // phpcs:ignore WordPress.Security.EscapeOutput
						?>
						</label>
					</span>
				<?php
			}
		}
	}
}

