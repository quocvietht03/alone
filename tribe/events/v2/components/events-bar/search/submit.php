<?php
/**
 * View: Events Bar Search Submit Input
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events/v2/components/events-bar/search/submit.php
 *
 * See more documentation about our views templating system.
 *
 * @link http://evnt.is/1aiy
 *
 * @version 4.9.10
 *
 */
?>
<button
	class="tribe-common-c-btn tribe-events-c-search__button"
	type="submit"
	name="submit-bar"
>
	<?php 
	if ( function_exists( 'icl_object_id' ) ) {
		if (ICL_LANGUAGE_CODE == "ar") {
			printf( esc_html__( 'البحث عن الأحداث', 'alone' ), tribe_get_event_label_plural() ); 
		} else {
			printf( esc_html__( 'Find %s', 'alone' ), tribe_get_event_label_plural() ); 
		}
	} else {
		printf( esc_html__( 'Find %s', 'alone' ), tribe_get_event_label_plural() ); 
	}
	?>
</button>
