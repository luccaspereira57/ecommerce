<?php
/**
 * Ubit Get CSS
 *
 * @package ubit
 */

/**
 * The Ubit Get CSS class
 */
class Ubit_Get_CSS {
	/**
	 * The list of fallback fonts.
	 *
	 * @var string
	 */
	public $fallback_font_family = 'Arial, Helvetica, sans-serif';

	/**
	 * Wp enqueue scripts
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'ubit_add_customizer_css' ), 130 );
		add_action( 'enqueue_block_editor_assets', array( $this, 'ubit_guten_block_editor_assets' ) );
	}

	/**
	 * Get Customizer css.
	 *
	 * @see get_ubit_theme_mods()
	 * @return array $styles the css
	 */
	public function ubit_get_css() {

		// Get all theme option value.
		$options = ubit_options( false );

		// GENERATE CSS.
		// Remove outline select on Firefox.
		$styles = '
			select:-moz-focusring{
				text-shadow: 0 0 0 ' . esc_attr( $options['text_color'] ) . ';
			}
		';

		// Logo width.
		$logo_width        = $options['logo_width'];
		$tablet_logo_width = $options['tablet_logo_width'];
		$mobile_logo_width = $options['mobile_logo_width'];
		if ( $logo_width && $logo_width > 0 ) {
			$styles .= '
				@media ( min-width: 769px ) {
					.elementor .site-branding img,
					.site-branding img{
						max-width: ' . esc_attr( $logo_width ) . 'px;
					}
				}
			';
		}

		if ( $tablet_logo_width && $tablet_logo_width > 0 ) {
			$styles .= '
				@media ( min-width: 481px ) and ( max-width: 768px ) {
					.elementor .site-branding img,
					.site-branding img{
						max-width: ' . esc_attr( $tablet_logo_width ) . 'px;
					}
				}
			';
		}

		if ( $mobile_logo_width && $mobile_logo_width > 0 ) {
			$styles .= '
				@media ( max-width: 480px ) {
					.elementor .site-branding img,
					.site-branding img{
						max-width: ' . esc_attr( $mobile_logo_width ) . 'px;
					}
				}
			';
		}

		// Topbar.
		$styles .= '
			.topbar{
				background-color: ' . esc_attr( $options['topbar_background_color'] ) . ';
				padding: ' . esc_attr( $options['topbar_space'] ) . 'px 0;
			}
			.topbar *{
				color: ' . esc_attr( $options['topbar_text_color'] ) . ';
			}
		';

		// Body css.
		$styles .= '
			body, select, button, input, textarea{
				font-family: ' . esc_attr( $options['body_font_family'] ) . ', ' . esc_attr( $this->fallback_font_family ) . ';
				font-weight: ' . esc_attr( $options['body_font_weight'] ) . ';
				line-height: ' . esc_attr( $options['body_line_height'] ) . 'px;
				text-transform: ' . esc_attr( $options['body_font_transform'] ) . ';
				font-size: ' . esc_attr( $options['body_font_size'] ) . 'px;
				color: ' . esc_attr( $options['text_color'] ) . ';
			}

			.alpha.entry-title a,
			.pagination a,
			.summary.entry-summary .price del .woocommerce-Price-amount,
			.product-loop-meta .price del .woocommerce-Price-amount,
			.woocommerce-pagination a,
			.woocommerce-loop-product__category a,
			.woocommerce-loop-product__title,
			.price del,
			.stars a,
			.woocommerce-review-link,
			.woocommerce-tabs .tabs li a,
			.woocommerce-cart-form__contents .product-remove a,
			.ubit-breadcrumb a,
			.breadcrumb-separator,
			#secondary .widget a,
			.has-ubit-text-color,
			.clear-cart-btn{
				color: ' . esc_attr( $options['text_color'] ) . ';
			}

			.price_slider_wrapper .price_slider,
			.has-ubit-text-background-color{
				background-color: ' . esc_attr( $options['text_color'] ) . ';
			}

			.elementor-add-to-cart .quantity,
			.clear-cart-btn{
				border: 1px solid ' . esc_attr( $options['text_color'] ) . ';
			}

			.product .woocommerce-loop-product__title{
				font-size: ' . esc_attr( $options['body_font_size'] ) . 'px;
			}
		';

		// Primary menu css.
		$styles .= '
			@media ( min-width: 991px ) {
				.primary-navigation a{
					font-family: ' . esc_attr( $options['menu_font_family'] ) . ', ' . esc_attr( $this->fallback_font_family ) . ';
					font-weight: ' . esc_attr( $options['menu_font_weight'] ) . ';
					text-transform: ' . esc_attr( $options['menu_font_transform'] ) . ';
				}

				.primary-navigation > li > a{
					font-size: ' . esc_attr( $options['parent_menu_font_size'] ) . 'px;
					line-height: ' . esc_attr( $options['parent_menu_line_height'] ) . 'px;
					color: ' . esc_attr( $options['primary_menu_color'] ) . ';
				}

				.primary-navigation .sub-menu a{
					line-height: ' . esc_attr( $options['sub_menu_line_height'] ) . 'px;
					font-size: ' . esc_attr( $options['sub_menu_font_size'] ) . 'px;
					color: ' . esc_attr( $options['primary_sub_menu_color'] ) . ';
				}
			}
		';

		// Heading css.
		$styles .= '
			h1, h2, h3, h4, h5, h6,
			#reply-title, .has-large-font-size{
				font-family: ' . esc_attr( $options['heading_font_family'] ) . ', ' . esc_attr( $this->fallback_font_family ) . ';
				font-weight: ' . esc_attr( $options['heading_font_weight'] ) . ';
				text-transform: ' . esc_attr( $options['heading_font_transform'] ) . ';
				line-height: ' . esc_attr( $options['heading_line_height'] ) . ';
				color: ' . esc_attr( $options['heading_color'] ) . ';
			}
			h1,
			.has-ubit-heading-1-font-size{
				font-size: ' . esc_attr( $options['heading_h1_font_size'] ) . 'px;
			}
			h2,
			.has-ubit-heading-2-font-size{
				font-size: ' . esc_attr( $options['heading_h2_font_size'] ) . 'px;
			}
			h3,
			.has-ubit-heading-3-font-size{
				font-size: ' . esc_attr( $options['heading_h3_font_size'] ) . 'px;
			}
			h4,
			.has-ubit-heading-4-font-size{
				font-size: ' . esc_attr( $options['heading_h4_font_size'] ) . 'px;
			}
			h5,
			.has-ubit-heading-5-font-size,
			.has-large-font-size{
				font-size: ' . esc_attr( $options['heading_h5_font_size'] ) . 'px;
			}
			h6,
			.has-ubit-heading-6-font-size{
				font-size: ' . esc_attr( $options['heading_h6_font_size'] ) . 'px;
			}

