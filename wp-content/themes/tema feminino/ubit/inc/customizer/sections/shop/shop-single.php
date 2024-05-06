<?php
/**
 * WooCommerce shop single customizer
 *
 * @package ubit
 */

// Default values.
$defaults = ubit_options();

// Product content background.
$wp_customize->add_setting(
	'ubit_setting[shop_single_content_background]',
	array(
		'default'           => $defaults['shop_single_content_background'],
		'sanitize_callback' => 'sanitize_hex_color',
		'type'              => 'option',
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'ubit_setting[shop_single_content_background]',
		array(
			'label'    => esc_html__( 'Content Background', 'ubit' ),
			'section'  => 'ubit_shop_single',
			'settings' => 'ubit_setting[shop_single_content_background]',
		)
	)
);

// Gallery layout.
$wp_customize->add_setting(
	'ubit_setting[shop_single_gallery_layout]',
	array(
		'default'           => $defaults['shop_single_gallery_layout'],
		'sanitize_callback' => 'ubit_sanitize_choices',
		'type'              => 'option',
	)
);

$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[shop_single_gallery_layout]',
		array(
			'label'    => esc_html__( 'Gallery Layout', 'ubit' ),
			'section'  => 'ubit_shop_single',
			'settings' => 'ubit_setting[shop_single_gallery_layout]',
			'type'     => 'select',
			'choices'  => apply_filters(
				'ubit_setting_sidebar_default_choices',
				array(
					'vertical'   => esc_html__( 'Vertical', 'ubit' ),
					'horizontal' => esc_html__( 'Horizontal', 'ubit' ),
				)
			),
		)
	)
);

// End section one divider.
$wp_customize->add_setting(
	'shop_single_section_one_divider',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Ubit_Divider_Control(
		$wp_customize,
		'shop_single_section_one_divider',
		array(
			'section'  => 'ubit_shop_single',
			'settings' => 'shop_single_section_one_divider',
			'type'     => 'divider',
		)
	)
);

// Structure title.
$wp_customize->add_setting(
	'shop_single_structute_meta_title',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Ubit_Divider_Control(
		$wp_customize,
		'shop_single_structute_meta_title',
		array(
			'section'  => 'ubit_shop_single',
			'settings' => 'shop_single_structute_meta_title',
			'type'     => 'heading',
			'label'    => esc_html__( 'Product Single Structure', 'ubit' ),
		)
	)
);

// Breadcrumbs.
$wp_customize->add_setting(
	'ubit_setting[shop_single_breadcrumb]',
	array(
		'type'              => 'option',
		'default'           => $defaults['shop_single_breadcrumb'],
		'sanitize_callback' => 'ubit_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[shop_single_breadcrumb]',
		array(
			'type'     => 'checkbox',
			'label'    => esc_html__( 'Breadcrumb', 'ubit' ),
			'section'  => 'ubit_shop_single',
			'settings' => 'ubit_setting[shop_single_breadcrumb]',
		)
	)
);

// Single product meta title.
$wp_customize->add_setting(
	'shop_single_product_meta_title',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Ubit_Divider_Control(
		$wp_customize,
		'shop_single_product_meta_title',
		array(
			'section'  => 'ubit_shop_single',
			'settings' => 'shop_single_product_meta_title',
			'type'     => 'heading',
			'label'    => esc_html__( 'Product Meta', 'ubit' ),
		)
	)
);

// Sku.
$wp_customize->add_setting(
	'ubit_setting[shop_single_skus]',
	array(
		'type'              => 'option',
		'transport'         => 'postMessage',
		'default'           => $defaults['shop_single_skus'],
		'sanitize_callback' => 'ubit_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[shop_single_skus]',
		array(
			'type'     => 'checkbox',
			'label'    => esc_html__( 'SKU', 'ubit' ),
			'section'  => 'ubit_shop_single',
			'settings' => 'ubit_setting[shop_single_skus]',
		)
	)
);

// Categories.
$wp_customize->add_setting(
	'ubit_setting[shop_single_categories]',
	array(
		'type'              => 'option',
		'transport'         => 'postMessage',
		'default'           => $defaults['shop_single_categories'],
		'sanitize_callback' => 'ubit_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[shop_single_categories]',
		array(
			'type'     => 'checkbox',
			'label'    => esc_html__( 'Categories', 'ubit' ),
			'section'  => 'ubit_shop_single',
			'settings' => 'ubit_setting[shop_single_categories]',
		)
	)
);

// Tags.
$wp_customize->add_setting(
	'ubit_setting[shop_single_tags]',
	array(
		'type'              => 'option',
		'transport'         => 'postMessage',
		'default'           => $defaults['shop_single_tags'],
		'sanitize_callback' => 'ubit_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[shop_single_tags]',
		array(
			'type'     => 'checkbox',
			'label'    => esc_html__( 'Tags', 'ubit' ),
			'section'  => 'ubit_shop_single',
			'settings' => 'ubit_setting[shop_single_tags]',
		)
	)
);

// End section two divider.
$wp_customize->add_setting(
	'shop_single_section_two_divider',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Ubit_Divider_Control(
		$wp_customize,
		'shop_single_section_two_divider',
		array(
			'section'  => 'ubit_shop_single',
			'settings' => 'shop_single_section_two_divider',
			'type'     => 'divider',
		)
	)
);
