<?php
/**
 * Sidebar
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/sidebar.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( 'full-content' === alone_get_option( 'product_catalog_layout' ) ) {
	return;
}

if( is_product() ) {
	return;
}

if ( ! is_active_sidebar( 'shop-sidebar' ) ) {
	return;
}

?>

<aside class="widget-area shop-sidebar" role="complementary" aria-label="<?php esc_attr_e( 'Shop Sidebar', 'alone' ); ?>">
  <div class="sidebar-widget-wrap">
    <?php dynamic_sidebar( 'shop-sidebar' ); ?>
  </div>
</aside><!-- .widget-area -->
