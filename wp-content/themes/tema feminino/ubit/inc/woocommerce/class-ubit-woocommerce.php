<?php
/**
 * Ubit WooCommerce Class
 *
 * @package ubit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Ubit_WooCommerce' ) ) :

	/**
	 * The Ubit WooCommerce Integration class
	 */
	class Ubit_WooCommerce {

		/**
		 * Instance
		 *
		 * @var object instance
		 */
		public static $instance;

		/**
		 * Initiator
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Setup class.
		 */
		public function __construct() {
			add_action( 'after_setup_theme', array( $this, 'ubit_woocommerce_setup' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'woocommerce_scripts' ), 200 );
			add_action( 'elementor/preview/enqueue_scripts', array( $this, 'ubit_elementor_preview_product_page_scripts' ) );
			add_filter( 'body_class', array( $this, 'woocommerce_body_class' ) );
			add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
			add_filter( 'woocommerce_cross_sells_columns', array( $this, 'ubit_change_cross_sells_columns' ) );
			add_filter( 'woocommerce_show_page_title', array( $this, 'ubit_remove_woocommerce_shop_title' ) );
			add_filter( 'woocommerce_available_variation', array( $this, 'ubit_available_variation_gallery' ), 90, 3 );

			// Remove Woo-Commerce Default actions.
			add_action( 'init', array( $this, 'woocommerce_remove_action' ) );

			add_action( 'woocommerce_before_shop_loop', array( $this, 'ubit_toggle_sidebar_mobile_button' ), 25 );

			// GENERAL.
			// Product related.
			add_filter( 'woocommerce_output_related_products_args', array( $this, 'ubit_related_products_args' ) );
			// Shop columns.
			add_filter( 'loop_shop_columns', array( $this, 'ubit_shop_columns' ) );
			add_filter( 'loop_shop_per_page', array( $this, 'ubit_products_per_page' ) );
			// Pagination arrow.
			add_filter( 'woocommerce_pagination_args', array( $this, 'ubit_change_woocommerce_arrow_pagination' ) );
			// Change sale flash.
			add_filter( 'woocommerce_sale_flash', array( $this, 'ubit_change_sale_flash' ) );
			// Cart fragment.
			add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'ubit_cart_sidebar_content_fragments' ) );
			add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'ubit_cart_total_number_fragments' ) );
			// Add product Loop action area.
			add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'ubit_product_loop_item_action' ), 25 );
			// Add add-to-cart icon into Loop action area.
			add_action( 'ubit_product_loop_item_action_item', array( $this, 'ubit_product_loop_item_add_to_cart_icon' ), 15 );
			// Add quick view icon into Loop action area.
			add_action( 'ubit_product_loop_item_action_item', array( $this, 'ubit_product_loop_item_quickview_icon' ), 20 );
			// Add wishlist icon into Loop action area.
			add_action( 'ubit_product_loop_item_action_item', array( $this, 'ubit_product_loop_item_wishlist_icon' ), 30 );
			// Attributes widget - show color bubbles next to color names.
			add_filter( 'woocommerce_layered_nav_term_html', array( $this, 'ubit_layered_nav_term_html' ), 10, 4 );
			// Workaround for not duplicating add-to-cart action on product page refresh.
			add_filter( 'woocommerce_add_to_cart_redirect', array( $this, 'ubit_add_to_cart_redirect' ) );
			// Clear shop cart.
			add_action( 'init', array( $this, 'ubit_detect_clear_cart_submit' ) );

			// SHOP PAGE.
			// Open wrapper product loop image.
			add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'ubit_loop_product_image_wrapper_open' ), 20 );
			// Product link open.
			add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'ubit_loop_product_link_open' ), 30 );
			// Product loop image.
			add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'ubit_loop_product_image' ), 40 );
			// Product loop hover image.
			add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'ubit_loop_product_hover_image' ), 50 );
			// Product link close.
			add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'ubit_loop_product_link_close' ), 60 );
			// Close wrapper product loop image.
			add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'ubit_loop_product_image_wrapper_close' ), 70 );

			// Add product category.
			add_action( 'woocommerce_shop_loop_item_title', array( $this, 'ubit_add_template_loop_product_category' ), 5 );
			// Add url inside product title.
			add_action( 'woocommerce_shop_loop_item_title', array( $this, 'ubit_add_template_loop_product_title' ), 10 );

			// Product rating.
			add_action( 'woocommerce_after_shop_loop_item_title', array( $this, 'ubit_loop_product_rating' ), 2 );

			// Product loop meta open.
			add_action( 'woocommerce_after_shop_loop_item_title', array( $this, 'ubit_loop_product_meta_open' ), 5 );

			add_action( 'woocommerce_after_shop_loop_item_title', array( $this, 'ubit_loop_product_price' ), 10 );
			add_action( 'woocommerce_after_shop_loop_item_title', array( $this, 'ubit_loop_product_add_to_cart_button' ), 15 );
			// Product loop meta close.
			add_action( 'woocommerce_after_shop_loop_item', array( $this, 'ubit_loop_product_meta_close' ), 20 );

			// PRODUCT PAGE.
			// Product container open.
			add_action( 'woocommerce_before_single_product_summary', array( $this, 'ubit_single_product_container_open' ), 10 );
			// Product gallery open.
			add_action( 'woocommerce_before_single_product_summary', array( $this, 'ubit_single_product_gallery_open' ), 20 );
			// Product gallery image slider.
			add_action( 'woocommerce_before_single_product_summary', array( $this, 'ubit_single_product_gallery_image_slide' ), 30 );
			// Product gallery thumbnail slider.
			add_action( 'woocommerce_before_single_product_summary', array( $this, 'ubit_single_product_gallery_thumb_slide' ), 40 );
			// Product gallery close.
			add_action( 'woocommerce_before_single_product_summary', array( $this, 'ubit_single_product_gallery_close' ), 50 );
			// Product galley script and style.
			add_action( 'woocommerce_before_single_product_summary', array( $this, 'ubit_single_product_gallery_dependency' ), 100 );
			// Product container close.
			add_action( 'woocommerce_after_single_product_summary', array( $this, 'ubit_single_product_container_close' ), 5 );
			// Container after summary.
			add_action( 'woocommerce_after_single_product_summary', array( $this, 'ubit_single_product_after_summary_open' ), 8 );
			add_action( 'woocommerce_after_single_product_summary', array( $this, 'ubit_single_product_after_summary_close' ), 100 );
			// Add wishlist icon into single product page.
			add_filter( 'yith_wcwl_button_icon', array( $this, 'ubit_wcwl_button_icon' ) );

			// Removed on cart action.
			add_action( 'wp_ajax_get_product_item_incart', array( $this, 'ubit_get_product_item_incart' ) );
			add_action( 'wp_ajax_nopriv_get_product_item_incart', array( $this, 'ubit_get_product_item_incart' ) );

			// CART PAGE.
			add_action( 'woocommerce_after_cart_table', array( $this, 'ubit_clear_shop_cart' ) );
		}

		/**
		 * Theme options
		 *
		 * @return array $options All theme options
		 */
		public function ubit_options() {
			$options = ubit_options( false );
			return $options;
		}

		/**
		 * Sets up theme defaults and registers support for various WooCommerce features.
		 */
		public function ubit_woocommerce_setup() {
			add_theme_support(
				'woocommerce',
				apply_filters(
					'ubit_woocommerce_args',
					array(
						'product_grid' => array(
							'default_columns' => 3,
							'default_rows'    => 4,
							'min_columns'     => 1,
							'max_columns'     => 6,
							'min_rows'        => 1,
						),
					)
				)
			);
		}

		/**
		 * WooCommerce enqueue scripts and styles.
		 */
		public function woocommerce_scripts() {
			$options = self::ubit_options();

			// Main woocommerce js file.
			wp_enqueue_script( 'ubit-woocommerce' );

			// Removed from mini cart.
			wp_localize_script(
				'ubit-woocommerce',
				'ubit_woocommerce_data',
				array(
					'ajax_url'     => esc_url_raw( admin_url( 'admin-ajax.php' ) ),
					'ajax_nonce'   => wp_create_nonce( 'ubit_ajax_mini_cart' ),
					'plugins_url'   => esc_url_raw( plugins_url() ),
				)
			);

			// Product variations.
			wp_enqueue_script( 'ubit-product-variation' );

			// Quantity button.
			wp_enqueue_script( 'ubit-quantity-button' );

			// Tiny slider: product images.
			wp_enqueue_script( 'ubit-product-images' );

			// Easyzoom.
			wp_enqueue_script( 'easyzoom-handle' );

			// Photoswipe.
			wp_enqueue_script( 'photoswipe-init' );

			// WooCommerce sidebar.
			wp_enqueue_script( 'ubit-woocommerce-sidebar' );

			// Add to cart variation.
			if ( wp_script_is( 'wc-add-to-cart-variation', 'registered' ) && ! wp_script_is( 'wc-add-to-cart-variation', 'enqueued' ) ) {
				wp_enqueue_script( 'wc-add-to-cart-variation' );
			}

			// WooCommerce selectWoo.
			wp_enqueue_script( 'selectWoo' );
			wp_enqueue_style( 'select2' );
		}

		/**
		 * Global variation gallery
		 */
		public function ubit_elementor_preview_product_page_scripts() {
			$product = wc_get_product( $this->ubit_get_last_product_id() );
			if ( ! is_object( $product ) ) {
				$this->ubit_global_for_vartiation_gallery( $product );
			}
		}

		/**
		 * Add WooCommerce specific classes to the body tag
		 *
		 * @param  array $classes css classes applied to the body tag.
		 * @return array $classes modified to include 'woocommerce-active' class
		 */
		public function woocommerce_body_class( $classes ) {
			$options   = ubit_options( false );
			$classes[] = 'woocommerce-active';

			// Product gallery.
			$page_id = ubit_get_page_id();
			$product = wc_get_product( $page_id );
			$gallery = $product ? $product->get_gallery_image_ids() : false;
			if ( $gallery || is_singular( 'elementor_library' ) ) {
				$classes[] = 'has-gallery-layout-' . $options['shop_single_gallery_layout'];
			}

			// Product meta.
			$sku        = $options['shop_single_skus'];
			$categories = $options['shop_single_categories'];
			$tags       = $options['shop_single_tags'];

			if ( true != $sku ) {
				$classes[] = 'hid-skus';
			}

			if ( true != $categories ) {
				$classes[] = 'hid-categories';
			}

			if ( true != $tags ) {
				$classes[] = 'hid-tags';
			}

			return $classes;
		}

		/**
		 * Removes a woocommerce shop title.
		 */
		public function ubit_remove_woocommerce_shop_title() {
			return false;
		}

		/**
		 * Toggle sidebar mobile button
		 */
		public function ubit_toggle_sidebar_mobile_button() {
			$icon = apply_filters( 'ubit_toggle_sidebar_mobile_button_icon', 'ubit-fa fa-filter' );
			?>
			<button id="toggle-sidebar-mobile-button" class="<?php echo esc_attr( $icon ); ?>"><?php esc_html_e( 'Filter', 'ubit' ); ?></button>
			<?php
		}

		/**
		 * Remove Woo-Commerce Default actions
		 */
		public function woocommerce_remove_action() {
			remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
			remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
			remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

			remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
			remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
			remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

			remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
			remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

			remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

			remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
			remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );

			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );

			add_action( 'woocommerce_before_main_content', 'ubit_before_content', 10 );
			add_action( 'woocommerce_after_main_content', 'ubit_after_content', 10 );
			add_action( 'ubit_content_top', 'ubit_shop_messages', 20 );

			add_action( 'woocommerce_before_shop_loop', 'ubit_sorting_wrapper', 9 );
			add_action( 'woocommerce_before_shop_loop', 'ubit_sorting_wrapper_close', 31 );

			// WooCommerce sidebar.
			add_action( 'ubit_theme_footer', 'ubit_woocommerce_cart_sidebar', 120 );

			// PRODUCT PAGE.
			// Sale flash.
			add_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 25 );

			// Swap position price and rating star.
			add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
			add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );

			// Disable WooCommerce setup wizard automatic redirect.
			add_filter( 'woocommerce_prevent_automatic_wizard_redirect', '__return_true' );
		}

		/**
		 * Change cross sell column
		 *
		 * @param      int $columns  The columns.
		 */
		public function ubit_change_cross_sells_columns( $columns ) {
			return 3;
		}

		/**
		 * Related Products Args
		 *
		 * @param  array $args related products args.
		 * @return  array $args related products args
		 */
		public function ubit_related_products_args( $args ) {
			$args = apply_filters(
				'ubit_related_products_args',
				array(
					'posts_per_page' => 4,
					'columns'        => 4,
				)
			);

			return $args;
		}

		/**
		 * Product gallery thumbnail columns
		 *
		 * @return integer number of columns
		 */
		public function ubit_shop_columns() {
			$options = self::ubit_options();
			$columns = $options['shop_columns'];

			return absint( apply_filters( 'ubit_shop_columns', $columns ) );
		}

		/**
		 * Products per page
		 *
		 * @return integer number of products
		 */
		public function ubit_products_per_page() {
			$options  = self::ubit_options();
			$per_page = $options['shop_product_per_page'];

			return absint( apply_filters( 'ubit_shop_products_per_page', $per_page ) );
		}

		/**
		 * Change arrow for pagination
		 *
		 * @param array $args WooCommerce pagination.
		 */
		public function ubit_change_woocommerce_arrow_pagination( $args ) {
			$args['prev_text'] = esc_html__( 'Prev', 'ubit' );
			$args['next_text'] = esc_html__( 'Next', 'ubit' );
			return $args;
		}

		/**
		 * Change sale flash
		 */
		public function ubit_change_sale_flash() {
			global $product;

			$sale       = $product->is_on_sale();
			$price_sale = $product->get_sale_price();
			$price      = $product->get_regular_price();
			$simple     = $product->is_type( 'simple' );
			$onsale_class = $simple ? 'onsale-simple' : 'onsale-variable';

			if ( $sale ) {
				?>
				<span class="onsale <?php echo esc_attr( $onsale_class ); ?>">
					<?php
					if ( $simple ) {
						$final_price = esc_html( ( ( $price - $price_sale ) / $price ) * 100 );
						echo '-' . round( $final_price ) . '%'; // WPCS: XSS ok.
					} else {
						esc_html_e( 'Sale', 'ubit' );
					}
					?>
				</span>
				<?php
			}
		}

		/**
		 * Product loop action
		 */
		public function ubit_product_loop_item_action() {
			?>
			<div class="product-loop-action"><?php do_action( 'ubit_product_loop_item_action_item' ); ?></div>
			<?php
		}

		/**
		 * Product loop quick view icon
		 */
		public function ubit_product_loop_item_quickview_icon() {
			if ( ! defined( 'YITH_WCQV' ) ) {
				return;
			}

			global $product;

			echo '<a href="#" aria-label="Quick View" data-product_id="' . $product->get_id() . '" class="far fa-eye product-quick-view-btn yith-wcqv-button"></a>';
		}

		/**
		 * Product loop wishlist icon
		 */
		public function ubit_product_loop_item_wishlist_icon() {
			if ( ! defined( 'YITH_WCWL' ) ) {
				return;
			}

			echo do_shortcode( '[yith_wcwl_add_to_wishlist]' );
		}

		/**
		 * Add wishlist icon into single product page
		 *
		 * @param  string			 $icon_option Icon CSS class.
		 * @return string			 Icon CSS class.
		 */
		public function ubit_wcwl_button_icon( $icon_option ) {
			if ( is_product() && empty( $icon_option ) ) {
				return esc_attr( 'ubit-heart' );
			}

			return $icon_option;
		}

		/**
		 * Attributes widget - show color bubbles next to color names
		 *
		 * @param  string				$term_html Term HTML.
		 * @param  object				$term Term object.
		 * @param  string|bool	$link Term URL.
		 * @param  int					$count Term count.
		 * @return string				Term HTML.
		 */
		public function ubit_layered_nav_term_html( $term_html, $term, $link, $count ) {
			if ( $term->taxonomy == 'pa_color' ) {
				$color = get_term_meta( $term->term_id, 'color', true );

				if ( ! empty( $color ) ) {
					$term_html = '<span class="ubit-widget-term-color" style="background-color: ' . esc_attr( $color ) . ';"></span>' . $term_html;
				}
			}

			return $term_html;
		}

		/**
		 * Update cart total item via ajax
		 *
		 * @param      array $fragments Fragments to refresh via AJAX.
		 * @return     array $fragments Fragments to refresh via AJAX
		 */
		public function ubit_cart_total_number_fragments( $fragments ) {
			$total = WC()->cart->cart_contents_count;

			ob_start();
			?>
				<span class="shop-cart-count"><?php echo esc_html( $total ); ?></span>
			<?php

			$fragments['span.shop-cart-count'] = ob_get_clean();

			return $fragments;
		}

		/**
		 * Workaround for not duplicating add-to-cart action on product page refresh.
		 */
		public function ubit_add_to_cart_redirect( $url ) {
			if( $url ) {
				return $url;
			}

			return remove_query_arg( 'add-to-cart', wp_get_referer() );
		}

		/**
		 * Clear cart button.
		 */
		public function ubit_detect_clear_cart_submit() {
			if ( isset( $_GET['empty-cart'] ) ) {
				WC()->cart->empty_cart();

				$referer = wp_get_referer() ? remove_query_arg( 'empty-cart', wp_get_referer() ) : wc_get_cart_url();
				wp_safe_redirect( $referer );
				exit;
			}
		}

		/**
		 * Update cart sidebar content via ajax
		 *
		 * @param      array $fragments Fragments to refresh via AJAX.
		 * @return     array $fragments Fragments to refresh via AJAX
		 */
		public function ubit_cart_sidebar_content_fragments( $fragments ) {
			ob_start();
			?>
				<div class="cart-sidebar-content">
					<?php woocommerce_mini_cart(); ?>
				</div>
			<?php

			$fragments['div.cart-sidebar-content'] = ob_get_clean();

			return $fragments;
		}

		/**
		 * Loop product category.
		 */
		public function ubit_add_template_loop_product_category() {
			$options = self::ubit_options();
			if ( false == $options['shop_page_product_category'] ) {
				return;
			}
			?>
			<div class="woocommerce-loop-product__category">
				<?php
				global $product;
				$product_id = $product->get_ID();
				echo wp_kses_post( wc_get_product_category_list( $product_id ) );
				?>
			</div>
			<?php
		}

		/**
		 * Loop product rating
		 */
		public function ubit_loop_product_rating() {
			$options = self::ubit_options();
			if ( false == $options['shop_page_product_rating'] ) {
				return;
			}

			global $product;
			echo wc_get_rating_html( $product->get_average_rating() ); // WPCS: XSS OK.
		}

		/**
		 * Loop product title.
		 */
		public function ubit_add_template_loop_product_title() {
			$options = self::ubit_options();
			if ( false == $options['shop_page_product_title'] ) {
				return;
			}
			?>
			<h2 class="woocommerce-loop-product__title">
				<?php
					woocommerce_template_loop_product_link_open();
					the_title();
					woocommerce_template_loop_product_link_close();
				?>
			</h2>
			<?php
		}

		/**
		 * Loop product image wrapper open tag
		 */
		public function ubit_loop_product_image_wrapper_open() {
			echo '<div class="product-loop-image-wrapper">';
		}

		/**
		 * Loop product link open
		 */
		public function ubit_loop_product_link_open() {
			// open tag <a>.
			woocommerce_template_loop_product_link_open();
		}

		/**
		 * Loop product image
		 */
		public function ubit_loop_product_image() {
			global $product;

			if ( ! $product ) {
				return '';
			}

			$size       = 'woocommerce_thumbnail';
			$img_id     = $product->get_image_id();
			$img_alt    = ubit_image_alt( $img_id, esc_attr__( 'Product image', 'ubit' ) );
			$img_origin = wp_get_attachment_image_src( $img_id, $size );
			$image_attr = array(
				'alt'             => esc_attr( $img_alt ),
				'data-origin_src' => esc_url( $img_origin[0] ),
			);

			echo ubit_loop_product_get_image( $product, $size, $image_attr ); // WPCS: XSS ok.
		}

		/**
		 * Loop product hover image
		 */
		public function ubit_loop_product_hover_image() {
			global $product;
			$gallery    = $product->get_gallery_image_ids();
			$size       = 'woocommerce_thumbnail';
			$image_size = apply_filters( 'single_product_archive_thumbnail_size', $size );

			// Hover image.
			if ( ! empty( $gallery ) ) {
				$hover = wp_get_attachment_image_src( $gallery[0], $image_size );
				?>
					<div class="product-loop-hover-image" style="background-image: url(<?php echo esc_url( $hover[0] ); ?>);"></div>
				<?php
			}
		}

		/**
		 * Loop product link close
		 */
		public function ubit_loop_product_link_close() {
			// close tag </a>.
			woocommerce_template_loop_product_link_close();
		}

		/**
		 * Loop product image wrapper close tag
		 */
		public function ubit_loop_product_image_wrapper_close() {
			echo '</div>';
		}

		/**
		 * Loop product meta open
		 */
		public function ubit_loop_product_meta_open() {
			global $product;
			$options = self::ubit_options();

			$class = (
				false == $options['shop_page_product_price'] ||
				false == $options['shop_page_product_add_to_cart_button'] ||
				'layout-1' != $options['product_style'] ||
				(
					'external' === $product->get_type() &&
					'' === $product->get_price()
				) ||
				(
					'layout-1' == $options['product_style'] &&
					true == $options['product_style_defaut_add_to_cart']
				) ||
				defined( 'YITH_WCQV' )
			) ? 'no-transform' : '';

			echo '<div class="product-loop-meta ' . esc_attr( $class ) . '">';
			echo '<div class="animated-meta">';
		}

		/**
		 * Loop product price
		 */
		public function ubit_loop_product_price() {
			$options = self::ubit_options();
			if ( false == $options['shop_page_product_price'] ) {
				return;
			}

			global $product;
			$price_html = $product->get_price_html();

			if ( $price_html ) {
				?>
				<span class="price"><?php echo wp_kses_post( $price_html ); ?></span>
				<?php
			}
		}

		/**
		 * Loop product add to cart icon
		 */
		public function ubit_product_loop_item_add_to_cart_icon() {
			$options = self::ubit_options();
			if ( false == $options['product_style_defaut_add_to_cart'] ) {
				return;
			}

			$args = ubit_modify_loop_add_to_cart_class();
			woocommerce_template_loop_add_to_cart( $args );
		}

		/**
		 * Loop product add to cart button
		 */
		public function ubit_loop_product_add_to_cart_button() {
			$options = self::ubit_options();
			if ( false == $options['shop_page_product_add_to_cart_button'] ) {
				return;
			}

			$args = ubit_modify_loop_add_to_cart_class();
			woocommerce_template_loop_add_to_cart( $args );
		}

		/**
		 * Loop product meta close
		 */
		public function ubit_loop_product_meta_close() {
			echo '</div></div>';
		}


		/**
		 * Product container open
		 */
		public function ubit_single_product_container_open() {
			$container = ubit_site_container();
			?>
				<div class="product-page-container">
					<div class="<?php echo esc_attr( $container ); ?>">
			<?php
		}

		/**
		 * Single gallery product open
		 */
		public function ubit_single_product_gallery_open() {
			global $product;

			if ( ! is_object( $product ) ) {
				$id = $this->ubit_get_last_product_id();
				if ( ! $id ) {
					return;
				}

				$product = wc_get_product( $id );
			}

			$options    = ubit_options( false );
			$gallery_id = $product->get_gallery_image_ids();
			$classes[]  = $options['shop_single_gallery_layout'] . '-style';
			if ( ! empty( $gallery_id ) ) {
				$classes[] = 'has-product-thumbnails';
			}

			// Global variation gallery.
			$this->ubit_global_for_vartiation_gallery( $product );
			?>
			<div class="product-gallery <?php echo esc_attr( implode( ' ', $classes ) ); ?>">
			<?php
		}

		/**
		 * Get variation gallery
		 *
		 * @param object $product The product.
		 */
		public function ubit_get_default_gallery( $product ) {
			$images = array();
			if ( ! is_object( $product ) ) {
				return $images;
			}

			$product_id             = $product->get_id();
			$gallery_images         = $product->get_gallery_image_ids();
			$has_default_thumbnails = false;

			if ( ! empty( $gallery_images ) ) {
				$has_default_thumbnails = true;
			}

			if ( has_post_thumbnail( $product_id ) ) {
				array_unshift( $gallery_images, get_post_thumbnail_id( $product_id ) );
			}

			if ( ! empty( $gallery_images ) ) {
				foreach ( $gallery_images as $i => $image_id ) {
					$images[ $i ]                           = wc_get_product_attachment_props( $image_id );
					$images[ $i ]['image_id']               = $image_id;
					$images[ $i ]['has_default_thumbnails'] = $has_default_thumbnails;
				}
			}

			return $images;
		}

		/**
		 * Available Gallery
		 *
		 * @param array  $available_variation Avaiable Variations.
		 * @param object $variation_product_object Product object.
		 * @param array  $variation Variations.
		 */
		public function ubit_available_variation_gallery( $available_variation, $variation_product_object, $variation ) {
			$product_id         = absint( $variation->get_parent_id() );
			$variation_id       = absint( $variation->get_id() );
			$variation_image_id = absint( $variation->get_image_id() );
			$product            = wc_get_product( $product_id );

			if ( ! $product->is_type( 'variable' ) || ! class_exists( 'WC_Additional_Variation_Images' ) ) {
				return $available_variation;
			}

			$gallery_images = get_post_meta( $variation_id, '_wc_additional_variation_images', true );
			if ( ! $gallery_images ) {
				return $available_variation;
			}
			$gallery_images = explode( ',', $gallery_images );

			if ( $variation_image_id ) {
				// Add Variation Default Image.
				array_unshift( $gallery_images, $variation->get_image_id() );
			} elseif ( has_post_thumbnail( $product_id ) ) {
				// Add Product Default Image.
				array_unshift( $gallery_images, get_post_thumbnail_id( $product_id ) );
			}

			$available_variation['ubit_variation_gallery_images'] = [];
			foreach ( $gallery_images as $k => $v ) {
				$available_variation['ubit_variation_gallery_images'][ $k ] = wc_get_product_attachment_props( $v );
			}

			return $available_variation;
		}

		/**
		 * Get variation gallery
		 *
		 * @param object $product The product.
		 */
		public function ubit_get_variation_gallery( $product ) {
			$images = array();

			if ( ! is_object( $product ) || ! $product->is_type( 'variable' ) ) {
				return $images;
			}

			$variations = array_values( $product->get_available_variations() );
			$key        = class_exists( 'WC_Additional_Variation_Images' ) ? 'ubit_variation_gallery_images' : 'variation_gallery_images';

			$images = array();
			foreach ( $variations as $k ) {
				if ( ! isset( $k[ $key ] ) ) {
					break;
				}

				array_unshift( $k[ $key ], array( 'variation_id' => $k['variation_id'] ) );
				array_push( $images, $k[ $key ] );
			}

			return $images;
		}

		/**
		 * Add global variation
		 *
		 * @param object $product The Product.
		 */
		public function ubit_global_for_vartiation_gallery( $product ) {

			// Ubit Variation gallery.
			wp_localize_script(
				'ubit-product-variation',
				'ubit_variation_gallery',
				$this->ubit_get_variation_gallery( $product )
			);

			// Ubit default gallery.
			wp_localize_script(
				'ubit-product-variation',
				'ubit_default_gallery',
				$this->ubit_get_default_gallery( $product )
			);
		}

		/**
		 * Product gallery product image slider
		 */
		public function ubit_single_product_gallery_image_slide() {
			global $product;

			if ( ! is_object( $product ) ) {
				$id = $this->ubit_get_last_product_id();
				if ( ! $id ) {
					return;
				}

				$product = wc_get_product( $id );
			}
			$product_id = $product->get_id();
			$image_id   = $product->get_image_id();
			$image_alt  = ubit_image_alt( $image_id, esc_attr__( 'Product image', 'ubit' ) );
			$get_size   = wc_get_image_size( 'shop_catalog' );
			$image_size = $get_size['width'] . 'x' . ( ! empty( $get_size['height'] ) ? $get_size['height'] : $get_size['width'] );

			if ( $image_id ) {
				$image_small_src  = wp_get_attachment_image_src( $image_id, 'thumbnail' );
				$image_medium_src = wp_get_attachment_image_src( $image_id, 'woocommerce_single' );
				$image_full_src   = wp_get_attachment_image_src( $image_id, 'full' );
				$image_size       = $image_full_src[1] . 'x' . $image_full_src[2];
			} else {
				$image_small_src[0]  = wc_placeholder_img_src();
				$image_medium_src[0] = wc_placeholder_img_src();
				$image_full_src[0]   = wc_placeholder_img_src();
			}

			$gallery_id        = $product->get_gallery_image_ids();
			?>
			<div class="product-images">
				<div id="product-images" itemscope itemtype="http://schema.org/ImageGallery">
					<figure class="image-item ez-zoom" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
						<a href="<?php echo esc_url( $image_full_src[0] ); ?>" data-size="<?php echo esc_attr( $image_size ); ?>" itemprop="contentUrl" data-elementor-open-lightbox="no">
							<img src="<?php echo esc_url( $image_medium_src[0] ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" itemprop="thumbnail">
						</a>
					</figure>

					<?php
					if ( ! empty( $gallery_id ) ) :
						foreach ( $gallery_id as $key ) :
							$g_full_img_src   = wp_get_attachment_image_src( $key, 'full' );
							$g_medium_img_src = wp_get_attachment_image_src( $key, 'woocommerce_single' );
							$g_image_size     = $g_medium_img_src[1] . 'x' . $g_medium_img_src[2];
							$g_img_alt        = ubit_image_alt( $key, esc_attr__( 'Product image', 'ubit' ) );
							?>
							<figure class="image-item ez-zoom" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
								<a href="<?php echo esc_url( $g_full_img_src[0] ); ?>" data-size="<?php echo esc_attr( $g_image_size ); ?>" itemprop="contentUrl" data-elementor-open-lightbox="no">
									<img src="<?php echo esc_url( $g_medium_img_src[0] ); ?>" alt="<?php echo esc_attr( $g_img_alt ); ?>" itemprop="thumbnail">
								</a>
							</figure>
							<?php
							endforeach;
						endif;
					?>
				</div>
			</div>
			<?php
		}

		/**
		 * Product gallery product thumbnail slider
		 */
		public function ubit_single_product_gallery_thumb_slide() {
			global $product;
			if ( ! is_object( $product ) ) {
				$id = $this->ubit_get_last_product_id();
				if ( ! $id ) {
					return;
				}

				$product = wc_get_product( $id );
			}

			$image_id   = $product->get_image_id();
			$image_alt  = ubit_image_alt( $image_id, esc_attr__( 'Product image', 'ubit' ) );

			if ( $image_id ) {
				$image_small_src  = wp_get_attachment_image_src( $image_id, 'thumbnail' );
				$image_medium_src = wp_get_attachment_image_src( $image_id, 'woocommerce_single' );
				$image_full_src   = wp_get_attachment_image_src( $image_id, 'full' );
			} else {
				$image_small_src[0]  = wc_placeholder_img_src();
				$image_medium_src[0] = wc_placeholder_img_src();
				$image_full_src[0]   = wc_placeholder_img_src();
			}

			$gallery_id = $product->get_gallery_image_ids();
			?>
			<div class="product-thumbnail-images">
				<?php if ( ! empty( $gallery_id ) ) { ?>
				<div id="product-thumbnail-images">
					<div class="thumbnail-item">
						<img src="<?php echo esc_url( $image_small_src[0] ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>">
					</div>

					<?php
					foreach ( $gallery_id as $key ) :
						$g_thumb_src = wp_get_attachment_image_src( $key, 'thumbnail' );
						$g_thumb_alt = ubit_image_alt( $key, esc_attr__( 'Product image', 'ubit' ) );
						?>
						<div class="thumbnail-item">
							<img src="<?php echo esc_url( $g_thumb_src[0] ); ?>" alt="<?php echo esc_attr( $g_thumb_alt ); ?>">
						</div>
					<?php endforeach; ?>
				</div>
				<?php } ?>
			</div>
			<?php
		}

		/**
		 * Single gallery product gallery script and style dependency
		 */
		public function ubit_single_product_gallery_dependency() {
			// Photoswipe markup html.
			get_template_part( 'template-parts/content', 'photoswipe' );
		}

		/**
		 * Single product gallery close
		 */
		public function ubit_single_product_gallery_close() {
			echo '</div>';
		}

		/**
		 * Product container close.
		 */
		public function ubit_single_product_container_close() {
			?>
				</div>
			</div>
			<?php
		}

		/**
		 * Container after summary open
		 */
		public function ubit_single_product_after_summary_open() {
			$container = ubit_site_container();
			echo '<div class="' . esc_attr( $container ) . '">';
		}

		/**
		 * Container after summary close
		 */
		public function ubit_single_product_after_summary_close() {
			echo '</div>';
		}

		/**
		 * Get product item in cart
		 */
		public function ubit_get_product_item_incart() {
			check_ajax_referer( 'ubit_ajax_mini_cart', 'nonce' );

			$response = array(
				'item' => 0,
			);

			if ( ! isset( $_POST['product_id'] ) ) {
				echo json_encode( $response );
				exit();
			}

			$product_id = intval( $_POST['product_id'] );
			$item       = ubit_product_check_in( $product_id, $in_cart = false, $qty_in_cart = true );

			ob_start();

			$response['item'] = $item;

			ob_get_clean();

			wp_send_json( $response );
		}

		/**
		 * Add clear shop cart button
		 */
		public function ubit_clear_shop_cart() {
			$clear = wc_get_cart_url() . '?empty-cart';
			?>
			<div class="clear-cart-box">
				<a class="clear-cart-btn" href="<?php echo esc_url( $clear ); ?>">
					<?php esc_html_e( 'Clear cart', 'ubit' ); ?>
				</a>
			</div>
			<?php
		}

		/**
		 * Get the last ID of product
		 */
		public function ubit_get_last_product_id() {
			$args = array(
				'post_type'           => 'product',
				'posts_per_page'      => 1,
				'post_status'         => 'publish',
				'ignore_sticky_posts' => 1,
			);

			$query = new WP_Query( $args );

			$id = false;

			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post();

					$id = get_the_ID();
				}

				wp_reset_postdata();
			}

			return $id;
		}
	}
	Ubit_WooCommerce::get_instance();

endif;
