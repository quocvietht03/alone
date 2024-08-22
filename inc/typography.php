<?php
/**
 * Alone: Typography
 *
 * @package WordPress
 * @subpackage Alone
 * @since Alone 7.0
 */

function alone_custom_typos_css() {
	$theme_css        = '';

	$properties = array(
		'font-family'    => 'font-family',
		'font-size'      => 'font-size',
		'variant'        => 'font-weight',
		'line-height'    => 'line-height',
		'letter-spacing' => 'letter-spacing',
		'color'          => 'color',
		'text-transform' => 'text-transform',
	);

	$settings = array(
		'body_typo'          => 'body',
		'heading1_typo'      => 'h1',
		'heading2_typo'      => 'h2',
		'heading3_typo'      => 'h3',
		'heading4_typo'      => 'h4',
		'heading5_typo'      => 'h5',
		'heading6_typo'      => 'h6',
		'menu_typo'          => '.primary-navigation ul a, .primary-navigation ul.primary-menu a',
		'sub_menu_typo'      => '.primary-navigation ul ul.sub-menu a, .primary-navigation ul.primary-menu ul.sub-menu a',
		'page_title_typo'      => '.page-titlebar .page-title',
		'page_breadcrumb_typo' => '.page-titlebar .breadcrumbs',
	);

	foreach ( $settings as $setting => $selector ) {
		$typography = alone_get_option( $setting );
		$style      = '';

		foreach ( $properties as $key => $property ) {
			if ( isset( $typography[ $key ] ) && ! empty( $typography[ $key ] ) ) {
				$value = 'font-family' == $key ? '"' . rtrim( trim( $typography[ $key ] ), ',' ) . '"' : $typography[ $key ];
				$value = 'variant' == $key ? str_replace( 'regular', '400', $value ) : $value;

				if ( $value ) {
					$style .= $property . ': ' . $value . ';';
				}
			}
		}

		if ( ! empty( $style ) ) {
			$theme_css .= $selector . '{' . $style . '}';
		}
	}

	$theme_css .= alone_get_heading_typography_css();

  /**
	 * Filters Alone custom typos CSS.
	 *
	 * @since Alone 7.0
	 *
	 * @param string $theme_css
	 */
	return apply_filters( 'alone_custom_typos_css', $theme_css );
}

/**
 * Returns CSS for the typography.
 */
function alone_get_heading_typography_css() {

	$headings   = array(
		'h1' => 'heading1_typo',
		'h2' => 'heading2_typo',
		'h3' => 'heading3_typo',
		'h4' => 'heading4_typo',
		'h5' => 'heading5_typo',
		'h6' => 'heading6_typo',
	);
	$inline_css = '';
	foreach ( $headings as $heading ) {
		$keys = array_keys( $headings, $heading );
		if ( $keys ) {
			$inline_css .= alone_get_heading_font( $keys[0], $heading );
		}
	}

	return $inline_css;

}

/**
 * Returns CSS for the typography.
 */
function alone_get_heading_font( $key, $heading ) {

	$inline_css   = '';
	$heading_typo = alone_get_option( $heading );

	if ( $heading_typo ) {
		if ( isset( $heading_typo['font-family'] ) && strtolower( $heading_typo['font-family'] ) !== 'poppins' ) {
			$typo       = rtrim( trim( $heading_typo['font-family'] ), ',' );
			$inline_css .= $key . '{font-family:' . $typo . ', Arial, sans-serif}';

		}
	}

	if ( empty( $inline_css ) ) {
		return;
	}

	return <<<CSS
	{$inline_css}
CSS;
}
