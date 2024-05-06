<?php
/**
 * Elementor Library Single
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
		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>
		<?php
		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();

				the_content();
			}
		}

		wp_footer();
		?>
	</body>
</html>
