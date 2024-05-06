<?php
/**
 * Template used to display post content.
 *
 * @package ubit
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
		/**
		 * Functions hooked in to ubit_loop_post action.
		 *
		 * @hooked ubit_post_thumbnail - 5
		 * @hooked ubit_post_header    - 10
		 * @hooked ubit_post_meta      - 20
		 * @hooked ubit_post_content   - 30
		 */
		do_action( 'ubit_loop_post' );
	?>

</article>
