<?php
function alone_events_cron_exec()
{
    $args_cron = [
        'posts_per_page' => -1,
    ];

    $events_cron = tribe_get_events($args_cron);
    if (!empty($events_cron)) {
        foreach ($events_cron as $event_cron) {

            $event_id = $event_cron->ID;

            $start_date = get_post_meta($event_id, '_EventStartDate', true);
            $end_date = get_post_meta($event_id, '_EventEndDate', true);

            if (empty($start_date) || empty($end_date)) {
                continue;
            }
            $new_start_date = date_create($start_date);
            date_add($new_start_date, date_interval_create_from_date_string('7 days'));
            $new_start_date = date_format($new_start_date, 'Y-m-d H:i:s');

            $new_end_date = date_create($end_date);
            date_add($new_end_date, date_interval_create_from_date_string('7 days'));
            $new_end_date = date_format($new_end_date, 'Y-m-d H:i:s');

            update_post_meta($event_id, '_EventStartDate', $new_start_date);
            update_post_meta($event_id, '_EventEndDate', $new_end_date);
            update_post_meta($event_id, '_EventStartDateUTC', $new_start_date);
            update_post_meta($event_id, '_EventEndDateUTC', $new_end_date);
        }
    }
}
add_action('alone_events_cron_hook', 'alone_events_cron_exec');


function alone_donations_cron_exec()
{
    $args = array(
        'number' => 100,
    );
    $donor_query = new Give_Donors_Query($args);
    $donor_query = $donor_query->get_donors();
    $payment_arr = array();
    $specific_date = '2025-01-01 00:00:00';
    if(is_rtl()) {
        $specific_date = '2025-10-01 00:00:00';
    }
    if ($donor_query) {
        foreach ($donor_query as $donor) {
            if ($donor->date_created > $specific_date) {
                $payment_arr = explode(',', $donor->payment_ids);
                foreach ($payment_arr as $payment_id) {
                    give_delete_donation($payment_id);
                }
                Give()->donors->delete($donor->id);
            } else {
                $payment_arr = explode(',', $donor->payment_ids);
                foreach ($payment_arr as $payment_id) {
                    $payment = get_post($payment_id);
                    if ($payment && $payment->post_date > $specific_date) {
                        give_delete_donation($payment_id);
                    }
                }
            }
        }
    }
}
add_action('alone_donations_cron_hook', 'alone_donations_cron_exec');
