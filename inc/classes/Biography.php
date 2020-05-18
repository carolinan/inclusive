<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Inclusive Author biography section
 *
 * @package Inclusive
 * @since 1.0.0
 */

namespace Inclusive;

use WP_Customize_Manager;
use Inclusive\Customizer;

/**
 * Author Biography
 *
 * @since 1.0.0
 */
class Biography {

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		add_action( 'customize_register', [ $this, 'action_register_customizer_control' ] );
		add_action( 'wp_footer', [ $this, 'action_custom_css' ] );
	}

	/**
	 * Adds a Customizer setting and control
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer manager instance.
	 * @since 1.0.0
	 * @access public
	 */
	public function action_register_customizer_control( WP_Customize_Manager $wp_customize ) {

		$wp_customize->add_section(
			'about_options',
			array(
				'title' => __( 'Author Biography options', 'inclusive' ),
				'panel' => 'theme_options',
			)
		);

		$wp_customize->add_setting(
			'author_information',
			array(
				'default'           => false,
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'author_information',
			array(
				'type'        => 'checkbox',
				'label'       => __( 'Enable the author biography on posts.', 'inclusive' ),
				'description' => __( 'Show the authors biography and links below posts. The content is generated from the users settings.', 'inclusive' ),
				'section'     => 'about_options',
			)
		);

		$wp_customize->selective_refresh->add_partial(
			'author_information',
			array(
				'selector'        => '.type-post .author-info',
				'render_callback' => 'author_information',
			)
		);

		$wp_customize->add_setting(
			'page_author_information',
			array(
				'default'           => false,
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'page_author_information',
			array(
				'type'        => 'checkbox',
				'label'       => __( 'Enable the author biography on pages.', 'inclusive' ),
				'description' => __( 'Show the authors biography and links below pages. The content is generated from the users settings. This can be useful if your website has more than one contributor.', 'inclusive' ),
				'section'     => 'about_options',
			)
		);

		$wp_customize->selective_refresh->add_partial(
			'page_author_information',
			array(
				'selector'        => '.type-page .author-info',
				'render_callback' => 'author_information',
			)
		);

		$wp_customize->add_setting(
			'author_information_distraction_free',
			array(
				'default'           => false,
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'author_information_distraction_free',
			array(
				'type'    => 'checkbox',
				'label'   => __( 'Enable the extended author information when using the distraction free template.', 'inclusive' ),
				'section' => 'about_options',
			)
		);

		$wp_customize->add_setting(
			'author_website',
			array(
				'default'           => true,
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'author_website',
			array(
				'type'        => 'checkbox',
				'label'       => __( 'Display the authors website link.', 'inclusive' ),
				'description' => __( '(Useful for guest authors.)', 'inclusive' ),
				'section'     => 'about_options',
			)
		);

		$wp_customize->add_setting(
			'author_bio',
			array(
				'default'           => true,
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'author_bio',
			array(
				'type'        => 'checkbox',
				'label'       => __( 'Display the authors biography.', 'inclusive' ),
				'description' => __( 'The biography must first be added to the users settings.', 'inclusive' ),
				'section'     => 'about_options',
			)
		);

		$wp_customize->add_setting(
			'gravatar_style',
			array(
				'default'           => 'circle',
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_select',
			)
		);

		$wp_customize->add_control(
			'gravatar_style',
			array(
				'label'       => __( 'Author Gravatar', 'inclusive' ),
				'description' => __( 'Select a style for the gravatar. ', 'inclusive' ),
				'section'     => 'about_options',
				'type'        => 'radio',
				'choices'     =>
				[
					'circle' => __( 'Circle (Default)', 'inclusive' ),
					'square' => __( 'Square', 'inclusive' ),
					'hide'   => __( 'Hide Gravatar', 'inclusive' ),
				],
			)
		);
	}

	/**
	 * Output the author bography
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public static function author_biography() {
		Styles::get_template_part( 'content', 'biography', 'assets/css/min/biography.min.css' );

		echo '<div class="author-info">';
		if ( get_theme_mod( 'gravatar_style', 'circle' ) !== 'hide' ) {
			echo '<a href="' , esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) , '">', get_avatar( get_the_author_meta( 'ID' ), '90' ) , '</a>';
		}

		echo '<h2 class="entry-title">' , the_author_posts_link() , '</h2>';

		echo '<div class="author-description">';
		if ( get_theme_mod( 'author_bio', true ) === true ) {
			echo wp_kses_post( the_author_meta( 'user_description' ) );
		}

		if ( get_theme_mod( 'author_website', true ) === true && get_the_author_meta( 'user_url' ) ) {
			echo '<p><a href="' , esc_url( get_the_author_meta( 'user_url' ) ) , '">' , esc_html__( 'Visit the authors website', 'inclusive' ) , '</a></p>';
		}
		echo '</div></div>';
	}

	/**
	 * Change the style of the gravatar depending on the setting.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public static function action_custom_css() {
		if ( get_theme_mod( 'gravatar_style', 'circle' ) === 'square' ) {
			echo '<style id="inclusive-gravatar-shape">';
			echo '.author-info .avatar { border-radius: 0 !important; }';
			echo '</style>';
		}
	}

}

