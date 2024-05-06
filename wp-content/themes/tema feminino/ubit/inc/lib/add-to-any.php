<?php
/**
 * AddToAny Share Buttons integration
 *
 * @package ubit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'A2A_SHARE_SAVE_init' ) ) {
  return;
}

function ubit_addtoany_sharing_disabled( $sharing_disabled ) {
  $current_page_id = get_queried_object_id();
	$current_page_post_type = get_post_type( $current_page_id );
  $frontpage_id = get_option( 'page_on_front' );
  $addtoany_options = get_option( 'addtoany_options' );

  if ( ( $current_page_id == $frontpage_id || $current_page_post_type == 'page' || is_archive() || is_search() ) && $addtoany_options === false ) {
		$sharing_disabled = true;
	}

  return $sharing_disabled;
}
add_filter( 'addtoany_sharing_disabled', 'ubit_addtoany_sharing_disabled' );
