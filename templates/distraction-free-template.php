<?php
/**
 * Template Name: Distraction Free Template
 * Template Post Type: post, page
 *
 * @link https://developer.wordpress.org/themes/template-files-section/page-template-files/#creating-page-templates-for-specific-post-types
 *
 * @package Inclusive
 * @since 1.0.0
 */

?>
<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php
wp_body_open();

Inclusive\Styles::get_template_part( 'distraction-free', 'css', 'assets/css/min/distraction-free.min.css' );

?>
<div id="page" class="site">
	<main id="primary" class="site-main" role="main">
		<?php
		while ( have_posts() ) {
			the_post();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>
				<?php
				get_template_part( 'template-parts/content/entry-header' );
				get_template_part( 'template-parts/content/the-content' );
				?>
			</article>
			<?php
			if ( get_theme_mod( 'author_information_distraction_free', false ) === true ) {
				Inclusive\Biography::author_biography();
			}
		}
		?>
	</main><!-- #primary -->
<?php wp_footer(); ?>

</body>
</html>
