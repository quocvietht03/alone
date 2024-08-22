<?php
/**
 * Enqueue scripts and styles.
 */
function alone_sermone_scripts() {
	wp_enqueue_style( 'alone-sermone-style', get_template_directory_uri() . '/css/sermone.css', array(), wp_get_theme()->get( 'Version' ) );

	wp_add_inline_style( 'alone-sermone-style', alone_sermone_theme_custom_style() );
}
add_action( 'wp_enqueue_scripts', 'alone_sermone_scripts' );

/**
 * Display custom style in customizer and on frontend.
 */
function alone_sermone_theme_custom_style() {
	// Not include custom style in admin.
	if ( is_admin() ) {
		return;
	}

	$theme_styles = '';

	if ( 199 !== absint( alone_get_option('main_color') ) ) {
		// Colors
		require_once get_parent_theme_file_path( '/sermone/color-patterns.php' );
		$theme_styles .= alone_sermone_custom_colors_css();

	}

	/**
	 * Filters Alone custom theme styles.
	 *
	 * @since Alone 7.0
	 *
	 * @param string $theme_styles
	 */
	return apply_filters( 'alone_sermone_theme_custom_style', $theme_styles );
}

/**
* Hook: alone_tribe_events_page_titlebar_archive
*
* @hooked alone_tribe_events_page_titlebar_archive_template - 10
*/
add_action( 'alone_sermone_page_titlebar_archive', 'alone_sermone_page_titlebar_archive_template' );

function alone_sermone_page_titlebar_archive_template() {

  get_template_part( 'sermone/page-titlebar', 'archive' );

}
