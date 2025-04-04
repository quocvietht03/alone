<?php
function affiliate_register_admin_script() {
  wp_register_style('affiliate', get_template_directory_uri() . '/affiliate/affiliate.css' );
  wp_enqueue_style('affiliate');

}
add_action( 'admin_enqueue_scripts', 'affiliate_register_admin_script' );

/* Give affiliate */
remove_action( 'admin_menu', 'give_add_add_ons_option_link', 999999 );

function affiliate_give_add_add_ons_option_link() {
	global $submenu;

	// Show menu only if user has permission.
	if ( ! current_user_can( 'edit_give_payments' ) ) {
		return;
	}

	// Add-ons
  $submenu['edit.php?post_type=give_forms'][] = [
		'<span class="bears-get-addons gateways-payment">All Gateways Payment</span>',
		'install_plugins',
		esc_url( 'https://stellarwp.pxf.io/n17M9x' ),
	];

  $submenu['edit.php?post_type=give_forms'][] = [
    '<span class="bears-get-addons recurring-payment">Recurring Payment</span>',
		'install_plugins',
		esc_url( 'https://stellarwp.pxf.io/2rADGD' ),
	];

  $submenu['edit.php?post_type=give_forms'][] = [
    '<span class="bears-get-addons must-have-addons">Must have Add-ons</span>',
		'install_plugins',
		esc_url( 'https://stellarwp.pxf.io/5bVrXn' ),
	];

}
add_action( 'admin_menu', 'affiliate_give_add_add_ons_option_link', 999999999 );
