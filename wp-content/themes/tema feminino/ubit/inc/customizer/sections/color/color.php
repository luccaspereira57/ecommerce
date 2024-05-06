<?php
/**
 * Color customizer
 *
 * @package ubit
 */

// Default values.
$defaults = ubit_options();

// Theme color.
$wp_customize->add_setting(
	'ubit_setting[theme_color]',
	array(
		'default'           => $defaults['theme_color'],
		'sanitize_callback' => 'sanitize_hex_color',
		'type'              => 'option',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'ubit_setting[theme_color]',
		array(
			'label'    => esc_html__( 'Theme Color', 'ubit' ),
			'section'  => 'ubit_color',
			'settings' => 'ubit_setting[theme_color]',
		)
	)
);

// Primary parent menu color.
$wp_customize->add_setting(
	'ubit_setting[primary_menu_color]',
	array(
		'default'           => $defaults['primary_menu_color'],
		'sanitize_callback' => 'sanitize_hex_color',
		'type'              => 'option',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'ubit_setting[primary_menu_color]',
		array(
			'label'    => esc_html__( 'Parent Menu Color', 'ubit' ),
			'section'  => 'ubit_color',
			'settings' => 'ubit_setting[primary_menu_color]',
		)
	)
);

// Primary sub menu color.
$wp_customize->add_setting(
	'ubit_setting[primary_sub_menu_color]',
	array(
		'default'           => $defaults['primary_sub_menu_color'],
		'sanitize_callback' => 'sanitize_hex_color',
		'type'              => 'option',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'ubit_setting[primary_sub_menu_color]',
		array(
			'label'    => esc_html__( 'Sub-menu Color', 'ubit' ),
			'section'  => 'ubit_color',
			'settings' => 'ubit_setting[primary_sub_menu_color]',
		)
	)
);

// Heading color.
$wp_customize->add_setting(
	'ubit_setting[heading_color]',
	array(
		'default'           => $defaults['heading_color'],
		'sanitize_callback' => 'sanitize_hex_color',
		'type'              => 'option',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'ubit_setting[heading_color]',
		array(
			'label'    => esc_html__( 'Heading Color', 'ubit' ),
			'section'  => 'ubit_color',
			'settings' => 'ubit_setting[heading_color]',
		)
	)
);

// Text Color.
$wp_customize->add_setting(
	'ubit_setting[text_color]',
	array(
		'default'           => $defaults['text_color'],
		'sanitize_callback' => 'sanitize_hex_color',
		'type'              => 'option',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'ubit_setting[text_color]',
		array(
			'label'    => esc_html__( 'Text Color', 'ubit' ),
			'section'  => 'ubit_color',
			'settings' => 'ubit_setting[text_color]',
		)
	)
);

// Accent Color.
$wp_customize->add_setting(
	'ubit_setting[accent_color]',
	array(
		'default'           => $defaults['accent_color'],
		'sanitize_callback' => 'sanitize_hex_color',
		'type'              => 'option',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'ubit_setting[accent_color]',
		array(
			'label'    => esc_html__( 'Link / Accent Color', 'ubit' ),
			'section'  => 'ubit_color',
			'settings' => 'ubit_setting[accent_color]',
		)
	)
);
