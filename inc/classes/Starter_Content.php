<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Starter Content
 *
 * @package Inclusive
 * @since 1.0.0
 */

namespace Inclusive;

/**
 * Starter Content for fresh sites.
 *
 * @since 1.0.0
 */
class Starter_Content {

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		add_action( 'after_setup_theme', [ $this, 'action_starter_content_theme_support' ] );
	}

	/**
	 * Adds theme support for starter content
	 */
	public function action_starter_content_theme_support() {
		add_theme_support(
			'starter-content',
			[
				// Default to a static front page and assign the front and posts pages.
				'options'   => [
					'show_on_front'  => 'page',
					'page_on_front'  => '{{front}}',
					'page_for_posts' => '{{blog}}',
				],
				'nav_menus' => [
					'menu-1' => [
						'name'  => __( 'Primary', 'inclusive' ),
						'items' => [
							'page_news',
							'page_about',
							'page_contact',
						],
					],
					'social' => [
						'name'  => __( 'Social', 'inclusive' ),
						'items' => [
							'link_facebook',
							'link_twitter',
							'link_instagram',
						],
					],
				],
				'posts'     => [
					'about',
					'contact',
					'blog',
					'news',
					'front' => [
						'post_type'    => 'page',
						'post_title'   => _x( 'Example homepage with blocks', 'Theme starter content', 'inclusive' ),
						'post_content' => join(
							'',
							[
								'<!-- wp:columns {"align":"wide"} -->
								<div class="wp-block-columns alignwide"><!-- wp:column {"width":58} -->
								<div class="wp-block-column" style="flex-basis:58%">
								<!-- wp:heading {"level":2,"className":"is-style-inclusive-text-shadow"} -->
								<h2 class="is-style-inclusive-text-shadow">' .
								_x( 'It is all about <span style="color:#b6007c" class="has-inline-color">You</span> <span style="color:#72009b" class="has-inline-color">&amp;</span> 
								<span style="color:#7747fa" class="has-inline-color">the </span><strong><span style="color:#479ffa" class="has-inline-color">Blocks</span></strong></h2>', 'Theme starter content', 'inclusive' ) .
								'<!-- /wp:heading -->
								</div>
								<!-- /wp:column -->

								<!-- wp:column -->
								<div class="wp-block-column"><!-- wp:cover {"url":"' . esc_url( get_theme_file_uri( 'assets/images/flora.png' ) ) . '","id":48,"customOverlayColor":"#e3eff5"} -->
								<div class="wp-block-cover has-background-dim" style="background-image:url(' . esc_url( get_theme_file_uri( 'assets/images/flora.png' ) ) . ');background-color:#e3eff5"><div class="wp-block-cover__inner-container"><!-- wp:paragraph -->
								<p></p>
								<!-- /wp:paragraph -->

								<!-- wp:heading {"align":"center","level":2,"customTextColor":"#000000","className":"is-style-inclusive-text-shadow"} -->
								<h2 class="has-text-color has-text-align-center is-style-inclusive-text-shadow" style="color:#000000">' . _x( 'Example heading', 'Theme starter content,', 'inclusive' ) . '</h2>
								<!-- /wp:heading -->

								<!-- wp:buttons {"align":"center"} -->
								<div class="wp-block-buttons aligncenter"><!-- wp:button {"className":"is-style-inclusive-large-button"} -->
								<div class="wp-block-button is-style-inclusive-large-button"><a href="#" class="wp-block-button__link">' . _x( 'Sign up for our Newsletter', 'Theme starter content', 'inclusive' ) . '</a></div>
								<!-- /wp:button --></div>
								<!-- /wp:buttons --></div></div>
								<!-- /wp:cover --></div>
								<!-- /wp:column --></div>
								<!-- /wp:columns -->

								<!-- wp:spacer {"height":50} -->
								<div style="height:50px" aria-hidden="true" class="wp-block-spacer"></div>
								<!-- /wp:spacer -->

								<!-- wp:paragraph {"fontSize":"medium"} -->
								<p class="has-medium-font-size">' . _x( 'This is an example page used to show you what you can do with your theme and the new block editor.', 'Theme starter content', 'inclusive' ) . '</p>
								<!-- /wp:paragraph -->

								<!-- wp:paragraph {"align":"center","backgroundColor":"secondary","fontSize":"medium","className":"is-style-inclusive-rounded-corners"} -->
								<p class="has-background has-text-align-center has-medium-font-size has-secondary-background-color is-style-inclusive-rounded-corners">
								<em><strong>' . _x( 'Edit this page to make it your own.', 'Theme starter content', 'inclusive' ) . '</strong></em></p>
								<!-- /wp:paragraph -->

								<!-- wp:spacer {"height":50} -->
								<div style="height:50px" aria-hidden="true" class="wp-block-spacer"></div>
								<!-- /wp:spacer -->

								<!-- wp:gallery {"ids":[31,32,41],"columns":2,"align":"wide","className":"alignwide"} -->
								<ul class="wp-block-gallery alignwide columns-2 is-cropped"><li class="blocks-gallery-item">
								<figure><img src="' . esc_url( get_theme_file_uri( 'assets/images/cherry2.png' ) ) . '" 
								alt="' . _x( 'A branch of pink cherry blossoms and buds.', 'Theme starter content', 'inclusive' ) . '" data-id="31" data-link="' . esc_url( get_theme_file_uri( 'assets/images/cherry2.png' ) ) . '" class="wp-image-31"/>
								</figure></li><li class="blocks-gallery-item">
									<figure><img src="' . esc_url( get_theme_file_uri( 'assets/images/cherry.png' ) ) . '" 
								alt="' . _x( 'Spring cherry blossom branch', 'Theme starter content', 'inclusive' ) . '" data-id="32" data-link="' . esc_url( get_theme_file_uri( 'assets/images/cherry.png' ) ) . '" class="wp-image-32"/>
								</figure></li><li class="blocks-gallery-item">
								<figure><img src="' . esc_url( get_theme_file_uri( 'assets/images/cherry3.png' ) ) . '" 
								alt="' . _x( 'Pink cherry blossoms against a blue sky', 'Theme starter content', 'inclusive' ) . '" data-id="41" data-link="' . esc_url( get_theme_file_uri( 'assets/images/cherry3.png' ) ) . '" class="wp-image-41"/>
								</figure></li></ul>
								<!-- /wp:gallery -->

								<!-- wp:quote {"className":"is-style-large"} -->
								<blockquote class="wp-block-quote is-style-large">
								<p><strong>' . _x( 'Cherish each hour of this day for it can never return.', 'Theme starter content', 'inclusive' ) . '</strong></p>
								<cite><em>' . _x( 'Og Mandino', 'Theme starter content', 'inclusive' ) . '</em></cite>
								</blockquote>
								<!-- /wp:quote -->

								<!-- wp:columns {"align":"wide"} -->
								<div class="wp-block-columns alignwide"><!-- wp:column -->
								<div class="wp-block-column"><!-- wp:paragraph -->
								<p>' . _x( 'Suspendisse ullamcorper risus sit amet massa consectetur lobortis. Pellentesque non nisi nec lorem sodales cursus. 
								Pellentesque vitae pretium tellus. Nullam vulputate, ipsum ut sodales accumsan, nunc est euismod magna, 
								a rutrum neque tortor vitae nisi. ', 'Theme starter content -Lorem Ipsum.', 'inclusive' ) . '</p>
								<!-- /wp:paragraph --></div>
								<!-- /wp:column -->

								<!-- wp:column -->
								<div class="wp-block-column"><!-- wp:paragraph -->
								<p>' . _x( 'In hac habitasse platea dictumst. Integer eu purus quis lectus cursus feugiat feugiat aliquam purus. Ut fermentum nunc purus, vitae ultricies ipsum vehicula et.', 'Theme starter content -Lorem Ipsum.', 'inclusive' ) . '</p>
								<!-- /wp:paragraph --></div>
								<!-- /wp:column --></div>
								<!-- /wp:columns -->

								<!-- wp:buttons -->
								<div class="wp-block-buttons"><!-- wp:button -->
								<div class="wp-block-button"><a href="#" class="wp-block-button__link">' . _x( 'Button', 'Theme starter content', 'inclusive' ) . '</a></div>
								<!-- /wp:button -->

								<!-- wp:button {"className":"is-style-outline"} -->
								<div class="wp-block-button is-style-outline"><a href="#" class="wp-block-button__link">' . _x( 'Button', 'Theme starter content', 'inclusive' ) . '</a></div>
								<!-- /wp:button -->

								<!-- wp:button {"className":"is-style-inclusive-large-button"} -->
								<div class="wp-block-button is-style-inclusive-large-button"><a href="#" class="wp-block-button__link">' . _x( 'Large Button', 'Theme starter content', 'inclusive' ) . '</a></div>
								<!-- /wp:button -->

								<!-- wp:button {"customTextColor":"#040404","gradient":"electric-grass"} -->
								<div class="wp-block-button"><a href="#" class="wp-block-button__link has-text-color has-background has-electric-grass-gradient-background" style="color:#040404">' . _x( 'Gradient Button', 'Theme starter content', 'inclusive' ) . '</a></div>
								<!-- /wp:button --></div>
								<!-- /wp:buttons -->

								<!-- wp:separator {"className":"is-style-inclusive-separator-ornament1"} -->
								<hr class="wp-block-separator is-style-inclusive-separator-ornament1"/>
								<!-- /wp:separator -->

								<!-- wp:latest-posts /-->

								<!-- wp:latest-comments /-->

								<!-- wp:cover {"url":"' . esc_url( get_theme_file_uri( 'assets/images/flora.png' ) ) . '","id":41,"hasParallax":true,"overlayColor":"secondary","align":"full"} -->
								<div class="wp-block-cover alignfull has-secondary-background-color has-background-dim has-parallax" style="background-image:url(' . esc_url( get_theme_file_uri( 'assets/images/flora.png' ) ) . ')">
								<div class="wp-block-cover__inner-container"><!-- wp:paragraph {"align":"center","customTextColor":"#000000","fontSize":"large"} -->
								<p style="color:#000000" class="has-text-color has-text-align-center has-large-font-size"><strong>' . _x( 'This is a full width cover block with a fixed background image.', 'Theme starter content', 'inclusive' ) . '</strong></p>
								<!-- /wp:paragraph --></div></div>
								<!-- /wp:cover -->

								<!-- wp:verse -->
								<pre class="wp-block-verse">' . _x( 'I remember you

Do you remember when I was sitting by your bed and we were watching that film, and I fell asleep, and you caressed my cheek?

Or when we sat in the shade by the river, holding hands and kissing on 4th of July? Because I do.

Do you remember on the patio, laughing and fighting off mosquitoes?
All I can think of is you sitting there, wearing that smile.

Do you remember the first little kiss, on our first evening, in the back of your van? Because I do.
Do you remember how nervous you were?

And do you remember the hickie, and what you told your dad? Because I do.
Thinking about it still makes me laugh.

Do you remember how you brought me precious gifts each day?
I still keep the necklace on my bedside table, together with a piece of painted glass.

Sometimes, I open the wooden chest in my closet, and I find the flowered box where I keep the letters you sent.
I look at the pictures of Yer Blanc, of Sparky, of your family, and of you.
Because I miss you, I do.

For nineteen years I have remembered you.', 'Theme starter content', 'inclusive' ) . '
</pre>
<!-- /wp:verse -->
								<!-- wp:separator {"className":"is-style-inclusive-separator-ornament1"} -->
								<hr class="wp-block-separator is-style-inclusive-separator-ornament1"/>
								<!-- /wp:separator -->
								',
							]
						),
					],
				],
				'widgets'   => [
					// Place three core-defined widgets in the footer area.
					'sidebar-1' => [
						'text_business_info',
						'text_about',
						'search',
					],
				],
			]
		);
	}
}
