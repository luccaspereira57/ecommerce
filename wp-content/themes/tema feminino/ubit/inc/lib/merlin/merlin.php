<?php
/**
 * Merlin WP configuration file.
 *
 * The following code is a derivative work from:
 * Woostify Sites Library plugin by Woostify/BoostifyThemes/Haintheme from Woostify.com,
 * Merlin WP by Rich Tabor from ThemeBeans.com & the team at ProteusThemes.com,
 * Envato WordPress Theme Setup Wizard by David Baker.
 *
 * @package   Merlin WP
 * @version   unknown-older-gplv2+-based (based on version 1.0.5 of Woostify Sites Library plugin)
 * @link      https://merlinwp.com/
 * @author    Rich Tabor, from ThemeBeans.com & the team at ProteusThemes.com
 * @copyright Copyright (c) 2018, Merlin WP of Inventionn LLC
 * @license   GPLv2 or later
 */

/**
 * Set constants.
 */
if ( ! defined( 'MERLIN_VER' ) ) {
	define( 'MERLIN_VER', '1.0.5' );
}

if ( ! defined( 'MERLIN_DIR' ) ) {
	define( 'MERLIN_DIR', trailingslashit( get_template_directory() . '/inc/lib/merlin' ) );
}

if ( ! defined( 'MERLIN_URI' ) ) {
	define( 'MERLIN_URI', trailingslashit( get_template_directory_uri() . '/inc/lib/merlin' ) );
}

require_once MERLIN_DIR . 'vendor/autoload.php';
require_once MERLIN_DIR . 'class-merlin.php';

/**
 * Set directory locations, text strings, and settings.
 */
