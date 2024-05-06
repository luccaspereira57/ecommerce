<?php
/**
 * Theme Builder
 *
 * @package ubit
 */

if ( ! function_exists( 'ubit_template_header' ) ) {
	/**
	 * Header template
	 */
	function ubit_template_header() {
		if ( function_exists( 'hfe_render_header' ) && hfe_header_enabled() ) {
			// Support Header & Footer Elementor plugin.
			hfe_render_header();
		} else {
			get_template_part( 'template-parts/header' );
		}
	}
}

if ( ! function_exists( 'ubit_template_footer' ) ) {
	/**
	 * Footer template
	 */
	function ubit_template_footer() {
		// Support Header & Footer Elementor plugin.
		if ( function_exists( 'hfe_render_footer' ) && hfe_footer_enabled() ) {
			hfe_render_footer();
		} else {
			get_template_part( 'template-parts/footer' );
		}
	}
}

if ( ! function_exists( 'ubit_template_single' ) ) {
	/**
	 * Single template
	 */
	function ubit_template_single() {
		get_template_part( 'template-parts/single' );
	}
}

if ( ! function_exists( 'ubit_template_archive' ) ) {
	/**
	 * Archive template
	 */
	function ubit_template_archive() {
		get_template_part( 'template-parts/archive' );
	}
}

if ( ! function_exists( 'ubit_template_404' ) ) {
	/**
	 * 404 template
	 */
	function ubit_template_404() {
		get_template_part( 'template-parts/404' );
	}
}
