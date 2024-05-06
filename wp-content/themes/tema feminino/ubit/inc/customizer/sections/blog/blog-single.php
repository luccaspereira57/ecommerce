<?php
/**
 * Blog single customizer
 *
 * @package ubit
 */

// Default values.
$defaults = ubit_options();

// Blog single structure title.
$wp_customize->add_setting(
	'blog_single_structure_title',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Ubit_Divider_Control(
		$wp_customize,
		'blog_single_structure_title',
		array(
			'section'  => 'ubit_blog_single',
			'settings' => 'blog_single_structure_title',
			'type'     => 'heading',
			'label'    => esc_html__( 'Blog Single Structure', 'ubit' ),
		)
	)
);

// Post feature image.
$wp_customize->add_setting(
	'ubit_setting[blog_single_feature_image]',
	array(
		'type'              => 'option',
		'default'           => $defaults['blog_single_feature_image'],
		'sanitize_callback' => 'ubit_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[blog_single_feature_image]',
		array(
			'type'     => 'checkbox',
			'label'    => esc_html__( 'Featured Image', 'ubit' ),
			'section'  => 'ubit_blog_single',
			'settings' => 'ubit_setting[blog_single_feature_image]',
		)
	)
);

// Post title.
$wp_customize->add_setting(
	'ubit_setting[blog_single_title]',
	array(
		'type'              => 'option',
		'default'           => $defaults['blog_single_title'],
		'sanitize_callback' => 'ubit_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[blog_single_title]',
		array(
			'type'     => 'checkbox',
			'label'    => esc_html__( 'Post Title', 'ubit' ),
			'section'  => 'ubit_blog_single',
			'settings' => 'ubit_setting[blog_single_title]',
		)
	)
);

// Author box.
$wp_customize->add_setting(
	'ubit_setting[blog_single_author_box]',
	array(
		'type'              => 'option',
		'default'           => $defaults['blog_single_author_box'],
		'sanitize_callback' => 'ubit_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[blog_single_author_box]',
		array(
			'type'     => 'checkbox',
			'label'    => esc_html__( 'Author Box', 'ubit' ),
			'section'  => 'ubit_blog_single',
			'settings' => 'ubit_setting[blog_single_author_box]',
		)
	)
);

// Related post.
$wp_customize->add_setting(
	'ubit_setting[blog_single_related_post]',
	array(
		'type'              => 'option',
		'default'           => $defaults['blog_single_related_post'],
		'sanitize_callback' => 'ubit_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[blog_single_related_post]',
		array(
			'type'     => 'checkbox',
			'label'    => esc_html__( 'Related Post', 'ubit' ),
			'section'  => 'ubit_blog_single',
			'settings' => 'ubit_setting[blog_single_related_post]',
		)
	)
);

// Blog single post meta title.
$wp_customize->add_setting(
	'blog_single_post_meta_title',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Ubit_Divider_Control(
		$wp_customize,
		'blog_single_post_meta_title',
		array(
			'section'  => 'ubit_blog_single',
			'settings' => 'blog_single_post_meta_title',
			'type'     => 'heading',
			'label'    => esc_html__( 'Blog Post Meta', 'ubit' ),
		)
	)
);

// Publish date.
$wp_customize->add_setting(
	'ubit_setting[blog_single_publish_date]',
	array(
		'type'              => 'option',
		'default'           => $defaults['blog_single_publish_date'],
		'sanitize_callback' => 'ubit_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[blog_single_publish_date]',
		array(
			'type'     => 'checkbox',
			'label'    => esc_html__( 'Publish Date', 'ubit' ),
			'section'  => 'ubit_blog_single',
			'settings' => 'ubit_setting[blog_single_publish_date]',
		)
	)
);

// Author.
$wp_customize->add_setting(
	'ubit_setting[blog_single_author]',
	array(
		'type'              => 'option',
		'default'           => $defaults['blog_single_author'],
		'sanitize_callback' => 'ubit_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[blog_single_author]',
		array(
			'type'     => 'checkbox',
			'label'    => esc_html__( 'Author', 'ubit' ),
			'section'  => 'ubit_blog_single',
			'settings' => 'ubit_setting[blog_single_author]',
		)
	)
);

// Category.
$wp_customize->add_setting(
	'ubit_setting[blog_single_category]',
	array(
		'type'              => 'option',
		'default'           => $defaults['blog_single_category'],
		'sanitize_callback' => 'ubit_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[blog_single_category]',
		array(
			'type'     => 'checkbox',
			'label'    => esc_html__( 'Category', 'ubit' ),
			'section'  => 'ubit_blog_single',
			'settings' => 'ubit_setting[blog_single_category]',
		)
	)
);

// Comment.
$wp_customize->add_setting(
	'ubit_setting[blog_single_comment]',
	array(
		'type'              => 'option',
		'default'           => $defaults['blog_single_comment'],
		'sanitize_callback' => 'ubit_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'ubit_setting[blog_single_comment]',
		array(
			'type'     => 'checkbox',
			'label'    => esc_html__( 'Comments', 'ubit' ),
			'section'  => 'ubit_blog_single',
			'settings' => 'ubit_setting[blog_single_comment]',
		)
	)
);
