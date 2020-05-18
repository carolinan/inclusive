<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Related Posts
 *
 * @package Inclusive
 * @since 1.0.0
 */

namespace Inclusive;

use WP_Customize_Manager;
use WP_Query;

/**
 * Related Posts
 *
 * @since 1.0.0
 */
class Related_Posts {

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		add_action( 'customize_register', [ $this, 'action_register_customizer_control' ] );
		add_action( 'related_posts', [ $this, 'related_posts' ], 10, 1 );
	}

	/**
	 * Adds a Customizer setting and control.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer manager instance.
	 * @since 1.0.0
	 */
	public function action_register_customizer_control( WP_Customize_Manager $wp_customize ) {

		$wp_customize->add_section(
			'related_posts_options',
			array(
				'title' => __( 'Related Posts', 'inclusive' ),
				'panel' => 'theme_options',
			)
		);

		$wp_customize->add_setting(
			'show_related_posts',
			array(
				'default'           => true,
				'transport'         => 'postMessage',
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'show_related_posts',
			array(
				'type'        => 'checkbox',
				'label'       => __( 'Related Posts', 'inclusive' ),
				'description' => __( 'Enable Related Posts below the post content.', 'inclusive' ),
				'section'     => 'related_posts_options',
			)
		);

		$wp_customize->selective_refresh->add_partial(
			'show_related_posts',
			array(
				'selector'            => '.related-posts',
				'container_inclusive' => true,
			)
		);

		$wp_customize->add_setting(
			'related_section_heading',
			array(
				'default'           => __( 'Related Posts', 'inclusive' ),
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'related_section_heading',
			array(
				'type'        => 'text',
				'label'       => __( 'Related Posts Section Heading', 'inclusive' ),
				'description' => __( 'Add a custom heading for the related posts section', 'inclusive' ),
				'section'     => 'related_posts_options',
			)
		);

		$wp_customize->add_setting(
			'number_of_related_posts',
			array(
				'default'           => 3,
				'transport'         => 'postMessage',
				'sanitize_callback' => 'absint',
			)
		);

		$wp_customize->add_control(
			'number_of_related_posts',
			array(
				'type'    => 'number',
				'label'   => __( 'Number of Related Posts', 'inclusive' ),
				'section' => 'related_posts_options',
			)
		);

		$wp_customize->selective_refresh->add_partial(
			'number_of_related_posts',
			array(
				'selector' => '.single .related-posts-entries',
			)
		);

		$wp_customize->add_setting(
			'show_related_posts_image',
			array(
				'default'           => true,
				'transport'         => 'postMessage',
				'sanitize_callback' => 'Inclusive\Customizer::sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'show_related_posts_image',
			array(
				'type'        => 'checkbox',
				'label'       => __( 'Related Posts Featured Images', 'inclusive' ),
				'description' => __( 'Show featured images below the post title.', 'inclusive' ),
				'section'     => 'related_posts_options',
			)
		);

		$wp_customize->selective_refresh->add_partial(
			'show_related_posts_image',
			array(
				'selector' => '.related-posts-entries .related-posts-image ',
			)
		);

	}
	/**
	 * Output related posts.
	 *
	 * @param int $post_id The ID of the current post.
	 * @since 1.0.0
	 * @return void
	 */
	public static function related_posts( $post_id ) {
		if ( get_theme_mod( 'show_related_posts', true ) === true ) {
			$categories = get_the_category( $post_id );
			if ( $categories ) {
				$category_ids = [];
				$category     = get_category( $category_ids );
				$categories   = get_the_category( $post_id );

				foreach ( $categories as $category ) {
					$category_ids[] = $category->term_id;
				}
				$count = $category->category_count;
				if ( $count > 1 ) {

					Styles::get_template_part( 'related-posts', 'css', 'assets/css/min/related-posts.min.css' );

					?>
					<div class="related-posts">
					<h2><?php echo esc_html( get_theme_mod( 'related_section_heading', __( 'Related Posts', 'inclusive' ) ) ); ?></h2>
					<?php
					$cat_post_args                 = [
						'category__in'        => $category_ids,
						'post__not_in'        => [ $post_id ],
						'post_type'           => 'post',
						'posts_per_page'      => get_theme_mod( 'number_of_related_posts', 3 ),
						'post_status'         => 'publish',
						'ignore_sticky_posts' => true,
					];
					$inclusive_related_posts_query = new WP_Query( $cat_post_args );

					while ( $inclusive_related_posts_query->have_posts() ) {
						echo '<div class="related-posts-entries">';
						$inclusive_related_posts_query->the_post();
						?>
						<h3 class="related-posts-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<?php
						if ( has_post_thumbnail() && get_theme_mod( 'show_related_posts_image', true ) && ! post_password_required() ) {
							// Add a link to the post or page. The alt here is the link text, so it describes the target, not the image.
							?>
							<a href="<?php the_permalink(); ?>" class="related-posts-image post-thumbnail">
							<?php
							the_post_thumbnail(
								'thumbnail',
								[
									'alt' => the_title_attribute(
										[
											'echo' => false,
										]
									),
								]
							);
							?>
							</a>
							<?php
						}
						?>
						</div><!-- .related-post entries -->
						<?php
					} //End While.
					wp_reset_postdata();
					?>
					</div> <!-- .related-posts -->
					<?php
				}
			}
		}
	}

}
