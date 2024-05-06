<?php
/**
 * Topbar
 *
 * @package ubit
 */

// Default values.
$defaults = ubit_options();

// Topbar color.
$wp_customize->add_setting(
	'ubit_setting[topbar_text_color]',
	array(
		'default'           => $defaults['topbar_text_color'],
		'sanitize_callback' => 'sanitize_hex_color',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'ubit_setting[topbar_text_color]',
		array(
			'label'    => esc_html__( 'Text Color', 'ubit' ),
			'section'  => 'ubit_topbar',
			'settings' => 'ubit_setting[topbar_text_color]',
		)
	)
);

// Background color.
$wp_customize->add_setting(
	'ubit_setting[topbar_background_color]',
	array(
		'default'           => $defaults['topbar_background_color'],
		'sanitize_callback' => 'sanitize_hex_color',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Ubit_Color_Control(
		$wp_customize,
		'ubit_setting[topbar_background_color]',
		array(
			'label'    => esc_html__( 'Background Color', 'ubit' ),
			'section'  => 'ubit_topbar',
			'settings' => 'ubit_setting[topbar_background_color]',
		)
	)
);

// Space.
$wp_customize->add_setting(
	'ubit_setting[topbar_space]',
	array(
		'default'           => $defaults['topbar_space'],
		'sanitize_callback' => 'absint',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Ubit_Range_Slider_Control(
		$wp_customize,
		'ubit_setting[topbar_space]',
		array(
			'label'    => esc_html__( 'Space', 'ubit' ),
			'section'  => 'ubit_topbar',
			'settings' => array(
				'desktop' => 'ubit_setting[topbar_space]',
			),
			'choices' => array(
				'desktop' => array(
					'min'  => apply_filters( 'ubit_topbar_min_step', 0 ),
					'max'  => apply_filters( 'ubit_topbar_max_step', 50 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
			),
		)
	)
);

// Content divider.
$wp_customize->add_setting(
	'topbar_content_divider',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Ubit_Divider_Control(
		$wp_customize,
		'topbar_content_divider',
		array(
			'section'  => 'ubit_topbar',
			'settings' => 'topbar_content_divider',
			'type'     => 'divider',
		)
	)
);

// Topbar left.
$wp_customize->add_setting(
	'ubit_setting[topbar_left]',
	array(
		'default'           => $defaults['topbar_left'],
		'sanitize_callback' => 'ubit_sanitize_raw_html',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[topbar_left]',
		array(
			'label'    => esc_html__( 'Content Left', 'ubit' ),
			'section'  => 'ubit_topbar',
			'settings' => 'ubit_setting[topbar_left]',
			'type'     => 'textarea',
		)
	)
);

// Topbar center.
$wp_customize->add_setting(
	'ubit_setting[topbar_center]',
	array(
		'default'           => $defaults['topbar_center'],
		'sanitize_callback' => 'ubit_sanitize_raw_html',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[topbar_center]',
		array(
			'label'    => esc_html__( 'Content Center', 'ubit' ),
			'section'  => 'ubit_topbar',
			'settings' => 'ubit_setting[topbar_center]',
			'type'     => 'textarea',
		)
	)
);

// Topbar right.
$wp_customize->add_setting(
	'ubit_setting[topbar_right]',
	array(
		'default'           => $defaults['topbar_right'],
		'sanitize_callback' => 'ubit_sanitize_raw_html',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[topbar_right]',
		array(
			'label'    => esc_html__( 'Content Right', 'ubit' ),
			'section'  => 'ubit_topbar',
			'settings' => 'ubit_setting[topbar_right]',
			'type'     => 'textarea',
		)
	)
);