			.ubit-shop-category .elementor-widget-wrap > .elementor-widget-image .wp-caption .wp-caption-text {
				font-family: ' . esc_attr( $options['heading_font_family'] ) . ', ' . esc_attr( $this->fallback_font_family ) . ';
			}

			.product-loop-meta .price,
			.variations label,
			.woocommerce-review__author,
			.button[name="apply_coupon"],
			.button[name="apply_coupon"]:hover,
			.button[name="update_cart"],
			.quantity .qty,
			.form-row label,
			.select2-container--default .select2-selection--single .select2-selection__rendered,
			.form-row .input-text:focus,
			.wc_payment_method label,
			.woocommerce-checkout-review-order-table thead th,
			.woocommerce-checkout-review-order-table .product-name,
			.woocommerce-thankyou-order-details strong,
			.woocommerce-table--order-details th,
			.woocommerce-table--order-details .amount,
			.wc-breadcrumb .ubit-breadcrumb,
			.sidebar-menu .primary-navigation .arrow-icon,
			.default-widget a strong:hover,
			.ubit-subscribe-form input,
			.ubit-shop-category .elementor-widget-image .widget-image-caption,
			.shop_table_responsive td:before,
			.cart-collaterals th,
			.woocommerce-mini-cart__total strong,
			.woocommerce-form-login-toggle .woocommerce-info a,
			.has-ubit-heading-color{
				color: ' . esc_attr( $options['heading_color'] ) . ';
			}

			.has-ubit-heading-background-color{
				background-color: ' . esc_attr( $options['heading_color'] ) . ';
			}

			.variations label{
				font-weight: ' . esc_attr( $options['heading_font_weight'] ) . ';
			}
		';

		// Link color.
		$styles .= '
			.cart-sidebar-content .woocommerce-mini-cart__buttons a:not(.checkout),
			.site-tools .header-search-icon,
			.ps-layout-1 .product-loop-meta .button,
			.ps-layout-1 .loop-add-to-cart-btn,
			a{
				color: ' . esc_attr( $options['accent_color'] ) . ';
			}

			.ubit-icon-bar span{
				background-color: ' . esc_attr( $options['accent_color'] ) . ';
			}

