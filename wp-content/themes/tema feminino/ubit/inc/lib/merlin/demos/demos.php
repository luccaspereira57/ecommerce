<?php
/**
 * Define the demo import files (local files).
 *
 * You have to use the same filter as in above example,
 * but with a slightly different array keys: local_*.
 * The values have to be absolute paths (not URLs) to your import files.
 * To use local import files, that reside in your theme folder,
 * please use the below code.
 * Note: make sure your import files are readable!
 */
function merlin_local_import_files() {
	return array(
		array(
			'import_file_name'             => 'Fashion',
			'local_import_file'            => MERLIN_DIR . 'demos/demo-1/demo-content.xml',
			'local_import_widget_file'     => MERLIN_DIR . 'demos/demo-1/widgets.wie',
			'local_import_customizer_file' => MERLIN_DIR . 'demos/demo-1/customizer.dat',
			'local_import_ss3_slider_file' => array(
				MERLIN_DIR . 'demos/demo-1/slider.ss3',
				MERLIN_DIR . 'demos/demo-1/slider-2.ss3',
			),
			'import_preview_image_url'     => MERLIN_URI . 'demos/demo-1/demo-1.jpg',
			'import_notice'                => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'ubit' ),
			'preview_url'                  => UBIT_WEB_URI_DEMO,
			'homepage'                     => 'Home',
			'blog_page'                    => 'Blog',
			'topbar_menu'                  => 'Top Bar Menu',
			'primary_menu'                 => 'Primary Menu',
			'footer_menu'                  => 'Footer Menu',
		),
	);
}
add_filter( 'merlin_import_files', 'merlin_local_import_files' );
