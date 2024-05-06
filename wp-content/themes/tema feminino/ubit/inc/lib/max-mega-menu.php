<?php
/**
 * Max Mega Menu integration
 *
 * @package ubit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Mega_Menu' ) ) {
  return;
}

function megamenu_add_theme_ubit($themes) {
  $themes["ubit"] = array(
		'title' => 'Ubit',
		'container_background_from' => 'rgba(255, 255, 255, 0)',
		'container_background_to' => 'rgba(255, 255, 255, 0)',
		'container_border_radius_top_left' => '5px',
		'container_border_radius_top_right' => '5px',
		'container_border_radius_bottom_left' => '5px',
		'container_border_radius_bottom_right' => '5px',
		'arrow_up' => 'dash-f343',
		'arrow_down' => 'dash-f347',
		'arrow_left' => 'dash-f341',
		'arrow_right' => 'dash-f345',
		'menu_item_background_hover_from' => 'rgba(255, 255, 255, 0)',
		'menu_item_background_hover_to' => 'rgba(255, 255, 255, 0)',
		'menu_item_spacing' => '20px',
		'menu_item_link_font_size' => '16px',
		'menu_item_link_height' => '90px',
		'menu_item_link_color' => 'rgb(51, 51, 51)',
		'menu_item_link_weight' => 'bold',
		'menu_item_link_text_transform' => 'uppercase',
		'menu_item_link_color_hover' => 'rgb(226, 80, 171)',
		'menu_item_link_weight_hover' => 'bold',
		'menu_item_link_border_radius_top_left' => '5px',
		'menu_item_link_border_radius_top_right' => '5px',
		'menu_item_link_border_radius_bottom_left' => '5px',
		'menu_item_link_border_radius_bottom_right' => '5px',
		'panel_background_from' => 'rgb(255, 255, 255)',
		'panel_background_to' => 'rgb(255, 255, 255)',
		'panel_width' => '650px',
		'panel_border_radius_top_left' => '5px',
		'panel_border_radius_top_right' => '5px',
		'panel_border_radius_bottom_left' => '5px',
		'panel_border_radius_bottom_right' => '5px',
		'panel_header_color' => 'rgb(51, 51, 51)',
		'panel_header_border_color' => '#555',
		'panel_padding_top' => '10px',
		'panel_padding_bottom' => '10px',
		'panel_widget_padding_left' => '25px',
		'panel_widget_padding_right' => '25px',
		'panel_font_size' => '14px',
		'panel_font_color' => '#666',
		'panel_font_family' => 'inherit',
		'panel_second_level_font_color' => 'rgb(51, 51, 51)',
		'panel_second_level_font_color_hover' => 'rgb(226, 80, 171)',
		'panel_second_level_text_transform' => 'uppercase',
		'panel_second_level_font' => 'inherit',
		'panel_second_level_font_size' => '16px',
		'panel_second_level_font_weight' => 'bold',
		'panel_second_level_font_weight_hover' => 'bold',
		'panel_second_level_text_decoration' => 'none',
		'panel_second_level_text_decoration_hover' => 'none',
		'panel_second_level_padding_bottom' => '15px',
		'panel_second_level_border_color' => '#555',
		'panel_third_level_font_color' => 'rgb(51, 51, 51)',
		'panel_third_level_font_color_hover' => 'rgb(226, 80, 171)',
		'panel_third_level_font' => 'inherit',
		'panel_third_level_font_size' => '16px',
		'panel_third_level_padding_top' => '8px',
		'panel_third_level_padding_bottom' => '8px',
		'flyout_menu_background_from' => 'rgba(255, 255, 255, 0)',
		'flyout_menu_background_to' => 'rgba(255, 255, 255, 0)',
		'flyout_border_radius_top_left' => '5px',
		'flyout_border_radius_top_right' => '5px',
		'flyout_border_radius_bottom_left' => '5px',
		'flyout_border_radius_bottom_right' => '5px',
		'flyout_link_padding_left' => '20px',
		'flyout_link_padding_right' => '20px',
		'flyout_link_padding_top' => '8px',
		'flyout_link_padding_bottom' => '8px',
		'flyout_link_height' => '30px',
		'flyout_background_from' => 'rgb(255, 255, 255)',
		'flyout_background_to' => 'rgb(255, 255, 255)',
		'flyout_background_hover_from' => 'rgb(255, 255, 255)',
		'flyout_background_hover_to' => 'rgb(255, 255, 255)',
		'flyout_link_size' => '16px',
		'flyout_link_color' => 'rgb(51, 51, 51)',
		'flyout_link_color_hover' => 'rgb(226, 80, 171)',
		'flyout_link_family' => 'inherit',
		'responsive_breakpoint' => '1024px',
		'line_height' => '1.2',
		'shadow' => 'on',
		'transitions' => 'on',
		'mobile_columns' => '2',
		'toggle_background_from' => 'rgba(255, 255, 255, 0)',
		'toggle_background_to' => 'rgba(255, 255, 255, 0)',
		'mobile_menu_padding_left' => '20px',
		'mobile_menu_padding_right' => '20px',
		'mobile_menu_item_height' => '50px',
		'mobile_menu_overlay' => 'on',
		'mobile_menu_force_width' => 'on',
		'mobile_background_from' => 'rgb(255, 255, 255)',
		'mobile_background_to' => 'rgb(255, 255, 255)',
		'mobile_menu_item_link_font_size' => '1.2em',
		'mobile_menu_item_link_color' => 'rgb(43, 43, 43)',
		'mobile_menu_item_link_text_align' => 'left',
		'mobile_menu_item_link_color_hover' => 'rgb(226, 80, 171)',
		'mobile_menu_item_background_hover_from' => 'rgba(255, 255, 255, 0)',
		'mobile_menu_item_background_hover_to' => 'rgba(255, 255, 255, 0)',
		'custom_css' => '/** Push menu onto new line **/
