<?php
/**
 * Header Transparent
 *
 * @package ubit
 */

// Default values.
$defaults = ubit_options();

// Enable/disable Header transparent.
$wp_customize->add_setting(
	'ubit_setting[header_transparent]',
	array(
		'default'           => $defaults['header_transparent'],
		'type'              => 'option',
		'sanitize_callback' => 'ubit_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Ubit_Switch_Control(
		$wp_customize,
		'ubit_setting[header_transparent]',
		array(
			'label'        => esc_html__( 'Enable Transparent Header', 'ubit' ),
			'settings'     => 'ubit_setting[header_transparent]',
			'section'      => 'ubit_header_transparent',
			'left_switch'  => esc_html__( 'No', 'ubit' ),
			'right_switch' => esc_html__( 'Yes', 'ubit' ),
		)
	)
);

// Disable on 404, Search and Archive.
$wp_customize->add_setting(
	'ubit_setting[header_transparent_disable_archive]',
	array(
		'default'           => $defaults['header_transparent_disable_archive'],
		'type'              => 'option',
		'sanitize_callback' => 'ubit_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[header_transparent_disable_archive]',
		array(
			'label'    => esc_html__( 'Disable on 404, Search & Archives', 'ubit' ),
			'settings' => 'ubit_setting[header_transparent_disable_archive]',
			'section'  => 'ubit_header_transparent',
			'type'     => 'checkbox',
		)
	)
);

// Disable on Index.
$wp_customize->add_setting(
	'ubit_setting[header_transparent_disable_index]',
	array(
		'default'           => $defaults['header_transparent_disable_index'],
		'type'              => 'option',
		'sanitize_callback' => 'ubit_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[header_transparent_disable_index]',
		array(
			'label'    => esc_html__( 'Disable on Blog page', 'ubit' ),
			'settings' => 'ubit_setting[header_transparent_disable_index]',
			'section'  => 'ubit_header_transparent',
			'type'     => 'checkbox',
		)
	)
);

// Disable on Pages.
$wp_customize->add_setting(
	'ubit_setting[header_transparent_disable_page]',
	array(
		'default'           => $defaults['header_transparent_disable_page'],
		'type'              => 'option',
		'sanitize_callback' => 'ubit_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[header_transparent_disable_page]',
		array(
			'label'    => esc_html__( 'Disable on Pages', 'ubit' ),
			'settings' => 'ubit_setting[header_transparent_disable_page]',
			'section'  => 'ubit_header_transparent',
			'type'     => 'checkbox',
		)
	)
);

// Disable on Posts.
$wp_customize->add_setting(
	'ubit_setting[header_transparent_disable_post]',
	array(
		'default'           => $defaults['header_transparent_disable_post'],
		'type'              => 'option',
		'sanitize_callback' => 'ubit_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[header_transparent_disable_post]',
		array(
			'label'    => esc_html__( 'Disable on Posts', 'ubit' ),
			'settings' => 'ubit_setting[header_transparent_disable_post]',
			'section'  => 'ubit_header_transparent',
			'type'     => 'checkbox',
		)
	)
);

// Disable on Shop page.
$wp_customize->add_setting(
	'ubit_setting[header_transparent_disable_shop]',
	array(
		'default'           => $defaults['header_transparent_disable_shop'],
		'type'              => 'option',
		'sanitize_callback' => 'ubit_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[header_transparent_disable_shop]',
		array(
			'label'    => esc_html__( 'Disable on Shop page', 'ubit' ),
			'settings' => 'ubit_setting[header_transparent_disable_shop]',
			'section'  => 'ubit_header_transparent',
			'type'     => 'checkbox',
		)
	)
);

// Disable on Product page.
$wp_customize->add_setting(
	'ubit_setting[header_transparent_disable_product]',
	array(
		'default'           => $defaults['header_transparent_disable_product'],
		'type'              => 'option',
		'sanitize_callback' => 'ubit_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[header_transparent_disable_product]',
		array(
			'label'    => esc_html__( 'Disable on Product page', 'ubit' ),
			'settings' => 'ubit_setting[header_transparent_disable_product]',
			'section'  => 'ubit_header_transparent',
			'type'     => 'checkbox',
		)
	)
);

// Enable on devices.
$wp_customize->add_setting(
	'ubit_setting[header_transparent_enable_on]',
	array(
		'default'           => $defaults['header_transparent_enable_on'],
		'type'              => 'option',
		'sanitize_callback' => 'ubit_sanitize_choices',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[header_transparent_enable_on]',
		array(
			'label'    => esc_html__( 'Enable On', 'ubit' ),
			'settings' => 'ubit_setting[header_transparent_enable_on]',
			'section'  => 'ubit_header_transparent',
			'type'     => 'select',
			'choices'  => array(
				'desktop'     => esc_html__( 'Desktop', 'ubit' ),
				'mobile'      => esc_html__( 'Mobile', 'ubit' ),
				'all-devices' => esc_html__( 'Desktop + Mobile', 'ubit' ),
			),
		)
	)
);

// Border divider.
$wp_customize->add_setting(
	'header_transparent_border_divider',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Ubit_Divider_Control(
		$wp_customize,
		'header_transparent_border_divider',
		array(
			'section'  => 'ubit_header_transparent',
			'settings' => 'header_transparent_border_divider',
			'type'     => 'divider',
		)
	)
);

// Border width.
$wp_customize->add_setting(
	'ubit_setting[header_transparent_border_width]',
	array(
		'default'           => $defaults['header_transparent_border_width'],
		'sanitize_callback' => 'absint',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Ubit_Range_Slider_Control(
		$wp_customize,
		'ubit_setting[header_transparent_border_width]',
		array(
			'label'    => esc_html__( 'Bottom Border Width', 'ubit' ),
			'section'  => 'ubit_header_transparent',
			'settings' => array(
				'desktop' => 'ubit_setting[header_transparent_border_width]',
			),
			'choices' => array(
				'desktop' => array(
					'min'  => apply_filters( 'ubit_header_transparent_border_width_min_step', 0 ),
					'max'  => apply_filters( 'ubit_header_transparent_border_width_max_step', 20 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
			),
		)
	)
);

// Border color.
$wp_customize->add_setting(
	'ubit_setting[header_transparent_border_color]',
	array(
		'default'           => $defaults['header_transparent_border_color'],
		'sanitize_callback' => 'ubit_sanitize_rgba_color',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Ubit_Color_Control(
		$wp_customize,
		'ubit_setting[header_transparent_border_color]',
		array(
			'label'    => esc_html__( 'Border Color', 'ubit' ),
			'section'  => 'ubit_header_transparent',
			'settings' => 'ubit_setting[header_transparent_border_color]',
		)
	)
);
