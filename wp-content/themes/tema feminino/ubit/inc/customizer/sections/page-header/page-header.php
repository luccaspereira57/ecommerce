<?php
/**
 * Page Header
 *
 * @package ubit
 */

// Default values.
$defaults = ubit_options();

// Page header display.
$wp_customize->add_setting(
	'ubit_setting[page_header_display]',
	array(
		'default'           => $defaults['page_header_display'],
		'type'              => 'option',
		'sanitize_callback' => 'ubit_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Ubit_Switch_Control(
		$wp_customize,
		'ubit_setting[page_header_display]',
		array(
			'label'        => esc_html__( 'Page Header Display', 'ubit' ),
			'settings'     => 'ubit_setting[page_header_display]',
			'section'      => 'ubit_page_header',
			'left_switch'  => esc_html__( 'No', 'ubit' ),
			'right_switch' => esc_html__( 'Yes', 'ubit' ),
		)
	)
);

// Breadcrumb divider.
$wp_customize->add_setting(
	'page_header_breadcrumb_divider',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Ubit_Divider_Control(
		$wp_customize,
		'page_header_breadcrumb_divider',
		array(
			'section'  => 'ubit_page_header',
			'settings' => 'page_header_breadcrumb_divider',
			'type'     => 'divider',
		)
	)
);

// Breadcrumb.
$wp_customize->add_setting(
	'ubit_setting[page_header_breadcrumb]',
	array(
		'default'           => $defaults['page_header_breadcrumb'],
		'type'              => 'option',
		'sanitize_callback' => 'ubit_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[page_header_breadcrumb]',
		array(
			'label'    => esc_html__( 'Breadcrumb', 'ubit' ),
			'settings' => 'ubit_setting[page_header_breadcrumb]',
			'section'  => 'ubit_page_header',
			'type'     => 'checkbox',
		)
	)
);

// Text align.
$wp_customize->add_setting(
	'ubit_setting[page_header_text_align]',
	array(
		'default'           => $defaults['page_header_text_align'],
		'type'              => 'option',
		'sanitize_callback' => 'ubit_sanitize_choices',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[page_header_text_align]',
		array(
			'label'       => esc_html__( 'Text Align', 'ubit' ),
			'settings'    => 'ubit_setting[page_header_text_align]',
			'section'     => 'ubit_page_header',
			'type'        => 'select',
			'choices'     => array(
				'left'    => esc_html__( 'Left', 'ubit' ),
				'center'  => esc_html__( 'Center', 'ubit' ),
				'right'   => esc_html__( 'Right', 'ubit' ),
				'justify' => esc_html__( 'Page Title / Breadcrumb', 'ubit' ),
			),
		)
	)
);

// Title color divider.
$wp_customize->add_setting(
	'page_header_title_color_divider',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Ubit_Divider_Control(
		$wp_customize,
		'page_header_title_color_divider',
		array(
			'section'  => 'ubit_page_header',
			'settings' => 'page_header_title_color_divider',
			'type'     => 'divider',
		)
	)
);

// Title color.
$wp_customize->add_setting(
	'ubit_setting[page_header_title_color]',
	array(
		'default'           => $defaults['page_header_title_color'],
		'sanitize_callback' => 'sanitize_hex_color',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'ubit_setting[page_header_title_color]',
		array(
			'label'    => esc_html__( 'Title Color', 'ubit' ),
			'section'  => 'ubit_page_header',
			'settings' => 'ubit_setting[page_header_title_color]',
		)
	)
);

// Breadcrumb text color.
$wp_customize->add_setting(
	'ubit_setting[page_header_breadcrumb_text_color]',
	array(
		'default'           => $defaults['page_header_breadcrumb_text_color'],
		'sanitize_callback' => 'sanitize_hex_color',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'ubit_setting[page_header_breadcrumb_text_color]',
		array(
			'label'    => esc_html__( 'Breadcrumb Color', 'ubit' ),
			'section'  => 'ubit_page_header',
			'settings' => 'ubit_setting[page_header_breadcrumb_text_color]',
		)
	)
);

