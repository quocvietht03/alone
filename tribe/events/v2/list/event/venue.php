<?php
/**
 * View: List Single Event Venue
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events/v2/list/event/venue.php
 *
 * See more documentation about our views templating system.
 *
 * @link http://m.tri.be/1aiy
 *
 * @version 4.9.11
 *
 * @var WP_Post $event The event post object with properties added by the `tribe_get_event` function.
 *
 * @see tribe_get_event() For the format of the event object.
 */

if ( ! $event->venues->count() ) {
	return;
}

$separator            = esc_html_x( ', ', 'Address separator', 'alone' );
$venue                = $event->venues[0];
$append_after_address = array_filter( array_map( 'trim', [ $venue->city, $venue->state_province, $venue->state, $venue->province ] ) );
$address              = $venue->address . ( $venue->address && $append_after_address ? $separator : '' );
?>
<address class="tribe-events-calendar-list__event-venue tribe-common-b2">
	<?php echo alone_get_icon_svg( 'tribe-map-marker', 16 ); ?>
	<span class="tribe-events-calendar-list__event-venue-title tribe-common-b2--bold">
		<?php echo wp_kses_post( $venue->post_title ); ?>
	</span>
	<span class="tribe-events-calendar-list__event-venue-address">
		<?php echo esc_html( $address ); ?>
		<?php if ( $append_after_address ) : ?>
			<?php echo esc_html( reset( $append_after_address ) ); ?>
		<?php endif; ?>
	</span>
</address>
