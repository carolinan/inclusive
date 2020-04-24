<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Social Sharing
 *
 * @package Inclusive
 * @since 1.0.0
 */

namespace Inclusive;

use WP_Customize_Manager;

/**
 * Social Sharing
 *
 * @since 1.0.0
 */
class Social_Sharing {

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		add_action( 'customize_register', [ $this, 'action_register_customizer_control' ] );
	}

	/**
	 * Adds a Customizer setting and control.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer manager instance.
	 * @since 1.0.0
	 * @access public
	 */
	public function action_register_customizer_control( WP_Customize_Manager $wp_customize ) {

		$wp_customize->add_section(
			'social_options',
			array(
				'title' => __( 'Social Sharing', 'inclusive' ),
				'panel' => 'theme_options',
			)
		);

		$wp_customize->add_setting(
			'sharing_posts',
			array(
				'default'           => true,
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'sharing_posts',
			array(
				'label'       => __( 'Show Social Sharing below posts', 'inclusive' ),
				'description' => __( 'Enable the sharing section below posts.', 'inclusive' ),
				'section'     => 'social_options',
				'type'        => 'checkbox',
			)
		);

		$wp_customize->selective_refresh->add_partial(
			'sharing_posts',
			array(
				'selector'        => '.type-post .social-sharing',
				'render_callback' => 'social_sharing',
			)
		);

		$wp_customize->add_setting(
			'sharing_pages',
			array(
				'default'           => false,
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_checkbox',
			)
		);

		$wp_customize->selective_refresh->add_partial(
			'sharing_pages',
			array(
				'selector'        => '.type-page .social-sharing',
				'render_callback' => 'social_sharing',
			)
		);

		$wp_customize->add_control(
			'sharing_pages',
			array(
				'label'       => __( 'Show Social Sharing below pages', 'inclusive' ),
				'description' => __( 'Enable the sharing section below pages.', 'inclusive' ),
				'section'     => 'social_options',
				'type'        => 'checkbox',
			)
		);

		$wp_customize->add_setting(
			'sharing_facebook',
			array(
				'default'           => true,
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'sharing_facebook',
			array(
				'label'       => __( 'Facebook Social Sharing', 'inclusive' ),
				'description' => __( 'Enable a Facebook sharing link.', 'inclusive' ),
				'section'     => 'social_options',
				'type'        => 'checkbox',
			)
		);

		$wp_customize->add_setting(
			'sharing_twitter',
			array(
				'default'           => true,
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'sharing_twitter',
			array(
				'label'       => __( 'Twitter Social Sharing', 'inclusive' ),
				'description' => __( 'Enable a Twitter sharing link.', 'inclusive' ),
				'section'     => 'social_options',
				'type'        => 'checkbox',
			)
		);

		$wp_customize->add_setting(
			'sharing_linkedin',
			array(
				'default'           => true,
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'sharing_linkedin',
			array(
				'label'       => __( 'LinkedIn Social Sharing', 'inclusive' ),
				'description' => __( 'Enable a LinkedIn sharing link.', 'inclusive' ),
				'section'     => 'social_options',
				'type'        => 'checkbox',
			)
		);

		$wp_customize->add_setting(
			'sharing_reddit',
			array(
				'default'           => true,
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'sharing_reddit',
			array(
				'label'       => __( 'Reddit Social Sharing', 'inclusive' ),
				'description' => __( 'Enable a Reddit sharing link.', 'inclusive' ),
				'section'     => 'social_options',
				'type'        => 'checkbox',
			)
		);

		$wp_customize->add_setting(
			'sharing_pinterest',
			array(
				'default'           => true,
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'sharing_pinterest',
			array(
				'label'       => __( 'Pinterest Social Sharing', 'inclusive' ),
				'description' => __( 'Enable a Pinterest sharing link.', 'inclusive' ),
				'section'     => 'social_options',
				'type'        => 'checkbox',
			)
		);

		$wp_customize->add_setting(
			'sharing_mail',
			array(
				'default'           => true,
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'sharing_mail',
			array(
				'label'       => __( 'Email', 'inclusive' ),
				'description' => __( 'Enable an email sharing link.', 'inclusive' ),
				'section'     => 'social_options',
				'type'        => 'checkbox',
			)
		);

	}

	/**
	 * Output the social sharing links.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public static function social_sharing() {
		if ( is_page() && get_theme_mod( 'sharing_pages', false ) === true || is_single() && ! is_page() && get_theme_mod( 'sharing_posts', true ) === true ) {

			Styles::get_template_part( 'content', 'sharing', 'assets/css/min/sharing.min.css' );

			echo '<div class="social-sharing">';
			if ( get_theme_mod( 'sharing_facebook', true ) === true ||
				get_theme_mod( 'sharing_twitter', true ) === true ||
				get_theme_mod( 'sharing_linkedin', true ) === true ||
				get_theme_mod( 'sharing_reddit', true ) === true ||
				get_theme_mod( 'sharing_pinterest', true ) === true ||
				get_theme_mod( 'sharing_email', true ) === true
			) {
				global $post;
				?>
				<div class="sharing-inner">
				<?php
				esc_html_e( 'Share: ', 'inclusive' );

				if ( get_theme_mod( 'sharing_facebook', true ) === true ) {
					?>
					<a href="<?php echo esc_url( 'https://www.facebook.com/sharer/sharer.php?u?' . get_permalink( $post->ID ) ); ?>"><span class="screen-reader-text"><?php esc_html_e( 'Facebook', 'inclusive' ); ?></span><?php echo Icons::social_sharing_icon( 'facebook.com' ); ?></a>
					<?php
				}

				if ( get_theme_mod( 'sharing_twitter', true ) === true ) {
					?>
					<a href="<?php echo esc_url( 'https://twitter.com/intent/tweet?text=' . get_the_title( $post->ID ) . '&amp;url=' . get_permalink( $post->ID ) ); ?>"><span class="screen-reader-text"><?php esc_html_e( 'Twitter', 'inclusive' ); ?></span><?php echo Icons::social_sharing_icon( 'twitter.com' ); ?></a>
					<?php
				}

				if ( get_theme_mod( 'sharing_linkedin', true ) === true ) {
					?>
					<a href="<?php echo esc_url( 'https://www.linkedin.com/shareArticle?url=' . get_permalink( $post->ID ) ); ?>"><span class="screen-reader-text"><?php esc_html_e( 'LinkedIn', 'inclusive' ); ?></span><?php echo Icons::social_sharing_icon( 'linkedin.com' ); ?></a>
					<?php
				}

				if ( get_theme_mod( 'sharing_reddit', true ) === true ) {
					?>
					<a href="<?php echo esc_url( 'https://reddit.com/submit?url=' . get_permalink( $post->ID ) ); ?>"><span class="screen-reader-text"><?php esc_html_e( 'Reddit', 'inclusive' ); ?></span><?php echo Icons::social_sharing_icon( 'reddit.com' ); ?></a>
					<?php
				}

				if ( get_theme_mod( 'sharing_pinterest', true ) === true ) {
					?>
					<a href="<?php echo esc_url( 'https://pinterest.com/pin/create/button/?url=[' . get_permalink( $post->ID ) ); ?>]"><span class="screen-reader-text"><?php esc_html_e( 'Pinterest', 'inclusive' ); ?></span><?php echo Icons::social_sharing_icon( 'pinterest.com' ); ?></a>
					<?php
				}

				if ( get_theme_mod( 'sharing_mail', true ) === true ) {
					?>
					<a href="<?php echo esc_url( 'mailto:?Subject=' . get_the_title( $post->ID ) . '&amp;Body=' . get_permalink( $post->ID ) ); ?>"><span class="screen-reader-text"><?php esc_html_e( 'Email', 'inclusive' ); ?></span><?php echo Icons::social_sharing_icon( 'mailto:' ); ?></a>
					<?php
				}
				?>
				</div>
				<?php
				echo '</div>';
			}
		}
	}

}
