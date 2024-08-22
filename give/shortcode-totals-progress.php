<?php
/**
 * This template is used to display the progress of [give_totals]
 */

// Bail out if total goal is empty.
if ( empty( $total_goal ) ) {
	return false;
}

// Set Give total progress bar color.
$color = apply_filters( 'give_totals_progress_color', '#2bc253' );

// Give total.
$total = ! empty( $total ) ? $total : 0;

/**
 * Filter the goal progress output
 *
 * @since 2.1
 */
$progress = round( ( $total / $total_goal ) * 100, 2 );

// Set progress to 100 percentage if total > total_goal
$progress = $total >= $total_goal ? 100 : $progress;
$progress = apply_filters( 'give_goal_totals_funded_percentage_output', $progress, $total, $total_goal );

$data_attr = 'class="give-card__progress"';

if( 1 === absint( alone_get_option( 'custom_goal_progress' ) ) ) {
	$easing = alone_get_option( 'goal_progress_easing' );
	$duration = absint( alone_get_option( 'goal_progress_duration' ) );
	$color = alone_get_option( 'goal_progress_color' );
	$trailcolor = alone_get_option( 'goal_progress_trailcolor' );

	$data_progressbar = array(
		'type' => 'line',
		'strokewidth' => 4,
		'easing' => $easing,
		'duration' => $duration,
		'color' => $color['from'],
		'trailcolor' => $trailcolor,
		'trailwidth' => 1,
		'tocolor' => $color['to'],
		'width' => '100%',
		'height' => '12px',
	);

	$data_attr = 'class="give-card__progress give-card__progress-custom"';

	foreach ($data_progressbar as $key => $value) {
		$data_attr .= ' data-' . $key . '="' . esc_attr( $value ) . '"';
	}
}


echo '<div ' . $data_attr . '>';
?>
	<div class="give-goal-progress">
		<div class="raised">
			<?php
			echo sprintf(
				/* translators: %s: percentage of the amount raised compared to the goal target */
				__( '<span class="give-percentage">%s%%</span> funded', 'give' ),
				round( $progress )
			);
			?>
		</div>

		<div class="give-progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100"
			 aria-valuenow="<?php echo esc_attr( $progress ); ?>">
				<span style="width: <?php echo esc_attr( $progress ); ?>%;
												<?php
												if ( ! empty( $color ) ) {
													echo 'background-color:' . $color;
												}
												?>
				"></span>
		</div><!-- /.give-progress-bar -->

	</div><!-- /.goal-progress -->

<?php
echo '</div>';
