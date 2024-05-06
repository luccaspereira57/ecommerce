<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package ubit
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	/**
	 * Functions hooked in to ubit_page add_action
	 *
	 * @hooked ubit_page_header  - 10
	 * @hooked ubit_page_content - 20
	 */
	do_action( 'ubit_page' );
	?>
</article><!-- #post-## -->
