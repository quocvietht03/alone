<?php
/**
 * SVG icons related functions
 *
 * @package WordPress
 * @subpackage Alone
 * @since Alone 7.0
 */

/**
 * Gets the SVG code for a given icon.
 */
function alone_get_icon_svg( $icon, $size = 24 ) {
	return Alone_SVG_Icons::get_svg( 'ui', $icon, $size );
}

/**
 * Gets the SVG code for a given social icon.
 */
function alone_get_social_icon_svg( $icon, $size = 24 ) {
	return Alone_SVG_Icons::get_svg( 'social', $icon, $size );
}
