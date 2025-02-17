<?php
use Give\Helpers\Form\Template;

$post_id          = get_the_ID();
$form_id          = get_field('give_form', $post_id);
$raw_content      = ''; // Raw form content.
$stripped_content = ''; // Form content stripped of HTML tags and shortcodes.
$excerpt          = ''; // Trimmed form excerpt ready for display.
$excerpt_length   = 25;

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'donations-give-form-wrap' ); ?>>

	<?php
	// Maybe display the featured image.
	printf(
		'<div class="give-card__media">%s</div>',
		get_the_post_thumbnail( $post_id, 'medium' )
	);

	?>

	<div class="give-card__body">
		<?php


		// Maybe display the goal progess bar.
		if ( give_is_setting_enabled( get_post_meta( $form_id, '_give_goal_option', true ) ) ) {
				give_show_goal_progress( $form_id );
		}

		// Maybe display the form title.
		printf(
			'<h3 class="give-card__title">
				<a href="%s">%s</a>
			</h3>',
			get_the_permalink(),
			get_the_title()
		);

		// Maybe display the form excerpt.
		if ( has_excerpt( $post_id ) ) {
			// Get excerpt from the form post's excerpt field.
			$raw_content      = get_the_excerpt( $form_id );
			$stripped_content = wp_strip_all_tags(
				strip_shortcodes( $raw_content )
			);
		} else {
			// Get content from the form post's content field.
			$raw_content = get_the_content($post_id);

			if ( ! empty( $raw_content ) ) {
				$stripped_content = wp_strip_all_tags(
					strip_shortcodes( $raw_content )
				);
			}
		}

		// Maybe truncate excerpt.
		if ( 0 < $excerpt_length ) {
			$excerpt = wp_trim_words( $stripped_content, $excerpt_length );
		} else {
			$excerpt = $stripped_content;
		}

		printf( '<p class="give-card__text">%s</p>', $excerpt );

		if( !Template::getActiveID($form_id) ) {
			echo do_shortcode('[give_form id="' . $form_id . '" display_style="modal" continue_button_title="' . esc_html__( 'Donate Now', 'alone' ) . '"]');
		} else {
			// Maybe display the form donate button.
			$atts = array(
				'id' => $form_id,  // integer.
				'show_title' => false, // boolean.
				'show_goal' => false, // boolean.
				'show_content' => 'none', //above, below, or none
				'display_style' => 'button', //modal, button, and reveal
				'continue_button_title' => esc_html__( 'Donate Now', 'alone' ) //string

			);

			echo give_get_donation_form( $atts );
		}

		?>
	</div>

</article>
