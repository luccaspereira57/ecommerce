<?php
/**
 * Register customizer panels & sections.
 *
 * @package ubit
 */

// LAYOUT.
$layout_sections = apply_filters(
	'ubit_customizer_layout_sections',
	array(
		'ubit_topbar'             => esc_html__( 'Topbar', 'ubit' ),
		'ubit_header'             => esc_html__( 'Normal Header', 'ubit' ),
		'ubit_header_transparent' => esc_html__( 'Header Transparent', 'ubit' ),
		'ubit_page_header'        => esc_html__( 'Page Header', 'ubit' ),
		'ubit_blog'               => esc_html__( 'Blog', 'ubit' ),
		'ubit_blog_single'        => esc_html__( 'Blog Single', 'ubit' ),
		'ubit_sidebar'            => esc_html__( 'Sidebar', 'ubit' ),
		'ubit_footer'             => esc_html__( 'Footer', 'ubit' ),
		'ubit_error'              => esc_html__( '404', 'ubit' ),
	)
);

$wp_customize->add_panel(
	'ubit_layout',
	array(
		'title'      => esc_html__( 'Layout', 'ubit' ),
		'priority'   => 30,
	)
);

foreach ( $layout_sections as $section_id => $name ) {
	$wp_customize->add_section(
		$section_id,
		array(
			'title' => $name,
			'panel' => 'ubit_layout',
		)
	);
}

// COLORS.
$wp_customize->add_section(
	'ubit_color',
	array(
		'title'    => esc_html__( 'Colors', 'ubit' ),
		'priority' => 30,
	)
);

// BUTTONS.
$wp_customize->add_section(
	'ubit_buttons',
	array(
		'title'    => esc_html__( 'Buttons', 'ubit' ),
		'priority' => 30,
	)
);

// TYPOGRAPHY.
$wp_customize->add_panel(
	'ubit_typography',
	array(
		'title'      => esc_html__( 'Typography', 'ubit' ),
		'priority'   => 35,
	)
);

// Body.
$wp_customize->add_section(
	'body_font_section',
	array(
		'title'      => esc_html__( 'Body', 'ubit' ),
		'panel'      => 'ubit_typography',
	)
);

// Primary menu.
$wp_customize->add_section(
	'menu_font_section',
	array(
		'title'      => esc_html__( 'Primary menu', 'ubit' ),
		'panel'      => 'ubit_typography',
	)
);

// Heading.
$wp_customize->add_section(
	'heading_font_section',
	array(
		'title'      => esc_html__( 'Heading', 'ubit' ),
		'panel'      => 'ubit_typography',
	)
);

// WOOCOMMERCE.
$wp_customize->add_section(
	'ubit_product_style',
	array(
		'title'      => esc_html__( 'Product Style', 'ubit' ),
		'panel'      => 'woocommerce',
	)
);

$wp_customize->add_section(
	'ubit_shop_page',
	array(
		'title'      => esc_html__( 'Shop Archive', 'ubit' ),
		'panel'      => 'woocommerce',
	)
);

$wp_customize->add_section(
	'ubit_shop_single',
	array(
		'title'      => esc_html__( 'Product Single', 'ubit' ),
		'panel'      => 'woocommerce',
	)
);
