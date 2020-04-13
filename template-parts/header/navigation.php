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
			$image = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ) );
			echo '<a href="' . esc_url( home_url( '/' ) ) . '" class="menu-custom-logo-link" rel="home"><img src="' . esc_url( $image[0] ) . '" width="40px" alt="" class="custom-logo"></a>';
		}

		if ( display_header_text() ) {
			echo '<div class="menu-title">';
			echo '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home">' . get_bloginfo( 'name' ) . '</a>';
			echo '</div>';
		}
		?>

		<button class="menu-toggle" aria-label="<?php esc_attr_e( 'Open menu', 'inclusive' ); ?>" 
		onClick="ToggleButtonClick('toggle-primary')" data-uid="toggle-primary" aria-controls="primary-menu" aria-expanded="false">
		<?php
		if ( Inclusive\Icons::nav_menu_button_icon() ) {
			echo Inclusive\Icons::nav_menu_button_icon();
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
	if ( get_theme_mod( 'menu_search', false ) === true ) {
		echo '<div class="topsearch">' . get_search_form( false ) . '</div>';
	}
	?>
</nav><!-- #site-navigation -->
