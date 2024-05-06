<?php
/**
 * Ubit hooks
 *
 * @package ubit
 */

/**
 * General
 */
add_action( 'ubit_sidebar', 'ubit_get_sidebar', 10 );

// Head tag.
add_action( 'ubit_head', 'ubit_facebook_social', 10 );
add_action( 'ubit_head', 'ubit_pingback', 20 );

// Performance.
add_action( 'wp_enqueue_scripts', 'ubit_dequeue_scripts_and_styles', 20 );

/**
 * Header
 */
add_action( 'ubit_theme_header', 'ubit_topbar' );
add_action( 'ubit_theme_header', 'ubit_template_header' );
add_action( 'ubit_theme_header', 'ubit_after_header', 100 );

// Header template part.
add_action( 'ubit_template_part_header', 'ubit_view_open', 10 ); // Open #view.
add_action( 'ubit_template_part_header', 'ubit_site_header', 30 );

// Inside @ubit_site_header hook.
add_action( 'ubit_site_header', 'ubit_default_container_open', 0 );
add_action( 'ubit_site_header', 'ubit_skip_links', 5 );
add_action( 'ubit_site_header', 'ubit_menu_toggle_btn', 10 );
add_action( 'ubit_site_header', 'ubit_site_branding', 20 );
add_action( 'ubit_site_header', 'ubit_primary_navigation', 30 );
add_action( 'ubit_site_header', 'ubit_header_action', 50 );
add_action( 'ubit_site_header', 'ubit_default_container_close', 200 );

// Inside @ubit_after_header hook.
add_action( 'ubit_after_header', 'ubit_page_header', 10 );
add_action( 'ubit_after_header', 'ubit_content_open', 20 ); // Open #content.
add_action( 'ubit_after_header', 'ubit_container_open', 30 ); // Open .container.
add_action( 'ubit_after_header', 'ubit_content_top', 40 );

// Inside @ubit_content_top hook.
add_action( 'ubit_content_top', 'ubit_content_top_open', 10 );
add_action( 'ubit_content_top', 'ubit_content_top_close', 40 );

/**
 * Page Header
 */
add_action( 'ubit_page_header_end', 'ubit_breadcrumb', 10 );

/**
 * Footer
 */
add_action( 'ubit_theme_footer', 'ubit_before_footer', 0 );
add_action( 'ubit_theme_footer', 'ubit_template_footer' );
add_action( 'ubit_theme_footer', 'ubit_after_footer', 100 );

// Footer template part.
add_action( 'ubit_template_part_footer', 'ubit_site_footer', 10 );
add_action( 'ubit_template_part_footer', 'ubit_view_close', 30 ); // Close #view.

// Inside @ubit_before_footer hook.
add_action( 'ubit_before_footer', 'ubit_container_close', 10 ); // Close .container.
add_action( 'ubit_before_footer', 'ubit_content_close', 10 ); // Close #content.

// Inside @ubit_after_footer hook.
add_action( 'ubit_after_footer', 'ubit_toggle_sidebar', 10 );
add_action( 'ubit_after_footer', 'ubit_overlay', 20 );
add_action( 'ubit_after_footer', 'ubit_footer_action', 20 );
add_action( 'ubit_after_footer', 'ubit_dialog_search', 30 );

// Inside @ubit_footer_action hook.
add_action( 'ubit_footer_action', 'ubit_scroll_to_top', 40 );

// Inside @ubit_site_footer hook.
add_action( 'ubit_footer_content', 'ubit_footer_widgets', 10 );
add_action( 'ubit_footer_content', 'ubit_credit', 20 );

// Inside @ubit_toggle_sidebar hook.
add_action( 'ubit_toggle_sidebar', 'ubit_sidebar_menu_open', 10 );
add_action( 'ubit_toggle_sidebar', 'ubit_search', 20 );
add_action( 'ubit_toggle_sidebar', 'ubit_primary_navigation', 30 );
add_action( 'ubit_toggle_sidebar', 'ubit_sidebar_menu_action', 40 );
add_action( 'ubit_toggle_sidebar', 'ubit_sidebar_menu_close', 50 );

/**
 * Posts
 */
add_action( 'ubit_loop_post', 'ubit_post_header_wrapper', 10 );
add_action( 'ubit_loop_post', 'ubit_post_thumbnail', 20 );

add_action( 'ubit_loop_post', 'ubit_post_info_start', 30 );
add_action( 'ubit_loop_post', 'ubit_post_title', 40 );
add_action( 'ubit_loop_post', 'ubit_post_meta', 50 );
add_action( 'ubit_loop_post', 'ubit_post_info_end', 60 );

add_action( 'ubit_loop_post', 'ubit_post_header_wrapper_close', 70 );
add_action( 'ubit_loop_post', 'ubit_post_content', 80 );

add_action( 'ubit_loop_after', 'ubit_paging_nav', 10 );
add_action( 'ubit_post_content_after', 'ubit_post_read_more_button', 10 );

add_action( 'ubit_single_post', 'ubit_post_title', 10 );
add_action( 'ubit_single_post', 'ubit_post_thumbnail', 20 );
add_action( 'ubit_single_post', 'ubit_post_meta', 30 );
add_action( 'ubit_single_post', 'ubit_post_content', 40 );
add_action( 'ubit_single_post', 'ubit_post_tags', 50 );
add_action( 'ubit_single_post', 'ubit_post_divider_bottom', 60 );

add_action( 'ubit_single_post_after', 'ubit_post_author_box', 20 );
add_action( 'ubit_single_post_after', 'ubit_post_nav', 30 );
add_action( 'ubit_single_post_after', 'ubit_post_related', 40 );
add_action( 'ubit_single_post_after', 'ubit_display_comments', 50 );

/**
 * Pages
 */
add_action( 'ubit_before_content', 'ubit_page_header', 10 );
add_action( 'ubit_page', 'ubit_page_content', 20 );
add_action( 'ubit_page_after', 'ubit_display_comments', 10 );

/**
 * Add search form to 404 page
 */
add_action( 'ubit_theme_404_container', 'ubit_search', 10 );

/**
 * Elementor
 */

// Template builder ( See inc/ubit-template-builder.php ).
add_action( 'ubit_theme_single', 'ubit_template_single' );
add_action( 'ubit_theme_archive', 'ubit_template_archive' );
add_action( 'ubit_theme_404', 'ubit_template_404' );

// Add Cart sidebar for Page using Elementor Canvas.
add_action( 'elementor/page_templates/canvas/after_content', 'ubit_woocommerce_cart_sidebar', 20 );
add_action( 'elementor/page_templates/canvas/after_content', 'ubit_overlay', 30 );
add_action( 'elementor/page_templates/canvas/after_content', 'ubit_footer_action', 40 );

add_action( 'elementor/page_templates/canvas/after_content', 'ubit_dialog_search', 50 );
