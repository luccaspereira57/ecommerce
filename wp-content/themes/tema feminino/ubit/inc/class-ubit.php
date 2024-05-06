<?php
/**
 * Ubit Class
 *
 * @package ubit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Ubit' ) ) :

	/**
	 * The main Ubit class
	 */
	class Ubit {

		/**
		 * Setup class.
		 */
		public function __construct() {
			// Set the content width based on the theme's design and stylesheet.
			$this->ubit_content_width();

			add_filter( 'http_request_args', array( $this, 'ubit_update_check' ), 5, 2 );
			add_action( 'after_setup_theme', array( $this, 'ubit_setup' ) );
			add_action( 'wp', array( $this, 'ubit_init' ) );
			add_action( 'widgets_init', array( $this, 'ubit_widgets_init' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'ubit_scripts' ), 10 );
			add_filter( 'wpcf7_load_css', '__return_false' );
			add_filter( 'excerpt_length', array( $this, 'ubit_limit_excerpt_character' ), 99 );

			// ELEMENTOR.
			add_action( 'elementor/theme/register_locations', array( $this, 'ubit_register_elementor_locations' ) );
			add_action( 'elementor/elements/categories_registered', array( $this, 'ubit_widget_categories' ) );
			add_action( 'elementor/preview/enqueue_scripts', array( $this, 'ubit_elementor_preview_scripts' ) );

			// Instagram Feed.
			add_filter( 'sbi_access_tokens', array( $this, 'ubit_sbi_access_tokens' ) );

			// Add Image column on blog list in admin screen.
			add_filter( 'manage_post_posts_columns', array( $this, 'ubit_columns_head' ), 10 );
			add_action( 'manage_post_posts_custom_column', array( $this, 'ubit_columns_content' ), 10, 2 );

			add_filter( 'body_class', array( $this, 'ubit_body_classes' ) );
			add_filter( 'ubit_header_class', array( $this, 'ubit_header_classes' ) );
			add_filter( 'wp_page_menu_args', array( $this, 'ubit_page_menu_args' ) );
			add_filter( 'navigation_markup_template', array( $this, 'ubit_navigation_markup_template' ), 10, 2 );
			add_action( 'customize_preview_init', array( $this, 'ubit_customize_live_preview' ) );
			add_filter( 'wp_tag_cloud', array( $this, 'ubit_remove_tag_inline_style' ) );
			add_filter( 'excerpt_more', array( $this, 'ubit_modify_excerpt_more' ) );
		}

		/**
		 * Don't update the theme from WordPress.org.
		 *
		 * If there is a theme in the WordPress.org repo with the same name, this prevents WordPress from prompting an update.
		 *
		 * @param  array $r An array of HTTP request arguments.
		 * @param  string $url The request URL.
		 * @return array A modified array of HTTP request arguments.
		 */
		public function ubit_update_check( $r, $url ) {
			// Theme update request.
			if ( false !== strpos( $url, '//api.wordpress.org/themes/update-check/1.1/' ) ) {
				// Decode JSON so we can manipulate the array.
				$data = json_decode( $r['body']['themes'] );

				// Remove the active parent and child themes from the update check.
				unset( $data->themes->{ get_option( 'template' ) } );
				unset( $data->themes->{ get_option( 'stylesheet' ) } );

				// Encode back into JSON and update the response.
			 	$r['body']['themes'] = wp_json_encode( $data );
			}

		 	return $r;
		}

		/**
		 * Set the content width based on the theme's design and stylesheet.
		 */
		public function ubit_content_width() {
			if ( ! isset( $content_width ) ) {
				// Pixel.
				$content_width = 1170;
			}
		}

		/**
		 * Get featured image
		 *
		 * @param      int $post_ID The post id.
		 * @return     string Image src.
		 */
		public function ubit_get_featured_image_src( $post_ID ) {
			$img_id  = get_post_thumbnail_id( $post_ID );
			$img_src = UBIT_THEME_URI . 'assets/images/thumbnail-default.jpg';

			if ( $img_id ) {
				$src     = wp_get_attachment_image_src( $img_id, 'thumbnail' );
				if ( $src ) {
					$img_src = $src[0];
				}
			}

			return $img_src;
		}

		/**
		 * Column head
		 *
		 * @param      array $defaults  The defaults.
		 */
		public function ubit_columns_head( $defaults ) {
			// See: https://codex.wordpress.org/Plugin_API/Filter_Reference/manage_$post_type_posts_columns.
			$order    = array();
			$checkbox = 'cb';
			foreach ( $defaults as $key => $value ) {
				$order[ $key ] = $value;
				if ( $key === $checkbox ) {
					$order['thumbnail_image'] = esc_html__( 'Image', 'ubit' );
				}
			}

			return $order;
		}

		/**
		 * Column content
		 *
		 * @param      string $column_name  The column name.
		 * @param      int    $post_ID      The post id.
		 */
		public function ubit_columns_content( $column_name, $post_ID ) {
			if ( 'thumbnail_image' === $column_name ) {
				$_img_src = $this->ubit_get_featured_image_src( $post_ID );
				?>
					<a href="<?php echo esc_url( get_edit_post_link( $post_ID ) ); ?>">
						<img src="<?php echo esc_url( $_img_src ); ?>"/>
					</a>
				<?php
			}
		}

		/**
		 * Sets up theme defaults and registers support for various WordPress features.
		 *
		 * Note that this function ubit_is hooked into the after_setup_theme hook, which
		 * runs before the init hook. The init hook is too late for some features, such
		 * as indicating support for post thumbnails.
		 */
		public function ubit_setup() {
			/*
			 * Load Localisation files.
			 *
			 * Note: the first-loaded translation file overrides any following ones if the same translation is present.
			 */

			// Loads wp-content/languages/themes/ubit-it_IT.mo.
			load_theme_textdomain( 'ubit', WP_LANG_DIR . '/themes' );

			// Loads wp-content/themes/child-theme-name/languages/it_IT.mo.
			load_theme_textdomain( 'ubit', get_stylesheet_directory() . '/languages' );

			// Loads wp-content/themes/ubit/languages/it_IT.mo.
			load_theme_textdomain( 'ubit', UBIT_THEME_DIR . 'languages' );

			/**
			 * Add default posts and comments RSS feed links to head.
			 */
			add_theme_support( 'automatic-feed-links' );

			/*
			 * Enable support for Post Thumbnails on posts and pages.
			 *
			 * @link https://developer.wordpress.org/reference/functions/add_theme_support/#Post_Thumbnails
			 */
			add_theme_support( 'post-thumbnails' );

			// Post formats.
			add_theme_support(
				'post-formats',
				array(
					'gallery',
					'image',
					'link',
					'quote',
					'video',
					'audio',
					'status',
					'aside',
				)
			);

			/**
			 * Enable support for site logo.
			 */
			add_theme_support(
				'custom-logo',
				apply_filters(
					'ubit_custom_logo_args',
					array(
						'height'      => 110,
						'width'       => 470,
						'flex-width'  => true,
						'flex-height' => true,
					)
				)
			);

			/**
			 * Register menu locations.
			 */
			register_nav_menus(
				apply_filters(
					'ubit_register_nav_menus',
					array(
						'topbar'  => esc_html__( 'Top Bar Menu', 'ubit' ),
						'primary' => esc_html__( 'Primary Menu', 'ubit' ),
						'footer'  => esc_html__( 'Footer Menu', 'ubit' ),
					)
				)
			);

			/*
			 * Switch default core markup for search form, comment form, comments, galleries, captions and widgets
			 * to output valid HTML5.
			 */
			add_theme_support(
				'html5',
				apply_filters(
					'ubit_html5_args',
					array(
						'search-form',
						'comment-form',
						'comment-list',
						'gallery',
						'caption',
						'widgets',
					)
				)
			);

			/**
			 * Setup the WordPress core custom background feature.
			 */
			add_theme_support(
				'custom-background',
				apply_filters(
					'ubit_custom_background_args',
					array(
						'default-color' => apply_filters( 'ubit_default_background_color', 'ffffff' ),
						'default-image' => '',
					)
				)
			);

			/**
			 * Declare support for title theme feature.
			 */
			add_theme_support( 'title-tag' );

			/**
			 * Declare support for selective refreshing of widgets.
			 */
			add_theme_support( 'customize-selective-refresh-widgets' );

			/**
			 * Gutenberg.
			 */
			$options = ubit_options( false );

			// Default block styles.
			add_theme_support( 'wp-block-styles' );

			// Responsive embedded content.
			add_theme_support( 'responsive-embeds' );

			// Editor styles.
			add_theme_support( 'editor-styles' );

			// Wide Alignment.
			add_theme_support( 'align-wide' );

			// Editor Color Palette.
			add_theme_support(
				'editor-color-palette',
				array(
					array(
						'name'  => esc_html__( 'Primary Color', 'ubit' ),
						'slug'  => 'ubit-primary',
						'color' => $options['theme_color'],
					),
					array(
						'name'  => esc_html__( 'Heading Color', 'ubit' ),
						'slug'  => 'ubit-heading',
						'color' => $options['heading_color'],
					),
					array(
						'name'  => esc_html__( 'Text Color', 'ubit' ),
						'slug'  => 'ubit-text',
						'color' => $options['text_color'],
					),
				)
			);

			// Block Font Sizes.
			add_theme_support(
				'editor-font-sizes',
				array(
					array(
						'name'      => esc_html__( 'H6', 'ubit' ),
						'size'      => $options['heading_h6_font_size'],
						'slug'      => 'ubit-heading-6',
					),
					array(
						'name'      => esc_html__( 'H5', 'ubit' ),
						'size'      => $options['heading_h5_font_size'],
						'slug'      => 'ubit-heading-5',
					),
					array(
						'name'      => esc_html__( 'H4', 'ubit' ),
						'size'      => $options['heading_h4_font_size'],
						'slug'      => 'ubit-heading-4',
					),
					array(
						'name'      => esc_html__( 'H3', 'ubit' ),
						'size'      => $options['heading_h3_font_size'],
						'slug'      => 'ubit-heading-3',
					),
					array(
						'name'      => esc_html__( 'H2', 'ubit' ),
						'size'      => $options['heading_h2_font_size'],
						'slug'      => 'ubit-heading-2',
					),
					array(
						'name'      => esc_html__( 'H1', 'ubit' ),
						'size'      => $options['heading_h1_font_size'],
						'slug'      => 'ubit-heading-1',
					),
				)
			);

			// Header Footer Elementor plugin support.
			add_theme_support( 'header-footer-elementor' );
		}

		/**
		 * Init
		 */
		public function ubit_init() {
			// Support Elementor Pro - Theme Builder.
			if ( ! defined( 'ELEMENTOR_PRO_VERSION' ) ) {
				return;
			}

			if ( ubit_elementor_has_location( 'header' ) && ! ubit_elementor_has_location( 'footer' ) ) {
				add_action( 'ubit_theme_header', 'ubit_view_open', 0 );
			} elseif ( ! ubit_elementor_has_location( 'header' ) && ubit_elementor_has_location( 'footer' ) ) {
				add_action( 'ubit_after_footer', 'ubit_view_close', 0 );
			}
		}

		/**
		 * Register widget area.
		 *
		 * @link https://codex.wordpress.org/Function_Reference/register_sidebar
		 */
		public function ubit_widgets_init() {
			$sidebar_args['sidebar'] = array(
				'name'          => esc_html__( 'Main Sidebar', 'ubit' ),
				'id'            => 'sidebar',
				'description'   => esc_html__( 'Appears in the sidebar of the site.', 'ubit' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
			);

			if ( class_exists( 'woocommerce' ) ) {
				$sidebar_args['shop_sidebar'] = array(
					'name'          => esc_html__( 'WooCommerce Sidebar', 'ubit' ),
					'id'            => 'sidebar-shop',
					'description'   => esc_html__( ' Appears in the sidebar of shop/product page.', 'ubit' ),
					'before_widget' => '<div id="%1$s" class="widget %2$s">',
					'after_widget'  => '</div>',
				);
			}

			$sidebar_args['footer'] = array(
				'name'          => esc_html__( 'Footer Widget', 'ubit' ),
				'id'            => 'footer',
				'description'   => esc_html__( 'Appears in the footer section of the site.', 'ubit' ),
				'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s">',
				'after_widget'  => '</div>',
			);

			foreach ( $sidebar_args as $sidebar => $args ) {
				$widget_tags = array(
					'before_title'  => '<h6 class="widget-title">',
					'after_title'   => '</h6>',
				);

				/**
				 * Dynamically generated filter hooks. Allow changing widget wrapper and title tags. See the list below.
				 */
				$filter_hook = sprintf( 'ubit_%s_widget_tags', $sidebar );
				$widget_tags = apply_filters( $filter_hook, $widget_tags );

				if ( is_array( $widget_tags ) ) {
					register_sidebar( $args + $widget_tags );
				}
			}
		}

		/**
		 * Enqueue scripts and styles.
		 */
		public function ubit_scripts() {
			/**
			 * Styles
			 */
			wp_enqueue_style(
				'ubit-style',
				get_template_directory_uri() . '/style.css',
				array(),
				ubit_version()
			);

			wp_style_add_data( 'ubit-style', 'rtl', 'replace' );

			/**
			 * Scripts
			 */
			// For IE.
			if ( 'ie' == ubit_browser_detection() ) {
				// Fetch API polyfill.
				wp_enqueue_script(
					'ubit-fetch-api-polyfill',
					UBIT_THEME_URI . 'assets/js/fetch-api-polyfill.js',
					array(),
					ubit_version(),
					true
				);

				// foreach polyfill.
				wp_enqueue_script(
					'ubit-for-each-polyfill',
					UBIT_THEME_URI . 'assets/js/for-each-polyfill.js',
					array(),
					ubit_version(),
					true
				);
			}

			// General script.
			wp_enqueue_script(
				'ubit-general',
				UBIT_THEME_URI . 'assets/js/general.js',
				array( 'jquery' ),
				ubit_version(),
				true
			);

			// Mobile menu.
			wp_enqueue_script(
				'ubit-navigation',
				UBIT_THEME_URI . 'assets/js/navigation.js',
				array( 'jquery' ),
				ubit_version(),
				true
			);

			// Quantity button.
			wp_register_script(
				'ubit-quantity-button',
				UBIT_THEME_URI . 'assets/js/woocommerce/quantity-button.js',
				array(),
				ubit_version(),
				true
			);

			// WooCommerce sidebar for mobile.
			wp_register_script(
				'ubit-woocommerce-sidebar',
				UBIT_THEME_URI . 'assets/js/woocommerce/woocommerce-sidebar.js',
				array(),
				ubit_version(),
				true
			);

			// WooCommerce.
			wp_register_script(
				'ubit-woocommerce',
				UBIT_THEME_URI . 'assets/js/woocommerce/woocommerce.js',
				array( 'jquery', 'ubit-quantity-button' ),
				ubit_version(),
				true
			);

			// Product gallery zoom.
			wp_register_script(
				'easyzoom',
				UBIT_THEME_URI . 'assets/js/easyzoom.js',
				array( 'jquery' ),
				ubit_version(),
				true
			);

			// Product gallery zoom handle.
			wp_register_script(
				'easyzoom-handle',
				UBIT_THEME_URI . 'assets/js/woocommerce/easyzoom-handle.js',
				array( 'easyzoom' ),
				ubit_version(),
				true
			);

			// Product varitions.
			wp_register_script(
				'ubit-product-variation',
				UBIT_THEME_URI . 'assets/js/woocommerce/product-variation.js',
				array( 'jquery', 'easyzoom-handle' ),
				ubit_version(),
				true
			);

			// Tiny slider js.
			wp_register_script(
				'tiny-slider',
				UBIT_THEME_URI . 'assets/js/tiny-slider.js',
				array(),
				ubit_version(),
				true
			);

			// Product images ( Tiny slider ).
			wp_register_script(
				'ubit-product-images',
				UBIT_THEME_URI . 'assets/js/woocommerce/product-images.js',
				array( 'jquery', 'tiny-slider' ),
				ubit_version(),
				true
			);

			// Photoswipe init js.
			wp_register_script(
				'photoswipe-init',
				UBIT_THEME_URI . 'assets/js/photoswipe-init.js',
				array( 'photoswipe', 'photoswipe-ui-default' ),
				ubit_version(),
				true
			);

			// Comment reply.
			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}
		}

		/**
		 * Support Elementor Location
		 *
		 * @param      array|object $elementor_theme_manager  The elementor theme manager.
		 */
		public function ubit_register_elementor_locations( $elementor_theme_manager ) {
			$elementor_theme_manager->register_location(
				'header',
				[
					'hook'         => 'ubit_theme_header',
					'remove_hooks' => [ 'ubit_template_header' ],
				]
			);
			$elementor_theme_manager->register_location(
				'footer',
				[
					'hook'         => 'ubit_theme_footer',
					'remove_hooks' => [ 'ubit_template_footer' ],
				]
			);
			$elementor_theme_manager->register_location(
				'single',
				[
					'hook'         => 'ubit_theme_single',
					'remove_hooks' => [ 'ubit_template_single' ],
				]
			);
			$elementor_theme_manager->register_location(
				'product_archive',
				[
					'hook'         => 'ubit_theme_archive',
					'remove_hooks' => [ 'ubit_template_archive' ],
				]
			);
			$elementor_theme_manager->register_location(
				'404',
				[
					'hook'         => 'ubit_theme_404',
					'remove_hooks' => [ 'ubit_template_404' ],
					'label'        => esc_html__( 'Ubit 404', 'ubit' ),
				]
			);
		}

		/**
		 * Add Elementor Category
		 *
		 * @param      Elements_Manager $elements_manager The elements manager.
		 */
		public function ubit_widget_categories( $elements_manager ) {
			$elements_manager->add_category(
				'ubit-theme',
				array(
					'title' => esc_html__( 'Ubit Theme', 'ubit' ),
				)
			);
		}

		/**
		 * Elementor pewview scripts
		 */
		public function ubit_elementor_preview_scripts() {
			// Elementor widgets js.
			wp_enqueue_script(
				'ubit-elementor-live-preview',
				UBIT_THEME_URI . 'assets/js/elementor-preview.js',
				array(),
				ubit_version()
			);
		}

		/**
		 * Instagram Feed pre-set access tokens.
		 *
		 * @param string|array $existing_shortcode_tokens Existing Instagram Feed access tokens.
		 * @return string|array Instagram Feed access tokens.
		 */
		public function ubit_sbi_access_tokens( $existing_shortcode_tokens ) {
			$instagram_feed_options = get_option( 'sb_instagram_settings' );

			if (
				empty( $existing_shortcode_tokens )
				&&
				( ! isset( $instagram_feed_options[ 'connected_accounts' ] ) || empty( $instagram_feed_options[ 'connected_accounts' ] ) )
				&&
				( ! isset( $instagram_feed_options[ 'sb_instagram_at' ] ) || empty( $instagram_feed_options[ 'sb_instagram_at' ] ) )
			) {
				$existing_shortcode_tokens = array(
					'6652085854.1677ed0.0558dce32d1f4b5abc0f09fc60b988ac',
				);
			}

			return apply_filters( 'ubit_sbi_access_tokens', $existing_shortcode_tokens );
		}

		/**
		 * Limit the character length in exerpt
		 *
		 * @param      int $length The length.
		 */
		public function ubit_limit_excerpt_character( $length ) {
			// Don't change anything inside /wp-admin/.
			if ( is_admin() ) {
				return $length;
			}

			$options = ubit_options( false );
			$length  = $options['blog_list_limit_exerpt'];
			return $length;
		}

		/**
		 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
		 *
		 * @param array $args Configuration arguments.
		 * @return array
		 */
		public function ubit_page_menu_args( $args ) {
			$args['show_home'] = true;
			return $args;
		}

		/**
		 * Adds custom classes to the array of body classes.
		 *
		 * @param array $classes Classes for the body element.
		 * @return array
		 */
		public function ubit_body_classes( $classes ) {
			// Get theme options.
			$options   = ubit_options( false );

			// Theme version.
			$classes[] = 'ubit-' . ubit_version();

			// Broser detection.
			if ( '' != ubit_browser_detection() ) {
				$classes[] = ubit_browser_detection() . '-detected';
			}

			// Site container layout.
			$customizer_container = $options['default_container'];
			$metabox_container    = ubit_get_metabox( false, 'site-container' );
			$container            = 'default' != $metabox_container ? $metabox_container : $customizer_container;
			$classes[]            = 'site-' . $container . '-container';

			// Header layout.
			$header_class_name = defined( 'UBIT_MULTIPLE_HEADER' ) ? $options['header_layout'] : 'layout-1';
			$classes[] = 'has-header-' . $header_class_name;

			// Header transparent.
			if ( true == ubit_header_transparent() ) {
				$classes[] = 'has-header-transparent header-transparent-for-' . $options['header_transparent_enable_on'];
			}

			// Sidebar class detected.
			$classes[] = ubit_sidebar_class();

			// Product style layout.
			$product_style_class_name = defined( 'UBIT_PRODUCT_STYLE' ) ? $options['product_style'] : 'layout-1';
			$classes[] = 'ps-' . $product_style_class_name;

			// Blog page layout.
			if ( ubit_is_blog() && ! is_singular( 'post' ) ) {
				$classes[] = 'blog-layout-' . $options['blog_list_layout'];
			}

			return $classes;
		}

		/**
		 * Adds custom classes to the array of header classes.
		 *
		 * @param array $classes Classes for the header element.
		 */
		public function ubit_header_classes( $classes ) {
			$options           = ubit_options( false );
			$header_class_name = defined( 'UBIT_MULTIPLE_HEADER' ) ? $options['header_layout'] : 'layout-1';

			$classes[] = 'header-' . $header_class_name;

			return $classes;
		}

		/**
		 * Custom navigation markup template hooked into `navigation_markup_template` filter hook.
		 *
		 * @param string $template The default template.
	 	 * @param string $class    The class passed by the calling function.
	 	 * @return string Navigation template.
		 */
		public function ubit_navigation_markup_template( $template, $class ) {
			$template  = '<nav class="navigation %1$s" role="navigation" aria-label="' . esc_attr__( 'Post Pagination', 'ubit' ) . '">';
			$template .= '<h2 class="screen-reader-text">%2$s</h2>';
			$template .= '<div class="nav-links">%3$s</div>';
			$template .= '</nav>';

			return apply_filters( 'ubit_navigation_markup_template', $template, $class );
		}

		/**
		 * Customizer live preview
		 */
		public function ubit_customize_live_preview() {
			wp_enqueue_script(
				'ubit-customizer-preview',
				UBIT_THEME_URI . 'assets/js/customizer-preview.js',
				array( 'jquery' ),
				ubit_version(),
				true
			);
		}

		/**
		 * Remove inline css on tag cloud
		 *
		 * @param string $string tagCloud.
		 */
		public function ubit_remove_tag_inline_style( $string ) {
			return preg_replace( '/ style=("|\')(.*?)("|\')/', '', $string );
		}


		/**
		 * Modify excerpt more to `...`
		 *
		 * @param string $more More exerpt.
		 */
		public function ubit_modify_excerpt_more( $more ) {
			// Don't change anything inside /wp-admin/.
			if ( is_admin() ) {
				return $more;
			}

			$more = apply_filters( 'ubit_excerpt_more', '...' );
			return $more;
		}
	}
endif;

$ubit = new Ubit();
