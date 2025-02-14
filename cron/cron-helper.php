<?php
function alone_events_cron_exec() {
  $wp_query = new \WP_Query( array(
                          'post_type' => 'tribe_events',
                          'post_status' => 'publish',
                          'posts_per_page' => -1
                        ) );

  if ( $wp_query->have_posts() ) {
    while ( $wp_query->have_posts() ) {
      $wp_query->the_post();



      $start_date = get_post_meta( get_the_ID(), '_EventStartDate', true);
      $end_date = get_post_meta( get_the_ID(), '_EventEndDate', true);
      
      $today = date('Y-m-d H:i:s');

      if ($start_date < $today) {
        $start_date = date_create($start_date);
        date_add($start_date, date_interval_create_from_date_string('365 days'));
        $start_date = date_format($start_date, 'Y-m-d H:i:s');

        $end_date = date_create($end_date);
        date_add($end_date, date_interval_create_from_date_string('365 days'));
        $end_date = date_format($end_date, 'Y-m-d H:i:s');

        update_post_meta(get_the_ID(), '_EventStartDate', $start_date);
        update_post_meta(get_the_ID(), '_EventEndDate', $end_date);

      }
    }
  }

}
add_action('alone_events_cron_hook', 'alone_events_cron_exec');