<?php
/**
 * The header for our theme.
 *
 * @package ubit
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php
		do_action( 'ubit_head' );
		wp_head();
	?>
</head>

<body <?php body_class(); ?>>
	<?php
	wp_body_open();

	/**
	 * Functions hooked in to ubit_theme_header
	 *
	 * @hooked ubit_theme_print_elementor_header  - 10
	 * @hooked ubit_content_page_start      			 - 100
	 * @hooked ubit_dialog_search       					 - 110
	 */
	do_action( 'ubit_theme_header' );