#{$wrap} {
    clear: both;
}
@include mobile { // Envato: it is not a PHP code. False alarm.
	#{$wrap} #{$menu} {
		margin-top: 10px;
		-webkit-box-shadow: 0 5px 5px 0 rgba(0,0,0,0.2);
		box-shadow: 0 5px 5px 0 rgba(0,0,0,0.2);
	}
	#{$wrap} .mega-menu-toggle .mega-toggle-block-1 .mega-toggle-label {
		display: none !important;
	}
	#{$wrap} .mega-menu-toggle .mega-toggle-block-1:after {
		color: #2b2b2b;
	}
	#{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu,
	#{$wrap} #{$menu} > li.mega-menu-flyout ul.mega-sub-menu {
		-webkit-box-shadow: none;
		-moz-box-shadow: none;
		-ms-box-shadow: none;
		-o-box-shadow: none;
		box-shadow: none;
	}
	#{$wrap} #{$menu} > li.mega-menu-item > a.mega-menu-link {
		padding-left: 0;
		padding-right: 0;
	}
	#{$wrap} #{$menu} li.mega-menu-megamenu > ul.mega-sub-menu > li.mega-menu-row .mega-menu-column > ul.mega-sub-menu > li.mega-menu-item {
		padding-left: 0;
		padding-right: 0;
		padding-top: 0;
	}
	#{$wrap} #{$menu} > li.mega-menu-flyout ul.mega-sub-menu {
		padding-bottom: 15px;
	}
	#{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu,
	#{$wrap} #{$menu} > li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item a.mega-menu-link  {
		padding-left: 0;
		padding-right: 0;
	}
}',
  );
  return $themes;
}
add_filter("megamenu_themes", "megamenu_add_theme_ubit");

