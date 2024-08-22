<?php
/**
 * Single Event Meta (Organizer) Template
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe-events/modules/meta/organizer.php
 *
 * @package TribeEventsCalendar
 * @version 4.6.19
 */

$organizer_ids = tribe_get_organizer_ids();
$multiple = count( $organizer_ids ) > 1;

$phone = tribe_get_organizer_phone();
$email = tribe_get_organizer_email();
$website = tribe_get_organizer_website_link();
?>

<div class="tribe-events-meta-group tribe-events-meta-group-organizer">
	<h2 class="tribe-events-single-section-title"><?php echo tribe_get_organizer_label( ! $multiple ); ?></h2>
	<div class="tribe-events-meta-list">
		<?php
		do_action( 'tribe_events_single_meta_organizer_section_start' );

		foreach ( $organizer_ids as $organizer ) {
			if ( ! $organizer ) {
				continue;
			}

			?>
			<div class="tribe-events-meta-item">
				<span style="display:none;"><?php // This element is just to make sure we have a valid HTML ?></span>
				<span class="tribe-organizer">
					<?php echo tribe_get_organizer_link( $organizer ) ?>
				</span>
			</div>
			<?php
		}

		if ( ! $multiple ) { // only show organizer details if there is one
			if ( ! empty( $phone ) ) {
				?>
				<div class="tribe-events-meta-item">
					<span class="tribe-organizer-tel-label tribe-meta-label">
						<?php esc_html_e( 'Phone:', 'the-events-calendar' ) ?>
					</span>
					<span class="tribe-organizer-tel">
						<?php echo esc_html( $phone ); ?>
					</span>
				</div>
				<?php
			}//end if

			if ( ! empty( $email ) ) {
				?>
				<div class="tribe-events-meta-item">
					<span class="tribe-organizer-email-label tribe-meta-label">
						<?php esc_html_e( 'Email:', 'the-events-calendar' ) ?>
					</span>
					<span class="tribe-organizer-email">
						<?php echo esc_html( $email ); ?>
					</span>
				</div>
				<?php
			}//end if

			if ( ! empty( $website ) ) {
				?>
				<div class="tribe-events-meta-item">
					<span class="tribe-organizer-url-label tribe-meta-label">
						<?php esc_html_e( 'Website:', 'the-events-calendar' ) ?>
					</span>
					<span class="tribe-organizer-url">
						<?php echo $website; ?>
					</span>
				</div>
				<?php
			}//end if
		}//end if

		do_action( 'tribe_events_single_meta_organizer_section_end' );
		?>

	</div>

</div>
