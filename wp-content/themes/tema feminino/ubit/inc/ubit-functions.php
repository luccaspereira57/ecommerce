<?php
/**
 * Ubit functions.
 *
 * @package ubit
 */

if ( ! function_exists( 'ubit_version' ) ) {
	/**
	 * Ubit Version
	 *
	 * @return string Ubit Version.
	 */
	function ubit_version() {
		return UBIT_VERSION;
	}
}

if ( ! function_exists( 'ubit_suffix' ) ) {
	/**
	 * Define Script debug.
	 *
	 * @return     string $suffix
	 */
	function ubit_suffix() {
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		return $suffix;
	}
}

if ( ! function_exists( 'ubit_is_woocommerce_activated' ) ) {
	/**
	 * Query WooCommerce activation
	 */
	function ubit_is_woocommerce_activated() {
		return class_exists( 'woocommerce' ) ? true : false;
	}
}

if ( ! function_exists( 'ubit_is_elementor_activated' ) ) {
	/**
	 * Check Elementor active
	 *
	 * @return     bool
	 */
	function ubit_is_elementor_activated() {
		return defined( 'ELEMENTOR_VERSION' );
	}
}

if ( ! function_exists( 'ubit_is_elementor_page' ) ) {
	/**
	 * Detect Elementor Page editor with current page
	 *
	 * @param int $page_id The page id.
	 * @return     bool
	 */
	function ubit_is_elementor_page( $page_id = false ) {
		if ( ! ubit_is_elementor_activated() ) {
			return false;
		}

		if ( ! $page_id ) {
			$page_id = ubit_get_page_id();
		}

		$edit_mode = get_post_meta( $page_id, '_elementor_edit_mode', true );
		$edit_mode = 'builder' === $edit_mode ? true : false;

		if ( class_exists( 'woocommerce' ) && is_tax() ) {
			$edit_mode = false;
		}

		return $edit_mode;
	}
}

if ( ! function_exists( 'ubit_elementor_has_location' ) ) {
	/**
	 * Detect if a page has Elementor location template.
	 *
	 * @param      string $location The location.
	 * @return     boolean
	 */
	function ubit_elementor_has_location( $location ) {
		if ( ! did_action( 'elementor_pro/init' ) ) {
			return false;
		}

		$conditions_manager = \ElementorPro\Plugin::instance()->modules_manager->get_modules( 'theme-builder' )->get_conditions_manager();
		$documents          = $conditions_manager->get_documents_for_location( $location );

		return ! empty( $documents );
	}
}

if ( ! function_exists( 'ubit_is_elementor_editor' ) ) {
	/**
	 * Condition if Current screen is Edit mode || Preview mode.
	 */
	function ubit_is_elementor_editor() {
		if ( ! ubit_is_elementor_activated() ) {
			return false;
		}

		$support_old_php_version = ( \Elementor\Plugin::$instance->editor->is_edit_mode() || \Elementor\Plugin::$instance->preview->is_preview_mode() );

		return $support_old_php_version;
	}
}

if ( ! function_exists( 'ubit_theme_name' ) ) {
	/**
	 * Get theme name.
	 *
	 * @return string Theme Name.
	 */
	function ubit_theme_name() {

		$theme_name = esc_html__( 'Ubit', 'ubit' );

		return apply_filters( 'ubit_theme_name', $theme_name );
	}
}

if ( ! function_exists( 'ubit_do_shortcode' ) ) {
	/**
	 * Call a shortcode function by tag name.
	 *
	 * @param string $tag     The shortcode whose function to call.
	 * @param array  $atts    The attributes to pass to the shortcode function. Optional.
	 * @param array  $content The shortcode's content. Default is null (none).
	 *
	 * @return string|bool False on failure, the result of the shortcode on success.
	 */
	function ubit_do_shortcode( $tag, array $atts = array(), $content = null ) {
		global $shortcode_tags;

		if ( ! isset( $shortcode_tags[ $tag ] ) ) {
			return false;
		}

		return call_user_func( $shortcode_tags[ $tag ], $atts, $content, $tag );
	}
}

if ( ! function_exists( 'ubit_sanitize_choices' ) ) {
	/**
	 * Sanitizes choices (selects / radios)
	 * Checks that the input matches one of the available choices
	 *
	 * @param array $input the available choices.
	 * @param array $setting the setting object.
	 */
	function ubit_sanitize_choices( $input, $setting ) {
		// Ensure input is a slug.
		$input   = sanitize_key( $input );

		// Get list of choices from the control associated with the setting.
		$choices = $setting->manager->get_control( $setting->id )->choices;

		// If the input is a valid key, return it; otherwise, return the default.
		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
	}
}

