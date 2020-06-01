<?php
/**
 * Template part for displaying the header navigation menu
 *
 * @package Inclusive
 * @since 1.0.0
 */

?>
<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Main menu', 'inclusive' ); ?>">
	<div class="menu-extras">
		<?php
		if ( get_theme_mod( 'menu_logo', false ) === true && has_custom_logo() ) {
			$inclusive_logo = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ) );
			// Note: Home is used as a link text here, not as a way to describe the image.
			echo '<a href="' , esc_url( home_url( '/' ) ) , '" class="menu-custom-logo-link" rel="home"><img src="' , esc_url( $inclusive_logo[0] ) , '" width="40px" alt="' , esc_attr_e( 'Home', 'inclusive' ) , '" class="custom-logo"></a>';
		}

		if ( display_header_text() ) {
			if ( get_theme_mod( 'show_header_title', false ) === false && is_front_page() || get_theme_mod( 'show_header_title', false ) === false && is_home() ) {
				echo '<h1 class="menu-title"><a href="' , esc_url( home_url( '/' ) ) , '" rel="home">' , wp_kses_post( get_bloginfo( 'name' ) ) , '</a></h1>';
			} else {
				echo '<div class="menu-title"><a href="' , esc_url( home_url( '/' ) ) , '" rel="home">' , wp_kses_post( get_bloginfo( 'name' ) ) , '</a></div>';
			}
		} elseif ( get_theme_mod( 'show_header_title', false ) === false && is_front_page() || get_theme_mod( 'show_header_title', false ) === false && is_home() ) {
			echo '<h1 class="menu-title screen-reader-text"><a href="' , esc_url( home_url( '/' ) ) , '" rel="home">' , wp_kses_post( get_bloginfo( 'name' ) ) , '</a></h1>';
		}
		?>

		<button class="menu-toggle" aria-label="<?php esc_attr_e( 'Open menu', 'inclusive' ); ?>" onClick="InclusiveToggleButtonClick('toggle-primary')" data-uid="toggle-primary" aria-controls="primary-menu" aria-expanded="false">
		<?php
		if ( Inclusive\Icons::nav_menu_button_icon() ) {
			echo Inclusive\Icons::nav_menu_button_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
		esc_html_e( 'Menu', 'inclusive' );
		?>
		</button>
	</div>

	<div class="primary-menu-container">
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'menu-1',
				'menu_id'        => 'primary-menu',
				'container'      => 'ul',
				'menu_class'     => 'primary-menu',
			)
		);
		?>
	</div>

	<?php
	if ( get_theme_mod( 'menu_search', true ) === true ) {
		?>
		<details class="desktop-search">
			<summary><span class="screen-reader-text"><?php esc_html_e( 'Toggle search', 'inclusive' ); ?></span><?php echo Inclusive\Icons::search_button_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></summary> 
			<?php get_search_form(); ?>
		</details>
		<?php
		echo '<div class="mobile-search">' , get_search_form( false ) , '</div>';
	}
	?>
</nav><!-- #site-navigation -->
