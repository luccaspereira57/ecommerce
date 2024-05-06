<?php
/**
 * The template for displaying search results pages.
 *
 * @package ubit
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php if ( have_posts() ) : ?>

			<?php
			get_template_part( 'template-parts/loop' );

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
do_action( 'ubit_sidebar' );
get_footer();
