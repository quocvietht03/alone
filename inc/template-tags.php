<?php
/**
 * Custom template tags for this theme
 *
 * @package WordPress
 * @subpackage Alone
 * @since Alone 7.0
 */

if ( ! function_exists( 'alone_the_posts_navigation' ) ) :
	/**
	 * Previous/next page navigation.
	 */
	function alone_the_posts_navigation() {
		the_posts_pagination(
			array(
				'mid_size'  => 2,
				'prev_text' => alone_get_icon_svg('arrow-left', 12) . __( 'Prev', 'alone' ),
	      		'next_text' => __( 'Next', 'alone' ) . alone_get_icon_svg('arrow-right', 12),
			)
		);
	}
endif;

if ( ! function_exists( 'alone_the_post_navigation' ) ) :
	/**
	 * Previous/next post navigation.
	 */
	function alone_the_post_navigation() {
		the_post_navigation(
			array(
				'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next Post', 'alone' ) . '</span> ' .
					'<span class="screen-reader-text">' . __( 'Next post:', 'alone' ) . '</span> <br/>' .
					'<span class="post-title">%title</span>',
				'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Previous Post', 'alone' ) . '</span> ' .
					'<span class="screen-reader-text">' . __( 'Previous post:', 'alone' ) . '</span> <br/>' .
					'<span class="post-title">%title</span>',
			)
		);
	}
endif;

if ( ! function_exists( 'wp_body_open' ) ) :
	/**
	 * Fire the wp_body_open action.
	 *
	 * Added for backward compatibility to support pre-5.2.0 WordPress versions.
	 *
	 * @since Alone 1.4
	 */
	function wp_body_open() {
		/**
		 * Triggered after the opening <body> tag.
		 *
		 * @since Alone 1.4
		 */
		do_action( 'wp_body_open' );
	}
endif;
