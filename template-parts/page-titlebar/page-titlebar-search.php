<?php
/**
 * Displays page titlebar in search results pages
 *
 * @package WordPress
 * @subpackage Alone
 * @since Alone 7.0
 */

if( ! alone_get_option( 'site_titlebar' ) ) {
	return;
}

?>

<div class="page-titlebar">
    <div class="container responsive">
      <div class="page-titlebar-content">
        <h1 class="page-title">
          <?php esc_html_e( 'Search results for: ', 'alone' ); ?>
          <?php echo get_search_query(); ?>
        </h1>
        <?php
          if ( function_exists('yoast_breadcrumb') ) {
            yoast_breadcrumb( '<div id="breadcrumbs" class="breadcrumbs">','</div>' );
          }
        ?>
      </div>
    </div>
</div>
