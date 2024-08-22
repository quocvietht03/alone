<?php
/**
 * Alone: Color Patterns
 *
 * @package WordPress
 * @subpackage Alone
 * @since Alone 7.0
 */

/**
 * Generate the CSS for the current primary color.
 */
function alone_woocommerce_custom_colors_css() {

	$main_color = absint( alone_get_option( 'main_color' ) );

	/**
	 * Filter Alone default saturation level.
	 *
	 * @since Alone 7.0
	 *
	 * @param int $saturation Color saturation level.
	 */
	$saturation = apply_filters( 'alone_scheme_color_saturation', 100 );
	$saturation = absint( $saturation ) . '%';

	/**
	 * Filter Alone default lightness level.
	 *
	 * @since Alone 7.0
	 *
	 * @param int $lightness Color lightness level.
	 */
	$lightness = apply_filters( 'alone_scheme_color_lightness', 33 );
	$lightness = absint( $lightness ) . '%';

	/**
	 * Filter Alone default hover lightness level.
	 *
	 * @since Alone 7.0
	 *
	 * @param int $lightness_hover Hover color lightness level.
	 */
	$lightness_hover = apply_filters( 'alone_scheme_color_lightness_hover', 23 );
	$lightness_hover = absint( $lightness_hover ) . '%';

	/**
	 * Theme color variable
	 */
	$base_color = 'hsl( ' . $main_color . ', ' . $saturation . ', ' . $lightness . ' )';
	$hover_color = 'hsl( ' . $main_color . ', ' . $saturation . ', ' . $lightness_hover . ' )';

	if( 'custom' == alone_get_option('custom_colors') ) {
		$base_color = alone_get_option( 'custom_color' );

		$hover_color = $base_color;
		if ( class_exists( 'Kirki_Color' ) && method_exists( 'Kirki_Color', 'adjust_brightness' ) ) {
			$hover_color = Kirki_Color::adjust_brightness( $base_color, - 10 );
		}

	}

	$theme_css = '

		/*
		 * Set Color
		 */
		.mini-cart .toggle-icon .mini-cart-counter,
		.mini-cart .widget_shopping_cart_content .cart_list li > a:hover,
		.mini-cart .widget_shopping_cart_content .cart_list li .amount,
		.mini-cart .widget_shopping_cart_content .total .amount,
		.mini-cart .widget_shopping_cart_content .elementor-menu-cart__products .elementor-menu-cart__product .elementor-menu-cart__product-name > a:hover,
		.mini-cart .widget_shopping_cart_content .elementor-menu-cart__products .elementor-menu-cart__product .elementor-menu-cart__product-price,
		.mini-cart .widget_shopping_cart_content .elementor-menu-cart__products .elementor-menu-cart__product .amount,
		.mini-cart .widget_shopping_cart_content .elementor-menu-cart__subtotal .amount,
		.woocommerce .woocommerce-toolbar .woocommerce-ordering .select .select-styled.active,
		.woocommerce .woocommerce-toolbar .woocommerce-ordering .select .select-styled:hover,
		.woocommerce .woocommerce-toolbar .woocommerce-result-count strong,
		.woocommerce ul.products li.product .button,
		.woocommerce ul.products li.product .woocommerce-loop-category__title:hover,
		.woocommerce ul.products li.product .woocommerce-loop-product__title:hover,
		.woocommerce ul.products li.product .price,
		.woocommerce .star-rating span,
		.woocommerce .widget_shopping_cart .widget_shopping_cart_content .cart_list li > a:hover,
		.woocommerce .widget_shopping_cart .widget_shopping_cart_content .cart_list li .amount,
		.woocommerce .widget_shopping_cart .widget_shopping_cart_content .total .amount,
		.woocommerce .widget_shopping_cart .widget_shopping_cart_content .elementor-menu-cart__products .elementor-menu-cart__product .elementor-menu-cart__product-name > a:hover,
		.woocommerce .widget_shopping_cart .widget_shopping_cart_content .elementor-menu-cart__products .elementor-menu-cart__product .elementor-menu-cart__product-price,
		.woocommerce .widget_shopping_cart .widget_shopping_cart_content .elementor-menu-cart__products .elementor-menu-cart__product .amount,
		.woocommerce .widget_shopping_cart .widget_shopping_cart_content .elementor-menu-cart__subtotal .amount,
		.woocommerce .widget_product_categories ul li a:hover,
		.woocommerce .widget_layered_nav ul li a:hover,
		.woocommerce .widget_product_categories ul.woocommerce-widget-layered-nav-list li a:hover,
		.woocommerce .widget_layered_nav ul.woocommerce-widget-layered-nav-list li a:hover,
		.woocommerce .widget_price_filter .price_slider_wrapper .price_slider_amount .price_label span,
		.woocommerce .widget_products ul > li > a:hover,
		.woocommerce .widget_top_rated_products ul > li > a:hover,
		.woocommerce .widget_recently_viewed_products ul > li > a:hover,
		.woocommerce .widget_recent_reviews ul > li > a:hover,
		.woocommerce .widget_products ul > li .amount,
		.woocommerce .widget_top_rated_products ul > li .amount,
		.woocommerce .widget_recently_viewed_products ul > li .amount,
		.woocommerce .widget_recent_reviews ul > li .amount,
		.woocommerce .widget_product_tag_cloud .tagcloud a:hover,
		.woocommerce div.product p.price,
		.woocommerce div.product span.price,
		.woocommerce div.product form.cart.grouped_form .woocommerce-grouped-product-list-item__price,
		.woocommerce div.product .product_meta span a:hover,
		.woocommerce div.product .woocommerce-tabs ul.tabs > li > a:hover,
		.woocommerce div.product .woocommerce-tabs ul.tabs > li.active > a,
		.woocommerce div.product .woocommerce-tabs #tab-reviews #reviews #review_form_wrapper .comment-form .comment-form-rating .stars > span > a,
		.woocommerce-cart .woocommerce-cart-form .shop_table tbody tr .product-name > a:hover,
		.woocommerce-cart .woocommerce-cart-form .shop_table tbody tr .product-price .amount,
		.woocommerce-cart .woocommerce-cart-form .shop_table tbody tr .product-subtotal .amount,
		.woocommerce-cart .cart-collaterals .cart_totals .shop_table .order-total,
		.woocommerce-cart .cart-collaterals .cart_totals .shop_table .order-total .amount,
		.woocommerce-checkout .woocommerce-checkout-review-order .shop_table tfoot .order-total th,
		.woocommerce-checkout .woocommerce-checkout-review-order .shop_table tfoot .order-total td .amount,
		.woocommerce-main-color {
			color: ' . $base_color . '; /* base: #0073a8; */
		}


		.woocommerce .woocommerce-toolbar .woocommerce-ordering svg,
		.woocommerce .quantity .decrease:hover svg,
		.woocommerce .quantity .increase:hover svg,
		.woocommerce-svg-main-color {
			fill: ' . $base_color . '; /* base: #0073a8; */
		}

		/*
		 * Set background
		 */
		input[type="submit"],
		button[type="submit"],
		.mini-cart .widget_shopping_cart_content .buttons a,
		.mini-cart .widget_shopping_cart_content .elementor-menu-cart__footer-buttons a,
		.woocommerce a.button,
		.woocommerce a.button.alt,
		.woocommerce button.button,
		.woocommerce button.button.alt,
		.woocommerce button.button.disabled,
		.woocommerce button.button.alt.disabled,
		.woocommerce button.button:disabled[disabled],
		.woocommerce #respond input#submit,
		.woocommerce span.onsale,
	 	.woocommerce .ribbons .ribbon,
		.woocommerce .woocommerce-toolbar .woocommerce-ordering .select .select-options li.selected,
		.woocommerce .woocommerce-toolbar .woocommerce-ordering .select .select-options li:hover,
		.woocommerce ul.products li.product .button .icon,
		.woocommerce ul.products li.product .added_to_cart,
		.woocommerce .widget_shopping_cart .widget_shopping_cart_content .buttons a,
		.woocommerce .widget_shopping_cart .widget_shopping_cart_content .elementor-menu-cart__footer-buttons a,
		.woocommerce .widget_price_filter .price_slider_wrapper .ui-slider .ui-slider-range,
		.woocommerce .widget_price_filter .price_slider_wrapper .ui-slider .ui-slider-handle,
		.woocommerce .widget_price_filter .price_slider_wrapper .price_slider_amount .button,
		.woocommerce div.product .woocommerce-tabs ul.tabs > li.active > a:before,
		.woocommerce .woocommerce-pagination-wrapper .woocommerce-pagination .page-numbers.current,
		.woocommerce .woocommerce-pagination-wrapper .woocommerce-pagination .page-numbers:hover,
		.woocommerce-cart .woocommerce-cart-form .shop_table thead,
		.woocommerce-checkout .woocommerce-checkout-review-order .shop_table thead,
		.woocommerce-checkout .woocommerce-checkout-review-order #payment ul.payment_methods li label:after,
		.woocommerce-checkout .woocommerce-checkout-review-order .woocommerce-checkout-payment ul.payment_methods li label:after,
		.woocommerce-account .woocommerce-MyAccount-navigation ul li a:hover,
		.woocommerce-account .woocommerce-MyAccount-navigation ul li.is-active a,
		.woocommerce-main-background-color {
			background-color: ' . $base_color . '; /* base: #0073a8; */
		}

		/*
		 * Set border color
		 */
		.woocommerce .widget_product_tag_cloud .tagcloud a:hover,
		.woocommerce div.product div.images .flex-control-thumbs li img.flex-active,
		.woocommerce-main-border-color {
			border-color: ' . $base_color . '; /* base: #0073a8; */
		}

		/* Hover colors */
		.woocommerce ul.products li.product .button:hover,
		.woocommerce-main-color-hover {
			color: ' . $hover_color . '; /* base: #005177; */
		}

		.woocommerce-svg-main-color-hover {
			fill: ' . $hover_color . '; /* base: #005177; */
		}

		input[type="submit"]:hover,
		button[type="submit"]:hover,
		.mini-cart .widget_shopping_cart_content .buttons a:hover,
		.mini-cart .widget_shopping_cart_content .elementor-menu-cart__footer-buttons a:hover,
		.woocommerce a.button:hover,
		.woocommerce a.button.alt:hover,
		.woocommerce button.button:hover,
		.woocommerce button.button.alt:hover,
		.woocommerce button.button.disabled:hover,
		.woocommerce button.button.alt.disabled:hover,
		.woocommerce button.button:disabled[disabled]:hover,
		.woocommerce #respond input#submit:hover,
		.woocommerce ul.products li.product .button:hover .icon,
		.woocommerce ul.products li.product .added_to_cart:hover,
		.woocommerce .widget_shopping_cart .widget_shopping_cart_content .buttons a:hover,
		.woocommerce .widget_shopping_cart .widget_shopping_cart_content .elementor-menu-cart__footer-buttons a:hover,
		.woocommerce .widget_price_filter .price_slider_wrapper .price_slider_amount .button:hover,
		.woocommerce-main-background-color-hover {
			background-color: ' . $hover_color . '; /* base: #005177; */
		}


		.woocommerce-main-border-color-hover {
			border-color: ' . $hover_color . '; /* base: #005177; */
		}';

	/**
	 * Filters Alone custom colors CSS.
	 *
	 * @since Alone 7.0
	 *
	 * @param string $theme_css           Base theme colors CSS.
	 * @param string $base_color 					The user's selected color.
	 * @param string $hover_color    			Filtered theme color hover.
	 */
	return apply_filters( 'alone_woocommerce_custom_colors_css', $theme_css, $base_color, $hover_color );
}
