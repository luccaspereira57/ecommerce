<?php
/**
 * The sidebar containing the shop page widget area.
 *
 * @package ubit
 */

if ( is_active_sidebar( 'sidebar-shop' ) ) {
	?>
	<div id="secondary" class="widget-area shop-widget" role="complementary">
		<?php dynamic_sidebar( 'sidebar-shop' ); ?>
	</div>
	<?php
}
