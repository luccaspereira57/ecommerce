<?php
/**
 * The loop template file.
 *
 * Included on pages like index.php, archive.php and search.php to display a loop of posts
 * Learn more: https://codex.wordpress.org/The_Loop
 *
 * @package ubit
 */

while ( have_posts() ) :
	the_post();
	get_template_part( 'template-parts/content', get_post_format() );
endwhile;

/**
 * Functions hooked in to ubit_paging_nav action
 *
 * @hooked ubit_paging_nav - 10
 */
do_action( 'ubit_loop_after' );
