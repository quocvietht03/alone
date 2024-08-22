<?php
/**
 * Alone: Styling
 *
 * @package WordPress
 * @subpackage Alone
 * @since Alone 7.0
 */

// Page Titlebar Pumori
if( 0 !== absint( alone_get_option('custom_page_titlebar') ) ) {

  $page_breadcrumb_bg_color = alone_get_option( 'page_breadcrumb_bg_color' );
  $page_titlebar_bg_color = alone_get_option( 'page_titlebar_bg_color' );
  $page_titlebar_bg_image = alone_get_option( 'page_titlebar_bg_image' );
  $page_titlebar_spacing = alone_get_option( 'page_titlebar_spacing' );
  
  $theme_styles .= '
                    .page-titlebar .breadcrumbs,
                    .page-titlebar .page-desc {
                      background-color: ' . $page_breadcrumb_bg_color . ';
                    }
                    .page-titlebar {
                      background-color: ' . $page_titlebar_bg_color . ';
                      background-image: url(' . $page_titlebar_bg_image . ');
                      background-size: cover;
                      background-position: center;
                      padding-top: ' . $page_titlebar_spacing['top'] . ';
                      padding-bottom: ' . $page_titlebar_spacing['bottom'] . ';
                    }';

}
