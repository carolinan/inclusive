<?php
/**
 * Template part for displaying a forum.
 *
 * @package Inclusive
 * @since 1.0.4
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>
	<?php
	get_template_part( 'template-parts/content/entry-header-forum' );

	get_template_part( 'template-parts/content/the-content' );
	?>
</article><!-- #post-<?php the_ID(); ?> -->