function megamenu_add_theme_ubit_footer($themes) {
  $themes["ubit_footer"] = array(
		'title' => 'Ubit Footer',
		'container_background_from' => 'rgba(255, 255, 255, 0)',
		'container_background_to' => 'rgba(255, 255, 255, 0)',
		'container_border_radius_top_left' => '5px',
		'container_border_radius_top_right' => '5px',
		'container_border_radius_bottom_left' => '5px',
		'container_border_radius_bottom_right' => '5px',
		'arrow_up' => 'dash-f343',
		'arrow_down' => 'dash-f347',
		'arrow_left' => 'dash-f341',
		'arrow_right' => 'dash-f345',
		'menu_item_background_hover_from' => 'rgba(255, 255, 255, 0)',
		'menu_item_background_hover_to' => 'rgba(255, 255, 255, 0)',
		'menu_item_spacing' => '20px',
		'menu_item_link_font_size' => '16px',
		'menu_item_link_height' => '90px',
		'menu_item_link_color' => 'rgb(51, 51, 51)',
		'menu_item_link_weight' => 'bold',
		'menu_item_link_text_transform' => 'uppercase',
		'menu_item_link_color_hover' => 'rgb(226, 80, 171)',
		'menu_item_link_weight_hover' => 'bold',
		'menu_item_link_border_radius_top_left' => '5px',
		'menu_item_link_border_radius_top_right' => '5px',
		'menu_item_link_border_radius_bottom_left' => '5px',
		'menu_item_link_border_radius_bottom_right' => '5px',
		'panel_background_from' => 'rgb(255, 255, 255)',
		'panel_background_to' => 'rgb(255, 255, 255)',
		'panel_border_radius_top_left' => '5px',
		'panel_border_radius_top_right' => '5px',
		'panel_border_radius_bottom_left' => '5px',
		'panel_border_radius_bottom_right' => '5px',
		'panel_header_color' => 'rgb(51, 51, 51)',
		'panel_header_border_color' => '#555',
		'panel_padding_top' => '10px',
		'panel_padding_bottom' => '10px',
		'panel_widget_padding_left' => '25px',
		'panel_widget_padding_right' => '25px',
		'panel_font_size' => '14px',
		'panel_font_color' => '#666',
		'panel_font_family' => 'inherit',
		'panel_second_level_font_color' => 'rgb(51, 51, 51)',
		'panel_second_level_font_color_hover' => 'rgb(226, 80, 171)',
		'panel_second_level_text_transform' => 'uppercase',
		'panel_second_level_font' => 'inherit',
		'panel_second_level_font_size' => '16px',
		'panel_second_level_font_weight' => 'bold',
		'panel_second_level_font_weight_hover' => 'bold',
		'panel_second_level_text_decoration' => 'none',
		'panel_second_level_text_decoration_hover' => 'none',
		'panel_second_level_padding_bottom' => '15px',
		'panel_second_level_border_color' => '#555',
		'panel_third_level_font_color' => 'rgb(51, 51, 51)',
		'panel_third_level_font_color_hover' => 'rgb(226, 80, 171)',
		'panel_third_level_font' => 'inherit',
		'panel_third_level_font_size' => '16px',
		'panel_third_level_padding_top' => '8px',
		'panel_third_level_padding_bottom' => '8px',
		'flyout_menu_background_from' => 'rgba(255, 255, 255, 0)',
		'flyout_menu_background_to' => 'rgba(255, 255, 255, 0)',
		'flyout_border_radius_top_left' => '5px',
		'flyout_border_radius_top_right' => '5px',
		'flyout_border_radius_bottom_left' => '5px',
		'flyout_border_radius_bottom_right' => '5px',
		'flyout_link_padding_left' => '20px',
		'flyout_link_padding_right' => '20px',
		'flyout_link_padding_top' => '8px',
		'flyout_link_padding_bottom' => '8px',
		'flyout_link_height' => '30px',
		'flyout_background_from' => 'rgb(255, 255, 255)',
		'flyout_background_to' => 'rgb(255, 255, 255)',
		'flyout_background_hover_from' => 'rgb(255, 255, 255)',
		'flyout_background_hover_to' => 'rgb(255, 255, 255)',
		'flyout_link_size' => '16px',
		'flyout_link_color' => 'rgb(51, 51, 51)',
		'flyout_link_color_hover' => 'rgb(226, 80, 171)',
		'flyout_link_family' => 'inherit',
		'responsive_breakpoint' => '991px',
		'line_height' => '1.2',
		'shadow' => 'on',
		'transitions' => 'on',
		'toggle_background_from' => 'rgba(255, 255, 255, 0)',
		'toggle_background_to' => 'rgba(255, 255, 255, 0)',
		'mobile_menu_item_height' => '50px',
		'mobile_menu_overlay' => 'on',
		'mobile_menu_force_width' => 'on',
		'mobile_background_from' => 'rgb(255, 255, 255)',
		'mobile_background_to' => 'rgb(255, 255, 255)',
		'mobile_menu_item_link_font_size' => '1.2em',
		'mobile_menu_item_link_color' => 'rgb(43, 43, 43)',
		'mobile_menu_item_link_text_align' => 'left',
		'mobile_menu_item_link_color_hover' => 'rgb(226, 80, 171)',
		'mobile_menu_item_background_hover_from' => 'rgba(255, 255, 255, 0)',
		'mobile_menu_item_background_hover_to' => 'rgba(255, 255, 255, 0)',
		'disable_mobile_toggle' => 'on',
		'custom_css' => '/** Push menu onto new line **/
#{$wrap} {
    clear: both;
}
#{$wrap} #{$menu} > li.mega-menu-item > a.mega-menu-link {
	height: 30px;
	line-height: 30px;
}
@include mobile { // Envato: it is not a PHP code. False alarm.
	#{$wrap} #{$menu} {
		display: flex !important;
		justify-content: center;
		margin-top: 10px;
	}
	#{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu,
	#{$wrap} #{$menu} > li.mega-menu-flyout ul.mega-sub-menu {
		-webkit-box-shadow: none;
		-moz-box-shadow: none;
		-ms-box-shadow: none;
		-o-box-shadow: none;
		box-shadow: none;
	}
	#{$wrap} #{$menu} > li.mega-menu-item {
		display: inline-block;
		margin: 0 3%;
	}
	#{$wrap} #{$menu} > li.mega-menu-item > a.mega-menu-link {
		padding-left: 0;
		padding-right: 0;
	}
	#{$wrap} #{$menu} li.mega-menu-megamenu > ul.mega-sub-menu > li.mega-menu-row .mega-menu-column > ul.mega-sub-menu > li.mega-menu-item {
		padding-left: 0;
		padding-right: 0;
		padding-top: 0;
	}
	#{$wrap} #{$menu} > li.mega-menu-flyout ul.mega-sub-menu {
		padding-bottom: 15px;
	}
	#{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu,
	#{$wrap} #{$menu} > li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item a.mega-menu-link  {
		padding-left: 0;
		padding-right: 0;
	}
}
@media (min-width: 576px) and (max-width: 991px) {
	#{$wrap} #{$menu} {
		justify-content: left;
	}
	#{$wrap} #{$menu} > li.mega-menu-item {
		margin: 0 6% 0 0;
	}
}',
  );
  return $themes;
}
add_filter("megamenu_themes", "megamenu_add_theme_ubit_footer");

