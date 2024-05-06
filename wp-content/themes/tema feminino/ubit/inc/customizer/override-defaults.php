<?php
/**
 * Override default customizer panels, sections, settings or controls.
 *
 * @package ubit
 */

// Move background color setting alongside background image.
$wp_customize->get_control( 'background_color' )->section  = 'background_image';

// Change background image section title & priority.
$wp_customize->get_section( 'background_image' )->panel    = 'ubit_layout';
$wp_customize->get_section( 'background_image' )->title    = esc_html__( 'Site Container', 'ubit' );
$wp_customize->get_section( 'background_image' )->priority = 10;

// Remove description on Site Icon.
$wp_customize->get_control( 'site_icon' )->description     = '';

$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

// Chage WooCommerce panel priority, after Typography panel.
if ( class_exists( 'woocommerce' ) ) {
	$wp_customize->get_panel( 'woocommerce' )->priority = 40;
}
