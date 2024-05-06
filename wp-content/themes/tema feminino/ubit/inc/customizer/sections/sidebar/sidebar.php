<?php
/**
 * Sidebar customizer
 *
 * @package ubit
 */

// Default values.
$defaults = ubit_options();

// Default sidebar.
$wp_customize->add_setting(
	'ubit_setting[sidebar_default]',
	array(
		'default'           => $defaults['sidebar_default'],
		'sanitize_callback' => 'ubit_sanitize_choices',
		'type'              => 'option',
	)
);

$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[sidebar_default]',
		array(
			'label'    => esc_html__( 'Default', 'ubit' ),
			'section'  => 'ubit_sidebar',
			'settings' => 'ubit_setting[sidebar_default]',
			'type'     => 'select',
			'choices'  => apply_filters(
				'ubit_setting_sidebar_default_choices',
				array(
					'full'  => esc_html__( 'No sidebar', 'ubit' ),
					'left'  => esc_html__( 'Left sidebar', 'ubit' ),
					'right' => esc_html__( 'Right sidebar', 'ubit' ),
				)
			),
		)
	)
);

// Page sidebar.
$wp_customize->add_setting(
	'ubit_setting[sidebar_page]',
	array(
		'default'           => $defaults['sidebar_page'],
		'sanitize_callback' => 'ubit_sanitize_choices',
		'type'              => 'option',
	)
);

$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[sidebar_page]',
		array(
			'label'    => esc_html__( 'Page', 'ubit' ),
			'section'  => 'ubit_sidebar',
			'settings' => 'ubit_setting[sidebar_page]',
			'type'     => 'select',
			'choices'  => apply_filters(
				'ubit_setting_sidebar_page_choices',
				array(
					'default' => esc_html__( 'Default', 'ubit' ),
					'full'    => esc_html__( 'No sidebar', 'ubit' ),
					'left'    => esc_html__( 'Left sidebar', 'ubit' ),
					'right'   => esc_html__( 'Right sidebar', 'ubit' ),
				)
			),
		)
	)
);

// Blog sidebar divider.
$wp_customize->add_setting(
	'blog_sidebar_divider',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Ubit_Divider_Control(
		$wp_customize,
		'blog_sidebar_divider',
		array(
			'section'  => 'ubit_sidebar',
			'settings' => 'blog_sidebar_divider',
			'type'     => 'divider',
		)
	)
);

// Blog archive sidebar.
$wp_customize->add_setting(
	'ubit_setting[sidebar_blog]',
	array(
		'default'           => $defaults['sidebar_blog'],
		'sanitize_callback' => 'ubit_sanitize_choices',
		'type'              => 'option',
	)
);

$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[sidebar_blog]',
		array(
			'label'    => esc_html__( 'Blog List', 'ubit' ),
			'section'  => 'ubit_sidebar',
			'settings' => 'ubit_setting[sidebar_blog]',
			'type'     => 'select',
			'choices'  => apply_filters(
				'ubit_setting_sidebar_blog_choices',
				array(
					'default' => esc_html__( 'Default', 'ubit' ),
					'full'    => esc_html__( 'No sidebar', 'ubit' ),
					'left'    => esc_html__( 'Left sidebar', 'ubit' ),
					'right'   => esc_html__( 'Right sidebar', 'ubit' ),
				)
			),
		)
	)
);

// Blog single sidebar.
$wp_customize->add_setting(
	'ubit_setting[sidebar_blog_single]',
	array(
		'default'           => $defaults['sidebar_blog_single'],
		'sanitize_callback' => 'ubit_sanitize_choices',
		'type'              => 'option',
	)
);

$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[sidebar_blog_single]',
		array(
			'label'    => esc_html__( 'Blog Single', 'ubit' ),
			'section'  => 'ubit_sidebar',
			'settings' => 'ubit_setting[sidebar_blog_single]',
			'type'     => 'select',
			'choices'  => apply_filters(
				'ubit_setting_sidebar_blog_single_choices',
				array(
					'default' => esc_html__( 'Default', 'ubit' ),
					'full'    => esc_html__( 'No sidebar', 'ubit' ),
					'left'    => esc_html__( 'Left sidebar', 'ubit' ),
					'right'   => esc_html__( 'Right sidebar', 'ubit' ),
				)
			),
		)
	)
);

if ( class_exists( 'woocommerce' ) ) {
	// woocommerce divider.
	$wp_customize->add_setting(
		'woocommerce_sidebar_divider',
		array(
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		new Ubit_Divider_Control(
			$wp_customize,
			'woocommerce_sidebar_divider',
			array(
				'section'  => 'ubit_sidebar',
				'settings' => 'woocommerce_sidebar_divider',
				'type'     => 'divider',
			)
		)
	);

	// Shop page sidebar.
	$wp_customize->add_setting(
		'ubit_setting[sidebar_shop]',
		array(
			'default'           => $defaults['sidebar_shop'],
			'sanitize_callback' => 'ubit_sanitize_choices',
			'type'              => 'option',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'ubit_setting[sidebar_shop]',
			array(
				'label'    => esc_html__( 'Shop Page', 'ubit' ),
				'section'  => 'ubit_sidebar',
				'settings' => 'ubit_setting[sidebar_shop]',
				'type'     => 'select',
				'choices'  => apply_filters(
					'ubit_setting_sidebar_shop_choices',
					array(
						'default' => esc_html__( 'Default', 'ubit' ),
						'full'    => esc_html__( 'No sidebar', 'ubit' ),
						'left'    => esc_html__( 'Left sidebar', 'ubit' ),
						'right'   => esc_html__( 'Right sidebar', 'ubit' ),
					)
				),
			)
		)
	);

	// Product page sidebar.
	$wp_customize->add_setting(
		'ubit_setting[sidebar_shop_single]',
		array(
			'default'           => $defaults['sidebar_shop_single'],
			'sanitize_callback' => 'ubit_sanitize_choices',
			'type'              => 'option',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'ubit_setting[sidebar_shop_single]',
			array(
				'label'    => esc_html__( 'Shop Single', 'ubit' ),
				'section'  => 'ubit_sidebar',
				'settings' => 'ubit_setting[sidebar_shop_single]',
				'type'     => 'select',
				'choices'  => apply_filters(
					'ubit_setting_sidebar_shop_single_choices',
					array(
						'default' => esc_html__( 'Default', 'ubit' ),
						'full'    => esc_html__( 'No sidebar', 'ubit' ),
						'left'    => esc_html__( 'Left sidebar', 'ubit' ),
						'right'   => esc_html__( 'Right sidebar', 'ubit' ),
					)
				),
			)
		)
	);
}
