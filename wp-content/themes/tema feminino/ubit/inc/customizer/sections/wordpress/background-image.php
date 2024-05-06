<?php
/**
 * Site Title & Tagline
 *
 * @package ubit
 */

// Default values.
$defaults = ubit_options();

// Default contailer.
$wp_customize->add_setting(
	'ubit_setting[default_container]',
	array(
		'type'              => 'option',
		'default'           => $defaults['default_container'],
		'sanitize_callback' => 'ubit_sanitize_choices',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[default_container]',
		array(
			'label'    => esc_html__( 'Default Container', 'ubit' ),
			'section'  => 'background_image',
			'type'     => 'select',
			'settings' => 'ubit_setting[default_container]',
			'priority' => 8,
			'choices' => apply_filters(
				'ubit_setting_default_container',
				array(
					'normal'     => esc_html__( 'Normal', 'ubit' ),
					'full-width' => esc_html__( 'Full Width', 'ubit' ),
					'boxed'      => esc_html__( 'Boxed', 'ubit' ),
				)
			),
		)
	)
);
