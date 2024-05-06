<?php
/**
 * 404 template
 *
 * @package ubit
 */

$options = ubit_options( false );
?>

<div class="error-404-text has-ubit-heading-color text-center">
	<?php
	echo '<h1>' . esc_html( $options['error_404_title'] ) . '</h1>';

	echo wpautop( wp_kses_post( $options['error_404_text'] ) );

	do_action( 'ubit_theme_404_container' );
	?>
</div>
