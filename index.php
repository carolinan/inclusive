<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Inclusive
 * @since 1.0.0
 */

get_header();
?>
	<main id="primary" class="site-main" role="main">
		<?php
		if ( have_posts() ) {

			get_template_part( 'template-parts/content/page-header' );

			while ( have_posts() ) {
				the_post();
				get_template_part( 'template-parts/content/content', get_post_type() );
			}

			if ( ! is_singular() ) {
				Inclusive\Styles::get_template_part( 'content', 'pagination', 'assets/css/min/navigation.min.css' );
			}
		} else {
			get_template_part( 'template-parts/content/none' );
		}
		?>
	</main><!-- #primary -->

<?php
get_footer();
