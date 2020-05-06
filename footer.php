<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Inclusive
 * @since 1.0.0
 */

Inclusive\Styles::get_template_part( 'footer', 'css', 'assets/css/min/footer.min.css' );
?>
	<footer class="site-footer" role="contentinfo">

		<?php
		get_template_part( 'template-parts/content/footer-block-area' );
		get_sidebar();
		?>
		<div class="site-info">
			<?php
			if ( has_nav_menu( 'social' ) ) {
				Inclusive\Styles::get_template_part( 'content', 'social-menu', 'assets/css/min/social-menu.min.css' );
			}

			Inclusive\Copyright::copyright();

			Inclusive\Privacy_Policy_Link::privacy_policy();

			Inclusive\Go_To_Top::go_to_top();
			?>
		</div><!-- .site-info -->
	</footer>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
