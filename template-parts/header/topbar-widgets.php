<?php
/**
 * Displays the header widget area
 *
 * @package WordPress
 * @subpackage Alone
 * @since Alone 7.0
 */

if ( is_active_sidebar( 'topbar-sidebar' ) ) : ?>

	<aside class="widget-area" role="complementary" aria-label="<?php esc_attr_e( 'Topbar', 'alone' ); ?>">
		<div class="container">
			<div class="topbar-widget-wrap">
				<?php dynamic_sidebar( 'topbar-sidebar' ); ?>
			</div>
		</div>
	</aside><!-- .widget-area -->

<?php endif; ?>
