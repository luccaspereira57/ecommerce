<?php
/**
 * Ubit Customizer Class
 *
 * @package ubit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Ubit_Customizer' ) ) :

	/**
	 * The Ubit Customizer class
	 */
	class Ubit_Customizer {

		/**
		 * Setup class.
		 */
		public function __construct() {
			add_action( 'customize_register', array( $this, 'ubit_customize_register' ) );
			add_action( 'customize_controls_enqueue_scripts', array( $this, 'ubit_customize_controls_scripts' ) );
		}

		/**
		 * Add script for customize controls
		 */
		public function ubit_customize_controls_scripts() {
			wp_enqueue_script(
				'ubit-condition-control',
				UBIT_THEME_URI . 'inc/customizer/custom-controls/conditional/js/condition.js',
				array(),
				ubit_version(),
				true
			);
		}

		/**
		 * Returns an array of the desired default Ubit settings
		 *
		 * @return array
		 */
		public static function ubit_get_ubit_default_setting_values() {
			return apply_filters(
				'ubit_setting_default_values',
				$args = array(
					// Site.
					'default_container'                       => 'normal',

					// Logo.
					'retina_logo'                             => '',
					'logo_mobile'                             => '',
					'logo_width'                              => '',
					'tablet_logo_width'                       => '',
					'mobile_logo_width'                       => '',

					// Color.
					'theme_color'                             => '#e250ab',
					'primary_menu_color'                      => '#2b2b2b',
					'primary_sub_menu_color'                  => '#2b2b2b',
					'heading_color'                           => '#2b2b2b',
					'text_color'                              => '#404040',
					'accent_color'                            => '#2b2b2b',

					// Topbar.
					'topbar_text_color'                       => '#ffffff',
					'topbar_background_color'                 => '#2b2b2b',
					'topbar_space'                            => 0,
					'topbar_left'                             => '',
					'topbar_center'                           => '',
					'topbar_right'                            => '',

					// Header.
					'header_layout'                           => 'layout-1',
					'header_background_color'                 => '#ffffff',
					'header_primary_menu'                     => true,
					'header_search_icon'                      => true,
					'header_wishlist_icon'                    => false,
					'header_search_only_product'              => true,
					'header_account_icon'                     => false,
					'header_shop_cart_icon'                   => false,

					// Header transparent.
					'header_transparent'                      => false,
					'header_transparent_enable_on'            => 'all-devices',
					'header_transparent_disable_archive'      => true,
					'header_transparent_disable_index'        => false,
					'header_transparent_disable_page'         => false,
					'header_transparent_disable_post'         => false,
					'header_transparent_disable_shop'         => false,
					'header_transparent_disable_product'      => false,
					'header_transparent_border_width'         => 0,
					'header_transparent_border_color'         => '#ffffff',
					'header_transparent_box_shadow'           => false,
					'header_transparent_shadow_type'          => 'outset',
					'header_transparent_shadow_x'             => 0,
					'header_transparent_shadow_y'             => 0,
					'header_transparent_shadow_blur'          => 0,
					'header_transparent_shadow_spread'        => 0,
					'header_transparent_shadow_color'         => '#000000',

					// Page header.
					'page_header_display'                     => true,
					'page_header_breadcrumb'                  => true,
					'page_header_text_align'                  => 'center',
					'page_header_title_color'                 => '#2b2b2b',
					'page_header_breadcrumb_text_color'       => '#404040',
					'page_header_background_color'            => '#f2f2f2',
					'page_header_background_image'            => '',
					'page_header_background_image_size'       => 'auto',
					'page_header_background_image_repeat'     => 'repeat',
					'page_header_background_image_position'   => 'center-center',
					'page_header_background_image_attachment' => 'scroll',

					'page_header_padding_top'                 => 40,
					'page_header_padding_bottom'              => 45,
					'page_header_margin_bottom'               => 40,

					// Footer.
					'scroll_to_top'                           => true,
					'footer_display'                          => true,
					'footer_space'                            => 100,
					'footer_column'                           => 4,
					'footer_background_color'                 => '#eeeeec',
					'footer_heading_color'                    => '#e250ab',
					'footer_link_color'                       => '#404040',
					'footer_text_color'                       => '#404040',
					'footer_custom_text'                      => ubit_footer_custom_text(),

					// Buttons.
					'button_text_color'                       => '#ffffff',
					'button_background_color'                 => '#e250ab',
					'button_hover_text_color'                 => '#ffffff',
					'button_hover_background_color'           => '#3a3a3a',
					'buttons_border_radius'                   => 50,

					// Blog.
					'blog_list_layout'                        => 'list',
					'blog_list_limit_exerpt'                  => 44,
					'blog_list_feature_image'                 => true,
					'blog_list_title'                         => true,
					'blog_list_publish_date'                  => true,
					'blog_list_author'                        => true,
					'blog_list_category'                      => true,
					'blog_list_comment'                       => true,

					// Blog single.
					'blog_single_feature_image'               => true,
					'blog_single_title'                       => true,
					'blog_single_author_box'                  => true,
					'blog_single_publish_date'                => true,
					'blog_single_author'                      => true,
					'blog_single_category'                    => true,
					'blog_single_comment'                     => true,
					'blog_single_related_post'                => false,

					// Shop.
					'shop_columns'                            => 4,
					'shop_product_per_page'                   => 12,
					'shop_page_title'                         => true,
					'shop_page_breadcrumb'                    => true,
					'shop_page_product_title'                 => true,
					'shop_page_product_category'              => false,
					'shop_page_product_rating'                => false,
					'shop_page_product_add_to_cart_button'    => false,
					'shop_page_product_price'                 => true,

					// Product style.
					'product_style'                           => 'layout-1',
					'product_style_defaut_add_to_cart'        => true,

					// Shop single.
					'shop_single_content_background'          => '#ffffff',
					'shop_single_gallery_layout'              => 'horizontal',
					'shop_single_breadcrumb'                  => true,
					'shop_single_skus'                        => true,
					'shop_single_categories'                  => true,
					'shop_single_tags'                        => true,

					// Sidebar.
					'sidebar_default'                         => is_rtl() ? 'left' : 'right',
					'sidebar_page'                            => 'full',
					'sidebar_blog'                            => 'default',
					'sidebar_blog_single'                     => 'default',
					'sidebar_shop'                            => 'default',
					'sidebar_shop_single'                     => 'full',

					// 404.
					'error_404_title'                         => esc_html__( '404', 'ubit' ),
					'error_404_text'                          => esc_html__( 'Oops! Page not found.', 'ubit' ),
					'error_404_image'                         => get_template_directory_uri() . '/assets/images/customizer/404/hero-paint-1.png',
				)
			);
		}

		/**
		 * Get all of the Ubit theme option.
		 *
		 * @return array $ubit_options The Ubit Theme Options.
		 */
		public function ubit_get_ubit_options() {
			$ubit_options = wp_parse_args(
				get_option( 'ubit_setting', array() ),
				self::ubit_get_ubit_default_setting_values()
			);

			return apply_filters( 'ubit_options', $ubit_options );
		}

		/**
		 * Add postMessage support for site title and description for the Theme Customizer along with several other settings.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		public function ubit_customize_register( $wp_customize ) {

			// Custom default section, panel.
			require_once UBIT_THEME_DIR . 'inc/customizer/override-defaults.php';

			// Add customizer custom controls.
			$customizer_controls = glob( UBIT_THEME_DIR . 'inc/customizer/custom-controls/**/*.php' );
			foreach ( $customizer_controls as $file ) {
				if ( file_exists( $file ) ) {
					require_once $file;
				}
			}

			// Register section & panel.
			require_once UBIT_THEME_DIR . 'inc/customizer/register-sections.php';

			// Add customizer sections.
			$customizer_sections = glob( UBIT_THEME_DIR . 'inc/customizer/sections/**/*.php' );
			foreach ( $customizer_sections as $file ) {
				if ( file_exists( $file ) ) {
					require_once $file;
				}
			}

			// Register Control Type.
			if ( method_exists( $wp_customize, 'register_control_type' ) ) {
				$wp_customize->register_control_type( 'Ubit_Color_Control' );
				$wp_customize->register_control_type( 'Ubit_Typography_Control' );
				$wp_customize->register_control_type( 'Ubit_Range_Slider_Control' );
			}
		}
	}

endif;

return new Ubit_Customizer();
