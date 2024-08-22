<?php

$events_label_singular = tribe_get_event_label_singular();
$events_label_plural   = tribe_get_event_label_plural();

$event_id = get_the_ID();

?>

<div id="tribe-events-content" class="tribe-events-single">

	<?php while ( have_posts() ) :  the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="tribe-events-single-event-details <?php echo has_post_thumbnail() ? 'has-thumbnail': ''; ?>">
				<!-- Event featured image, but exclude link -->
				<?php if ( has_post_thumbnail() ) { ?>
					<div class="tribe-events-single-event-image-wrap">
						<div class="tribe-events-single-event-image">
							<?php
									// Maybe display the featured image.
									echo get_the_post_thumbnail( $event_id, 'full' );
							?>
						</div>
					</div>
				<?php } ?>

				<div class="tribe-events-single-event-content-wrap">
					<p class="tribe-events-back">
						<a href="<?php echo esc_url( tribe_get_events_link() ); ?>"> <?php printf( alone_get_icon_svg( 'tribe-arrow-left', 12 ) . esc_html_x( 'All %s', '%s Events plural label', 'the-events-calendar' ), $events_label_plural ); ?></a>
					</p>

					<!-- Notices -->
					<?php tribe_the_notices() ?>

					<?php the_title( '<h1 class="tribe-events-single-event-title">', '</h1>' ); ?>

					<div class="tribe-events-single-event-schedule tribe-clearfix">
						<?php echo alone_get_icon_svg( 'tribe-clock', 16 ) . tribe_events_event_schedule_details( $event_id ); ?>
					</div>

					<!-- Event content -->
					<?php do_action( 'tribe_events_single_event_before_the_content' ) ?>
					<div class="tribe-events-single-event-description tribe-events-content">
						<?php the_content(); ?>
					</div>

					<!-- .tribe-events-single-event-cost -->
					<?php if ( tribe_get_cost() ) : ?>
						<div class="tribe-events-single-event-cost"><?php echo tribe_get_cost( null, true ) ?></div>
					<?php endif; ?>

					<!-- .tribe-events-single-event-description -->
					<?php do_action( 'tribe_events_single_event_after_the_content' ) ?>

				</div>
			</div>

			<!-- Event meta -->
			<?php do_action( 'tribe_events_single_event_before_the_meta' ) ?>
			<?php tribe_get_template_part( 'modules/meta' ); ?>
			<?php do_action( 'tribe_events_single_event_after_the_meta' ) ?>

		</article> <!-- #post-x -->
		<?php if ( get_post_type() == Tribe__Events__Main::POSTTYPE && tribe_get_option( 'showComments', false ) ) comments_template() ?>
	<?php endwhile; ?>

	<!-- Event footer -->
	<div id="tribe-events-footer">
		<!-- Navigation -->
		<nav class="tribe-events-nav-pagination" aria-label="<?php printf( esc_html__( '%s Navigation', 'the-events-calendar' ), $events_label_singular ); ?>">
			<ul class="tribe-events-sub-nav">
				<li class="tribe-events-nav-previous"><?php tribe_the_prev_event_link( alone_get_icon_svg( 'tribe-arrow-left', 16 ) . ' %title%' ) ?></li>
				<li class="tribe-events-nav-next"><?php tribe_the_next_event_link( '%title% ' . alone_get_icon_svg( 'tribe-arrow-right', 16 ) ) ?></li>
			</ul>
			<!-- .tribe-events-sub-nav -->
		</nav>
	</div>
	<!-- #tribe-events-footer -->

</div><!-- #tribe-events-content -->
