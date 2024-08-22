<?php
/**
 * Alone_Meta_Box_Product_Data class.
 */
class Alone_Meta_Box_Product_Data {

	/**
	 * Constructor.
	 */
	public function __construct() {

		// Add form
		add_action( 'woocommerce_product_data_panels', array( $this, 'product_meta_fields' ) );
		add_action( 'woocommerce_product_data_tabs', array( $this, 'product_meta_tab' ) );
		add_action( 'woocommerce_process_product_meta', array( $this, 'product_meta_fields_save' ) );

		add_action( 'wp_ajax_product_meta_fields', array( $this, 'instance_product_meta_fields' ) );
		add_action( 'wp_ajax_nopriv_product_meta_fields', array( $this, 'instance_product_meta_fields' ) );
	}

	/**
	 * Get product data fields
	 *
	 */
	public function instance_product_meta_fields() {
		$post_id = $_POST['post_id'];
		ob_start();
		$this->create_product_extra_fields( $post_id );
		$response = ob_get_clean();
		wp_send_json_success( $response );
		die();
	}

	/**
	 * Product data tab
	 */
	public function product_meta_tab( $product_data_tabs ) {
		/* $product_data_tabs['alone_instagram'] = array(
			'label'  => esc_html__( 'Instagram', 'alone' ),
			'target' => 'product_alone_instagram',
			'class'  => 'product-alone_instagram'
		); */

		$product_data_tabs['alone_attributes_extra'] = array(
			'label'  => esc_html__( 'Extra', 'alone' ),
			'target' => 'product_attributes_extra',
			'class'  => 'product-attributes-extra'
		);

		return $product_data_tabs;
	}

	/**
	 * Add product data fields
	 *
	 */
	public function product_meta_fields() {
		global $post;
		$this->create_product_extra_fields( $post->ID );
	}

	/**
	 * product_meta_fields_save function.
	 *
	 * @param mixed $post_id
	 */
	public function product_meta_fields_save( $post_id ) {
		/* if ( isset( $_POST['product_instagram_hashtag'] ) ) {
			$woo_data = $_POST['product_instagram_hashtag'];
			update_post_meta( $post_id, 'product_instagram_hashtag', $woo_data );
		} */

		if ( isset( $_POST['custom_badges_text'] ) ) {
			$woo_data = $_POST['custom_badges_text'];
			update_post_meta( $post_id, 'custom_badges_text', $woo_data );
		}

		if ( isset( $_POST['_is_new'] ) ) {
			$woo_data = $_POST['_is_new'];
			update_post_meta( $post_id, '_is_new', $woo_data );
		} else {
			update_post_meta( $post_id, '_is_new', 0 );
		}
	}

	/**
	 * Create product meta fields
	 *
	 * @param $post_id
	 */
	public function create_product_extra_fields( $post_id ) {
		/* echo '<div id="product_alone_instagram" class="panel woocommerce_options_panel">';
		woocommerce_wp_text_input(
			array(
				'id'       => 'product_instagram_hashtag',
				'label'    => esc_html__( 'Hashtag', 'alone' ),
				'desc_tip' => esc_html__( 'Enter the hashtag for which photos will be displayed. If no hashtag is entered, no photos will display.', 'alone' ),
			)
		);
		echo '</div>'; */

		echo '<div id="product_attributes_extra" class="panel woocommerce_options_panel">';
		woocommerce_wp_text_input(
			array(
				'id'       => 'custom_badges_text',
				'label'    => esc_html__( 'Custom Badge Text', 'alone' ),
				'desc_tip' => esc_html__( 'Enter this optional to show your badges.', 'alone' ),
			)
		);
		woocommerce_wp_checkbox(
			array(
				'id'          => '_is_new',
				'label'       => esc_html__( 'New product?', 'alone' ),
				'description' => esc_html__( 'Enable to set this product as a new product. A "New" badge will be added to this product.', 'alone' ),
			)
		);
		echo '</div>';


	}
}

new Alone_Meta_Box_Product_Data;
