<?php
/**
 * Displays page titlebar in main template
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
        <?php if ( is_home() && ! is_front_page() ) : ?>
          <h1 class="page-title"><?php single_post_title(); ?></h1>
          <?php
            if ( function_exists('yoast_breadcrumb') ) {
              yoast_breadcrumb( '<div id="breadcrumbs" class="breadcrumbs">','</div>' );
            }
          ?>
        <?php else : ?>
          <h2 class="page-title"><?php esc_html_e( 'Posts', 'alone' ); ?></h2>
          <div class="page-desc"><?php esc_html_e( 'Articles to help you grow your business big or small.', 'alone' ) ?></div>
        <?php endif; ?>
      </div>
    </div>
</div>
