<?php
/**
 * The template for displaying the forum archive for BBPress.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Inclusive
 * @since 1.0.4
 */

get_header();
?>
	<main id="primary" class="site-main" role="main">
		<?php
		if ( have_posts() ) {

			while ( have_posts() ) {
				the_post();

				get_template_part( 'template-parts/content/forum' );
			}
		} else {

			get_template_part( 'template-parts/content/none' );

		}
		?>
	</main><!-- #primary -->
<?php
get_footer();