$wizard = new Merlin(

	$config = array(
		'merlin_url'   => 'merlin', // The wp-admin page slug where Merlin WP loads.
		'parent_slug'          => 'themes.php', // The wp-admin parent page slug for the admin menu item.
		'capability'           => 'manage_options', // The capability required for this menu to be displayed to the user.
		'child_action_btn_url' => 'https://developer.wordpress.org/themes/advanced-topics/child-themes/', // URL for the 'child-action-link'.
		'dev_mode'             => true, // Enable development mode for testing.
		'license_step'         => false, // EDD license activation step.
		'license_required'     => false, // Require the license activation step.
		'license_help_url'     => '', // URL for the 'license-tooltip'.
		'edd_remote_api_url'   => '', // EDD_Theme_Updater_Admin remote_api_url.
		'edd_item_name'        => '', // EDD_Theme_Updater_Admin item_name.
		'edd_theme_slug'       => '', // EDD_Theme_Updater_Admin item_slug.
		'ready_big_button_url' => '', // Link for the big button on the ready step.
	),

	$strings = array(
		'admin-menu'               => esc_html__( 'Theme Setup Wizard', 'ubit' ),

		/* translators: 1: Title Tag 2: Theme Name 3: Closing Title Tag */
		'title%s%s%s%s'            => esc_html__( '%1$s%2$s Themes &lsaquo; Theme Setup: %3$s%4$s', 'ubit' ),
		'return-to-dashboard'      => esc_html__( 'Return to the dashboard', 'ubit' ),
		'ignore'                   => esc_html__( 'Disable this wizard', 'ubit' ),

		'btn-skip'                 => esc_html__( 'Skip', 'ubit' ),
		'btn-next'                 => esc_html__( 'Next', 'ubit' ),
		'btn-start'                => esc_html__( 'Start', 'ubit' ),
		'btn-no'                   => esc_html__( 'Cancel', 'ubit' ),
		'btn-plugins-install'      => esc_html__( 'Install', 'ubit' ),
		'btn-child-install'        => esc_html__( 'Install', 'ubit' ),
		'btn-content-install'      => esc_html__( 'Install', 'ubit' ),
		'btn-import'               => esc_html__( 'Start Import', 'ubit' ),
		'btn-license-activate'     => esc_html__( 'Activate', 'ubit' ),
		'btn-license-skip'         => esc_html__( 'Later', 'ubit' ),

		/* translators: Theme Name */
		'license-header%s'         => esc_html__( 'Activate %s', 'ubit' ),
		/* translators: Theme Name */
		'license-header-success%s' => esc_html__( '%s is Activated', 'ubit' ),
		/* translators: Theme Name */
		'license%s'                => esc_html__( 'Enter your license key to enable remote updates and theme support.', 'ubit' ),
		'license-label'            => esc_html__( 'License key', 'ubit' ),
		'license-success%s'        => esc_html__( 'The theme is already registered, so you can go to the next step!', 'ubit' ),
		'license-json-success%s'   => esc_html__( 'Your theme is activated! Remote updates and theme support are enabled.', 'ubit' ),
		'license-tooltip'          => esc_html__( 'Need help?', 'ubit' ),

		/* translators: Theme Name */
		'welcome-header%s'         => esc_html__( 'Welcome to %s', 'ubit' ),
		'welcome-header-success%s' => esc_html__( 'Hi. Welcome back', 'ubit' ),
		'welcome%s'                => esc_html__( 'This wizard will set up your theme, install plugins, and import content. It is optional & should take only a few minutes.', 'ubit' ),
		'welcome-success%s'        => esc_html__( 'You may have already run this theme setup wizard. If you would like to proceed anyway, click on the "Start" button below.', 'ubit' ),

		'child-header'             => esc_html__( 'Install Child Theme', 'ubit' ),
		'child-header-success'     => esc_html__( 'You\'re good to go!', 'ubit' ),
		'child'                    => esc_html__( 'Let\'s build & activate a child theme so you may easily make theme changes.', 'ubit' ),
		'child-success%s'          => esc_html__( 'Your child theme has already been installed and is now activated, if it wasn\'t already.', 'ubit' ),
		'child-action-link'        => esc_html__( 'Learn about child themes', 'ubit' ),
		'child-json-success%s'     => esc_html__( 'Awesome. Your child theme has already been installed and is now activated.', 'ubit' ),
		'child-json-already%s'     => esc_html__( 'Awesome. Your child theme has been created and is now activated.', 'ubit' ),

		'plugins-header'           => esc_html__( 'Install Plugins', 'ubit' ),
		'plugins-header-success'   => esc_html__( 'You\'re up to speed!', 'ubit' ),
		'plugins'                  => esc_html__( 'Let\'s install some essential WordPress plugins to get your site up to speed.', 'ubit' ),
		'plugins-success%s'        => esc_html__( 'The required WordPress plugins are all installed and up to date. Press "Next" to continue the setup wizard.', 'ubit' ),
		'plugins-action-link'      => esc_html__( 'Advanced', 'ubit' ),

		'import-header'            => esc_html__( 'Import Content', 'ubit' ),
		'import'                   => esc_html__( 'Let\'s import content to your website, to help you get familiar with the theme.', 'ubit' ),
		'import-action-link'       => esc_html__( 'Advanced', 'ubit' ),

		'ready-header'             => esc_html__( 'All done. Have fun!', 'ubit' ),

		/* translators: Theme Author */
		'ready%s'                  => esc_html__( 'Your theme has been all set up. Enjoy your new theme!.', 'ubit' ),
		'ready-action-link'        => esc_html__( 'Extras', 'ubit' ),
		'ready-big-button'         => esc_html__( 'View your website', 'ubit' ),
		'ready-link-1'             => sprintf( '<a href="%1$s" target="_blank">%2$s</a>', esc_url( UBIT_WEB_URI_MAIN ), esc_html__( 'Explore The Theme', 'ubit' ) ),
		'ready-link-2'             => sprintf( '<a href="%1$s" target="_blank">%2$s</a>', esc_url( UBIT_WEB_URI_SUPPORT ), esc_html__( 'Get Theme Support', 'ubit' ) ),
		'ready-link-3'             => sprintf( '<a href="%1$s">%2$s</a>', admin_url( 'customize.php' ), esc_html__( 'Start Customizing', 'ubit' ) ),
	)
);

require_once MERLIN_DIR . 'demos/demos.php';
