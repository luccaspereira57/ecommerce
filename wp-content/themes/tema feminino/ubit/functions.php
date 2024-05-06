<?php
/**
 * Ubit
 *
 * @package ubit
 */

// Main constants.
define( 'UBIT_VERSION', '1.5.6' );
define( 'UBIT_THEME_DIR', get_template_directory() . '/' );
define( 'UBIT_THEME_URI', get_template_directory_uri() . '/' );

// Required software version constants.
define( 'UBIT_VERSION_REQUIRE_PHP', '5.6.20' );
define( 'UBIT_VERSION_REQUIRE_MYSQL', '5.0.15' );
define( 'UBIT_VERSION_REQUIRE_WORDPRESS', '4.7' );
define( 'UBIT_VERSION_REQUIRE_WOOCOMMERCE', '3.3' );

// API URI constants.
define( 'UBIT_API_URI_TRACKER', 'https://themes.3akis.eu/tracking/v1/' );

// Web URI constants.
define( 'UBIT_WEB_URI_MAIN', 'https://ubit-wp.github.io' );
define( 'UBIT_WEB_URI_DEMO', UBIT_WEB_URI_MAIN . '/demo' );
define( 'UBIT_WEB_URI_DOCS', UBIT_WEB_URI_MAIN . '/docs' );
define( 'UBIT_WEB_URI_CHANGELOG', UBIT_WEB_URI_MAIN . '/changelog' );
define( 'UBIT_WEB_URI_SUPPORT', UBIT_WEB_URI_MAIN . '/support' );

// Ubit functions, hooks.
require_once UBIT_THEME_DIR . 'inc/ubit-functions.php';
require_once UBIT_THEME_DIR . 'inc/ubit-template-hooks.php';
require_once UBIT_THEME_DIR . 'inc/ubit-template-builder.php';
require_once UBIT_THEME_DIR . 'inc/ubit-template-functions.php';

// Ubit generate css.
require_once UBIT_THEME_DIR . 'inc/customizer/class-ubit-fonts-helpers.php';
require_once UBIT_THEME_DIR . 'inc/customizer/class-ubit-get-css.php';

// Ubit core and customizer.
require_once UBIT_THEME_DIR . 'inc/class-ubit.php';
require_once UBIT_THEME_DIR . 'inc/customizer/class-ubit-customizer.php';

// Ubit WooCommerce.
if ( ubit_is_woocommerce_activated() ) {
	require_once UBIT_THEME_DIR . 'inc/woocommerce/class-ubit-woocommerce.php';
	require_once UBIT_THEME_DIR . 'inc/woocommerce/ubit-woocommerce-template-functions.php';
}

// Ubit admin.
if ( is_admin() ) {
	require_once UBIT_THEME_DIR . 'inc/admin/class-ubit-admin.php';
	require_once UBIT_THEME_DIR . 'inc/admin/class-ubit-meta-boxes.php';
}

// AddToAny Share Buttons integration.
require_once UBIT_THEME_DIR . 'inc/lib/add-to-any.php';

// Max Mega Menu integration.
require_once UBIT_THEME_DIR . 'inc/lib/max-mega-menu.php';

// WooCommerce Currency Switcher integration.
require_once UBIT_THEME_DIR . 'inc/lib/woocs.php';

// YITH WooCommerce Wishlist integration.
require_once UBIT_THEME_DIR . 'inc/lib/yith-woocommerce-wishlist.php';

// Merlin WP setup wizard as library.
require_once UBIT_THEME_DIR . 'inc/lib/merlin/merlin.php';

// Fix WordPress 5.5+ color picker incompatibility
if( is_admin() ) {
  add_action( 'wp_default_scripts', 'wp_default_custom_scripts' );
  function wp_default_custom_scripts( $scripts ){
    did_action( 'init' ) && $scripts->localize(
      'wp-color-picker',
      'wpColorPickerL10n',
      array(
        'clear'            => __( 'Clear' ),
        'clearAriaLabel'   => __( 'Clear color' ),
        'defaultString'    => __( 'Default' ),
        'defaultAriaLabel' => __( 'Select default color' ),
        'pick'             => __( 'Select Color' ),
        'defaultLabel'     => __( 'Color value' )
      )
    );
  }
}

/**
 * Note: Do not add any custom code here. Please use a custom plugin so that your customizations aren't lost during updates.
 */