			.site-tools .header-search-icon:hover,
			a:hover,
			.topbar a:hover,
			.topbar a:hover *,
			.ps-layout-1 .product-loop-meta .button:hover,
			.ps-layout-1 .loop-add-to-cart-btn:hover,
			#secondary .widget a:not(.tag-cloud-link):hover,
			.cart-sidebar-content .woocommerce-mini-cart__buttons a:not(.checkout):hover,
			.custom-eael-grid-1 .eael-grid-post .eael-post-elements-readmore-btn,
			.post .entry-meta a:hover{
				color: ' . esc_attr( $options['theme_color'] ) . ';
			}
		';

		// Buttons.
		$styles .= '
			.ubit-button-color {
				color: ' . esc_attr( $options['button_text_color'] ) . ';
			}
			.ubit-button-bg-color {
				background-color: ' . esc_attr( $options['button_background_color'] ) . ';
			}
			.ubit-button-hover-color {
				color: ' . esc_attr( $options['button_hover_text_color'] ) . ';
			}
			.ubit-button-hover-bg-color {
				background-color: ' . esc_attr( $options['button_hover_background_color'] ) . ';
			}

			.button,
			#scroll-to-top,
			.comment-body .reply a,
			.woocommerce-widget-layered-nav-dropdown__submit,
			.form-submit .submit,
			.elementor-button-wrapper .elementor-button,
			.ubit-contact-form input[type="submit"],
			.has-ubit-contact-form input[type="submit"],
			#secondary .widget a.button,
			.ps-layout-1 .product-loop-meta.no-transform .button,
			.ps-layout-1 .product-loop-meta.no-transform .added_to_cart,
			.mc4wp-form input[type="submit"]{
				background-color: ' . esc_attr( $options['button_background_color'] ) . ';
				color: ' . esc_attr( $options['button_text_color'] ) . ';
				border-radius: ' . esc_attr( $options['buttons_border_radius'] ) . 'px;
			}

			.mc4wp-form input[type="submit"]{
				border: 1px solid ' . esc_attr( $options['button_background_color'] ) . ';
			}

			.cart .quantity,
			.clear-cart-btn{
				border-radius: ' . esc_attr( $options['buttons_border_radius'] ) . 'px;
			}

			.button:hover,
			#scroll-to-top:hover,
			.comment-body .reply a:hover,
			.woocommerce-widget-layered-nav-dropdown__submit:hover,
			.form-submit .submit:hover,
			.elementor-button-wrapper .elementor-button:hover,
			.ubit-contact-form input[type="submit"]:hover,
			.has-ubit-contact-form input[type="submit"]:hover,
			#secondary .widget a.button:hover,
			.ps-layout-1 .product-loop-meta.no-transform .button:hover,
			.ps-layout-1 .product-loop-meta.no-transform .added_to_cart:hover,
			.mc4wp-form input[type="submit"]:hover{
				background-color: ' . esc_attr( $options['button_hover_background_color'] ) . ';
				color: ' . esc_attr( $options['button_hover_text_color'] ) . ';
			}

			.mc4wp-form input[type="submit"]:hover{
				border: 1px solid ' . esc_attr( $options['button_hover_background_color'] ) . ';
			}

			.select2-container--default .select2-results__option--highlighted[aria-selected],
			.select2-container--default .select2-results__option--highlighted[data-selected]{
				background-color: ' . esc_attr( $options['button_background_color'] ) . ' !important;
			}

			.single_add_to_cart_button:not(.disabled),
			.checkout-button{
				/*box-shadow: 0px 10px 40px 0px ' . ubit_hex_to_rgba( esc_attr( $options['button_background_color'] ), 0.3 ) . ';*/
			}

			@media ( max-width: 600px ) {
				.woocommerce-cart-form__contents [name="update_cart"],
				.woocommerce-cart-form__contents .coupon button,
				.checkout_coupon.woocommerce-form-coupon [name="apply_coupon"],
				.clear-cart-btn{
					background-color: ' . esc_attr( $options['button_background_color'] ) . ';
				}
				.woocommerce-cart-form__contents [name="update_cart"],
				.woocommerce-cart-form__contents .coupon button,
				.checkout_coupon.woocommerce-form-coupon [name="apply_coupon"],
				.clear-cart-box .clear-cart-btn{
					color: ' . esc_attr( $options['button_text_color'] ) . ';
				}
			}
		';