if ( ! function_exists( 'ubit_sanitize_checkbox' ) ) {
	/**
	 * Checkbox sanitization callback.
	 *
	 * Sanitization callback for 'checkbox' type controls. This callback sanitizes `$checked`
	 * as a boolean value, either TRUE or FALSE.
	 *
	 * @param bool $checked Whether the checkbox is checked.
	 * @return bool Whether the checkbox is checked.
	 */
	function ubit_sanitize_checkbox( $checked ) {
		return ( ( isset( $checked ) && true == $checked ) ? true : false );
	}
}

if ( ! function_exists( 'ubit_sanitize_variants' ) ) {
	/**
	 * Sanitize our Google Font variants
	 *
	 * @param      string $input sanitize variants.
	 * @return     sanitize_text_field( $input )
	 */
	function ubit_sanitize_variants( $input ) {
		if ( is_array( $input ) ) {
			$input = implode( ',', $input );
		}
		return sanitize_text_field( $input );
	}
}

if ( ! function_exists( 'ubit_sanitize_rgba_color' ) ) {
	/**
	 * Sanitize color || rgba color
	 *
	 * @param      string $color  The color.
	 */
	function ubit_sanitize_rgba_color( $color ) {
		if ( empty( $color ) || is_array( $color ) ) {
			return 'rgba(255,255,255,0)';
		}

		// If string does not start with 'rgba', then treat as hex sanitize the hex color and finally convert hex to rgba.
		if ( false === strpos( $color, 'rgba' ) ) {
			return sanitize_hex_color( $color );
		}

		// By now we know the string is formatted as an rgba color so we need to further sanitize it.
		$color = str_replace( ' ', '', $color );
		sscanf( $color, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );

		return 'rgba(' . $red . ',' . $green . ',' . $blue . ',' . $alpha . ')';
	}
}

if ( ! function_exists( 'ubit_sanitize_int' ) ) {
	/**
	 * Sanitize integer value
	 *
	 * @param      integer $value  The integer number.
	 */
	function ubit_sanitize_int( $value ) {
		return intval( $value );
	}
}

if ( ! function_exists( 'ubit_sanitize_raw_html' ) ) {
	/**
	 * Sanitize raw html value
	 *
	 * @param      string $value  The raw html value.
	 */
	function ubit_sanitize_raw_html( $value ) {
		$content = wp_kses(
			$value,
			array(
				'a' => array(
					'class'  => array(),
					'href'   => array(),
					'rel'    => array(),
					'title'  => array(),
					'target' => array(),
					'style'  => array(),
				),
				'code' => array(),
				'div'  => array(
					'class' => array(),
					'style' => array(),
				),
				'em' => array(),
				'h1' => array(),
				'h2' => array(),
				'h3' => array(),
				'h4' => array(),
				'h5' => array(),
				'h6' => array(),
				'i'  => array(),
				'li' => array(
					'class' => array(),
				),
				'ul' => array(
					'class' => array(),
				),
				'ol' => array(
					'class' => array(),
				),
				'p' => array(
					'class' => array(),
					'style' => array(),
				),
				'span' => array(
					'class' => array(),
					'style' => array(),
				),
				'strong' => array(
					'class' => array(),
					'style' => array(),
				),
				'b'    => array(
					'class' => array(),
					'style' => array(),
				),
			)
		);
		return $content;
	}
}

if ( ! function_exists( 'ubit_is_blog' ) ) {
	/**
	 * Ubit detect blog page
	 *
	 * @return boolean $is_blog
	 */
	function ubit_is_blog() {
		global $post;

		$post_type = get_post_type( $post );

		$is_blog = ( 'post' == $post_type && ( is_archive() || is_search() || is_author() || is_category() || is_home() || is_single() || is_tag() ) ) ? true : false;

		return apply_filters( 'ubit_is_blog', $is_blog );
	}
}

if ( ! function_exists( 'ubit_options' ) ) {
	/**
	 * Theme option
	 * If ( $defaults = true ) return Default value
	 * Else return all theme option
	 *
	 * @param      bool $defaults  Condition check output.
	 * @return     array $options         All theme options
	 */
	function ubit_options( $defaults = true ) {
		$default_settings = Ubit_Customizer::ubit_get_ubit_default_setting_values();
		$default_fonts    = Ubit_Fonts_Helpers::ubit_get_default_fonts();
		$default_options  = array_merge( $default_settings, $default_fonts );

		if ( true == $defaults ) {
			return $default_options;
		}

		$options = wp_parse_args(
			get_option( 'ubit_setting', array() ),
			$default_options
		);

		return $options;
	}
}

