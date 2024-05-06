<?php
/**
 * Footer widgets column
 *
 * @package ubit
 */

// Default values.
$defaults = ubit_options();

// Scroll to top.
$wp_customize->add_setting(
	'ubit_setting[scroll_to_top]',
	array(
		'default'           => $defaults['scroll_to_top'],
		'type'              => 'option',
		'sanitize_callback' => 'ubit_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Ubit_Switch_Control(
		$wp_customize,
		'ubit_setting[scroll_to_top]',
		array(
			'label'        => esc_html__( 'Scroll To Top', 'ubit' ),
			'settings'     => 'ubit_setting[scroll_to_top]',
			'section'      => 'ubit_footer',
			'left_switch'  => esc_html__( 'No', 'ubit' ),
			'right_switch' => esc_html__( 'Yes', 'ubit' ),
		)
	)
);

// Footer display divider.
$wp_customize->add_setting(
	'footer_display_divider',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Ubit_Divider_Control(
		$wp_customize,
		'footer_display_divider',
		array(
			'section'  => 'ubit_footer',
			'settings' => 'footer_display_divider',
			'type'     => 'divider',
		)
	)
);

// Footer display.
$wp_customize->add_setting(
	'ubit_setting[footer_display]',
	array(
		'default'           => $defaults['footer_display'],
		'type'              => 'option',
		'sanitize_callback' => 'ubit_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Ubit_Switch_Control(
		$wp_customize,
		'ubit_setting[footer_display]',
		array(
			'label'        => esc_html__( 'Footer Display', 'ubit' ),
			'settings'     => 'ubit_setting[footer_display]',
			'section'      => 'ubit_footer',
			'left_switch'  => esc_html__( 'No', 'ubit' ),
			'right_switch' => esc_html__( 'Yes', 'ubit' ),
		)
	)
);

// Space.
$wp_customize->add_setting(
	'ubit_setting[footer_space]',
	array(
		'default'           => $defaults['footer_space'],
		'sanitize_callback' => 'absint',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Ubit_Range_Slider_Control(
		$wp_customize,
		'ubit_setting[footer_space]',
		array(
			'label'    => esc_html__( 'Space', 'ubit' ),
			'section'  => 'ubit_footer',
			'settings' => array(
				'desktop' => 'ubit_setting[footer_space]',
			),
			'choices' => array(
				'desktop' => array(
					'min'  => apply_filters( 'ubit_footer_space_min_step', 0 ),
					'max'  => apply_filters( 'ubit_footer_space_max_step', 200 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
			),
		)
	)
);

// Footer widget columns.
$wp_customize->add_setting(
	'ubit_setting[footer_column]',
	array(
		'default'           => $defaults['footer_column'],
		'type'              => 'option',
		'sanitize_callback' => 'ubit_sanitize_choices',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[footer_column]',
		array(
			'label'       => esc_html__( 'Widget Columns', 'ubit' ),
			'settings'    => 'ubit_setting[footer_column]',
			'section'     => 'ubit_footer',
			'type'        => 'select',
			'choices'     => apply_filters(
				'ubit_setting_footer_column_choices',
				array(
					0 => 0,
					1 => 1,
					2 => 2,
					3 => 3,
					4 => 4,
					5 => 5,
				)
			),
		)
	)
);

// Footer background color divider.
$wp_customize->add_setting(
	'footer_background_color_divider',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Ubit_Divider_Control(
		$wp_customize,
		'footer_background_color_divider',
		array(
			'section'  => 'ubit_footer',
			'settings' => 'footer_background_color_divider',
			'type'     => 'divider',
		)
	)
);

// Footer Background.
$wp_customize->add_setting(
	'ubit_setting[footer_background_color]',
	array(
		'default'           => $defaults['footer_background_color'],
		'sanitize_callback' => 'ubit_sanitize_rgba_color',
		'type'              => 'option',
	)
);
$wp_customize->add_control(
	new Ubit_Color_Control(
		$wp_customize,
		'ubit_setting[footer_background_color]',
		array(
			'label'    => esc_html__( 'Background Color', 'ubit' ),
			'section'  => 'ubit_footer',
			'settings' => 'ubit_setting[footer_background_color]',
		)
	)
);

// Footer heading color.
$wp_customize->add_setting(
	'ubit_setting[footer_heading_color]',
	array(
		'default'           => $defaults['footer_heading_color'],
		'sanitize_callback' => 'sanitize_hex_color',
		'type'              => 'option',
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'ubit_setting[footer_heading_color]',
		array(
			'label'    => esc_html__( 'Heading Color', 'ubit' ),
			'section'  => 'ubit_footer',
			'settings' => 'ubit_setting[footer_heading_color]',
		)
	)
);

// Footer link color.
$wp_customize->add_setting(
	'ubit_setting[footer_link_color]',
	array(
		'default'           => $defaults['footer_link_color'],
		'sanitize_callback' => 'sanitize_hex_color',
		'type'              => 'option',
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'ubit_setting[footer_link_color]',
		array(
			'label'    => esc_html__( 'Link Color', 'ubit' ),
			'section'  => 'ubit_footer',
			'settings' => 'ubit_setting[footer_link_color]',
		)
	)
);

// Footer text color.
$wp_customize->add_setting(
	'ubit_setting[footer_text_color]',
	array(
		'default'           => $defaults['footer_text_color'],
		'sanitize_callback' => 'sanitize_hex_color',
		'type'              => 'option',
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'ubit_setting[footer_text_color]',
		array(
			'label'    => esc_html__( 'Text Color', 'ubit' ),
			'section'  => 'ubit_footer',
			'settings' => 'ubit_setting[footer_text_color]',
		)
	)
);

// Footer text divider.
$wp_customize->add_setting(
	'footer_text_divider',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Ubit_Divider_Control(
		$wp_customize,
		'footer_text_divider',
		array(
			'section'  => 'ubit_footer',
			'settings' => 'footer_text_divider',
			'type'     => 'divider',
		)
	)
);

// Custom text.
$wp_customize->add_setting(
	'ubit_setting[footer_custom_text]',
	array(
		'default'           => $defaults['footer_custom_text'],
		'sanitize_callback' => 'ubit_sanitize_raw_html',
		'type'              => 'option',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[footer_custom_text]',
		array(
			'label'    => esc_html__( 'Custom Text', 'ubit' ),
			'type'     => 'textarea',
			'section'  => 'ubit_footer',
			'settings' => 'ubit_setting[footer_custom_text]',
		)
	)
);