function megamenu_add_theme_ubit_top_bar($themes) {
  $themes["ubit_top_bar"] = array(
		'title' => 'Ubit Top Bar',
		'container_background_from' => 'rgba(255, 255, 255, 0)',
		'container_background_to' => 'rgba(255, 255, 255, 0)',
		'container_border_radius_top_left' => '5px',
		'container_border_radius_top_right' => '5px',
		'container_border_radius_bottom_left' => '5px',
		'container_border_radius_bottom_right' => '5px',
		'menu_item_background_hover_from' => 'rgba(255, 255, 255, 0)',
		'menu_item_background_hover_to' => 'rgba(255, 255, 255, 0)',
		'menu_item_spacing' => '20px',
		'menu_item_link_font_size' => '16px',
		'menu_item_link_height' => '32px',
		'menu_item_link_color' => 'rgb(51, 51, 51)',
		'menu_item_link_color_hover' => 'rgb(226, 80, 171)',
		'menu_item_link_weight_hover' => 'inherit',
		'menu_item_link_padding_right' => '0px',
		'menu_item_link_border_radius_top_left' => '5px',
		'menu_item_link_border_radius_top_right' => '5px',
		'menu_item_link_border_radius_bottom_left' => '5px',
		'menu_item_link_border_radius_bottom_right' => '5px',
		'panel_background_from' => 'rgb(255, 255, 255)',
		'panel_background_to' => 'rgb(255, 255, 255)',
		'panel_border_radius_top_left' => '5px',
		'panel_border_radius_top_right' => '5px',
		'panel_border_radius_bottom_left' => '5px',
		'panel_border_radius_bottom_right' => '5px',
		'panel_header_color' => 'rgb(51, 51, 51)',
		'panel_header_border_color' => '#555',
		'panel_padding_top' => '5px',
		'panel_padding_bottom' => '5px',
		'panel_widget_padding_top' => '10px',
		'panel_widget_padding_bottom' => '10px',
		'panel_font_size' => '14px',
		'panel_font_color' => '#666',
		'panel_font_family' => 'inherit',
		'panel_second_level_font_color' => 'rgb(51, 51, 51)',
		'panel_second_level_font_color_hover' => 'rgb(226, 80, 171)',
		'panel_second_level_text_transform' => 'none',
		'panel_second_level_font' => 'inherit',
		'panel_second_level_font_size' => '16px',
		'panel_second_level_font_weight' => 'normal',
		'panel_second_level_font_weight_hover' => 'inherit',
		'panel_second_level_text_decoration' => 'none',
		'panel_second_level_text_decoration_hover' => 'none',
		'panel_second_level_padding_bottom' => '15px',
		'panel_second_level_border_color' => '#555',
		'panel_third_level_font_color' => 'rgb(51, 51, 51)',
		'panel_third_level_font_color_hover' => 'rgb(226, 80, 171)',
		'panel_third_level_font' => 'inherit',
		'panel_third_level_font_size' => '16px',
		'panel_third_level_font_weight_hover' => 'inherit',
		'panel_third_level_padding_top' => '8px',
		'panel_third_level_padding_bottom' => '8px',
		'flyout_width' => '150px',
		'flyout_menu_background_from' => 'rgba(255, 255, 255, 0)',
		'flyout_menu_background_to' => 'rgba(255, 255, 255, 0)',
		'flyout_border_radius_top_left' => '5px',
		'flyout_border_radius_top_right' => '5px',
		'flyout_border_radius_bottom_left' => '5px',
		'flyout_border_radius_bottom_right' => '5px',
		'flyout_link_padding_top' => '10px',
		'flyout_link_padding_bottom' => '10px',
		'flyout_link_weight_hover' => 'inherit',
		'flyout_link_height' => '20px',
		'flyout_background_from' => 'rgb(255, 255, 255)',
		'flyout_background_to' => 'rgb(255, 255, 255)',
		'flyout_background_hover_from' => 'rgb(255, 255, 255)',
		'flyout_background_hover_to' => 'rgb(255, 255, 255)',
		'flyout_link_size' => '16px',
		'flyout_link_color' => 'rgb(51, 51, 51)',
		'flyout_link_color_hover' => 'rgb(226, 80, 171)',
		'flyout_link_family' => 'inherit',
		'responsive_breakpoint' => '991px',
		'line_height' => '1.2',
		'shadow' => 'on',
		'transitions' => 'on',
		'toggle_background_from' => 'rgba(255, 255, 255, 0)',
		'toggle_background_to' => 'rgba(255, 255, 255, 0)',
		'mobile_menu_item_height' => '30px',
		'mobile_menu_overlay' => 'on',
		'mobile_menu_force_width' => 'on',
		'mobile_background_from' => 'rgba(255, 255, 255, 0)',
		'mobile_background_to' => 'rgba(255, 255, 255, 0)',
		'mobile_menu_item_link_font_size' => '16px',
		'mobile_menu_item_link_color' => 'rgb(43, 43, 43)',
		'mobile_menu_item_link_text_align' => 'left',
		'mobile_menu_item_link_color_hover' => 'rgb(226, 80, 171)',
		'mobile_menu_item_background_hover_from' => 'rgba(255, 255, 255, 0)',
		'mobile_menu_item_background_hover_to' => 'rgba(255, 255, 255, 0)',
		'disable_mobile_toggle' => 'on',
		'custom_css' => '/** Push menu onto new line **/
#{$wrap} {
    clear: both;
}
#{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu li.mega-menu-column > ul.mega-sub-menu > li.mega-menu-item > a.mega-menu-link:after {
	content: \'\';
	width: 15px;
	height: 2px;
	background-color: #e250ab;
	display: inline-block;
	position: absolute;
	left: -5px;
	bottom: 10px;
}
@include mobile { // Envato: it is not a PHP code. False alarm.
	#{$wrap} #{$menu} > li.mega-menu-flyout ul.mega-sub-menu {
		position: absolute;
    	z-index: 9999999;
    	min-width: 200px;
	}
	#{$wrap} #{$menu} > li.mega-menu-flyout ul.mega-sub-menu {
		padding-bottom: 0 !important;
	}
	#{$wrap} #{$menu} > li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item a.mega-menu-link {
		padding-left: 10px !important;
		padding-right: 10px !important;
	}
	#{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu {
		position: absolute;
	}
	#{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu,
	#{$wrap} #{$menu} > li.mega-menu-item > a.mega-menu-link {
		padding-left: 0;
		padding-right: 0;
	}
	#{$wrap} #{$menu} li.mega-menu-megamenu > ul.mega-sub-menu > li.mega-menu-row .mega-menu-column > ul.mega-sub-menu > li.mega-menu-item {
		padding-left: 0;
		padding-right: 0;
		padding-top: 0;
	}
	#{$wrap} #{$menu} > li.mega-menu-flyout ul.mega-sub-menu {
		padding-bottom: 15px;
	}
	#{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu,
	#{$wrap} #{$menu} > li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item a.mega-menu-link  {
		padding-left: 0;
		padding-right: 0;
	}
}',
  );
  return $themes;
}
add_filter("megamenu_themes", "megamenu_add_theme_ubit_top_bar");

function megamenu_override_default_theme( $value ) {
  if ( ! isset( $value['primary']['enabled'] ) && ! isset( $value['primary']['theme'] ) ) {
    $value['primary']['enabled'] = true;
    $value['primary']['theme'] = 'ubit';
  }

  if ( ! isset( $value['footer']['enabled'] ) && ! isset( $value['footer']['theme'] ) ) {
    $value['footer']['enabled'] = true;
    $value['footer']['theme'] = 'ubit_footer';
  }

  if ( ! isset( $value['topbar']['enabled'] ) && ! isset( $value['topbar']['theme'] ) ) {
    $value['topbar']['enabled'] = true;
    $value['topbar']['theme'] = 'ubit_top_bar';
  }

  return $value;
}
add_filter( 'default_option_megamenu_settings', 'megamenu_override_default_theme' );

function megamenu_remove_ids_from_toggle_blocks( $attributes, $block, $content, $nav_menu, $args, $theme_id ) {
	if ( isset( $attributes['id'] ) ) {
		unset( $attributes['id'] );
	}

	return $attributes;
}
add_filter( 'megamenu_toggle_block_attributes', 'megamenu_remove_ids_from_toggle_blocks', 10, 6 );
