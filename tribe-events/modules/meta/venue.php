<?php
/**
 * Single Event Meta (Venue) Template
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe-events/modules/meta/venue.php
 *
 * @package TribeEventsCalendar
 * @version 4.6.19
 */

if ( ! tribe_get_venue_id() ) {
	return;
}

$phone   = tribe_get_phone();
$website = tribe_get_venue_website_link();

?>

<div class="tribe-events-meta-group tribe-events-meta-group-venue">
	<h2 class="tribe-events-single-section-title"> <?php esc_html_e( tribe_get_venue_label_singular(), 'the-events-calendar' ) ?> </h2>
	<div class="tribe-events-meta-list">
		<?php do_action( 'tribe_events_single_meta_venue_section_start' ) ?>

		<div class="tribe-events-meta-item">
			<span class="tribe-venue"> <?php echo tribe_get_venue() ?> </span>
		</div>

		<?php if ( tribe_address_exists() ) : ?>
			<div class="tribe-events-meta-item">
				<span class="tribe-venue-location">
					<address class="tribe-events-address">
						<?php echo tribe_get_full_address(); ?>

						<?php if ( tribe_show_google_map_link() ) : ?>
							<?php echo tribe_get_map_link_html(); ?>
						<?php endif; ?>
					</address>
				</span>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $phone ) ): ?>
			<div class="tribe-events-meta-item">
				<span class="tribe-venue-tel-label tribe-meta-label"> <?php esc_html_e( 'Phone:', 'the-events-calendar' ) ?> </span>
				<span class="tribe-venue-tel"> <?php echo $phone ?> </span>
			</div>
		<?php endif ?>

		<?php if ( ! empty( $website ) ): ?>
			<div class="tribe-events-meta-item">
				<span class="tribe-venue-url-label tribe-meta-label"> <?php esc_html_e( 'Website:', 'the-events-calendar' ) ?> </span>
				<span class="tribe-venue-url"> <?php echo $website ?> </span>
			</div>
		<?php endif ?>

		<?php do_action( 'tribe_events_single_meta_venue_section_end' ) ?>

	</div>

</div>
