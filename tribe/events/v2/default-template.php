<?php
/**
 * View: Default Template for Events
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events/v2/default-template.php
 *
 * See more documentation about our views templating system.
 *
 * @link http://m.tri.be/1aiy
 *
 * @version 5.0.0
 */

use Tribe\Events\Views\V2\Template_Bootstrap;

get_header();

/**
* Hook: alone_tribe_events_page_titlebar_archive
*
* @hooked alone_tribe_events_page_titlebar_archive_template - 10
*/
do_action( 'alone_tribe_events_page_titlebar_archive' );

$classes = 'archive-tribe-events-template';
if( is_singular( 'tribe_events' ) ) {
	$classes = 'single-tribe-events-template';
}

?>

<div id="content" class="site-content">
	<div id="primary" class="content-area <?php echo esc_attr($classes); ?>">
		<div class="container responsive">
			<main id="main" class="site-main">
				<?php echo tribe( Template_Bootstrap::class )->get_view_html(); ?>
			</main><!-- .site-main -->

		</div>
	</div><!-- #primary -->
</div><!-- #content -->

<?php

get_footer();
