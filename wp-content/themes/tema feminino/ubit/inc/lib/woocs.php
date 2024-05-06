<?php
/**
 * WooCommerce Currency Switcher integration
 *
 * @package ubit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WOOCS' ) ) {
  return;
}

function ubit_woocs_drop_down_view( $value ) {
  if ( $value == 'ddslick' ) {
		$value = 'no';
	}

  return $value;
}
add_filter( 'woocs_drop_down_view', 'ubit_woocs_drop_down_view' );

function ubit_woocs_shortcode( $output, $tag, $attr, $m ) {
	if ( 'woocs' !== $tag ) {
		return $output;
	}

	$output = str_ireplace( ' action="" class="woocommerce-currency-switcher-form', ' action="#" class="woocommerce-currency-switcher-form', $output);

	return $output;
}
add_filter( 'do_shortcode_tag', 'ubit_woocs_shortcode', 10, 4 );
