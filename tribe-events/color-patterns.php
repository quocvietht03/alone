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
function alone_events_custom_colors_css() {

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
		.archive-tribe-events-template .tribe-events .tribe-events-header__events-bar .tribe-events-c-view-selector__list-item-link:hover .tribe-events-c-view-selector__list-item-text,
		.archive-tribe-events-template .tribe-events .tribe-events-header__events-bar .tribe-events-c-view-selector__list-item--active .tribe-events-c-view-selector__list-item-text,
		.archive-tribe-events-template .tribe-events .tribe-events-calendar-list__event-date-tag-daynum,
		.archive-tribe-events-template .tribe-events .tribe-events-calendar-list__event-row--featured .tribe-events-calendar-list__event-datetime-featured-text,
		.archive-tribe-events-template .tribe-events .tribe-events-calendar-list__event-title-link:hover,
		.archive-tribe-events-template .tribe-events .tribe-events-calendar-list__event-cost,
		.archive-tribe-events-template .tribe-events .tribe-events-calendar-month__calendar-event-title a:hover,
		.archive-tribe-events-template .tribe-events .tribe-events-calendar-month__day--current .tribe-events-calendar-month__day-date,
		.archive-tribe-events-template .tribe-events .tribe-events-calendar-month__day--current .tribe-events-calendar-month__day-date-link,
		.archive-tribe-events-template .tribe-events .tribe-events-header__messages .tribe-events-c-messages__message-list-item-link:hover,
		.archive-tribe-events-template .tribe-events .tribe-events-c-ical__link,
		.tribe-events .tribe-events-calendar-month__calendar-event-tooltip-datetime-featured-text,
		.tribe-events .tribe-events-calendar-month__calendar-event-tooltip-title a:hover,
		.tribe-events .tribe-events-calendar-month__calendar-event-tooltip-cost,
		.tribe-events .tribe-events-calendar-month-mobile-events__mobile-event-datetime-featured-text,
		.tribe-events .tribe-events-calendar-month-mobile-events__mobile-event-title a:hover,
		.tribe-events .tribe-events-calendar-month-mobile-events__mobile-event-cost,
		.single-tribe-events-template .tribe-events-single .tribe-events-single-event-cost,
		.single-tribe-events-template .tribe-events-single .tribe-events-cal-links a,
		.single-tribe-events-template .tribe-events-single .tribe-events-event-meta .tribe-events-meta-list .tribe-events-meta-item .tribe-events-event-cost,
		.single-tribe-events-template .tribe-events-single .tribe-events-event-meta .tribe-events-meta-list .tribe-events-meta-item .tribe-events-address a,
		.single-tribe-events-template .tribe-events-single #tribe-events-footer ul.tribe-events-sub-nav li a:hover,
		.tribe-main-color {
			color: ' . $base_color . '; /* base: #0073a8; */
		}

		.archive-tribe-events-template .tribe-events .tribe-events-calendar-list__event-datetime-wrapper svg,
		.archive-tribe-events-template .tribe-events .tribe-events-calendar-list__event-venue svg,
		.single-tribe-events-template .tribe-events-single .tribe-events-single-event-schedule svg,
		.single-tribe-events-template .tribe-events-single #tribe-events-footer ul.tribe-events-sub-nav li a:hover svg,
		.tribe-svg-main-color {
			fill: ' . $base_color . '; /* base: #0073a8; */
		}

		/*
		 * Set background
		 */
		.archive-tribe-events-template .tribe-events .tribe-events-header__events-bar .tribe-events-c-search__button,
		.archive-tribe-events-template .tribe-events .tribe-events-header__events-bar .tribe-events-c-view-selector__list-item--active .tribe-events-c-view-selector__list-item-link:after,
		.archive-tribe-events-template .tribe-events .tribe-events-header__events-bar .tribe-events-c-events-bar__search-button:before,
		.archive-tribe-events-template .tribe-events .tribe-events-header__events-bar .tribe-events-c-view-selector__button:before,
		.archive-tribe-events-template .tribe-events .tribe-events-header__top-bar .tribe-events-c-top-bar__datepicker-container .datepicker .month.focused,
		.archive-tribe-events-template .tribe-events .tribe-events-header__top-bar .tribe-events-c-top-bar__datepicker-container .datepicker .day.focused,
		.archive-tribe-events-template .tribe-events .tribe-events-header__top-bar .tribe-events-c-top-bar__datepicker-container .datepicker .month.active,
		.archive-tribe-events-template .tribe-events .tribe-events-header__top-bar .tribe-events-c-top-bar__datepicker-container .datepicker .day.active,
		.archive-tribe-events-template .tribe-events .tribe-events-calendar-list__event-date-tag-weekday,
		.archive-tribe-events-template .tribe-events .tribe-events-calendar-month__day:hover:after,
		.archive-tribe-events-template .tribe-events .tribe-events-calendar-month__day-cell--selected,
		.archive-tribe-events-template .tribe-events .tribe-events-calendar-month__mobile-events-icon--event,
		.archive-tribe-events-template .tribe-events .tribe-events-c-ical__link:hover,
		.single-tribe-events-template .tribe-events-single .tribe-events-back a,
		.tribe-main-background-color {
			background-color: ' . $base_color . '; /* base: #0073a8; */
		}

		/*
		 * Set border color
		 */
		.archive-tribe-events-template .tribe-events .tribe-events-header__messages .tribe-events-c-messages__message-list-item-link,
		.archive-tribe-events-template .tribe-events .tribe-events-c-ical__link,
		.tribe-main-border-color {
			border-color: ' . $base_color . '; /* base: #0073a8; */
		}

		/* Hover colors */
		.single-tribe-events-template .tribe-events-single .tribe-events-cal-links a:hover,
		.tribe-main-color-hover {
			color: ' . $hover_color . '; /* base: #005177; */
		}

		.tribe-svg-main-color-hover {
			fill: ' . $hover_color . '; /* base: #005177; */
		}

		.archive-tribe-events-template .tribe-events .tribe-events-header__events-bar .tribe-events-c-search__button:hover,
		.single-tribe-events-template .tribe-events-single .tribe-events-back a:hover,
		.tribe-main-background-color-hover {
			background-color: ' . $hover_color . '; /* base: #005177; */
		}


		.tribe-main-border-color-hover {
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
	return apply_filters( 'alone_events_custom_colors_css', $theme_css, $base_color, $hover_color );
}
