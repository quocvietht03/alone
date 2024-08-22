<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Alone
 * @since Alone 7.0
 */

if ( 'full-content' === alone_get_option( 'give_pages_layout' ) ) {
	return;
}

if ( ! is_active_sidebar( 'give-sidebar' ) ) {
	return;
}

?>

<aside class="widget-area give-sidebar" role="complementary" aria-label="<?php esc_attr_e( 'Give Sidebar', 'alone' ); ?>">
  <div class="sidebar-widget-wrap">
    <?php dynamic_sidebar( 'give-sidebar' ); ?>
  </div>
</aside><!-- .widget-area -->
