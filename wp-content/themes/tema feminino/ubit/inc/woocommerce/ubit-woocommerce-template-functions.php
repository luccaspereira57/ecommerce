<?php
/**
 * WooCommerce Template Functions.
 *
 * @package ubit
 */

if ( ! function_exists( 'ubit_before_content' ) ) {
	/**
	 * Before Content
	 * Wraps all WooCommerce content in wrappers which match the theme markup
	 *
	 * @return  void
	 */
	function ubit_before_content() {
		?>
		<div id="primary" class="content-area">
			<main id="main" class="site-main">
		<?php
	}
}

if ( ! function_exists( 'ubit_after_content' ) ) {
	/**
	 * After Content
	 * Closes the wrapping divs
	 *
	 * @return  void
	 */
	function ubit_after_content() {
		?>
			</main><!-- #main -->
		</div><!-- #primary -->

		<?php
		do_action( 'ubit_sidebar' );
	}
}

if ( ! function_exists( 'ubit_sorting_wrapper' ) ) {
	/**
	 * Sorting wrapper
	 *
	 * @return  void
	 */
	function ubit_sorting_wrapper() {
		echo '<div class="ubit-sorting">';
	}
}

if ( ! function_exists( 'ubit_sorting_wrapper_close' ) ) {
	/**
	 * Sorting wrapper close
	 *
	 * @return  void
	 */
	function ubit_sorting_wrapper_close() {
		echo '</div>';
	}
}

if ( ! function_exists( 'ubit_shop_messages' ) ) {
	/**
	 * Ubit shop messages
	 *
	 * @uses    ubit_do_shortcode
	 */
	function ubit_shop_messages() {
		if ( is_checkout() ) {
			return;
		}

		echo wp_kses_post( ubit_do_shortcode( 'woocommerce_messages' ) );
	}
}

if ( ! function_exists( 'ubit_woocommerce_pagination' ) ) {
	/**
	 * Ubit WooCommerce Pagination
	 * WooCommerce disables the product pagination inside the woocommerce_product_subcategories() function
	 * but since Ubit adds pagination before that function is excuted we need a separate function to
	 * determine whether or not to display the pagination.
	 */
	function ubit_woocommerce_pagination() {
		if ( woocommerce_products_will_display() ) {
			woocommerce_pagination();
		}
	}
}

if ( ! function_exists( 'ubit_woocommerce_cart_sidebar' ) ) {
	/**
	 * Cart sidebar
	 */
	function ubit_woocommerce_cart_sidebar() {
		$total = WC()->cart->cart_contents_count;
		?>
			<div id="shop-cart-sidebar">
				<div class="cart-sidebar-head">
					<h4 class="cart-sidebar-title"><?php esc_html_e( 'Shopping cart', 'ubit' ); ?></h4>
					<span class="shop-cart-count"><?php echo esc_html( $total ); ?></span>
					<button id="close-cart-sidebar-btn" class="fas fa-times"></button>
				</div>

				<div class="cart-sidebar-content">
					<?php woocommerce_mini_cart(); ?>
				</div>
			</div>
		<?php
	}
}

if ( ! function_exists( 'ubit_modify_loop_add_to_cart_class' ) ) {
	/**
	 * Modify loop add to cart class name
	 */
	function ubit_modify_loop_add_to_cart_class() {
		global $product;

		$args = array(
			'class' => implode(
				' ',
				array_filter(
					array(
						apply_filters( 'ubit_loop_add_to_cart_icon', 'ubit-fa fa-shopping-cart' ),
						'loop-add-to-cart-btn',
						'button',
						'product_type_' . $product->get_type(),
						$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
						$product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
					)
				)
			),
		);

		return $args;
	}
}

if ( ! function_exists( 'ubit_is_woocommerce_page' ) ) {
	/**
	 * Returns true if on a page which uses WooCommerce templates
	 * Cart and Checkout are standard pages with shortcodes and which are also included
	 */
	function ubit_is_woocommerce_page() {
		if ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
			return true;
		}

		$keys = array(
			'woocommerce_shop_page_id',
			'woocommerce_terms_page_id',
			'woocommerce_cart_page_id',
			'woocommerce_checkout_page_id',
			'woocommerce_pay_page_id',
			'woocommerce_thanks_page_id',
			'woocommerce_myaccount_page_id',
			'woocommerce_edit_address_page_id',
			'woocommerce_view_order_page_id',
			'woocommerce_change_password_page_id',
			'woocommerce_logout_page_id',
			'woocommerce_lost_password_page_id',
		);

		foreach ( $keys as $k ) {
			if ( get_the_ID() == get_option( $k, 0 ) ) {
				return true;
			}
		}

		return false;
	}
}

if ( ! function_exists( 'ubit_loop_product_get_image' ) ) {
	/**
	 * Loop product get image
	 */
	function ubit_loop_product_get_image( $product, $size, $image_attr ) {
		if ( ! $product ) {
			return '';
		}

		return $product->get_image( $size, $image_attr );
	}
}
