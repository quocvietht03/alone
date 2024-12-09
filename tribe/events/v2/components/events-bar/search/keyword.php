<?php
/**
 * View: Events Bar Search Keyword Input
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events/v2/components/events-bar/search/keyword.php
 *
 * See more documentation about our views templating system.
 *
 * @link http://evnt.is/1aiy
 *
 * @var array $bar The search bar contents.
 *
 * @version 5.3.0
 *
 */

/* translators: %s: events (plural). */
if (ICL_LANGUAGE_CODE == "ar") {
	$placeholder = sprintf( __( 'البحث عن الأحداث', 'the-events-calendar' ), tribe_get_event_label_plural_lowercase() );
}else{
	$placeholder = sprintf( __( 'Search for %s', 'the-events-calendar' ), tribe_get_event_label_plural_lowercase() );
}

/* translators: %s: events (plural). */


if (ICL_LANGUAGE_CODE == "ar") {
	$aria_label = sprintf( __( 'أدخل الكلمة الرئيسية. ابحث عن الأحداث باستخدام الكلمة الرئيسية.', 'the-events-calendar' ), tribe_get_event_label_plural_lowercase() );
}else{
	$aria_label = sprintf( __( 'Enter Keyword. Search for %s by Keyword.', 'the-events-calendar' ), tribe_get_event_label_plural_lowercase() );
}
?>
<div
	class="tribe-common-form-control-text tribe-events-c-search__input-control tribe-events-c-search__input-control--keyword"
	data-js="tribe-events-events-bar-input-control"
>
	<label class="tribe-common-form-control-text__label" for="tribe-events-events-bar-keyword">
		<?php 
		if (ICL_LANGUAGE_CODE == "ar") {
			printf( esc_html__( 'أدخل الكلمة الرئيسية. ابحث عن الأحداث باستخدام الكلمة الرئيسية.', 'the-events-calendar' ), tribe_get_event_label_plural() ); 
		}else{
			printf( esc_html__( 'Enter Keyword. Search for %s by Keyword.', 'the-events-calendar' ), tribe_get_event_label_plural() );
		}
		?>
	</label>
	<input
		class="tribe-common-form-control-text__input tribe-events-c-search__input"
		data-js="tribe-events-events-bar-input-control-input"
		type="text"
		id="tribe-events-events-bar-keyword"
		name="tribe-events-views[tribe-bar-search]"
		value="<?php echo esc_attr( tribe_events_template_var( [ 'bar', 'keyword' ], '' ) ); ?>"
		placeholder="<?php echo esc_attr( $placeholder ); ?>"
		aria-label="<?php echo esc_attr( $aria_label ); ?>"
	/>
	<?php $this->template( 'components/icons/search', [ 'classes' => [ 'tribe-events-c-search__input-control-icon-svg' ] ] ); ?>
</div>
