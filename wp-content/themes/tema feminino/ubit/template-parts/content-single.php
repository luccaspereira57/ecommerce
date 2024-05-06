<?php
/**
 * Template used to display post content on single pages.
 *
 * @package ubit
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
	do_action( 'ubit_single_post_top' );

	/**
	 * Functions hooked into ubit_single_post add_action
	 *
	 * @hooked ubit_post_header          - 10
	 * @hooked ubit_post_meta            - 20
	 * @hooked ubit_post_content         - 30
	 */
	do_action( 'ubit_single_post' );

	do_action( 'ubit_single_post_bottom' );
	?>

</article><!-- #post-## -->
