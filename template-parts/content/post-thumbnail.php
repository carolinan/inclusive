<?php
/**
 * Template part for displaying a featured image.
 *
 * @package Inclusive
 * @since 1.0.0
 */

if ( post_password_required() || ! has_post_thumbnail() ) {
	return;
}

if ( is_singular( get_post_type() ) ) {
	?>
	<div class="post-thumbnail">
		<?php the_post_thumbnail( 'post-thumbnail' ); ?>
	</div><!-- .post-thumbnail -->
	<?php
} else {
	// Add a link to the post or page.
	?>
	<figure aria-hidden="true">
		<a class="post-thumbnail" href="<?php the_permalink(); ?>" tabindex="-1"><?php the_post_thumbnail( 'thumbnail' ); ?></a>
	</figure><!-- .post-thumbnail -->
	<?php
}