		// Theme color.
		$styles .= '
			.ubit-theme-color,
			body:not(.error404) .primary-navigation li.current-menu-item > a,
			body:not(.error404) .primary-navigation li.current-menu-ancestor > a,
			body:not(.error404) .primary-navigation li.current-menu-parent > a,
			body:not(.error404) .primary-navigation li.current_page_parent > a,
			body:not(.error404) .primary-navigation li.current_page_ancestor > a,
			body:not(.error404) .primary-navigation li.current_page_item > a,
			.summary.entry-summary .price .woocommerce-Price-amount,
			.product-loop-meta .price .woocommerce-Price-amount,
			.woocommerce-cart-form__contents .product-subtotal,
			.woocommerce-checkout-review-order-table .order-total,
			.woocommerce-table--order-details .product-name a,
			.primary-navigation a:hover,
			.primary-navigation .menu-item-has-children:hover > a,
			.default-widget a strong,
			.woocommerce-mini-cart__total .amount,
			.woocommerce-form-login-toggle .woocommerce-info a:hover,
			.has-ubit-primary-color,
			.blog-layout-grid .site-main .post-read-more a,
			.site-footer a:hover,
			.ubit-simple-subsbrice-form input[type="submit"],
			.alpha.entry-title a:hover,
			.widget-title,
			.widgettitle,
			#secondary .widget .current-cat > a,
			#secondary .widget .current-cat > span,
			#secondary .widget .woocommerce-widget-layered-nav-list__item--chosen > a,
			#secondary .widget .woocommerce-widget-layered-nav-list__item--chosen > span,
			.widget .post-date,
			.widget .rpwwt-post-date,
			.widget #wp-calendar tbody td a,
			.site-header-inner .site-branding .beta.site-title a,
			.star-rating > span:before,
			.stars.selected span a,
			.stars.selected span:hover a,
			.stars.selected span:hover a.active ~ a,
			.stars:not(.selected) span:hover a,
			.product-loop-action .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a,
			blockquote:before,
			.ubit-breadcrumb .item-bread:after,
			.site-main nav.navigation.post-navigation .nav-previous a i,
			.site-main nav.navigation.post-navigation .nav-next a i{
				color: ' . esc_attr( $options['theme_color'] ) . ';
			}

			.onsale,
			.pagination li .page-numbers.current,
			.woocommerce-pagination li .page-numbers.current,
			.tagcloud a:hover,
			.price_slider_wrapper .ui-widget-header,
			.price_slider_wrapper .ui-slider-handle,
			.cart-sidebar-head .shop-cart-count,
			.shop-cart-count,
			.sidebar-menu .primary-navigation a:before,
			.woocommerce-message,
			.woocommerce-info,
			.woocommerce-store-notice,
			.has-ubit-primary-background-color,
			.ubit-simple-subsbrice-form input[type="submit"]:hover,
			.post.sticky .alpha.entry-title:before,
			.post-author-box .author-ava.author-avatar-default img{
				background-color: ' . esc_attr( $options['theme_color'] ) . ';
			}

			.wcpscwc-product-slider button.slick-arrow:hover,
			div#n2-ss-2 .nextend-arrow:hover,
			.tns-controls [data-controls]:hover {
			  background-color: ' . esc_attr( $options['theme_color'] ) . ' !important;
			}

			/* Fix issue not showing on IE */
			.ubit-simple-subsbrice-form:focus-within input[type="submit"]{
				background-color: ' . esc_attr( $options['theme_color'] ) . ';
			}
		';

		// Header.
		$styles .= '
			.site-header-inner{
				background-color: ' . esc_attr( $options['header_background_color'] ) . ';
			}
			.site-header-inner .site-branding .beta.site-title {
				font-family: ' . esc_attr( $options['heading_font_family'] ) . ', ' . esc_attr( $this->fallback_font_family ) . ';
			}
			.site-header-inner .site-branding .beta.site-title a:hover{
				color: ' . esc_attr( $options['primary_menu_color'] ) . ';
			}
		';

		// Header transparent.
		if ( ubit_header_transparent() ) {
			$styles .= '
				.has-header-transparent .site-header-inner{
					border-bottom-width: ' . esc_attr( $options['header_transparent_border_width'] ) . 'px;
					border-bottom-color: ' . esc_attr( $options['header_transparent_border_color'] ) . ';
				}
			';
		}

