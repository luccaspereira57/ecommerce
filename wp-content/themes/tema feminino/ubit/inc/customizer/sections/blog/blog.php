<?php
/**
 * Blog customizer
 *
 * @package ubit
 */

// Default values.
$defaults = ubit_options();

// Blog layout.
$wp_customize->add_setting(
	'ubit_setting[blog_list_layout]',
	array(
		'sanitize_callback' => 'ubit_sanitize_choices',
		'default'           => $defaults['blog_list_layout'],
		'type'              => 'option',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[blog_list_layout]',
		array(
			'section'  => 'ubit_blog',
			'settings' => 'ubit_setting[blog_list_layout]',
			'type'     => 'select',
			'label'    => esc_html__( 'Blog Layout', 'ubit' ),
			'choices'  => apply_filters(
				'ubit_setting_blog_list_layout_choices',
				array(
					'list' => esc_html__( 'List', 'ubit' ),
					'grid' => esc_html__( 'Grid', 'ubit' ),
				)
			),
		)
	)
);

// Limit exerpt.
$wp_customize->add_setting(
	'ubit_setting[blog_list_limit_exerpt]',
	array(
		'sanitize_callback' => 'absint',
		'default'           => $defaults['blog_list_limit_exerpt'],
		'type'              => 'option',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[blog_list_limit_exerpt]',
		array(
			'section'  => 'ubit_blog',
			'settings' => 'ubit_setting[blog_list_limit_exerpt]',
			'type'     => 'number',
			'label'    => esc_html__( 'Limit Excerpt', 'ubit' ),
		)
	)
);

// End section one divider.
$wp_customize->add_setting(
	'blog_list_section_one_divider',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Ubit_Divider_Control(
		$wp_customize,
		'blog_list_section_one_divider',
		array(
			'section'  => 'ubit_blog',
			'settings' => 'blog_list_section_one_divider',
			'type'     => 'divider',
		)
	)
);

// Blog list structure title.
$wp_customize->add_setting(
	'blog_list_structure_title',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Ubit_Divider_Control(
		$wp_customize,
		'blog_list_structure_title',
		array(
			'section'  => 'ubit_blog',
			'settings' => 'blog_list_structure_title',
			'type'     => 'heading',
			'label'    => esc_html__( 'Blog List Structure', 'ubit' ),
		)
	)
);

// Post feature image.
$wp_customize->add_setting(
	'ubit_setting[blog_list_feature_image]',
	array(
		'type'              => 'option',
		'default'           => $defaults['blog_list_feature_image'],
		'sanitize_callback' => 'ubit_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[blog_list_feature_image]',
		array(
			'type'     => 'checkbox',
			'label'    => esc_html__( 'Featured Image', 'ubit' ),
			'section'  => 'ubit_blog',
			'settings' => 'ubit_setting[blog_list_feature_image]',
		)
	)
);

// Post title.
$wp_customize->add_setting(
	'ubit_setting[blog_list_title]',
	array(
		'type'              => 'option',
		'default'           => $defaults['blog_list_title'],
		'sanitize_callback' => 'ubit_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[blog_list_title]',
		array(
			'type'     => 'checkbox',
			'label'    => esc_html__( 'Post Title', 'ubit' ),
			'section'  => 'ubit_blog',
			'settings' => 'ubit_setting[blog_list_title]',
		)
	)
);

// Blog list meta title.
$wp_customize->add_setting(
	'blog_list_post_meta_title',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Ubit_Divider_Control(
		$wp_customize,
		'blog_list_post_meta_title',
		array(
			'section'  => 'ubit_blog',
			'settings' => 'blog_list_post_meta_title',
			'type'     => 'heading',
			'label'    => esc_html__( 'Blog Post Meta', 'ubit' ),
		)
	)
);

// Publish date.
$wp_customize->add_setting(
	'ubit_setting[blog_list_publish_date]',
	array(
		'type'              => 'option',
		'default'           => $defaults['blog_list_publish_date'],
		'sanitize_callback' => 'ubit_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[blog_list_publish_date]',
		array(
			'type'     => 'checkbox',
			'label'    => esc_html__( 'Publish Date', 'ubit' ),
			'section'  => 'ubit_blog',
			'settings' => 'ubit_setting[blog_list_publish_date]',
		)
	)
);

// Author.
$wp_customize->add_setting(
	'ubit_setting[blog_list_author]',
	array(
		'type'              => 'option',
		'default'           => $defaults['blog_list_author'],
		'sanitize_callback' => 'ubit_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[blog_list_author]',
		array(
			'type'     => 'checkbox',
			'label'    => esc_html__( 'Author', 'ubit' ),
			'section'  => 'ubit_blog',
			'settings' => 'ubit_setting[blog_list_author]',
		)
	)
);

// Category.
$wp_customize->add_setting(
	'ubit_setting[blog_list_category]',
	array(
		'type'              => 'option',
		'default'           => $defaults['blog_list_category'],
		'sanitize_callback' => 'ubit_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[blog_list_category]',
		array(
			'type'     => 'checkbox',
			'label'    => esc_html__( 'Category', 'ubit' ),
			'section'  => 'ubit_blog',
			'settings' => 'ubit_setting[blog_list_category]',
		)
	)
);

// Comment.
$wp_customize->add_setting(
	'ubit_setting[blog_list_comment]',
	array(
		'type'              => 'option',
		'default'           => $defaults['blog_list_comment'],
		'sanitize_callback' => 'ubit_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[blog_list_comment]',
		array(
			'type'     => 'checkbox',
			'label'    => esc_html__( 'Comments', 'ubit' ),
			'section'  => 'ubit_blog',
			'settings' => 'ubit_setting[blog_list_comment]',
		)
	)
);
