<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Inclusive Blog and Archive options
 *
 * @package Inclusive
 * @since 1.0.0
 */

namespace Inclusive;

use WP_Customize_Manager;

/**
 * Options for the blog, search and archive pages.
 *
 * @since 1.0.0
 */
class Blog_Options {

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		add_action( 'customize_register', [ $this, 'action_register_customizer_control' ] );
		add_filter( 'excerpt_length', [ $this, 'filter_excerpt_length' ], 999 );
		add_filter( 'excerpt_more', [ $this, 'filter_excerpt_more' ], 999 );
		add_filter( 'the_title', [ $this, 'filter_post_title' ], 999 );
		add_filter( 'the_content_more_link', [ $this, 'filter_read_more_tag' ] );
	}

	/**
	 * Adds a Customizer section, settings, controls and partials.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer manager instance.
	 * @access public
	 * @since 1.0.0
	 */
	public function action_register_customizer_control( WP_Customize_Manager $wp_customize ) {

		$wp_customize->add_section(
			'blog_options',
			array(
				'title'    => __( 'Blog & Archive Options', 'inclusive' ),
				'panel'    => 'theme_options',
				'priority' => 3,
			)
		);

		$wp_customize->add_setting(
			'excerpt_length',
			array(
				'default'           => '45',
				'transport'         => 'postMessage',
				'sanitize_callback' => 'absint',
			)
		);

		$wp_customize->add_control(
			'excerpt_length',
			array(
				'label'       => __( 'Excerpt length', 'inclusive' ),
				'description' => __( 'Adjust the number of words used in the generated excerpt. ', 'inclusive' ),
				'section'     => 'blog_options',
				'type'        => 'number',
			)
		);

		$wp_customize->selective_refresh->add_partial(
			'excerpt_length',
			array(
				'selector'            => '.entry-summary',
				'container_inclusive' => true,
			)
		);

		$wp_customize->add_setting(
			'archive_show_author',
			array(
				'default'           => true,
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'archive_show_author',
			array(
				'type'        => 'checkbox',
				'label'       => __( 'Show "Written by [author name]".', 'inclusive' ),
				'description' => __( 'Show or hide the author name below the title. ', 'inclusive' ),
				'section'     => 'blog_options',
			)
		);

		$wp_customize->selective_refresh->add_partial(
			'archive_show_author',
			array(
				'selector' => '.type-post .posted-by',
			)
		);

		$wp_customize->add_setting(
			'archive_show_date',
			array(
				'default'           => true,
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'archive_show_date',
			array(
				'type'        => 'checkbox',
				'label'       => __( 'Show publishing date.', 'inclusive' ),
				'description' => __( 'Show or hide the publishing date. ', 'inclusive' ),
				'section'     => 'blog_options',
			)
		);

		$wp_customize->add_setting(
			'archive_show_categories',
			array(
				'default'           => true,
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'archive_show_categories',
			array(
				'type'        => 'checkbox',
				'label'       => __( 'Show categories.', 'inclusive' ),
				'description' => __( 'Show or hide the categories. ', 'inclusive' ),
				'section'     => 'blog_options',
			)
		);

		$wp_customize->add_setting(
			'archive_show_tags',
			array(
				'default'           => false,
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'archive_show_tags',
			array(
				'type'        => 'checkbox',
				'label'       => __( 'Show tags.', 'inclusive' ),
				'description' => __( 'Show or hide the tags. ', 'inclusive' ),
				'section'     => 'blog_options',
			)
		);

		$wp_customize->add_setting(
			'archive_show_comment_count',
			array(
				'default'           => false,
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'archive_show_comment_count',
			array(
				'type'        => 'checkbox',
				'label'       => __( 'Show comment count.', 'inclusive' ),
				'description' => __( 'Show or hide the comment count, if comments are enabled. ', 'inclusive' ),
				'section'     => 'blog_options',
			)
		);

		$wp_customize->add_setting(
			'archive_show_continue_reading',
			array(
				'default'           => true,
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'archive_show_continue_reading',
			array(
				'type'    => 'checkbox',
				'label'   => __( 'Show continue reading text.', 'inclusive' ),
				'section' => 'blog_options',
			)
		);
	}

	/**
	 * Add the excerpt length filter
	 *
	 * @access public
	 * @since 1.0.0
	 * @return int The length of the excerpt.
	 */
	public function filter_excerpt_length() {
		if ( ! is_admin() ) {
			$excerpt_length = absint( get_theme_mod( 'excerpt_length', 45 ) );
			return $excerpt_length;
		}
	}

	/**
	 * Show or hide continue reading on archives.
	 *
	 * @param string $more Link to single post/page.
	 * @return string 'Continue reading' link.
	 * @access public
	 * @since 1.0.0
	 */
	public function filter_excerpt_more( $more ) {
		if ( is_admin() ) {
			return $more;
		}

		if ( get_theme_mod( 'archive_show_continue_reading', true ) === true ) {
			$more = sprintf(
				// translators: %1$s: Link to current post. %3$s: Name of current post. Only visible to screen readers.
				'&hellip; <br><a class="more-link" href="%1$s">%2$s<span class="screen-reader-text">%3$s</span></a>',
				esc_url( get_permalink( get_the_ID() ) ),
				__( 'Continue reading ', 'inclusive' ),
				get_the_title( get_the_ID() )
			);
			return $more;
		} else {
			return '&hellip;';
		}

	}

	/**
	 * Add a title to posts that are missing titles.
	 *
	 * @since 1.0.0
	 * @access public
	 * @param string $title The post title.
	 * @return string The replacement post title.
	 */
	public function filter_post_title( $title ) {
		if ( '' === $title ) {
			return __( '(Untitled)', 'inclusive' );
		} else {
			return $title;
		}
	}

	/**
	 * Add a wrapper to the read more, so that we can position it correctly.
	 *
	 * @param string $html The default output HTML for the more tag.
	 *
	 * @return string $html
	 */
	public function filter_read_more_tag( $html ) {
		$html = '<div class="read-more-wrap">' . $html . '</div>';
		return $html;
	}

}
