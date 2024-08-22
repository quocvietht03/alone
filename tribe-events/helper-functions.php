<?php
/**
 * Enqueue scripts and styles.
 */
function alone_events_scripts() {
	wp_enqueue_style( 'alone-events-style', get_template_directory_uri() . '/css/events.css', array(), wp_get_theme()->get( 'Version' ) );

	wp_add_inline_style( 'alone-events-style', alone_events_theme_custom_style() );
}
add_action( 'wp_enqueue_scripts', 'alone_events_scripts' );

/**
 * Display custom style in customizer and on frontend.
 */
function alone_events_theme_custom_style() {
	// Not include custom style in admin.
	if ( is_admin() ) {
		return;
	}

	$theme_styles = '';

	if ( 199 !== absint( alone_get_option('main_color') ) ) {
		// Colors
		require_once get_parent_theme_file_path( '/tribe-events/color-patterns.php' );
		$theme_styles .= alone_events_custom_colors_css();

	}

	/**
	 * Filters Alone custom theme styles.
	 *
	 * @since Alone 7.0
	 *
	 * @param string $theme_styles
	 */
	return apply_filters( 'alone_events_theme_custom_style', $theme_styles );
}

/**
* Hook: alone_tribe_events_page_titlebar_archive
*
* @hooked alone_tribe_events_page_titlebar_archive_template - 10
*/
add_action( 'alone_tribe_events_page_titlebar_archive', 'alone_tribe_events_page_titlebar_archive_template' );

function alone_tribe_events_page_titlebar_archive_template() {

  get_template_part( 'tribe-events/page-titlebar', 'archive' );

}
