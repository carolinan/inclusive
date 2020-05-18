<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Post Options
 *
 * @package Inclusive
 * @since 1.0.0
 */

namespace Inclusive;

use WP_Customize_Manager;

/**
 * Post Options
 *
 * @since 1.0.0
 */
class Post_Options {

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		add_action( 'customize_register', [ $this, 'action_register_customizer_control' ] );
		add_filter( 'body_class', [ $this, 'filter_body_classes' ] );
	}

	/**
	 * Adds custom classes to indicate if the date for the last update is showing.
	 *
	 * @param array $classes Classes for the body element.
	 * @return array Filtered body classes.
	 */
	public function filter_body_classes( array $classes ) : array {
		if ( get_theme_mod( 'show_latest_update', false ) === true ) {
			$classes[] = 'show-latest-update';
		}

		return $classes;
	}

	/**
	 * Adds a Customizer setting and control
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer manager instance.
	 */
	public function action_register_customizer_control( WP_Customize_Manager $wp_customize ) {

		$wp_customize->add_section(
			'post_options',
			array(
				'title'    => __( 'Post options', 'inclusive' ),
				'panel'    => 'theme_options',
				'priority' => 4,
			)
		);

		$wp_customize->add_setting(
			'show_lead',
			array(
				'default'           => true,
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'show_lead',
			array(
				'type'        => 'checkbox',
				'label'       => __( 'Show the custom excerpt as a lead text.', 'inclusive' ),
				'description' => __( 'Show or hide the lead text above the content for single posts.', 'inclusive' ),
				'section'     => 'post_options',
			)
		);

		$wp_customize->add_setting(
			'show_author',
			array(
				'default'           => true,
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'show_author',
			array(
				'type'        => 'checkbox',
				'label'       => __( 'Show "Written by" and [author name]".', 'inclusive' ),
				'description' => __( 'Show or hide the text and the author name below the title. ', 'inclusive' ),
				'section'     => 'post_options',
			)
		);

		$wp_customize->selective_refresh->add_partial(
			'show_author',
			array(
				'selector' => '.type-post .posted-by',
			)
		);

		$wp_customize->add_setting(
			'show_date',
			array(
				'default'           => true,
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'show_date',
			array(
				'type'        => 'checkbox',
				'label'       => __( 'Show the publishing date.', 'inclusive' ),
				'description' => __( 'Show or hide the publishing date. ', 'inclusive' ),
				'section'     => 'post_options',
			)
		);

		$wp_customize->add_setting(
			'show_latest_update',
			array(
				'default'           => false,
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'show_latest_update',
			array(
				'type'        => 'checkbox',
				'label'       => __( 'Show the date of the latest update.', 'inclusive' ),
				'description' => __( 'Show or hide the date for the latest update. ', 'inclusive' ),
				'section'     => 'post_options',
			)
		);

		$wp_customize->add_setting(
			'show_categories',
			array(
				'default'           => true,
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'show_categories',
			array(
				'type'        => 'checkbox',
				'label'       => __( 'Show categories.', 'inclusive' ),
				'description' => __( 'Show or hide the categories. ', 'inclusive' ),
				'section'     => 'post_options',
			)
		);

		$wp_customize->selective_refresh->add_partial(
			'show_categories',
			array(
				'selector' => '.single .type-post .entry-meta',
			)
		);

		$wp_customize->add_setting(
			'show_tags',
			array(
				'default'           => false,
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'show_tags',
			array(
				'type'        => 'checkbox',
				'label'       => __( 'Show tags.', 'inclusive' ),
				'description' => __( 'Show or hide the tags. ', 'inclusive' ),
				'section'     => 'post_options',
			)
		);

		$wp_customize->add_setting(
			'show_navigation_text',
			array(
				'default'           => true,
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'show_navigation_text',
			array(
				'type'        => 'checkbox',
				'label'       => __( 'Show Navigation Text.', 'inclusive' ),
				'description' => __( 'Show or hide the "Next:" & "Previous:" text for the post navigation. ', 'inclusive' ),
				'section'     => 'post_options',
			)
		);

	}

	/**
	 * Output the lead text according to the option.
	 */
	public static function lead_text() {
		if ( has_excerpt() && get_theme_mod( 'show_lead', true ) === true ) {
			echo '<div class="lead">';
			the_excerpt();
			echo '</div>';
		}
	}

}


