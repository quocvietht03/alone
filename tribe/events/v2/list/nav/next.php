<?php
/**
 * View: List View Nav Next Button
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events/v2/list/nav/next.php
 *
 * See more documentation about our views templating system.
 *
 * @link http://evnt.is/1aiy
 *
 * @var string $link The URL to the next page.
 *
 * @version 5.3.0
 *
 */

/* translators: %s: Event (plural or singular). */
$label = sprintf( __( 'Next %1$s', 'alone' ), tribe_get_event_label_plural() );
if ( function_exists( 'icl_object_id' ) ) {
	if (ICL_LANGUAGE_CODE == "ar") {
		$label = sprintf( __( 'الأحداث القادمة', 'alone' ), tribe_get_event_label_plural() );
	} else {
		$label = sprintf( __( 'Next %1$s', 'alone' ), tribe_get_event_label_plural() );
	}
} else {
	$label = sprintf( __( 'Next %1$s', 'alone' ), tribe_get_event_label_plural() );
}

/* translators: %s: Event (plural or singular). */
if ( function_exists( 'icl_object_id' ) ) {
	if (ICL_LANGUAGE_CODE == "ar") {
		$events_mobile_friendly_label = sprintf( __( 'الأحداث القادمة', 'alone' ), '<span class="tribe-events-c-nav__next-label-plural tribe-common-a11y-visual-hide">' . tribe_get_event_label_plural() . '</span>' );
	} else {
		$events_mobile_friendly_label = sprintf( __( 'Next %1$s', 'alone' ), '<span class="tribe-events-c-nav__next-label-plural tribe-common-a11y-visual-hide">' . tribe_get_event_label_plural() . '</span>' );
	}
} else {
	$events_mobile_friendly_label = sprintf( __( 'Next %1$s', 'alone' ), '<span class="tribe-events-c-nav__next-label-plural tribe-common-a11y-visual-hide">' . tribe_get_event_label_plural() . '</span>' );
}
?>
<li class="tribe-events-c-nav__list-item tribe-events-c-nav__list-item--next">
	<a
		href="<?php echo esc_url( $link ); ?>"
		rel="next"
		class="tribe-events-c-nav__next tribe-common-b2 tribe-common-b1--min-medium"
		data-js="tribe-events-view-link"
		aria-label="<?php echo esc_attr( $label ); ?>"
		title="<?php echo esc_attr( $label ); ?>"
	>
		<span class="tribe-events-c-nav__next-label">
			<?php echo wp_kses( $events_mobile_friendly_label, [ 'span' => [ 'class' => [] ] ] ); ?>
		</span>
		<?php $this->template( 'components/icons/caret-right', [ 'classes' => [ 'tribe-events-c-nav__next-icon-svg' ] ] ); ?>
	</a>
</li>
