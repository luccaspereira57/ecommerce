<?php
/**
 * YITH WooCommerce Wishlist integration
 *
 * @package ubit
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

if ( ! defined( 'YITH_WCWL' ) ) {
  return;
}

function ubit_yith_wcwl_wishlist_page_url( $value ) {
  $wishlist_page_url = ubit_wishlist_page_url();
  $wishlist_page_id = get_option( 'yith_wcwl_wishlist_page_id' );

  if ( $wishlist_page_id === false && $wishlist_page_url ) {
    $value = $wishlist_page_url;
  }

  return $value;
}
add_filter( 'yith_wcwl_wishlist_page_url', 'ubit_yith_wcwl_wishlist_page_url' );
