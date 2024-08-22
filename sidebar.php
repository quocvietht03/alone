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

if ( 'full-content' === alone_get_option( 'blog_pages_layout' ) ) {
	return;
}

if ( ! is_active_sidebar( 'blog-sidebar' ) ) {
	return;
}

?>

<aside class="widget-area blog-sidebar" role="complementary" aria-label="<?php esc_attr_e( 'Blog Sidebar', 'alone' ); ?>">
  <div class="sidebar-widget-wrap">
    <?php dynamic_sidebar( 'blog-sidebar' ); ?>
  </div>
</aside><!-- .widget-area -->
