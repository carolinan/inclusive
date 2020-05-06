<?php
/**
 * Template part for displaying a post's metadata
 *
 * @package Inclusive
 * @since 1.0.0
 */

$post_type_obj = get_post_type_object( get_post_type() );

$time_string = '';
$posted_on   = '';
$author_string = '';

// Show date only when the post type is 'post' or has an archive.
if ( 'post' === $post_type_obj->name || $post_type_obj->has_archive ) {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	$time_string = sprintf(
		$time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);

	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$updated_time_string = '<time class="updated" datetime="%1$s">%2$s</time>';
		$updated_time_string = sprintf(
			$updated_time_string,
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);
	}
}

// Show author only if the post type supports it.
if ( post_type_supports( $post_type_obj->name, 'author' ) ) {
	$author_string = sprintf(
		'<span class="author vcard"><a class="url fn n" href="%1$s">%2$s</a></span>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_html( get_the_author() )
	);
}

if ( ! empty( $author_string ) && is_single() && get_theme_mod( 'show_author', true ) === true
	|| ! empty( $author_string ) && ! is_single() && get_theme_mod( 'archive_show_author', true ) === true ) {
	?>
	<span class="posted-by">
		<?php
		if ( get_theme_mod( 'posted_by' ) ) {
			$author_string = esc_html( get_theme_mod( 'posted_by' ) ) . ' ' . $author_string;
		}
		echo $author_string; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>
	</span>
	<?php
}

if ( ! empty( $time_string ) && is_single() && get_theme_mod( 'show_date', true ) === true
	|| ! empty( $time_string ) && ! is_single() && get_theme_mod( 'archive_show_date', true ) === true ) {
	?>
	<span class="posted-on">
		<?php
		if ( get_theme_mod( 'publishing_date_text' ) ) {
			$posted_on = esc_html( get_theme_mod( 'publishing_date_text' ) ) . ' %s';
			printf(
				$posted_on, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				$time_string // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			);
		} else {
			// Includes a space between the author name and date if needed.
			echo '&nbsp;' . $time_string;  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		if ( ! empty( $updated_time_string ) && get_theme_mod( 'show_latest_update', false ) === true ) {
			echo '&nbsp; ';
			/* translators: %s: Date and time of last update. */
			$updated_on = __( 'Updated %s', 'inclusive' );
			printf(
				$updated_on, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				$updated_time_string // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			);
		}
		?>
	</span>
	<?php
}
