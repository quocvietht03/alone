<?php
/**
 * Default Events Template
 * This file is the basic wrapper template for all the views if 'Default Events Template'
 * is selected in Events -> Settings -> Display -> Events Template.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/default-template.php
 *
 * @package TribeEventsCalendar
 * @version 4.6.23
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

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
			<main id="tribe-events-pg-template" class="tribe-events-pg-template">
				<?php tribe_events_before_html(); ?>
				<?php tribe_get_view(); ?>
				<?php tribe_events_after_html(); ?>
			</main> <!-- #tribe-events-pg-template -->

		</div>
	</div><!-- #primary -->
</div><!-- #content -->

<?php
get_footer();