		// Page header.
		if ( $options['page_header_display'] ) {
			$page_header_background_image = '';
			if ( $options['page_header_background_image'] ) {
				$page_header_background_image .= 'background-image: url(' . esc_attr( $options['page_header_background_image'] ) . ');';
				$page_header_background_image .= 'background-size: ' . esc_attr( $options['page_header_background_image_size'] ) . ';';
				$page_header_background_image .= 'background-repeat: ' . esc_attr( $options['page_header_background_image_repeat'] ) . ';';
				$page_header_bg_image_position = str_replace( '-', ' ', $options['page_header_background_image_position'] );
				$page_header_background_image .= 'background-position: ' . esc_attr( $page_header_bg_image_position ) . ';';
				$page_header_background_image .= 'background-attachment: ' . esc_attr( $options['page_header_background_image_attachment'] ) . ';';
			}

			$styles .= '
				.page-header{
					padding-top: ' . esc_attr( $options['page_header_padding_top'] ) . 'px;
					padding-bottom: ' . esc_attr( $options['page_header_padding_bottom'] ) . 'px;
					margin-bottom: ' . esc_attr( $options['page_header_margin_bottom'] ) . 'px;
					background-color: ' . esc_attr( $options['page_header_background_color'] ) . ';' . $page_header_background_image . '
				}

				.page-header .entry-title{
					color: ' . esc_attr( $options['page_header_title_color'] ) . ';
				}

				.ubit-breadcrumb,
				.ubit-breadcrumb a{
					color: ' . esc_attr( $options['page_header_breadcrumb_text_color'] ) . ';
				}
			';
		}

		// Footer.
		$styles .= '
			.site-footer{
				margin-top: ' . esc_attr( $options['footer_space'] ) . 'px;
			}

			.site-footer a{
				color: ' . esc_attr( $options['footer_link_color'] ) . ';
			}

			.site-footer{
				background-color: ' . esc_attr( $options['footer_background_color'] ) . ';
				color: ' . esc_attr( $options['footer_text_color'] ) . ';
			}

			.site-footer-widget #wp-calendar tfoot td {
				border: 1px solid ' . esc_attr( $options['footer_background_color'] ) . ';
			}

			.site-footer .widget-title,
			.ubit-footer-social-icon a{
				color: ' . esc_attr( $options['footer_heading_color'] ) . ';
			}

			.ubit-footer-social-icon a:hover{
				background-color: ' . esc_attr( $options['footer_heading_color'] ) . ';
				border-color: ' . esc_attr( $options['footer_heading_color'] ) . ';
			}

			.ubit-footer-social-icon a {
				border-color: ' . esc_attr( $options['footer_heading_color'] ) . ';
			}
		';

		// Spinner color.
		$styles .= '
			.circle-loading:before,
			.product_list_widget .remove_from_cart_button:focus:before,
			.updating-cart.ajax-single-add-to-cart .single_add_to_cart_button:before,
			.product-loop-meta .loading:before,
			.updating-cart #shop-cart-sidebar:before,
			#product-images:not(.tns-slider) .image-item:first-of-type:before,
			#product-thumbnail-images:not(.tns-slider) .thumbnail-item:first-of-type:before{
				border-top-color: ' . esc_attr( $options['theme_color'] ) . ';
			}
		';

		// WooCommerce.
		// Shop single.
		$styles .= '
			.single-product .content-top,
			.product-page-container{
				background-color:  ' . esc_attr( $options['shop_single_content_background'] ) . ';
			}
		';

		// 404.
		$error_404_bg = $options['error_404_image'];
		if ( $error_404_bg ) {
			$styles .= '
				.error404 .site-content{
					background-image: url(' . esc_url( $error_404_bg ) . ');
				}
			';
		}

		return apply_filters( 'ubit_customizer_css', $styles );
	}

	/**
	 * Add Gutenberg css.
	 */
	public function ubit_guten_block_editor_assets() {
		// Get all theme option value.
		$options = ubit_options( false );

		$block_styles = '
			.edit-post-visual-editor, .edit-post-visual-editor p{
				font-family: ' . esc_attr( $options['body_font_family'] ) . ', ' . esc_attr( $this->fallback_font_family ) . ';
			}

			.editor-post-title__block .editor-post-title__input,
			.wp-block-heading, .editor-rich-text__tinymce{
				font-family: ' . esc_attr( $options['heading_font_family'] ) . ', ' . esc_attr( $this->fallback_font_family ) . ';
			}
		';

		wp_register_style( 'ubit-block-editor', false ); // @codingStandardsIgnoreLine
		wp_enqueue_style( 'ubit-block-editor' );
		wp_add_inline_style( 'ubit-block-editor', $block_styles );
	}

	/**
	 * Add CSS in <head> for styles handled by the theme customizer
	 *
	 * @return void
	 */
	public function ubit_add_customizer_css() {
		wp_add_inline_style( 'ubit-style', $this->ubit_get_css() );
	}
}

return new Ubit_Get_CSS();
