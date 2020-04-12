<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Inclusive
 * @since 1.0.0
 */

get_header();

?>
	<main id="primary" class="site-main" role="main">
		<header class="page-header">
			<h1 class="page-title"><?php esc_html_e( '404: Not Found', 'inclusive' ); ?></h1>
		</header>
		<div class="entry-content">
			<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'inclusive' ); ?></p>
			<?php get_search_form(); ?>
		</div>
	</main><!-- #primary -->
<?php
get_footer();
