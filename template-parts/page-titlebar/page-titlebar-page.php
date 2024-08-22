<?php
/**
 * Displays page titlebar in page template
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
        <h1 class="page-title"><?php single_post_title(); ?></h1>
        <?php
          if ( function_exists('yoast_breadcrumb') ) {
            yoast_breadcrumb( '<div id="breadcrumbs" class="breadcrumbs">','</div>' );
          }
        ?>
      </div>
    </div>
</div>
