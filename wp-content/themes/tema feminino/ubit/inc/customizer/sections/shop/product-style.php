<?php
/**
 * WooCommerce shop product style customizer
 *
 * @package ubit
 */

// Default values.
$defaults = ubit_options();

// Header layout.
$wp_customize->add_setting(
	'ubit_setting[product_style]',
	array(
		'default'           => $defaults['product_style'],
		'sanitize_callback' => 'ubit_sanitize_choices',
		'type'              => 'option',
	)
);
$wp_customize->add_control(
	new Ubit_Radio_Image_Control(
		$wp_customize,
		'ubit_setting[product_style]',
		array(
			'label'    => esc_html__( 'Layout', 'ubit' ),
			'section'  => 'ubit_product_style',
			'settings' => 'ubit_setting[product_style]',
			'priority' => 5,
			'choices'  => apply_filters(
				'ubit_setting_product_style_choices',
				array(
					'layout-1' => UBIT_THEME_URI . 'assets/images/customizer/product-style/ubit-product-card-1.jpg',
				)
			),
		)
	)
);

// Always show add to cart button.
$wp_customize->add_setting(
	'ubit_setting[product_style_defaut_add_to_cart]',
	array(
		'type'              => 'option',
		'default'           => $defaults['product_style_defaut_add_to_cart'],
		'sanitize_callback' => 'ubit_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[product_style_defaut_add_to_cart]',
		array(
			'type'     => 'checkbox',
			'label'    => esc_html__( 'Always Show Add To Cart', 'ubit' ),
			'section'  => 'ubit_product_style',
			'settings' => 'ubit_setting[product_style_defaut_add_to_cart]',
		)
	)
);
