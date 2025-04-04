<?php
/**
 * Single Event Meta (Details) Template
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe-events/modules/meta/details.php
 *
 * @package TribeEventsCalendar
 * @version 4.6.19
 */


$event_id             = Tribe__Main::post_id_helper();
$time_format          = get_option( 'time_format', Tribe__Date_Utils::TIMEFORMAT );
$time_range_separator = tribe_get_option( 'timeRangeSeparator', ' - ' );
$show_time_zone       = tribe_get_option( 'tribe_events_timezones_show_zone', false );
$time_zone_label      = Tribe__Events__Timezones::get_event_timezone_abbr( $event_id );

$start_datetime = tribe_get_start_date();
$start_date = tribe_get_start_date( null, false );
$start_time = tribe_get_start_date( null, false, $time_format );
$start_ts = tribe_get_start_date( null, false, Tribe__Date_Utils::DBDATEFORMAT );

$end_datetime = tribe_get_end_date();
$end_date = tribe_get_display_end_date( null, false );
$end_time = tribe_get_end_date( null, false, $time_format );
$end_ts = tribe_get_end_date( null, false, Tribe__Date_Utils::DBDATEFORMAT );

$time_formatted = null;
if ( $start_time == $end_time ) {
	$time_formatted = esc_html( $start_time );
} else {
	$time_formatted = esc_html( $start_time . $time_range_separator . $end_time );
}

/**
 * Returns a formatted time for a single event
 *
 * @var string Formatted time string
 * @var int Event post id
 */
$time_formatted = apply_filters( 'tribe_events_single_event_time_formatted', $time_formatted, $event_id );

/**
 * Returns the title of the "Time" section of event details
 *
 * @var string Time title
 * @var int Event post id
 */
$time_title = apply_filters( 'tribe_events_single_event_time_title', __( 'Time:', 'alone' ), $event_id );

$cost    = tribe_get_formatted_cost();
$website = tribe_get_event_website_link();
?>

<div class="tribe-events-meta-group tribe-events-meta-group-details">
	<h2 class="tribe-events-single-section-title"> <?php esc_html_e( 'Details', 'alone' ); ?> </h2>
	<div class="tribe-events-meta-list">

		<?php
		do_action( 'tribe_events_single_meta_details_section_start' );

		// All day (multiday) events
		if ( tribe_event_is_all_day() && tribe_event_is_multiday() ) :
			?>

			<div class="tribe-events-meta-item">
				<span class="tribe-events-start-date-label tribe-meta-label"><?php esc_html_e( 'Start:', 'alone' ); ?></span>
				<span class="tribe-events-abbr tribe-events-start-date published dtstart" title="<?php echo esc_attr( $start_ts ); ?>"> <?php echo esc_html( $start_date ); ?> </span>
			</div>

			<div class="tribe-events-meta-item">
				<span class="tribe-events-end-date-label tribe-meta-label"><?php esc_html_e( 'End:', 'alone' ); ?></span>
				<span class="tribe-events-abbr tribe-events-end-date dtend" title="<?php echo esc_attr( $end_ts ); ?>"> <?php echo esc_html( $end_date ); ?> </span>
			</div>

		<?php
		// All day (single day) events
		elseif ( tribe_event_is_all_day() ):
			?>
			<div class="tribe-events-meta-item">
				<span class="tribe-events-start-date-label tribe-meta-label"> <?php esc_html_e( 'Date:', 'alone' ); ?> </span>
				<span class="tribe-events-abbr tribe-events-start-date published dtstart" title="<?php echo esc_attr( $start_ts ); ?>"> <?php echo esc_html( $start_date ); ?> </span>
			</div>

		<?php
		// Multiday events
		elseif ( tribe_event_is_multiday() ) :
			?>
			<div class="tribe-events-meta-item">
				<span class="tribe-events-start-datetime-label tribe-meta-label"> <?php esc_html_e( 'Start:', 'alone' ); ?> </span>
				<span class="tribe-events-abbr tribe-events-start-datetime updated published dtstart" title="<?php echo esc_attr( $start_ts ); ?>"> <?php echo esc_html( $start_datetime ); ?> </span>
				<?php if ( $show_time_zone ) : ?>
					<span class="tribe-events-abbr tribe-events-time-zone published "><?php echo esc_html( $time_zone_label ); ?></span>
				<?php endif; ?>
			</div>

			<div class="tribe-events-meta-item">
				<span class="tribe-events-end-datetime-label tribe-meta-label"> <?php esc_html_e( 'End:', 'alone' ); ?> </span>
				<span class="tribe-events-abbr tribe-events-end-datetime dtend" title="<?php echo esc_attr( $end_ts ); ?>"> <?php echo esc_html( $end_datetime ); ?> </span>
				<?php if ( $show_time_zone ) : ?>
					<span class="tribe-events-abbr tribe-events-time-zone published "><?php echo esc_html( $time_zone_label ); ?></span>
				<?php endif; ?>
			</div>

		<?php
		// Single day events
		else :
			?>
			<div class="tribe-events-meta-item">
				<span class="tribe-events-start-date-label tribe-meta-label"> <?php esc_html_e( 'Date:', 'alone' ); ?> </span>
				<span class="tribe-events-abbr tribe-events-start-date published dtstart" title="<?php echo esc_attr( $start_ts ); ?>"> <?php echo esc_html( $start_date ); ?> </span>
			</div>

			<div class="tribe-events-meta-item">
				<span class="tribe-events-start-time-label tribe-meta-label"> <?php echo esc_html( $time_title ); ?> </span>
				<div class="tribe-events-abbr tribe-events-start-time published dtstart" title="<?php echo esc_attr( $end_ts ); ?>">
					<?php echo esc_html($time_formatted); ?>
					<?php if ( $show_time_zone ) : ?>
						<span class="tribe-events-abbr tribe-events-time-zone published "><?php echo esc_html( $time_zone_label ); ?></span>
					<?php endif; ?>
				</div>
			</div>

		<?php endif ?>

		<?php
		// Event Cost
		if ( ! empty( $cost ) ) : ?>
			<div class="tribe-events-meta-item">
				<span class="tribe-events-event-cost-label tribe-meta-label"> <?php esc_html_e( 'Cost:', 'alone' ); ?> </span>
				<span class="tribe-events-event-cost"> <?php echo esc_html( $cost ); ?> </span>
			</div>
		<?php endif ?>

		<?php
		the_terms(
			$event_id,
			'tribe_events_cat',
			'<div class="tribe-events-meta-item"><span class="tribe-events-event-categories-label tribe-meta-label">' . esc_html__( 'Event Category:', 'alone' ) . '</span><span class="tribe-events-event-categories">',
			', ',
			'</span></div>'
		);
		?>

		<?php
		the_terms(
			$event_id,
			'post_tag',
			'<div class="tribe-events-meta-item"><span class="tribe-events-event-categories-label tribe-meta-label">' . esc_html__( 'Event Tags:', 'alone' ) . '</span><span class="tribe-events-event-categories">',
			', ',
			'</span></div>'
		);
		?>

		<?php
		// Event Website
		if ( ! empty( $website ) ) : ?>
			<div class="tribe-events-meta-item">
				<span class="tribe-events-event-url-label tribe-meta-label"> <?php esc_html_e( 'Website:', 'alone' ); ?> </span>
				<?php echo '<span class="tribe-events-event-url">' . $website . '</span>'; ?> 
			</div>
		<?php endif ?>

		<?php do_action( 'tribe_events_single_meta_details_section_end' ); ?>

	</div>

</div>
