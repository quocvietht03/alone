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
function alone_give_custom_colors_css() {

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
		.give-goal-progress .income,
		.give-goal-progress .goal-text,
		form[id*=give-form] .give-total-wrap #give-amount,
		form[id*=give-form] #give-donation-level-button-wrap .give-btn:hover,
		form[id*=give-form] #give-donation-level-radio-list li label:hover,
		form[id*=give-form] #give-donation-level-radio-list li input.give-default-level + label,
		form[id*=give-form] .give_terms_links:hover,
		form[id*=give-form] #give-final-total-wrap .give-final-total-amount,
		form[id*=give-form] #give-gateway-radio-list > li label:hover,
		form[id*=give-form] #give-gateway-radio-list > li.give-gateway-option-selected label,
		form[id*=give-form] #give_terms_agreement label:hover,
		form[id*=give-form] #give_terms_agreement input[type=checkbox]:checked + label,
		.give-sidebar .widget .give-donor .give-donor__total,
		.give-form-wrap .give-meta li a,
		.give-form-wrap .give-form-box-wrap form[id*=give-form] .give-total-wrap .give-currency-symbol,
		.give-form-wrap .give-form-box-wrap form[id*=give-form] #give-donation-level-button-wrap .give-btn.give-default-level,
		.give-form-wrap .give-form-box-wrap form[id*=give-form] #give-final-total-wrap .give-donation-total-label,
		.give-form-wrap .give-form-box-wrap form[id*=give-form] > .give-btn,
		.give-form-wrap .give-form-box-wrap form[id*=give-form] .give-submit,
		.single-give_posts .give-content-wrap .give-content-col .give-meta li a,
		.single-give_posts .give-content-wrap .give-content-col .give-content-inner > ol li:before,
		.give-main-color {
			color: ' . $base_color . '; /* base: #0073a8; */
		}

		.single-give-forms-template.style-5 .give-content-wrap .give-form-col .give-donor-wall-top .give-grid__item .give-donor-details__total,
		.single-give-forms-template.style-5 .give-content-wrap .give-form-col .give-donor-wall-recent .give-grid__item .give-donor-details__total {
			color: ' . $base_color . ' !important; /* base: #0073a8; */
		}

		.give-form-wrap .give-meta li svg,
		.single-give_posts .give-content-wrap .give-content-col .give-meta li svg,
		.give-svg-main-color {
			fill: ' . $base_color . '; /* base: #0073a8; */
		}

		/*
		 * Set background
		 */
		.give-btn,
		.mini-donation .btn-donation,
		.give-goal-progress .give-progress-bar > span,
		.donations-give-form-wrap .give-card__body .give-card__button,
		.give-forms-loadmore .btn-loadmore,
		form[id*=give-form] .give-total-wrap .give-currency-symbol,
		form[id*=give-form] .give-donation-amount .give-currency-symbol,
		form[id*=give-form] #give-donation-level-button-wrap .give-btn.give-default-level,
		form[id*=give-form] #give-donation-level-radio-list li label:after,
		form[id*=give-form] #give-gateway-radio-list > li label:after,
		form[id*=give-form] #give_terms_agreement input[type=checkbox]:checked + label:before,
		form[id*=give-form] > .give-btn,
		div[id*=give-form] > .give-btn,
		form[id*=give-form] #give-final-total-wrap .give-donation-total-label,
		form[id*=give-form] .give-submit,
		.give-form-wrap .give-form-box-wrap,
		.give-form-wrap .give-form-content-footer .give-tag-links a,
		.give-form-wrap .give-form-content-footer .give-social-share a,
		.single-give-forms-template.style-5 .give-content-wrap .give-form-col .give-goal-wrap .give-card__button,
		.single-give-forms-template.style-5 .give-content-wrap .give-form-col .give-donor-wall-recent .give-donor__load_more,
		.single-give_posts .give-content-wrap .give-content-col .give-content-inner > ul li:before,
		.single-give_posts .give-content-wrap .give-content-col .give-form-content-footer .give-tag-links a,
		.give-main-background-color {
			background-color: ' . $base_color . '; /* base: #0073a8; */
		}

		/*
		 * Set border color
		 */
		form[id*=give-form] #give-donation-level-button-wrap .give-btn:hover,
		form[id*=give-form] #give-donation-level-button-wrap .give-btn.give-default-level,
		form[id*=give-form] #give_terms_agreement input[type=checkbox]:checked + label:before,
		.single-give_posts .give-content-wrap .give-content-col .give-content-inner blockquote,
		.give-main-border-color {
			border-color: ' . $base_color . '; /* base: #0073a8; */
		}

		/* Hover colors */
		.give-main-color-hover{
			color: ' . $hover_color . '; /* hover: #005177; */
		}

		.give-svg-main-color-hover {
			fill: ' . $hover_color . '; /* hover: #005177; */
		}

		.give-btn:hover,
		.mini-donation .btn-donation:hover,
		.donations-give-form-wrap .give-card__body .give-card__button:hover,
		.give-forms-loadmore .btn-loadmore:hover,
		form[id*=give-form] > .give-btn:hover,
		div[id*=give-form] > .give-btn:hover,
		form[id*=give-form] .give-submit:hover,
		.give-form-wrap .give-form-content-footer .give-tag-links a:hover,
		.give-form-wrap .give-form-content-footer .give-social-share a:hover,
		.single-give-forms-template.style-5 .give-content-wrap .give-form-col .give-goal-wrap .give-card__button:hover,
		.single-give-forms-template.style-5 .give-content-wrap .give-form-col .give-donor-wall-recent .give-donor__load_more:hover,
		.single-give_posts .give-content-wrap .give-content-col .give-form-content-footer .give-tag-links a:hover,
		.give-main-background-color-hover {
			background-color: ' . $hover_color . '; /* hover: #005177; */
		}

		.give-main-border-color-hover {
			border-color: ' . $hover_color . '; /* hover: #005177; */
		}
		
		.single-give_posts .give-content-wrap .give-content-col .give-content-inner p a {
			color: ' . $base_color . '; /* base: #0073a8; */
			box-shadow: 0px 1px 0px ' . $base_color . ';
		}
		.single-give_posts .give-content-wrap .give-content-col .give-content-inner p a:hover{
			box-shadow: 0px 2px 0px ' . $base_color . ';
		}
		.single-give_posts .give-content-wrap .give-form-col .give-donor-wall-top .give-grid__item .give-donor-details__total, 
		.single-give_posts .give-content-wrap .give-form-col .give-donor-wall-recent .give-grid__item .give-donor-details__total {
			color: ' . $base_color . ' !important; /* base: #0073a8; */
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
	return apply_filters( 'alone_give_custom_colors_css', $theme_css, $base_color, $hover_color );
}
