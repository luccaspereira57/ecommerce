<?php
/**
 * WooCommerce shop single customizer
 *
 * @package ubit
 */

// Default values.
$defaults = ubit_options();

// Custom title.
$wp_customize->add_setting(
	'ubit_setting[error_404_title]',
	array(
		'default'           => $defaults['error_404_title'],
		'sanitize_callback' => 'sanitize_text_field',
		'type'              => 'option',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[error_404_title]',
		array(
			'label'    => esc_html__( 'Custom Title', 'ubit' ),
			'type'     => 'text',
			'section'  => 'ubit_error',
			'settings' => 'ubit_setting[error_404_title]',
		)
	)
);

// Custom text.
$wp_customize->add_setting(
	'ubit_setting[error_404_text]',
	array(
		'default'           => $defaults['error_404_text'],
		'sanitize_callback' => 'ubit_sanitize_raw_html',
		'type'              => 'option',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[error_404_text]',
		array(
			'label'    => esc_html__( 'Custom Text', 'ubit' ),
			'type'     => 'textarea',
			'section'  => 'ubit_error',
			'settings' => 'ubit_setting[error_404_text]',
		)
	)
);

// Background.
$wp_customize->add_setting(
	'ubit_setting[error_404_image]',
	array(
		'default'           => $defaults['error_404_image'],
		'type'              => 'option',
		'sanitize_callback' => 'esc_url_raw',
	)
);
$wp_customize->add_control(
	new WP_Customize_Image_Control(
		$wp_customize,
		'ubit_setting[error_404_image]',
		array(
			'label'    => esc_html__( 'Background', 'ubit' ),
			'section'  => 'ubit_error',
			'settings' => 'ubit_setting[error_404_image]',
		)
	)
);
