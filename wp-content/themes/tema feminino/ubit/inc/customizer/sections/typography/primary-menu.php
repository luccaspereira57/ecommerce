<?php
/**
 * Primary menu typography
 *
 * @package ubit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Default values.
$defaults = ubit_options();

// menu font family.
$wp_customize->add_setting(
	'ubit_setting[menu_font_family]',
	array(
		'default'           => $defaults['menu_font_family'],
		'type'              => 'option',
		'sanitize_callback' => 'sanitize_text_field',
	)
);

// menu font category.
$wp_customize->add_setting(
	'menu_font_category',
	array(
		'default'           => $defaults['menu_font_category'],
		'sanitize_callback' => 'sanitize_text_field',
	)
);

// font font variants.
$wp_customize->add_setting(
	'menu_font_family_variants',
	array(
		'default'           => $defaults['menu_font_family_variants'],
		'sanitize_callback' => 'ubit_sanitize_variants',
	)
);

// menu font weight.
$wp_customize->add_setting(
	'ubit_setting[menu_font_weight]',
	array(
		'default'           => $defaults['menu_font_weight'],
		'type'              => 'option',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);

// menu text transform.
$wp_customize->add_setting(
	'ubit_setting[menu_font_transform]',
	array(
		'default'           => $defaults['menu_font_transform'],
		'type'              => 'option',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);

// add control for menu typography.
$wp_customize->add_control(
	new Ubit_Typography_Control(
		$wp_customize,
		'menu_typography',
		array(
			'section'  => 'menu_font_section',
			'label'    => esc_html__( 'Menu Font', 'ubit' ),
			'settings' => array(
				'family'    => 'ubit_setting[menu_font_family]',
				'variant'   => 'menu_font_family_variants',
				'category'  => 'menu_font_category',
				'weight'    => 'ubit_setting[menu_font_weight]',
				'transform' => 'ubit_setting[menu_font_transform]',
			),
		)
	)
);

// Parent menu divider.
$wp_customize->add_setting(
	'parent_menu_divider',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Ubit_Divider_Control(
		$wp_customize,
		'parent_menu_divider',
		array(
			'section'  => 'menu_font_section',
			'settings' => 'parent_menu_divider',
			'type'     => 'divider',
		)
	)
);

// CUSTOM HEADING.
$wp_customize->add_setting(
	'parent_menu_title',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'parent_menu_title',
		array(
			'label'    => esc_html__( 'Parent Menu', 'ubit' ),
			'section'  => 'menu_font_section',
			'settings' => 'parent_menu_title',
			'type'     => 'hidden',
		)
	)
);

// parent menu font size.
$wp_customize->add_setting(
	'ubit_setting[parent_menu_font_size]',
	array(
		'default'           => $defaults['parent_menu_font_size'],
		'sanitize_callback' => 'absint',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	new Ubit_Range_Slider_Control(
		$wp_customize,
		'ubit_setting[parent_menu_font_size]',
		array(
			'type'           => 'ubit-range-slider',
			'description'    => esc_html__( 'Font Size', 'ubit' ),
			'section'        => 'menu_font_section',
			'settings'       => array(
				'desktop' => 'ubit_setting[parent_menu_font_size]',
			),
			'choices'        => array(
				'desktop' => array(
					'min'  => apply_filters( 'ubit_parent_menu_font_size_min_step', 10 ),
					'max'  => apply_filters( 'ubit_parent_menu_font_size_max_step', 60 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
			),
		)
	)
);

// parent menu line height.
$wp_customize->add_setting(
	'ubit_setting[parent_menu_line_height]',
	array(
		'default'           => $defaults['parent_menu_line_height'],
		'sanitize_callback' => 'absint',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	new Ubit_Range_Slider_Control(
		$wp_customize,
		'ubit_setting[parent_menu_line_height]',
		array(
			'type'           => 'ubit-range-slider',
			'description'    => esc_html__( 'Line Height', 'ubit' ),
			'section'        => 'menu_font_section',
			'settings'       => array(
				'desktop' => 'ubit_setting[parent_menu_line_height]',
			),
			'choices'        => array(
				'desktop' => array(
					'min'  => apply_filters( 'ubit_parent_menu_line_height_min_step', 10 ),
					'max'  => apply_filters( 'ubit_parent_menu_line_height_max_step', 100 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
			),
		)
	)
);

// Submenu divider.
$wp_customize->add_setting(
	'sub_menu_divider',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Ubit_Divider_Control(
		$wp_customize,
		'sub_menu_divider',
		array(
			'section'  => 'menu_font_section',
			'settings' => 'sub_menu_divider',
			'type'     => 'divider',
		)
	)
);

// CUSTOM HEADING.
$wp_customize->add_setting(
	'sub_menu_title',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'sub_menu_title',
		array(
			'label'    => esc_html__( 'Sub Menu', 'ubit' ),
			'section'  => 'menu_font_section',
			'settings' => 'sub_menu_title',
			'type'     => 'hidden',
		)
	)
);

// sub menu font size.
$wp_customize->add_setting(
	'ubit_setting[sub_menu_font_size]',
	array(
		'default'           => $defaults['sub_menu_font_size'],
		'sanitize_callback' => 'absint',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	new Ubit_Range_Slider_Control(
		$wp_customize,
		'ubit_setting[sub_menu_font_size]',
		array(
			'type'        => 'ubit-range-slider',
			'description' => esc_html__( 'Font Size', 'ubit' ),
			'section'     => 'menu_font_section',
			'settings'    => array(
				'desktop' => 'ubit_setting[sub_menu_font_size]',
			),
			'choices'     => array(
				'desktop' => array(
					'min'  => apply_filters( 'ubit_sub_menu_font_size_min_step', 10 ),
					'max'  => apply_filters( 'ubit_sub_menu_font_size_max_step', 100 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
			),
		)
	)
);

// sub menu line height.
$wp_customize->add_setting(
	'ubit_setting[sub_menu_line_height]',
	array(
		'default'           => $defaults['sub_menu_line_height'],
		'sanitize_callback' => 'absint',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	new Ubit_Range_Slider_Control(
		$wp_customize,
		'ubit_setting[sub_menu_line_height]',
		array(
			'type'        => 'ubit-range-slider',
			'description' => esc_html__( 'Line Height', 'ubit' ),
			'section'     => 'menu_font_section',
			'settings'    => array(
				'desktop' => 'ubit_setting[sub_menu_line_height]',
			),
			'choices'     => array(
				'desktop' => array(
					'min'  => apply_filters( 'ubit_sub_menu_line_height_min_step', 10 ),
					'max'  => apply_filters( 'ubit_sub_menu_line_height_max_step', 100 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
			),
		)
	)
);
