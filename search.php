<?php
/**
 * Template for search results.
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
				get_template_part( 'template-parts/content/content' );
			}

			Inclusive\Styles::get_template_part( 'content', 'pagination', 'assets/css/min/navigation.min.css' );

		} else {
			get_template_part( 'template-parts/content/none' );
		}
		?>
	</main><!-- #primary -->

<?php
get_footer();