if ( ! function_exists( 'ubit_image_alt' ) ) {

	/**
	 * Get image alt
	 *
	 * @param      bolean $id          The image id.
	 * @param      string $alt         The alternate.
	 * @param      bolean $placeholder The bolean.
	 *
	 * @return     string  The image alt
	 */
	function ubit_image_alt( $id = null, $alt = '', $placeholder = false ) {
		if ( ! $id ) {
			if ( $placeholder ) {
				return esc_attr__( 'Placeholder image', 'ubit' );
			}
			return esc_attr__( 'Error image', 'ubit' );
		}

		$data = get_post_meta( $id, '_wp_attachment_image_alt', true );
		$img_alt = ! empty( $data ) ? $data : $alt;

		return $img_alt;
	}
}

if ( ! function_exists( 'ubit_hex_to_rgba' ) ) {
	/**
	 * Convert HEX to RGBA color
	 *
	 * @param      string  $hex    The hexadecimal color.
	 * @param      integer $alpha  The alpha.
	 * @return     string  The rgba color.
	 */
	function ubit_hex_to_rgba( $hex, $alpha = 1 ) {
		$hex = str_replace( '#', '', $hex );

		if ( 3 == strlen( $hex ) ) {
			$r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
			$g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
			$b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
		} else {
			$r = hexdec( substr( $hex, 0, 2 ) );
			$g = hexdec( substr( $hex, 2, 2 ) );
			$b = hexdec( substr( $hex, 4, 2 ) );
		}

		$rgba = array( $r, $g, $b, $alpha );

		return 'rgba(' . implode( ',', $rgba ) . ')';
	}
}

if ( ! function_exists( 'ubit_browser_detection' ) ) {
	/**
	 * Ubit broswer detection
	 */
	function ubit_browser_detection() {
		global $is_IE, $is_edge, $is_safari, $is_iphone;

		$class = '';

		if ( $is_iphone ) {
			$class = 'iphone';
		} elseif ( $is_IE ) {
			$class = 'ie';
		} elseif ( $is_edge ) {
			$class = 'edge';
		} elseif ( $is_safari ) {
			$class = 'safari';
		}

		return $class;
	}
}

if ( ! function_exists( 'ubit_dequeue_scripts_and_styles' ) ) {
	/**
	 * Dequeue scripts and style no need
	 */
	function ubit_dequeue_scripts_and_styles() {
		// What is 'sb-font-awesome'?
		wp_deregister_style( 'sb-font-awesome' );
		wp_dequeue_style( 'sb-font-awesome' );

		// Remove default YITH Wishlist css.
		wp_dequeue_style( 'yith-wcwl-main' );
		wp_dequeue_style( 'yith-wcwl-font-awesome' );
		wp_dequeue_style( 'jquery-selectBox' );

		// Fallback for Font Awesome CSS if Elementor didn't load it.
		if ( ! wp_style_is( 'font-awesome-5-all', 'enqueued' ) ) {
			wp_enqueue_style(
				'ubit-font-awesome',
				UBIT_THEME_URI . 'assets/css/fontawesome.min.css',
				array(),
				ubit_version()
			);
		}
	}
}

if ( ! function_exists( 'ubit_narrow_data' ) ) {
	/**
	 * Get dropdown data
	 *
	 * @param      string $type   The type 'post' || 'term'.
	 * @param      string $terms  The terms post, category, product, product_cat, custom_post_type...
	 *
	 * @return     array
	 */
	function ubit_narrow_data( $type = 'post', $terms = 'category' ) {
		$output = array();
		switch ( $type ) {
			case 'post':
				$args = array(
					'post_type'           => $terms,
					'post_status'         => 'publish',
					'ignore_sticky_posts' => 1,
					'posts_per_page'      => -1,
				);

				$qr     = new WP_Query( $args );
				$output = wp_list_pluck( $qr->posts, 'post_title', 'ID' );
				break;

			case 'term':
				$terms  = get_terms( $terms );
				$output = wp_list_pluck( $terms, 'name', 'term_id' );
				break;
		}

		return $output;
	}
}

if ( ! function_exists( 'ubit_get_metabox' ) ) {
	/**
	 * Get metabox option
	 *
	 * @param int    $page_id      The page ID.
	 * @param string $metabox_name Metabox option name.
	 */
	function ubit_get_metabox( $page_id = false, $metabox_name ) {
 		$page_id = $page_id ? intval( $page_id ) : ubit_get_page_id();
		$metabox = get_post_meta( $page_id, $metabox_name, true );

		if ( ! $metabox ) {
			$metabox = 'default';
		}

		return $metabox;
	}
}

