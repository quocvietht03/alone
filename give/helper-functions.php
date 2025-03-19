<?php
/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function alone_give_widgets_init() {

	register_sidebar(
		array(
			'name'          => __( 'Give', 'alone' ),
			'id'            => 'give-sidebar',
			'description'   => __( 'Add widgets here to appear in your give.', 'alone' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

}
add_action( 'widgets_init', 'alone_give_widgets_init' );



/**
 * Enqueue scripts and styles.
 */
function alone_give_scripts() {
	wp_enqueue_style( 'alone-give-style', get_template_directory_uri() . '/css/give.css', array(), wp_get_theme()->get( 'Version' ) );

	wp_add_inline_style( 'alone-give-style', alone_give_theme_custom_style() );

	wp_register_script( 'alone-waypoint', get_theme_file_uri( '/js/waypoints.min.js' ), array(), '', true );
	wp_register_script( 'alone-progressbar', get_theme_file_uri( '/js/progressbar.min.js' ), array(), '', true );
	wp_enqueue_script( 'alone-give', get_theme_file_uri( '/js/give.js' ), array( 'alone-waypoint', 'alone-progressbar' ), '20200828', true );
}
add_action( 'wp_enqueue_scripts', 'alone_give_scripts' );

/**
 * Display custom style in customizer and on frontend.
 */
function alone_give_theme_custom_style() {
	// Not include custom style in admin.
	if ( is_admin() ) {
		return;
	}

	$theme_styles = '';

	if ( 'default' !== alone_get_option('custom_colors') || 199 !== absint( alone_get_option('main_color') ) ) {
		// Colors
		require_once get_parent_theme_file_path( '/give/color-patterns.php' );
		$theme_styles .= alone_give_custom_colors_css();

	}

	/**
	 * Filters Alone custom theme styles.
	 *
	 * @since Alone 7.0
	 *
	 * @param string $theme_styles
	 */
	return apply_filters( 'alone_give_theme_custom_style', $theme_styles );
}

/**
 * Change posts per page in archive pages
 */
function alone_give_change_posts_per_page( $query ) {
  if ( is_admin() || ! $query->is_main_query() ) {
     return;
  }

	if( 1 !== absint( alone_get_option( 'give_change_posts_per_page' ) ) ) {
		return;
	}

  if ( is_post_type_archive( 'give_forms' ) || is_post_type_archive( 'give_posts' ) ) {

     $query->set( 'posts_per_page', absint( alone_get_option( 'give_posts_per_page' ) ) );
  }
}
add_filter( 'pre_get_posts', 'alone_give_change_posts_per_page' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function alone_give_body_classes( $classes ) {

  if( alone_get_option( 'show_mini_donation' ) ) {
    // Adds `has-mini-items` to pages.
		$classes[] = 'has-mini-items';
  }

	return $classes;
}
add_filter( 'body_class', 'alone_give_body_classes' );

/**
 * Filter site branding extras navigation
 */
add_action( 'alone_site_branding_extras_navigation', 'alone_site_branding_extras_navigation_donation', 50 );
function alone_site_branding_extras_navigation_donation() {
	if( ! alone_get_option( 'show_mini_donation' ) ) {
    return;
  }
	$form_id = alone_get_option( 'give_form_id' );
	if( 0 === absint( $form_id ) ) {
    return;
  }

	$form_display = get_post_meta( $form_id, '_give_payment_display', true );

  ?>
	<div class="extra-item toggle-item mini-donation">
		<?php
			if( !empty( $form_display ) ) {
				echo do_shortcode('[give_form id="' . esc_attr( $form_id ) . '" show_title="false" show_goal="false" show_content="none" display_style="button"]');
			} else {
				echo '<a href="' . get_the_permalink( $form_id ) . '" class="give-btn-link">' . alone_get_icon_svg( 'give-heart', 16 ) . esc_html__( 'Donate Now', 'alone' ) . '</a>';
			}
		?>
	</div>
  <?php
}

/**
 * Get Donation Form.
 *
 * @param array $args An array of form arguments.
 *
 * @return string Donation form.
 * @since 1.0
 */
function alone_give_get_donation_form( $args = array() ) {

	global $post;
	static $count = 1;

	$args = wp_parse_args( $args, give_get_default_form_shortcode_args() );

	// Backward compatibility for `form_id` function param.
	// If are calling this function directly with `form_id` the use `id` instead.
	$args['id'] = ! empty( $args['form_id'] ) ? absint( $args['form_id'] ) : $args['id'];

	// If `id` is not set then maybe we are single donation form page, so lets render form.
	if ( empty( $args['id'] ) && is_object( $post ) && $post->ID ) {
		$args['id'] = $post->ID;
	}

	// set `form_id` for backward compatibility because many legacy filters and functions are using it.
	$args['form_id'] = $args['id'];

	/**
	 * Fire the filter
	 * Note: we will deprecated this filter soon. Use give_get_default_form_shortcode_args instead
	 *
	 * @deprecated 2.4.1
	 */
	$args = apply_filters( 'give_form_args_defaults', $args );

	$form = new Give_Donate_Form( $args['id'] );

	// Bail out, if no form ID.
	if ( empty( $form->ID ) ) {
		return false;
	}

	$args['id_prefix'] = "{$form->ID}-{$count}";
	$payment_mode      = give_get_chosen_gateway( $form->ID );

	$form_action = add_query_arg(
		apply_filters(
			'give_form_action_args',
			array(
				'payment-mode' => $payment_mode,
			)
		),
		give_get_current_page_url()
	);

	// Sanity Check: Donation form not published or user doesn't have permission to view drafts.
	if (
		( 'publish' !== $form->post_status && ! current_user_can( 'edit_give_forms', $form->ID ) )
		|| ( 'trash' === $form->post_status )
	) {
		return false;
	}

	// Get the form wrap CSS classes.
	$form_wrap_classes = $form->get_form_wrap_classes( $args );

	// Get the <form> tag wrap CSS classes.
	$form_classes = $form->get_form_classes( $args );

	ob_start();

	/**
	 * Fires while outputting donation form, before the form wrapper div.
	 *
	 * @param int   Give_Donate_Form::ID The form ID.
	 * @param array $args An array of form arguments.
	 *
	 * @since 1.0
	 */
	//do_action( 'give_pre_form_output', $form->ID, $args, $form );

	?>
	<div id="give-form-<?php echo $form->ID; ?>-wrap" class="<?php echo $form_wrap_classes; ?>">
		<?php
		if ( $form->is_close_donation_form() ) {

			//$form_title = ! is_singular( 'give_forms' ) ? apply_filters( 'give_form_title', '<h2 class="give-form-title">' . get_the_title( $form->ID ) . '</h2>' ) : '';

			// Get Goal thank you message.
			$goal_achieved_message = get_post_meta( $form->ID, '_give_form_goal_achieved_message', true );
			$goal_achieved_message = ! empty( $goal_achieved_message ) ? $form_title . apply_filters( 'the_content', $goal_achieved_message ) : '';

			// Print thank you message.
			echo apply_filters( 'give_goal_closed_output', $goal_achieved_message, $form->ID, $form );

		} else {
			/**
			 * Show form title:
			 * 1. if admin set form display_style to button or modal
			 */
			//$form_title = apply_filters( 'give_form_title', '<h2 class="give-form-title">' . get_the_title( $form->ID ) . '</h2>' );

			//if ( ! doing_action( 'give_single_form_summary' ) && true === $args['show_title'] ) {
			//	echo $form_title;
			//}

			/**
			 * Fires while outputting donation form, before the form.
			 *
			 * @param int              Give_Donate_Form::ID The form ID.
			 * @param array            $args An array of form arguments.
			 * @param Give_Donate_Form $form Form object.
			 *
			 * @since 1.0
			 */
			//do_action( 'give_pre_form', $form->ID, $args, $form );

			// Set form html tags.
			$form_html_tags = array(
				'id'      => "give-form-{$args['id_prefix']}",
				'class'   => $form_classes,
				'action'  => esc_url_raw( $form_action ),
				'data-id' => $args['id_prefix'],
			);

			/**
			 * Filter the form html tags.
			 *
			 * @param array            $form_html_tags Array of form html tags.
			 * @param Give_Donate_Form $form           Form object.
			 *
			 * @since 1.8.17
			 */
			$form_html_tags = apply_filters( 'give_form_html_tags', (array) $form_html_tags, $form );
			?>
			<form <?php echo give_get_attribute_str( $form_html_tags ); ?> method="post">
				<!-- The following field is for robots only, invisible to humans: -->
				<span class="give-hidden" style="display: none !important;">
					<label for="give-form-honeypot-<?php echo $form->ID; ?>"></label>
					<input id="give-form-honeypot-<?php echo $form->ID; ?>" type="text" name="give-honeypot"
						   class="give-honeypot give-hidden"/>
				</span>

				<?php
				/**
				 * Fires while outputting donation form, before all other fields.
				 *
				 * @param int              Give_Donate_Form::ID The form ID.
				 * @param array            $args An array of form arguments.
				 * @param Give_Donate_Form $form Form object.
				 *
				 * @since 1.0
				 */
				do_action( 'give_donation_form_top', $form->ID, $args, $form );

				/**
				 * Fires while outputting donation form, for payment gateway fields.
				 *
				 * @param int              Give_Donate_Form::ID The form ID.
				 * @param array            $args An array of form arguments.
				 * @param Give_Donate_Form $form Form object.
				 *
				 * @since 1.7
				 */
				do_action( 'give_payment_mode_select', $form->ID, $args, $form );

				/**
				 * Fires while outputting donation form, after all other fields.
				 *
				 * @param int              Give_Donate_Form::ID The form ID.
				 * @param array            $args An array of form arguments.
				 * @param Give_Donate_Form $form Form object.
				 *
				 * @since 1.0
				 */
				do_action( 'give_donation_form_bottom', $form->ID, $args, $form );

				?>
			</form>

			<?php
			/**
			 * Fires while outputting donation form, after the form.
			 *
			 * @param int              Give_Donate_Form::ID The form ID.
			 * @param array            $args An array of form arguments.
			 * @param Give_Donate_Form $form Form object.
			 *
			 * @since 1.0
			 */
			do_action( 'give_post_form', $form->ID, $args, $form );

		}
		?>

	</div><!--end #give-form-<?php echo absint( $form->ID ); ?>-->
	<?php

	/**
	 * Fires while outputting donation form, after the form wrapper div.
	 *
	 * @param int   Give_Donate_Form::ID The form ID.
	 * @param array $args An array of form arguments.
	 *
	 * @since 1.0
	 */
	do_action( 'give_post_form_output', $form->ID, $args );

	$final_output = ob_get_clean();
	$count ++;

	echo apply_filters( 'give_donate_form', $final_output, $args );
}

/**
 * Load more give forms
 */
function alone_give_forms_load_more_scripts() {

	if( 'pagination' === alone_get_option( 'give_pagination_type' ) ) {
	  return;
	}

	  global $wp_query;

	  wp_register_script( 'give-loadmore', get_stylesheet_directory_uri() . '/js/give-loadmore.js', array('jquery') );

	  wp_localize_script( 'give-loadmore', 'give_loadmore_params', array(
		  'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php',
		  'posts' => json_encode( $wp_query->query_vars ),
		  'current_page' => get_query_var( 'paged' ) ? get_query_var('paged') : 1,
		  'max_page' => $wp_query->max_num_pages
	  ) );

	   wp_enqueue_script( 'give-loadmore' );
  }
  add_action( 'wp_enqueue_scripts', 'alone_give_forms_load_more_scripts' );

  /**
   * Load more give forms ajax handler
   */
  function alone_give_forms_loadmore_ajax_handler(){
	if( 'pagination' === alone_get_option( 'give_pagination_type' ) ) {
	  return;
	}

	  $args = json_decode( stripslashes( $_POST['query'] ), true );
	  $args['paged'] = $_POST['page'] + 1;
	  $args['post_status'] = 'publish';

	  query_posts( $args );

	  if( have_posts() ) :

		while ( have_posts() ) {
			the_post();
				get_template_part( 'give/content-give-form' );
		}

	  endif;
	  die;
  }

  add_action('wp_ajax_give_loadmore', 'alone_give_forms_loadmore_ajax_handler');
  add_action('wp_ajax_nopriv_give_loadmore', 'alone_give_forms_loadmore_ajax_handler');


/**
 * Add give content on template single default
 */
function alone_give_template_single_content(){
	give_form_display_content( get_the_ID(), $args = array() );
}
add_action( 'give_single_form_summary', 'alone_give_template_single_content', 5 );
