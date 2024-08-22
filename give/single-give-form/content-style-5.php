<?php

$form_id = get_the_ID();

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'give-form-wrap' ); ?>>

  <div class="give-header-ss">

    <div class="container responsive">
      <div class="give-header-inner">
        <ul class="give-meta">
          <li class="give-published">
            <?php if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) { ?>
              <?php echo alone_get_icon_svg( 'give-calendar', 16 ); ?>
              <time class="updated" datetime="<?php echo esc_attr( get_the_modified_date( DATE_W3C ) ); ?>"><?php echo get_the_modified_date(); ?></time>
            <?php } else { ?>
              <?php echo alone_get_icon_svg( 'give-calendar', 16 ); ?>
              <time class="give-date published" datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo get_the_date(); ?></time>
            <?php } ?>
          </li>
          <?php the_terms( $form_id, 'give_forms_category', '<li class="give-category">' . esc_html__('Project In: ', 'alone'), ',', '</li>' ); ?>
        </ul>

        <?php the_title( '<h1 class="give-title">', '</h1>' ); ?>
      </div>
    </div>

  </div>

	<div class="give-content-ss">
    <div class="container responsive">
      <div class="give-content-wrap">
        <div class="give-content-col">
          <div class="give-media">
            <?php the_post_thumbnail('full'); ?>
          </div>

          <?php give_form_display_content( $form_id, $args = array() ); ?>

          <div class="give-form-content-footer">
            <?php the_terms( $form_id, 'give_forms_tag', '<div class="give-tag-links"><span>'. esc_html__('Tags: ', 'alone') .'</span>', '', '</div>' ); ?>

            <?php
              /**
               * Hook: alone_entry_share_socials
               *
               * @hooked alone_share_socials_wrapper_start - 10
               * @hooked alone_share_socials_content - 20
               * @hooked alone_share_socials_wrapper_end - 40
               */
              do_action( 'alone_entry_share_socials' );
            ?>
          </div>

        </div>

        <div class="give-form-col">
          <div class="give-form-side-wrap give-goal-wrap">
            <?php
              echo '<div class="give-goal-subtitle">' . esc_html__('Join Us', 'alone') . '</div>';
              echo '<h2 class="give-form-title give-goal-title">' . esc_html__('We Need Your Help', 'alone') . '</h2>';

              // Maybe display the goal progess bar.
          		if ( give_is_setting_enabled( get_post_meta( $form_id, '_give_goal_option', true ) ) ) {
          				give_show_goal_progress( $form_id );
          		}

              // Maybe display the form donate button.
              $atts = array(
          			'id' => $form_id,  // integer.
          			'show_title' => false, // boolean.
          			'show_goal' => false, // boolean.
          			'show_content' => 'none', //above, below, or none
          			'display_style' => 'button', //modal, button, and reveal
          			'continue_button_title' => esc_html__( 'Donate Now', 'alone' ) //string

          		);

          		echo '<div>' . give_get_donation_form( $atts ) . '</div>';
            ?>
          </div>

          <div class="give-form-side-wrap give-donor-wall-top">
            <?php
              echo '<h2 class="give-form-title give-donor-wall_title">' . esc_html__('Top 3 Donations', 'alone') . '</h2>';
              echo do_shortcode('[give_donor_wall columns="1" orderby="donation_amount" donors_per_page="3" show_total="true" show_comments="false"]');
            ?>
          </div>

          <div class="give-form-side-wrap give-donor-wall-recent">
            <?php
              echo '<h2 class="give-form-title give-donor-wall_title">' . esc_html__('Recent Donations', 'alone') . '</h2>';
              echo do_shortcode('[give_donor_wall columns="1" donors_per_page="5" show_total="true" show_comments="false"]');
            ?>
          </div>
        </div>
      </div>
    </div>
	</div>
</article>
