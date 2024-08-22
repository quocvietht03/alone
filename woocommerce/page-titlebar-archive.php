<?php
/**
 * Displays page titlebar in shop template
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
			<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
				<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
			<?php endif; ?>

			<?php
				if ( function_exists('yoast_breadcrumb') ) {
					yoast_breadcrumb( '<div id="breadcrumbs" class="breadcrumbs">','</div>' );
				}
			?>
		</div>
	</div>
</div>
