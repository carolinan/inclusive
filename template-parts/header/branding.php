<?php
/**
 * Template part for displaying the header branding
 *
 * @package Inclusive
 * @since 1.0.0
 */

if ( has_custom_logo() && get_theme_mod( 'show_header_logo', true ) === true ||
	get_theme_mod( 'show_header_title', false ) === true ||
	get_theme_mod( 'show_tagline', false ) === true ) {

	$inclusive_description = get_bloginfo( 'description', 'display' );
	?>
	<div class="inner-branding">
	<?php
	if ( is_front_page() && 'page' === get_option( 'show_on_front' ) && get_theme_mod( 'page_hide_title', true ) === true ) {
		if ( has_custom_logo() && get_theme_mod( 'show_header_logo', true ) === true ) {
			the_custom_logo();
		}

		if ( get_theme_mod( 'show_header_title', false ) === true ) {
			?>
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php
		}

		if ( get_theme_mod( 'show_tagline', false ) === true && $inclusive_description ) {
			?>
			<p class="site-description">
				<?php echo $inclusive_description; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>
			</p>
			<?php
		}
	} else {
		if ( is_front_page() || is_home() ) {
			if ( has_custom_logo() && get_theme_mod( 'show_header_logo', true ) === true ) {
				the_custom_logo();
			}

			if ( get_theme_mod( 'show_header_title', false ) === true ) {
				?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php
			}
		} else {
			if ( has_custom_logo() && get_theme_mod( 'show_header_logo', true ) === true ) {
				the_custom_logo();
			}

			if ( get_theme_mod( 'show_header_title', false ) === true ) {
				?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php
			}
		}

		if ( get_theme_mod( 'show_tagline', false ) === true && $inclusive_description ) {
			?>
			<p class="site-description">
				<?php echo $inclusive_description; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>
			</p>
			<?php
		}
	}
	?>
	</div><!-- .inner-branding -->
	<?php
}
get_template_part( 'template-parts/header/block-area' );
?>
</div><!-- .site-branding -->
