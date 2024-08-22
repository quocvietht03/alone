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
function alone_sermone_custom_colors_css() {

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
		.sermone-main-color {
			color: ' . $base_color . '; /* base: #0073a8; */
		}

		.sermone-svg-main-color {
			fill: ' . $base_color . '; /* base: #0073a8; */
		}

		/*
		 * Set background
		 */
		.sermone-main-background-color {
			background-color: ' . $base_color . '; /* base: #0073a8; */
		}

		/*
		 * Set border color
		 */
		.sermone-main-border-color {
			border-color: ' . $base_color . '; /* base: #0073a8; */
		}

		/* Hover colors */
		.sermone-main-color-hover {
			color: ' . $hover_color . '; /* base: #005177; */
		}

		.sermone-svg-main-color-hover {
			fill: ' . $hover_color . '; /* base: #005177; */
		}

		.sermone-main-background-color-hover {
			background-color: ' . $hover_color . '; /* base: #005177; */
		}


		.sermone-main-border-color-hover {
			border-color: ' . $hover_color . '; /* base: #005177; */
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
	return apply_filters( 'alone_sermone_custom_colors_css', $theme_css, $base_color, $hover_color );
}
