<?php
/**
 * WooCommerce shop single customizer
 *
 * @package ubit
 */

// Default values.
$defaults = ubit_options();

// Shop columns.
$wp_customize->add_setting(
	'ubit_setting[shop_columns]',
	array(
		'default'           => $defaults['shop_columns'],
		'sanitize_callback' => 'ubit_sanitize_choices',
		'type'              => 'option',
	)
);

$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[shop_columns]',
		array(
			'label'    => esc_html__( 'Product Columns', 'ubit' ),
			'section'  => 'ubit_shop_page',
			'type'     => 'select',
			'settings' => 'ubit_setting[shop_columns]',
			'choices'     => apply_filters(
				'ubit_setting_shop_columns',
				array(
					1 => 1,
					2 => 2,
					3 => 3,
					4 => 4,
					5 => 5,
					6 => 6,
				)
			),
		)
	)
);

// Product per page.
$wp_customize->add_setting(
	'ubit_setting[shop_product_per_page]',
	array(
		'default'           => $defaults['shop_product_per_page'],
		'sanitize_callback' => 'absint',
		'type'              => 'option',
	)
);

$wp_customize->add_control(
	new Ubit_Range_Slider_Control(
		$wp_customize,
		'ubit_setting[shop_product_per_page]',
		array(
			'type'        => 'ubit-range-slider',
			'label'       => esc_html__( 'Products Per Row', 'ubit' ),
			'description' => esc_html__( 'How many products should be shown per row?', 'ubit' ),
			'section'     => 'ubit_shop_page',
			'settings'    => array(
				'desktop' => 'ubit_setting[shop_product_per_page]',
			),
			'choices' => array(
				'desktop' => array(
					'min'  => apply_filters( 'ubit_shop_product_per_row_min_step', 3 ),
					'max'  => apply_filters( 'ubit_shop_product_per_row_max_step', 60 ),
					'step' => 1,
					'edit' => true,
					'unit' => '',
				),
			),
		)
	)
);

// Structure title.
$wp_customize->add_setting(
	'shop_page_structute_meta_title',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Ubit_Divider_Control(
		$wp_customize,
		'shop_page_structute_meta_title',
		array(
			'section'  => 'ubit_shop_page',
			'settings' => 'shop_page_structute_meta_title',
			'type'     => 'heading',
			'label'    => esc_html__( 'Shop Structure', 'ubit' ),
		)
	)
);

// Shop title.
$wp_customize->add_setting(
	'ubit_setting[shop_page_title]',
	array(
		'type'              => 'option',
		'default'           => $defaults['shop_page_title'],
		'sanitize_callback' => 'ubit_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[shop_page_title]',
		array(
			'type'     => 'checkbox',
			'label'    => esc_html__( 'Shop Title', 'ubit' ),
			'section'  => 'ubit_shop_page',
			'settings' => 'ubit_setting[shop_page_title]',
		)
	)
);

// Breadcrumbs.
$wp_customize->add_setting(
	'ubit_setting[shop_page_breadcrumb]',
	array(
		'type'              => 'option',
		'default'           => $defaults['shop_page_breadcrumb'],
		'sanitize_callback' => 'ubit_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[shop_page_breadcrumb]',
		array(
			'type'     => 'checkbox',
			'label'    => esc_html__( 'Breadcrumb', 'ubit' ),
			'section'  => 'ubit_shop_page',
			'settings' => 'ubit_setting[shop_page_breadcrumb]',
		)
	)
);

// Product meta title.
$wp_customize->add_setting(
	'shop_page_product_meta_title',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Ubit_Divider_Control(
		$wp_customize,
		'shop_page_product_meta_title',
		array(
			'section'  => 'ubit_shop_page',
			'settings' => 'shop_page_product_meta_title',
			'type'     => 'heading',
			'label'    => esc_html__( 'Product Meta', 'ubit' ),
		)
	)
);

// Product title.
$wp_customize->add_setting(
	'ubit_setting[shop_page_product_title]',
	array(
		'type'              => 'option',
		'default'           => $defaults['shop_page_product_title'],
		'sanitize_callback' => 'ubit_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[shop_page_product_title]',
		array(
			'type'     => 'checkbox',
			'label'    => esc_html__( 'Product Title', 'ubit' ),
			'section'  => 'ubit_shop_page',
			'settings' => 'ubit_setting[shop_page_product_title]',
		)
	)
);

// Product category.
$wp_customize->add_setting(
	'ubit_setting[shop_page_product_category]',
	array(
		'type'              => 'option',
		'default'           => $defaults['shop_page_product_category'],
		'sanitize_callback' => 'ubit_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[shop_page_product_category]',
		array(
			'type'     => 'checkbox',
			'label'    => esc_html__( 'Product Category', 'ubit' ),
			'section'  => 'ubit_shop_page',
			'settings' => 'ubit_setting[shop_page_product_category]',
		)
	)
);

// Product rating.
$wp_customize->add_setting(
	'ubit_setting[shop_page_product_rating]',
	array(
		'type'              => 'option',
		'default'           => $defaults['shop_page_product_rating'],
		'sanitize_callback' => 'ubit_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[shop_page_product_rating]',
		array(
			'type'     => 'checkbox',
			'label'    => esc_html__( 'Product Rating', 'ubit' ),
			'section'  => 'ubit_shop_page',
			'settings' => 'ubit_setting[shop_page_product_rating]',
		)
	)
);

// Product add to cart button.
$wp_customize->add_setting(
	'ubit_setting[shop_page_product_add_to_cart_button]',
	array(
		'type'              => 'option',
		'default'           => $defaults['shop_page_product_add_to_cart_button'],
		'sanitize_callback' => 'ubit_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[shop_page_product_add_to_cart_button]',
		array(
			'type'     => 'checkbox',
			'label'    => esc_html__( 'Product Add To Cart Button', 'ubit' ),
			'section'  => 'ubit_shop_page',
			'settings' => 'ubit_setting[shop_page_product_add_to_cart_button]',
		)
	)
);

// Product price.
$wp_customize->add_setting(
	'ubit_setting[shop_page_product_price]',
	array(
		'type'              => 'option',
		'default'           => $defaults['shop_page_product_price'],
		'sanitize_callback' => 'ubit_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[shop_page_product_price]',
		array(
			'type'     => 'checkbox',
			'label'    => esc_html__( 'Product Price', 'ubit' ),
			'section'  => 'ubit_shop_page',
			'settings' => 'ubit_setting[shop_page_product_price]',
		)
	)
);
