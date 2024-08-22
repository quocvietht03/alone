<?php
/**
 * Add support for custom templates.
 *
 * @link https://github.com/woocommerce/woocommerce/wiki/Declaring-WooCommerce-support-in-themes
 */

function alone_add_woocommerce_support() {
  add_theme_support( 'woocommerce', array(
    'thumbnail_image_width' => 300,
		'gallery_thumbnail_image_width' => 150,
    'single_image_width'    => 600,

    'product_grid'          => array(
      'default_rows'    => 3,
      'min_rows'        => 2,
      'max_rows'        => 8,
      'default_columns' => 4,
      'min_columns'     => 2,
      'max_columns'     => 5,
    ),

  ) );

	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'alone_add_woocommerce_support' );


/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function alone_woocommerce_widgets_init() {

	register_sidebar(
		array(
			'name'          => __( 'Shop', 'alone' ),
			'id'            => 'shop-sidebar',
			'description'   => __( 'Add widgets here to appear in your shop.', 'alone' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

}
add_action( 'widgets_init', 'alone_woocommerce_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function alone_woocommerce_scripts() {
	wp_enqueue_style( 'alone-woocommerce-style', get_template_directory_uri() . '/css/woocommerce.css', array(), wp_get_theme()->get( 'Version' ) );

  wp_add_inline_style( 'alone-woocommerce-style', alone_woocommerce_theme_custom_style() );

  wp_enqueue_script( 'alone-woocommerce', get_theme_file_uri( '/js/woocommerce.js' ), array(), '20200828', true );
}
add_action( 'wp_enqueue_scripts', 'alone_woocommerce_scripts' );

/**
 * Display custom style in customizer and on frontend.
 */
function alone_woocommerce_theme_custom_style() {
	// Not include custom style in admin.
	if ( is_admin() ) {
		return;
	}

  $theme_styles = '';

	if ( 199 !== absint( alone_get_option('main_color') ) ) {
		// Colors
		require_once get_parent_theme_file_path( '/woocommerce/color-patterns.php' );
		$theme_styles .= alone_woocommerce_custom_colors_css();

	}

	/**
	 * Filters Alone custom theme styles.
	 *
	 * @since Alone 7.0
	 *
	 * @param string $theme_styles
	 */
	return apply_filters( 'alone_woocommerce_theme_custom_style', $theme_styles );
}

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function alone_woocommerce_body_classes( $classes ) {

  if( alone_get_option( 'show_mini_cart' ) ) {
    // Adds `has-mini-items` to products pages.
		$classes[] = 'has-mini-items';
  }

	if( alone_get_option( 'show_badges' ) ) {
    // Adds `shop-bages` to products pages.
		$classes[] = 'shop-bages';
  }

	return $classes;
}
add_filter( 'body_class', 'alone_woocommerce_body_classes' );

if ( is_admin() ) {
  /**
   * Add meta box product.
   */
  require get_template_directory() . '/woocommerce/product-meta-box.php';
}

/**
 * Filter site branding extras navigation
 */
add_action( 'alone_site_branding_extras_navigation', 'alone_site_branding_extras_navigation_cart', 30 );
function alone_site_branding_extras_navigation_cart() {
  if( ! alone_get_option( 'show_mini_cart' ) ) {
    return;
  }

  global $woocommerce;
		ob_start();
		woocommerce_mini_cart();
		$mini_cart = ob_get_clean();

		$mini_content = sprintf( '	<div class="widget_shopping_cart_content">%s</div>', $mini_cart );

  ?>
    <div class="extra-item toggle-item mini-cart">
      <a href="#" class="toggle-icon">
        <?php echo alone_get_icon_svg( 'woo-bag', 16 ); ?>
        <?php echo '<span class="mini-cart-counter" >' . intval( $woocommerce->cart->cart_contents_count ) . '</span>'; ?>
      </a>
      <div class="toggle-content">
        <div class="content-wrap">
          <h3 class="cart-title"><?php esc_html_e('My Shopping Cart', 'alone') ?></h3>
          <?php echo '<div class="cart-content">' . $mini_content . '</div>'; ?>
        </div>
      </div>
    </div>
  <?php
}

/**
 * Need an early hook to ajaxify update mini shop cart
 */
add_filter( 'woocommerce_add_to_cart_fragments', 'alone_add_to_cart_fragments' );
function alone_add_to_cart_fragments( $fragments ) {
  if( ! alone_get_option( 'show_mini_cart' ) ) {
    return;
  }

	global $woocommerce;

	if ( empty( $woocommerce ) ) {
		return $fragments;
	}

	ob_start();
	?>
    <span class="mini-cart-counter"><?php echo intval( $woocommerce->cart->cart_contents_count ) ?></span>
	<?php
	$fragments['span.mini-cart-counter'] = ob_get_clean();

	return $fragments;
}

/**
 * Filter woocommerce sale flash
 */
add_action( 'woocommerce_before_shop_loop_item_title', 'alone_product_ribbons', 10 );
add_action( 'woocommerce_before_single_product_summary', 'alone_product_ribbons', 10 );

function alone_product_ribbons() {
	if( ! alone_get_option( 'show_badges' ) ) {
		return;
	}

	global $product;

	$output = array();
	$badges = alone_get_option( 'badges' );
	// Change the default sale ribbon

	$custom_badges = maybe_unserialize( get_post_meta( $product->get_id(), 'custom_badges_text', true ) );
	if ( $custom_badges ) {

		$output[] = '<span class="custom ribbon">' . esc_html( $custom_badges ) . '</span>';

	} else {
		if ( ! $product->is_in_stock() && in_array( 'outofstock', $badges ) ) {
			$outofstock = alone_get_option( 'outofstock_text' );
			if ( ! $outofstock ) {
				$outofstock = esc_html__( 'Out Of Stock', 'alone' );
			}
			$output[] = '<span class="out-of-stock ribbon">' . esc_html( $outofstock ) . '</span>';
		} elseif ( $product->is_on_sale() && in_array( 'sale', $badges ) ) {
			$percentage = 0;
			$save       = 0;
			if ( $product->get_type() == 'variable' ) {
				$available_variations = $product->get_available_variations();
				$percentage           = 0;
				$save                 = 0;

				for ( $i = 0; $i < count( $available_variations ); $i ++ ) {
					$variation_id     = $available_variations[ $i ]['variation_id'];
					$variable_product = new WC_Product_Variation( $variation_id );
					$regular_price    = $variable_product->get_regular_price();
					$sales_price      = $variable_product->get_sale_price();
					if ( empty( $sales_price ) ) {
						continue;
					}
					$max_percentage = $regular_price ? round( ( ( ( $regular_price - $sales_price ) / $regular_price ) * 100 ) ) : 0;
					$max_save       = $regular_price ? $regular_price - $sales_price : 0;

					if ( $percentage < $max_percentage ) {
						$percentage = $max_percentage;
					}

					if ( $save < $max_save ) {
						$save = $max_save;
					}
				}
			} elseif ( $product->get_type() == 'simple' || $product->get_type() == 'external' ) {
				$percentage = round( ( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100 );
				$save       = $product->get_regular_price() - $product->get_sale_price();
			}
			if ( alone_get_option( 'sale_type' ) == '2' ) {
				if ( $save ) {
					$output[] = '<span class="ribbon sale sale-save"><span class="sep">' . esc_html( alone_get_option( 'sale_save_text' ) ) . '</span>' . ' ' . wc_price( $save ) . '</span>';
				}
			} else {
				if ( $percentage ) {
					$output[] = '<span class="ribbon sale sale-percent"><span class="sep">-</span>' . $percentage . '%' . '</span>';
				}
			}

		} elseif ( $product->is_featured() && in_array( 'hot', $badges ) ) {
			$hot = alone_get_option( 'hot_text' );
			if ( ! $hot ) {
				$hot = esc_html__( 'Hot', 'alone' );
			}
			$output[] = '<span class="featured ribbon">' . esc_html( $hot ) . '</span>';
		} elseif ( ( time() - ( 60 * 60 * 24 * alone_get_option( 'product_newness' ) ) ) < strtotime( get_the_time( 'Y-m-d' ) ) && in_array( 'new', $badges ) || get_post_meta( $product->get_id(), '_is_new', true ) == 'yes' ) {
			$new = alone_get_option( 'new_text' );
			if ( ! $new ) {
				$new = esc_html__( 'New', 'alone' );
			}
			$output[] = '<span class="newness ribbon">' . esc_html( $new ) . '</span>';
		}
	}

	if ( $output ) {
		printf( '<span class="ribbons">%s</span>', implode( '', $output ) );
	}
}


/**
 * Remove woocommerce breadcrumb
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

/**
* Hook: alone_woocommerce_page_titlebar_archive
*
* @hooked alone_woocomerce_page_titlebar_archive_template - 10
*/
add_action( 'alone_woocommerce_page_titlebar_archive', 'alone_woocomerce_page_titlebar_archive_template' );

function alone_woocomerce_page_titlebar_archive_template() {

  get_template_part( 'woocommerce/page-titlebar', 'archive' );

}

/**
 * Filter woocommerce result count & catalog ordering
 */
add_action( 'woocommerce_before_shop_loop', 'alone_woocommerce_toolbar_wrapper_start', 15 );
add_action( 'woocommerce_before_shop_loop', 'alone_woocommerce_toolbar_wrapper_end', 40 );

function alone_woocommerce_toolbar_wrapper_start() {
  if ( 1 !== absint( alone_get_option( 'product_catalog_toolbar' ) ) ) {
    return;
  }

  if ( ! wc_get_loop_prop( 'is_paginated' ) || ! woocommerce_products_will_display() ) {
		return;
	}

  echo '<div class="woocommerce-toolbar">';
}

function alone_woocommerce_toolbar_wrapper_end() {
  if ( 1 !== absint( alone_get_option( 'product_catalog_toolbar' ) ) ) {
    return;
  }

  if ( ! wc_get_loop_prop( 'is_paginated' ) || ! woocommerce_products_will_display() ) {
		return;
	}

  echo '</div>';
}

/**
 * Filter woocommerce quantity
 */
add_action( 'woocommerce_before_quantity_input_field', 'alone_decrease_quantity_input_field', 10 );
add_action( 'woocommerce_after_quantity_input_field', 'alone_increase_quantity_input_field', 10 );

function alone_decrease_quantity_input_field() {
	echo '<span class="decrease icon-minus">' . alone_get_icon_svg( 'woo-minus', 12 ) . '</span>';
}

function alone_increase_quantity_input_field() {
	echo '<span class="increase icon-plus">' . alone_get_icon_svg( 'woo-plus', 12 ) . '</span>';
}

/**
 * Filter woocommerce content product
 */
add_action( 'woocommerce_before_subcategory_title', 'alone_template_loop_product_thumbnail_wrapper_start', 5 );
add_action( 'woocommerce_before_subcategory_title', 'alone_template_loop_product_thumbnail_wrapper_end', 30 );
add_action( 'woocommerce_before_shop_loop_item_title', 'alone_template_loop_product_thumbnail_wrapper_start', 5 );
add_action( 'woocommerce_before_shop_loop_item_title', 'alone_template_loop_product_thumbnail_wrapper_end', 30 );
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 20 );
add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 5 );
add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 20 );


remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

function alone_template_loop_product_thumbnail_wrapper_start() {
  echo '<div class="woocommerce-loop-product__header"><div class="woocommerce-loop-product__overlay"></div>';
}

function alone_template_loop_product_thumbnail_wrapper_end() {
  echo '</div>';
}

add_filter( 'woocommerce_loop_add_to_cart_link', 'alone_loop_add_to_cart_link', 10, 2 );

function alone_loop_add_to_cart_link() {
  global $product;

  $defaults = array(
		'quantity'   => 1,
    'data-quantity' => 1,
		'class'      => implode(
			' ',
			array_filter(
				array(
					'button',
					'product_type_' . $product->get_type(),
					$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
					$product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
				)
			)
		),
		'attributes' => array(
			'data-product_id'  => $product->get_id(),
			'data-product_sku' => $product->get_sku(),
			'aria-label'       => $product->add_to_cart_description(),
			'rel'              => 'nofollow',
		),
	);

	$args = apply_filters( 'woocommerce_loop_add_to_cart_args', $defaults, $product );

	if ( isset( $args['attributes']['aria-label'] ) ) {
		$args['attributes']['aria-label'] = wp_strip_all_tags( $args['attributes']['aria-label'] );
	}

	switch ( $product->get_type() ) {

		case 'external':
			$icon = alone_get_icon_svg( 'woo-bag', 16 );

		break;
		case 'grouped':
			$icon = alone_get_icon_svg( 'woo-reply', 16 );

		break;
		case 'simple':
			$icon = alone_get_icon_svg( 'woo-bag', 16 );

		break;
		case 'variable':
			$icon = alone_get_icon_svg( 'woo-bag', 16 );

		break;
		default:
			$icon = alone_get_icon_svg( 'woo-reply', 16 );

	}

  return sprintf(
		'<a href="%s" data-quantity="%s" class="%s" %s>%s</a>',
		esc_url( $product->add_to_cart_url() ),
		esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
		esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
		isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
	  '<span class="icon">' . $icon . '</span>' . '<span class="text">' . esc_html( $product->add_to_cart_text() ) . '</span>'
	);
}


/**
 * Filter woocommerce pagination
 */
 add_action( 'woocommerce_after_shop_loop', 'alone_woocommerce_pagination_wrapper_start', 5 );
 add_action( 'woocommerce_after_shop_loop', 'alone_woocommerce_pagination_wrapper_end', 20 );

 function alone_woocommerce_pagination_wrapper_start() {
   echo '<div class="woocommerce-pagination-wrapper">';
 }

 function alone_woocommerce_pagination_wrapper_end() {
   echo '</div>';
 }

 add_filter( 'woocommerce_pagination_args', 'alone_pagination_args', 10, 1 );

 function alone_pagination_args() {
   $total   = isset( $total ) ? $total : wc_get_loop_prop( 'total_pages' );
   $current = isset( $current ) ? $current : wc_get_loop_prop( 'current_page' );
   $base    = isset( $base ) ? $base : esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
   $format  = isset( $format ) ? $format : '';

   if ( $total <= 1 ) {
   	return;
   }

   return array( // WPCS: XSS ok.
     'base'      => $base,
     'format'    => $format,
     'add_args'  => false,
     'current'   => max( 1, $current ),
     'total'     => $total,
     'prev_text' => alone_get_icon_svg('arrow-left', 12) . __( 'Prev', 'alone' ),
     'next_text' => __( 'Next', 'alone' ) . alone_get_icon_svg('arrow-right', 12),
     'type'      => 'plain',
     'mid_size'  => 2,
   );
 }