// Background color.
$wp_customize->add_setting(
	'ubit_setting[page_header_background_color]',
	array(
		'default'           => $defaults['page_header_background_color'],
		'sanitize_callback' => 'sanitize_hex_color',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Ubit_Color_Control(
		$wp_customize,
		'ubit_setting[page_header_background_color]',
		array(
			'label'    => esc_html__( 'Background Color', 'ubit' ),
			'section'  => 'ubit_page_header',
			'settings' => 'ubit_setting[page_header_background_color]',
		)
	)
);

// Background image.
$wp_customize->add_setting(
	'ubit_setting[page_header_background_image]',
	array(
		'type'              => 'option',
		'default'           => $defaults['page_header_background_image'],
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new WP_Customize_Image_Control(
		$wp_customize,
		'ubit_setting[page_header_background_image]',
		array(
			'label'    => esc_html__( 'Background Image', 'ubit' ),
			'section'  => 'ubit_page_header',
			'settings' => 'ubit_setting[page_header_background_image]',
		)
	)
);

// Background image size.
$wp_customize->add_setting(
	'ubit_setting[page_header_background_image_size]',
	array(
		'default'           => $defaults['page_header_background_image_size'],
		'type'              => 'option',
		'sanitize_callback' => 'ubit_sanitize_choices',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[page_header_background_image_size]',
		array(
			'label'       => esc_html__( 'Background Size', 'ubit' ),
			'settings'    => 'ubit_setting[page_header_background_image_size]',
			'section'     => 'ubit_page_header',
			'type'        => 'select',
			'choices'     => array(
				'auto'    => esc_html__( 'Default', 'ubit' ),
				'cover'   => esc_html__( 'Cover', 'ubit' ),
				'contain' => esc_html__( 'Contain', 'ubit' ),
			),
		)
	)
);

// Background image repeat.
$wp_customize->add_setting(
	'ubit_setting[page_header_background_image_repeat]',
	array(
		'default'           => $defaults['page_header_background_image_repeat'],
		'type'              => 'option',
		'sanitize_callback' => 'ubit_sanitize_choices',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[page_header_background_image_repeat]',
		array(
			'label'       => esc_html__( 'Background Repeat', 'ubit' ),
			'settings'    => 'ubit_setting[page_header_background_image_repeat]',
			'section'     => 'ubit_page_header',
			'type'        => 'select',
			'choices'     => array(
				'repeat'    => esc_html__( 'Default', 'ubit' ),
				'no-repeat' => esc_html__( 'No Repeat', 'ubit' ),
				'repeat-x'  => esc_html__( 'Repeat X', 'ubit' ),
				'repeat-y'  => esc_html__( 'Repeat Y', 'ubit' ),
				'space'     => esc_html__( 'Space', 'ubit' ),
				'round'     => esc_html__( 'Round', 'ubit' ),
			),
		)
	)
);

// Background image position.
$wp_customize->add_setting(
	'ubit_setting[page_header_background_image_position]',
	array(
		'default'           => $defaults['page_header_background_image_position'],
		'type'              => 'option',
		'sanitize_callback' => 'ubit_sanitize_choices',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[page_header_background_image_position]',
		array(
			'label'       => esc_html__( 'Background Position', 'ubit' ),
			'settings'    => 'ubit_setting[page_header_background_image_position]',
			'section'     => 'ubit_page_header',
			'type'        => 'select',
			'choices'     => array(
				'left-top'      => esc_html__( 'Left Top', 'ubit' ),
				'left-center'   => esc_html__( 'Left Center', 'ubit' ),
				'left-bottom'   => esc_html__( 'Left Bottom', 'ubit' ),
				'center-top'    => esc_html__( 'Center Top', 'ubit' ),
				'center-center' => esc_html__( 'Center Center', 'ubit' ),
				'center-bottom' => esc_html__( 'Center Bottom', 'ubit' ),
				'right-top'     => esc_html__( 'Right Top', 'ubit' ),
				'right-center'  => esc_html__( 'Right Center', 'ubit' ),
				'right-bottom'  => esc_html__( 'Right Bottom', 'ubit' ),
			),
		)
	)
);

// Background image attachment.
$wp_customize->add_setting(
	'ubit_setting[page_header_background_image_attachment]',
	array(
		'default'           => $defaults['page_header_background_image_attachment'],
		'type'              => 'option',
		'sanitize_callback' => 'ubit_sanitize_choices',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[page_header_background_image_attachment]',
		array(
			'label'       => esc_html__( 'Background Attachment', 'ubit' ),
			'settings'    => 'ubit_setting[page_header_background_image_attachment]',
			'section'     => 'ubit_page_header',
			'type'        => 'select',
			'choices'     => array(
				'scroll' => esc_html__( 'Default', 'ubit' ),
				'fixed'  => esc_html__( 'Fixed', 'ubit' ),
				'local'  => esc_html__( 'Local', 'ubit' ),
			),
		)
	)
);

// Padding divider.
$wp_customize->add_setting(
	'page_header_spacing_divider',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Ubit_Divider_Control(
		$wp_customize,
		'page_header_spacing_divider',
		array(
			'section'  => 'ubit_page_header',
			'settings' => 'page_header_spacing_divider',
			'type'     => 'divider',
		)
	)
);

// Padding top.
$wp_customize->add_setting(
	'ubit_setting[page_header_padding_top]',
	array(
		'default'           => $defaults['page_header_padding_top'],
		'sanitize_callback' => 'absint',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Ubit_Range_Slider_Control(
		$wp_customize,
		'ubit_setting[page_header_padding_top]',
		array(
			'label'    => esc_html__( 'Padding Top', 'ubit' ),
			'section'  => 'ubit_page_header',
			'settings' => array(
				'desktop' => 'ubit_setting[page_header_padding_top]',
			),
			'choices' => array(
				'desktop' => array(
					'min'  => apply_filters( 'ubit_page_header_padding_top_min_step', 0 ),
					'max'  => apply_filters( 'ubit_page_header_padding_top_max_step', 200 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
			),
		)
	)
);

// Padding bottom.
$wp_customize->add_setting(
	'ubit_setting[page_header_padding_bottom]',
	array(
		'default'           => $defaults['page_header_padding_bottom'],
		'sanitize_callback' => 'absint',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Ubit_Range_Slider_Control(
		$wp_customize,
		'ubit_setting[page_header_padding_bottom]',
		array(
			'label'    => esc_html__( 'Padding Bottom', 'ubit' ),
			'section'  => 'ubit_page_header',
			'settings' => array(
				'desktop' => 'ubit_setting[page_header_padding_bottom]',
			),
			'choices' => array(
				'desktop' => array(
					'min'  => apply_filters( 'ubit_page_header_padding_bottom_min_step', 0 ),
					'max'  => apply_filters( 'ubit_page_header_padding_bottom_max_step', 200 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
			),
		)
	)
);

// Margin bottom.
$wp_customize->add_setting(
	'ubit_setting[page_header_margin_bottom]',
	array(
		'default'           => $defaults['page_header_margin_bottom'],
		'sanitize_callback' => 'absint',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);
$wp_customize->add_control(
	new Ubit_Range_Slider_Control(
		$wp_customize,
		'ubit_setting[page_header_margin_bottom]',
		array(
			'label'    => esc_html__( 'Margin Bottom', 'ubit' ),
			'section'  => 'ubit_page_header',
			'settings' => array(
				'desktop' => 'ubit_setting[page_header_margin_bottom]',
			),
			'choices' => array(
				'desktop' => array(
					'min'  => apply_filters( 'ubit_page_header_margin_bottom_min_step', 0 ),
					'max'  => apply_filters( 'ubit_page_header_margin_bottom_max_step', 200 ),
					'step' => 1,
					'edit' => true,
					'unit' => 'px',
				),
			),
		)
	)
);
