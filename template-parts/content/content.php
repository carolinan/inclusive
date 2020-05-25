<?php
/**
 * Template part for displaying a post
 *
 * @package Inclusive
 * @since 1.0.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>
	<?php
	get_template_part( 'template-parts/content/entry-header', get_post_type() );

	if ( is_search() || is_home() || is_archive() && ! is_post_type_archive( 'forum' ) ) {

		if ( get_theme_mod( 'blog_layout', 'one-column' ) === 'two-columns' ) {

			Inclusive\Styles::get_template_part( 'content', 'excerpt', 'assets/css/min/layout-two-columns.min.css' );

		} elseif ( get_theme_mod( 'blog_layout', 'one-column' ) === 'one-column' ) {

			get_template_part( 'template-parts/content/excerpt' );

		} else {

			get_template_part( 'template-parts/content/the-content' );

		}
	} else {
		get_template_part( 'template-parts/content/the-content' );

	}

	get_template_part( 'template-parts/content/footer', get_post_type() );

	?>
</article><!-- #post-<?php the_ID(); ?> -->

<?php
if ( is_singular( get_post_type() ) ) {

	get_template_part( 'template-parts/content/post-navigation' );

	/**
	* Show comments only when the post type supports it
	* and when comments are open or at least one comment exists.
	*/
	if ( post_type_supports( get_post_type(), 'comments' ) && ( comments_open() || get_comments_number() ) ) {
		comments_template();
	}

	Inclusive\Related_Posts::related_posts( get_the_ID() );

}
