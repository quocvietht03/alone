<?php
/**
 * Displays the footer widget area
 *
 * @package WordPress
 * @subpackage Alone
 * @since Alone 7.0
 */

if ( is_active_sidebar( 'footer-sidebar' ) ) : ?>

	<aside class="widget-area" role="complementary" aria-label="<?php esc_attr_e( 'Footer', 'alone' ); ?>">
		<div class="container responsive">
			<div class="footer-widget-wrap">
				<?php dynamic_sidebar( 'footer-sidebar' ); ?>
			</div>
		</div>
	</aside><!-- .widget-area -->

<?php endif; ?>
