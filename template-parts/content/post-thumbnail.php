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
	// Add a link to the post or page. The alt here is the link text, so it describes the target, not the image.
	?>
	<div class="post-thumbnail">
		<a href="<?php the_permalink(); ?>">
		<?php
		the_post_thumbnail(
			'medium',
			[
				'alt' => the_title_attribute(
					[
						'echo' => false,
					]
				),
			]
		);
		?>
		</a>
	</div><!-- .post-thumbnail -->
	<?php
}
