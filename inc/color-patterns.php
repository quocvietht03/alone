<?php
/**
 * Alone: Color Patterns
 *
 * @package WordPress
 * @subpackage Alone
 * @since Alone 7.0
 */

/**
 * Generate the CSS for the current primary color.
 */
function alone_custom_colors_css() {

	$main_color = absint( alone_get_option( 'main_color' ) );

	/**
	 * Filter Alone default saturation level.
	 *
	 * @since Alone 7.0
	 *
	 * @param int $saturation Color saturation level.
	 */
	$saturation = apply_filters( 'alone_scheme_color_saturation', 100 );
	$saturation = absint( $saturation ) . '%';

	/**
	 * Filter Alone default lightness level.
	 *
	 * @since Alone 7.0
	 *
	 * @param int $lightness Color lightness level.
	 */
	$lightness = apply_filters( 'alone_scheme_color_lightness', 33 );
	$lightness = absint( $lightness ) . '%';

	/**
	 * Filter Alone default hover lightness level.
	 *
	 * @since Alone 7.0
	 *
	 * @param int $lightness_hover Hover color lightness level.
	 */
	$lightness_hover = apply_filters( 'alone_scheme_color_lightness_hover', 23 );
	$lightness_hover = absint( $lightness_hover ) . '%';

	/**
	 * Theme color variable
	 */
	$base_color = 'hsl( ' . $main_color . ', ' . $saturation . ', ' . $lightness . ' )';
	$hover_color = 'hsl( ' . $main_color . ', ' . $saturation . ', ' . $lightness_hover . ' )';

	if( 'custom' == alone_get_option('custom_colors') ) {
		$base_color = alone_get_option( 'custom_color' );

		$hover_color = $base_color;
		if ( class_exists( 'Kirki_Color' ) && method_exists( 'Kirki_Color', 'adjust_brightness' ) ) {
			$hover_color = Kirki_Color::adjust_brightness( $base_color, - 10 );
		}

	}

	$theme_css = '

		/*
		 * Set Color
		 */
		a:focus, a:hover,
		h1 a:hover,
		h2 a:hover,
		h3 a:hover,
		h4 a:hover,
		h5 a:hover,
		h6 a:hover,
		#site-preloader .nprogress-loading-text span,
		.site-logo .site-title a:hover,
		.primary-navigation ul a:hover,
		.primary-navigation ul.primary-menu a:hover,
		.primary-navigation ul li.current_page_item > a,
		.primary-navigation ul.primary-menu li.current_page_item > a,
		.primary-navigation ul ul.sub-menu a:hover,
		.primary-navigation ul.primary-menu ul.sub-menu a:hover,
		.primary-navigation ul ul.sub-menu li.current_page_item > a,
		.primary-navigation ul.primary-menu ul.sub-menu li.current_page_item > a,
		.widget ul li a:hover,
		.widget ul li a[aria-current="page"],
		.blog-post-wrap .entry-content .entry-cat-links a,
		.blog-post-wrap .entry-content .entry-title a:hover,
		.blog-posts-list .post-wrap .entry-content .entry-cat-links a, 
		.blog-posts-list .post-wrap .entry-content .entry-cat-links a:hover, 
		.related-posts-list .post-wrap .entry-content .entry-cat-links a,
		.related-posts-list .post-wrap .entry-content .entry-cat-links a:hover,
		.blog-posts-list .post-wrap .entry-content .entry-title a:hover, 
		.related-posts-list .post-wrap .entry-content .entry-title a:hover,
		.search-post-wrap .entry-content .entry-cat-links a,
		.search-post-wrap .entry-content .entry-title a:hover,
		.single-post-wrap .entry-content .entry-cat-links a,
		.single-post-wrap .entry-content .entry-meta li a:hover,
		.single-post-wrap .entry-content .entry-content-inner p a,
		.single-post-wrap .entry-content .entry-content-inner > ol li:before,
		.author-bio .author-link,
		.post-navigation .nav-links a:hover,
		#respond .comment-form .comment-form-cookies-consent label:hover,
		#comments .comment-item .comment-content a,
		#comments .comment-item .comment-content .comment-reply-link,
		.site-footer .footer-navigation ul.footer-menu li a:hover,
		.single-team-wrap .entry-postion,
		.related-member-wrap .entry-title a:hover,
		.main-color {
			color: ' . $base_color . '; /* base: #0073a8; */
		}

		.blog-post-wrap .entry-image .entry-comment-count svg,
		.blog-posts-list .post-wrap .entry-image .entry-comment-count svg, 
		.related-posts-list .post-wrap .entry-image .entry-comment-count svg,
		#comments .comment-item .comment-content .comment-reply-link svg,
		.site-footer .site-info.has-backtop .site-info-wrap .site-backtop:hover svg,
		.site-footer .site-info.has-backtop .site-info-wrap .site-backtop:focus svg,
		.svg-main-color {
			fill: ' . $base_color . '; /* base: #0073a8; */
		}

		/*
		 * Set background
		 */
		input[type="submit"],
		#nprogress .bar,
		.site-header .widget-area,
		.extras-navigation .toggle-icon,
		.pagination .nav-links .page-numbers.current,
		.pagination .nav-links .page-numbers:hover,
		.page-titlebar .page-title:after,
		.entry-social-share a,
		.blog-post-wrap .entry-content .entry-meta li:not(:last-child):after,
		.blog-posts-list .post-wrap .entry-content .entry-meta li:not(:last-child):after, 
		.related-posts-list .post-wrap .entry-content .entry-meta li:not(:last-child):after,
		.search-post-wrap .entry-content .entry-meta li:not(:last-child):after,
		.posts-loadmore .btn-loadmore,
		.single-post-wrap .entry-content .entry-meta li:not(:last-child):after,
		.single-post-wrap .entry-content .entry-content-inner > ul li:before,
		.single-post-wrap .entry-content .entry-footer .entry-tag-links a,
		#respond .comment-form .comment-form-cookies-consent input[type=checkbox]:checked + label:before,
		#comments .comment-item .comment-content .comment-reply-link:hover,
		.single-team-wrap .entry-socials a:hover,
		.main-background-color {
			background-color: ' . $base_color . '; /* base: #0073a8; */
		}

		/*
		 * Set border color
		 */
		input[type="submit"],
		#respond .comment-form .comment-form-cookies-consent input[type=checkbox]:checked + label:before,
		#comments .comment-item .comment-content .comment-reply-link,
		.main-border-color {
			border-color: ' . $base_color . '; /* base: #0073a8; */
		}

		.single-post-wrap .entry-content .entry-content-inner p a {
			box-shadow: 0px 1px 0px ' . $base_color . ';
		}
		.single-post-wrap .entry-content .entry-content-inner p a:hover {
			box-shadow: 0px 2px 0px ' . $base_color . ';
		}

		.gallery-item > div > a:focus {
			box-shadow: 0 0 0 2px ' . $base_color . '; /* base: #0073a8; */
		}

		.single-post-wrap .entry-content .entry-content-inner blockquote {
			box-shadow: inset 2px 0px 0px ' . $base_color . '; /* base: #0073a8; */
		}

		/* Hover colors */
		.blog-post-wrap .entry-content .entry-cat-links a:hover,
		.search-post-wrap .entry-content .entry-cat-links a:hover,
		.single-post-wrap .entry-content .entry-cat-links a:hover,
		.author-bio .author-link:hover,
		.main-color-hover {
			color: ' . $hover_color . '; /* base: #005177; */
		}

		.blog-post-wrap .entry-image .entry-comment-count:hover svg,
		.svg-main-color-hover {
			fill: ' . $hover_color . '; /* base: #005177; */
		}

		input[type="submit"]:hover,
		.extras-navigation .toggle-icon:hover,
		.extras-navigation .extra-item.active .toggle-icon,
		.entry-social-share a:hover,
		.posts-loadmore .btn-loadmore:hover,
		.single-post-wrap .entry-content .entry-footer .entry-tag-links a:hover,
		.main-background-color-hover {
			background-color: ' . $hover_color . '; /* base: #005177; */
		}

		input[type="submit"]:hover,
		.main-border-color-hover {
			border-color: ' . $hover_color . '; /* base: #005177; */
		}

		@media (max-width: 991.98px) {
			/*
			 * Set background
			 */
			.site-footer .site-info.has-backtop .site-info-wrap .site-backtop {
				background-color: ' . $base_color . '; /* base: #0073a8; */
			}

			/* Hover colors */
			.site-footer .site-info.has-backtop .site-info-wrap .site-backtop:hover {
				background-color: ' . $hover_color . '; /* base: #005177; */
			}
		}';

	/**
	 * Filters Alone custom colors CSS.
	 *
	 * @since Alone 7.0
	 *
	 * @param string $theme_css           Base theme colors CSS.
	 * @param string $base_color 					The user's selected color.
	 * @param string $hover_color    			Filtered theme color hover.
	 */
	return apply_filters( 'alone_custom_colors_css', $theme_css, $base_color, $hover_color );
}