if ( ! function_exists( 'ubit_header_transparent' ) ) {
	/**
	 * Detect header transparent on current page
	 */
	function ubit_header_transparent() {
		$options             = ubit_options( false );
		$transparent         = $options['header_transparent'];
		$archive_transparent = $options['header_transparent_disable_archive'];
		$index_transparent   = $options['header_transparent_disable_index'];
		$page_transparent    = $options['header_transparent_disable_page'];
		$post_transparent    = $options['header_transparent_disable_post'];
		$shop_transparent    = $options['header_transparent_disable_shop'];
		$product_transparent = $options['header_transparent_disable_product'];
		$metabox_transparent = ubit_get_metabox( false, 'site-header-transparent' );

		// Disable header transparent on Shop page.
		if ( class_exists( 'woocommerce' ) && is_shop() && $shop_transparent ) {
			$transparent = false;
		} elseif ( class_exists( 'woocommerce' ) && is_product() && $product_transparent ) {
			// Disable header transparent on Product page.
			$transparent = false;
		} elseif ( ( ( is_archive() && ( class_exists( 'woocommerce' ) && ! is_shop() ) ) || is_404() || is_search() ) && $archive_transparent ) {
			// Disable header transparent on Archive, 404 and Search page NOT Shop page.
			$transparent = false;
		} elseif ( is_home() && $index_transparent ) {
			// Disable header transparent on Blog page.
			$transparent = false;
		} elseif ( is_page() && $page_transparent ) {
			// Disable header transparent on Pages.
			$transparent = false;
		} elseif ( is_singular( 'post' ) && $post_transparent ) {
			// Disable header transparent on Posts.
			$transparent = false;
		}

		// Metabox option for single post or page. Priority highest.
		if ( 'default' != $metabox_transparent ) {
			if ( 'enabled' == $metabox_transparent ) {
				$transparent = true;
			} else {
				$transparent = false;
			}
		}

		return $transparent;
	}
}

if ( ! function_exists( 'ubit_pingback' ) ) {
	/**
	 * Pingback
	 */
	function ubit_pingback() {
		if ( ! is_singular() || ! pings_open( get_queried_object() ) ) {
			return;
		}
		?>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<?php
	}
}

if ( ! function_exists( 'ubit_facebook_social' ) ) {
	/**
	 * Get Title and Image for Facebook share
	 */
	function ubit_facebook_social() {
		if ( ! is_singular( 'product' ) ) {
			return;
		}
		$id        = ubit_get_page_id();
		$title     = get_the_title( $id );
		$image     = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'full' );
		$image_src = $image ? $image[0] : wc_placeholder_img_src();
		?>

		<meta property="og:title" content="<?php echo esc_attr( $title ); ?>">
		<meta property="og:image" content="<?php echo esc_attr( $image_src ); ?>">
		<?php
	}
}

if ( ! function_exists( 'ubit_array_insert' ) ) {
	/**
	 * Insert an array into another array before/after a certain key
	 *
	 * @param array  $array The initial array.
	 * @param array  $pairs The array to insert.
	 * @param string $key The certain key.
	 * @param string $position Wether to insert the array before or after the key.
	 * @return array
	 */
	function ubit_array_insert( $array, $pairs, $key, $position = 'after' ) {
		$key_pos = array_search( $key, array_keys( $array ) );
		if ( 'after' === $position ) {
			$key_pos++;
			if ( false !== $key_pos ) {
				$result = array_slice( $array, 0, $key_pos );
				$result = array_merge( $result, $pairs );
				$result = array_merge( $result, array_slice( $array, $key_pos ) );
			}
		} else {
			$result = array_merge( $array, $pairs );
		}

		return $result;
	}
}

if ( ! function_exists( 'ubit_implode_comma_and' ) ) {
	/**
	 * Implode array of strings with comma, but for the last array item use a word "and"
	 *
	 * @param array  $strings_array The array of strings to implode.
	 * @return string
	 */
	function ubit_implode_comma_and( $strings_array ) {
		$strings_array_first = $strings_array;
		$strings_array_last = array_pop( $strings_array_first );

		if ( ! empty( $strings_array_first ) ) {
			$strings_array = implode( ' ' . esc_html__( 'and', 'ubit' ) . ' ', array(
				implode( esc_html__( ', ', 'ubit' ), $strings_array_first ),
				$strings_array_last,
			) );
		}
		else {
			$strings_array = implode( esc_html__( ', ', 'ubit' ), $strings_array );
		}

		return $strings_array;
	}
}
