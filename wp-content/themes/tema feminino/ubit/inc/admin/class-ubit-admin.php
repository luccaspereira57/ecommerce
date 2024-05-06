<?php
/**
 * Ubit Admin Class
 *
 * @package ubit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Ubit_Admin' ) ) :
	/**
	 * The Ubit admin class
	 */
	class Ubit_Admin {

		/**
		 * Instance
		 *
		 * @var instance
		 */
		private static $instance;

		/**
		 *  Initiator
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Setup class.
		 */
		public function __construct() {
			add_action( 'admin_notices', array( $this, 'ubit_admin_notice' ) );
			add_action( 'wp_ajax_dismiss_admin_notice', array( $this, 'ubit_dismiss_admin_notice' ) );
			add_action( 'admin_menu', array( $this, 'ubit_welcome_register_menu' ), 1 );
			add_action( 'admin_enqueue_scripts', array( $this, 'ubit_welcome_static' ) );
			add_action( 'admin_body_class', array( $this, 'ubit_admin_classes' ) );
		}

		/**
		 * Required software versions check.
		 *
		 * @return array
		 */
		public function ubit_admin_required_software_versions_check() {
			global $wpdb, $wp_version;

			$software = array();

			if ( function_exists( 'phpversion' ) ) {
				$software[] = array(
					'name'		=> 'PHP',
					'installed'	=> phpversion(),
					'required'	=> UBIT_VERSION_REQUIRE_PHP,
					'outdated'	=> version_compare( phpversion(), UBIT_VERSION_REQUIRE_PHP, '<' ),
				);
			}

			if ( method_exists( $wpdb, 'db_version' ) ) {
				$software[] = array(
					'name'		=> 'MySQL',
					'installed'	=> $wpdb->db_version(),
					'required'	=> UBIT_VERSION_REQUIRE_MYSQL,
					'outdated'	=> version_compare( $wpdb->db_version(), UBIT_VERSION_REQUIRE_MYSQL, '<' ),
				);
			}

			if ( $wp_version ) {
				$software[] = array(
					'name'		=> 'WordPress',
					'installed'	=> $wp_version,
					'required'	=> UBIT_VERSION_REQUIRE_WORDPRESS,
					'outdated'	=> version_compare( $wp_version, UBIT_VERSION_REQUIRE_WORDPRESS, '<' ),
				);
			}

			if ( defined( 'WC_VERSION' ) ) {
				$software[] = array(
					'name'		=> 'WooCommerce',
					'installed'	=> WC_VERSION,
					'required'	=> UBIT_VERSION_REQUIRE_WOOCOMMERCE,
					'outdated'	=> version_compare( WC_VERSION, UBIT_VERSION_REQUIRE_WOOCOMMERCE, '<' ),
				);
			}

			return $software;
		}

		/**
		 * Admin body classes.
		 *
		 * @param array $classes Classes for the body element.
		 * @return array
		 */
		public function ubit_admin_classes( $classes ) {
			$classes .= version_compare( get_bloginfo( 'version' ), '5.0', '>=' ) ? 'gutenberg-version' : 'old-version';

			return $classes;
		}

		/**
		 * Add admin notice
		 */
		public function ubit_admin_notice() {
			if ( ! current_user_can( 'install_plugins' ) || ! current_user_can( 'activate_plugins' ) ) {
			  return;
			}

			$screen = get_current_screen();
			$required_software_versions_check = $this->ubit_admin_required_software_versions_check();
			$required_software_versions_outdated = array_filter( $required_software_versions_check, function( $v ) {
				return $v['outdated'] === true;
			});

			// For required software versions notice.
			if (
				$screen->id !== 'appearance_page_ubit-welcome'
				&&
				! empty( $required_software_versions_outdated )
				&&
				! get_user_meta( get_current_user_id(), 'ubit_print_required_software_versions_admin_notice_' . ubit_version(), true )
			) {
				?>
				<div class="ubit-admin-notice ubit-required-software-versions-notice notice notice-error is-dismissible" data-notice="<?php
					echo esc_attr( 'ubit_print_required_software_versions_admin_notice_' . ubit_version() );
				?>">
					<div class="ubit-notice-content">
						<div class="ubit-notice-text">
							<p>
								<strong>
									<?php esc_html_e( 'Oops! Seems like that your software is outdated...', 'ubit' ); ?>
								</strong>
							</p>
							<p>
								<?php
								echo implode( ' ', array(
									esc_html__( 'Ubit theme may not be compatible with an outdated software.', 'ubit' ),
									esc_html__( 'Please, update the outdated software which is listed below:', 'ubit' ),
								) );
								?>
							</p>
							<ul>
								<?php
								foreach ( $required_software_versions_outdated as $software_required ) {
									printf(
										wp_kses(
											/* translators: software - installed version X.X.X and required version Y.Y.Y */
											__( '<li>- <strong>%1$s:</strong> installed version - <code class="%2$s">%3$s</code>, required version - <code>%4$s+</code></li>', 'ubit' ),
											array(
												'li' => array(),
												'strong' => array(),
												'code' => array(
													'class' => array(),
												),
											)
										),
										sanitize_text_field( $software_required['name'] ),
										esc_attr( $software_required['outdated'] ? 'code-bg-red' : 'code-bg-green' ),
										sanitize_text_field( $software_required['installed'] ),
										sanitize_text_field( $software_required['required'] )
									);
								}
								?>
							</ul>
						</div>
					</div>
				</div>
				<?php
			}

			// For theme options notice.
			if ( $screen->id !== 'appearance_page_ubit-welcome' && ! get_option( 'ubit_print_option_box_admin_notice' ) ) {
				?>
				<div class="ubit-admin-notice ubit-options-notice notice notice-info is-dismissible" data-notice="ubit_print_option_box_admin_notice">
					<div class="ubit-notice-content">
						<div class="ubit-notice-img">
							<img src="<?php echo esc_url( UBIT_THEME_URI . 'assets/images/logo.png' ); ?>" alt="<?php esc_attr_e( 'Ubit', 'ubit' ); ?>">
						</div>
						<div class="ubit-notice-text">
							<div class="ubit-notice-heading"><?php esc_html_e( 'Thanks for installing Ubit theme!', 'ubit' ); ?></div>
							<p>
								<?php
								printf(
									wp_kses(
										/* translators: Theme options URL and options section name */
										__( 'To take all advantages of the theme please make sure to <a href="%1$s">%2$s</a> and visit <a href="%3$s">%4$s</a>.', 'ubit' ),
										array( 'a' => array( 'href' => array() ) )
									),
									esc_url( admin_url( 'themes.php?page=merlin' ) ),
									esc_html__( 'Run the Setup Wizard', 'ubit' ),
									esc_url( admin_url( 'themes.php?page=ubit-welcome' ) ),
									esc_html__( 'Ubit Options', 'ubit' )
								);
								?>
							</p>
              <p>
								<a href="<?php echo esc_url( admin_url( 'themes.php?page=merlin' ) ); ?>" class="ubit-button button button-primary"><?php esc_html_e( 'Run the Setup Wizard', 'ubit' ); ?></a>
								<a href="<?php echo esc_url( admin_url( 'themes.php?page=ubit-welcome' ) ); ?>" class="ubit-button button"><?php esc_html_e( 'Ubit Options', 'ubit' ); ?></a>
              </p>
						</div>
					</div>
				</div>
				<?php
			}
		}

		/**
		 * Dismiss admin notice
		 */
		public function ubit_dismiss_admin_notice() {
			// Nonce check.
			check_ajax_referer( 'ubit_dismiss_admin_notice', 'nonce' );

			// Bail if user can't edit theme options.
			if ( ! current_user_can( 'install_plugins' ) || ! current_user_can( 'activate_plugins' ) ) {
				wp_send_json_error();
			}

			$notice = isset( $_POST['notice'] ) ? sanitize_text_field( wp_unslash( $_POST['notice'] ) ) : '';

			if ( ! empty( $notice ) ) {
				if ( $notice == 'ubit_print_required_software_versions_admin_notice_' . ubit_version() ) {
					update_user_meta( get_current_user_id(), $notice, 'true' );
					wp_send_json_success();
				}

				if ( $notice == 'ubit_print_option_box_admin_notice' ) {
					update_option( $notice, 'true', true );
					wp_send_json_success();
				}
			}

			wp_send_json_error();
		}

		/**
		 * Load welcome screen script and css
		 */
		public function ubit_welcome_static() {
			// Dismiss admin notice.
			wp_enqueue_script(
				'ubit-dismiss-admin-notice',
				UBIT_THEME_URI . 'assets/js/admin/dismiss-admin-notice.js',
				[],
				ubit_version(),
				true
			);

			wp_localize_script(
				'ubit-dismiss-admin-notice',
				'ubit_dismiss_admin_notice',
				[
					'nonce' => wp_create_nonce( 'ubit_dismiss_admin_notice' ),
				]
			);

			// Welcome screen script.
			wp_enqueue_script(
				'ubit-welcome-screen',
				UBIT_THEME_URI . 'assets/js/admin/welcome.js',
				[],
				ubit_version(),
				true
			);

			// Welcome screen style.
			wp_enqueue_style(
				'ubit-welcome-screen',
				UBIT_THEME_URI . 'assets/css/admin/welcome-screen/welcome.css',
				[],
				ubit_version()
			);
		}

		/**
		 * Creates the dashboard page
		 *
		 * @see  add_theme_page()
		 */
		public function ubit_welcome_register_menu() {
			// Filter to remove Admin menu.
			$admin_menu = apply_filters( 'ubit_options_admin_menu', false );
			if ( true === $admin_menu ) {
				return;
			}

			$page = add_theme_page( esc_html__( 'Ubit Options', 'ubit' ), esc_html__( 'Ubit Options', 'ubit' ), 'activate_plugins', 'ubit-welcome', array( $this, 'ubit_welcome_screen' ) );
			add_action( 'admin_print_styles-' . $page, array( $this, 'ubit_welcome_static' ) );
		}

		/**
		 * Customizer settings link
		 */
		public function ubit_welcome_customizer_settings() {
			$customizer_settings = apply_filters(
				'ubit_panel_customizer_settings',
				array(
					'upload_logo' => array(
						'icon'     => 'dashicons dashicons-format-image',
						'name'     => esc_html__( 'Logo', 'ubit' ),
						'type'     => 'control',
						'setting'  => 'custom_logo',
						'required' => '',
					),
					'layout' => array(
						'icon'     => 'dashicons dashicons-layout',
						'name'     => esc_html__( 'Layout', 'ubit' ),
						'type'     => 'panel',
						'setting'  => 'ubit_layout',
						'required' => '',
					),
					'set_color' => array(
						'icon'     => 'dashicons dashicons-admin-appearance',
						'name'     => esc_html__( 'Colors', 'ubit' ),
						'type'     => 'section',
						'setting'  => 'ubit_color',
						'required' => '',
					),
					'button' => array(
						'icon'     => 'dashicons dashicons-admin-customizer',
						'name'     => esc_html__( 'Buttons', 'ubit' ),
						'type'     => 'section',
						'setting'  => 'ubit_buttons',
						'required' => '',
					),
					'typo' => array(
						'icon'     => 'dashicons dashicons-editor-paragraph',
						'name'     => esc_html__( 'Typography', 'ubit' ),
						'type'     => 'panel',
						'setting'  => 'ubit_typography',
						'required' => '',
					),
					'shop' => array(
						'icon'     => 'dashicons dashicons-cart',
						'name'     => esc_html__( 'Shop', 'ubit' ),
						'type'     => 'panel',
						'setting'  => 'woocommerce',
						'required' => 'woocommerce',
					),
				)
			);

			return $customizer_settings;
		}

		/**
		 * The welcome screen Header
		 */
		public function ubit_welcome_screen_header() {
			?>
				<section class="ubit-welcome-nav">
					<div class="ubit-welcome-container">
						<a class="ubit-welcome-theme-brand" href="<?php echo esc_url( UBIT_WEB_URI_MAIN ); ?>" target="_blank" rel="noopener noreferrer">
							<div class="ubit-welcome-theme-icon-container">
							  <img class="ubit-welcome-theme-icon" src="<?php echo esc_url( UBIT_THEME_URI . 'assets/images/logo.png' ); ?>" alt="<?php esc_attr_e( 'Ubit', 'ubit' ); ?>">
							</div>
							<span class="ubit-welcome-theme-title"><?php esc_html_e( 'Ubit', 'ubit' ); ?></span>
							<span class="ubit-welcome-theme-version"><?php echo ubit_version(); // WPCS: XSS ok. ?></span>
						</a>

						<ul class="ubit-welcome-nav_link">
              <li><a href="<?php echo esc_url( UBIT_WEB_URI_DOCS ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Documentation', 'ubit' ); ?></a></li>
              <li><a href="<?php echo esc_url( UBIT_WEB_URI_CHANGELOG ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Changelog', 'ubit' ); ?></a></li>
              <li><a href="<?php echo esc_url( UBIT_WEB_URI_SUPPORT ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Support', 'ubit' ); ?></a></li>
							<li><a href="<?php echo esc_url( get_admin_url() . 'customize.php' ); ?>" target="_blank" rel="noopener noreferrer"><strong><?php esc_html_e( 'Open Customizer', 'ubit' ); ?></strong></a></li>
						</ul>
					</div>
				</section>
			<?php
		}

		/**
		 * The welcome screen
		 */
		public function ubit_welcome_screen() {
			?>
			<div class="ubit-options-wrap admin-welcome-screen">

				<?php $this->ubit_welcome_screen_header(); ?>

				<div class="ubit-enhance">
					<div class="ubit-welcome-container">
						<div class="ubit-enhance-content">

							<div class="ubit-enhance__column ubit-bundle">
								<h3><?php esc_html_e( 'Quick Access to Customizer Settings', 'ubit' ); ?></h3>
								<div class="ubit-quick-setting-section">
									<ul class="wst-flex">
									<?php
									foreach ( $this->ubit_welcome_customizer_settings() as $key ) {
										$url = get_admin_url() . 'customize.php?autofocus[' . $key['type'] . ']=' . $key['setting'];

										$disabled = '';
										$title    = '';
										if ( '' !== $key['required'] && ! class_exists( $key['required'] ) ) {
											$disabled = 'disabled';

											/* translators: 1: Class name */
											$title = sprintf( esc_html__( '%s not activated.', 'ubit' ), ucfirst( $key['required'] ) );

											$url = '#';
										}
										?>

										<li class="link-to-customie-item <?php echo esc_attr( $disabled ); ?>" title="<?php echo esc_attr( $title ); ?>">
											<a class="wst-quick-setting-title wp-ui-text-highlight" href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer">
												<span class="<?php echo esc_attr( $key['icon'] ); ?>"></span>
												<?php echo esc_html( $key['name'] ); ?>
											</a>
										</li>

									<?php } ?>
									</ul>
								</div>
							</div>

							<?php
							$required_software_versions_check = $this->ubit_admin_required_software_versions_check();

							$required_software_versions_outdated = array_filter( $required_software_versions_check, function( $v ) {
								return $v['outdated'] === true;
							});
							?>
							<div class="ubit-enhance__column ubit-bundle">
								<h3><?php
								if ( ! empty( $required_software_versions_outdated ) > 0 ) {
									esc_html_e( 'Oops! Seems like that your software is outdated...', 'ubit' );
								}
								else {
									esc_html_e( 'Software Compatibility', 'ubit' );
								}
								?></h3>
								<div class="ubit-quick-setting-section">
									<p>
										<?php
										if ( ! empty( $required_software_versions_outdated ) > 0 ) {
											echo implode( ' ', array(
												esc_html__( 'Ubit theme may not be compatible with an outdated software.', 'ubit' ),
												esc_html__( 'Please, update the outdated software which is marked in red below:', 'ubit' ),
											) );
										}
										else {
											esc_html_e( 'Awesome! Your software is up-to-date.', 'ubit' );
										}
										?>
									</p>
									<ul>
										<?php
										foreach ( $required_software_versions_check as $software_required ) {
											printf(
												wp_kses(
													/* translators: software - installed version X.X.X and required version Y.Y.Y */
													__( '<li>- <strong>%1$s:</strong> installed version - <code class="%2$s">%3$s</code>, required version - <code>%4$s+</code></li>', 'ubit' ),
													array(
														'li' => array(),
														'strong' => array(),
														'code' => array(
															'class' => array(),
														),
													)
												),
												sanitize_text_field( $software_required['name'] ),
												esc_attr( $software_required['outdated'] ? 'code-bg-red' : 'code-bg-green' ),
												sanitize_text_field( $software_required['installed'] ),
												sanitize_text_field( $software_required['required'] )
											);
										}
										?>
									</ul>
								</div>
							</div>

							<?php do_action( 'ubit_panel_column' ); ?>
						</div>

						<div class="ubit-enhance-sidebar">
							<?php do_action( 'ubit_panel_sidebar' ); ?>

							<div class="ubit-enhance__column">
								<h3><?php esc_html_e( 'Setup Wizard', 'ubit' ); ?></h3>

								<div class="ubit-quick-setting-section">
									<p class="ubit-img-container">
									  <img src="<?php echo esc_url( UBIT_THEME_URI . 'assets/images/customizer/header/ubit-header-1.jpg' ); ?>" alt="<?php esc_attr_e( 'Ubit header style 1', 'ubit' ); ?>" class="ubit-setup-img-1">
									  <img src="<?php echo esc_url( UBIT_THEME_URI . 'assets/images/thumbnail-default.jpg' ); ?>" alt="<?php esc_attr_e( 'Ubit default thumbnail', 'ubit' ); ?>" class="ubit-setup-img-2">
									  <img src="<?php echo esc_url( UBIT_THEME_URI . 'assets/images/customizer/product-style/ubit-product-card-1.jpg' ); ?>" alt="<?php esc_attr_e( 'Ubit product card style 1', 'ubit' ); ?>" class="ubit-setup-img-3">
									</p>
									<p>
										<?php esc_html_e( 'Quickly and easily transform your shop appearance with Ubit ready-to-import demo sites.', 'ubit' ); ?>
									</p>
									<p>
										<span class="dashicons dashicons-warning"></span>
										<?php esc_html_e( 'Warning! If you will run the setup wizard again - it may overwrite your site content and other settings.', 'ubit' ); ?>
									</p>
									<p>
										<?php echo '<a href="' . esc_url( admin_url( 'themes.php?page=merlin' ) ) . '" class="ubit-button button button-primary">' . esc_html__( 'Run the Setup Wizard', 'ubit' ) . '</a>'; ?>
										<a href="#" class="ubit-button button ubit-read-more-button" data-read-more-id="ubit-read-more-setup-wizard-block"><?php esc_html_e( 'Read More', 'ubit' ); ?></a>
									</p>
									<div class="ubit-read-more-block" id="ubit-read-more-setup-wizard-block"">
										<?php
										global $tgmpa;

										if ( $tgmpa && $tgmpa->plugins && count( $tgmpa->plugins ) > 0 ) {
											$tgmpa_plugins_required = array_filter( $tgmpa->plugins, function( $v ) {
												return $v['required'] === true;
											});

											$tgmpa_plugins_optional = array_filter( $tgmpa->plugins, function( $v ) {
												return $v['required'] !== true;
											});

											if ( count( $tgmpa_plugins_required ) > 0 ) {
												$tgmpa_plugins_required = wp_list_pluck( $tgmpa_plugins_required, 'name' );
												$tgmpa_plugins_required = ubit_implode_comma_and( $tgmpa_plugins_required );

												echo '<p>';
												printf(
													/* translators: a list of plugins */
													esc_html__( 'The setup wizard will install a few required 3rd party plugins: %s.', 'ubit' ),
													$tgmpa_plugins_required
												);
												echo '</p>';
											}

											if ( count( $tgmpa_plugins_optional ) > 0 ) {
												$tgmpa_plugins_optional = wp_list_pluck( $tgmpa_plugins_optional, 'name' );
												$tgmpa_plugins_optional = ubit_implode_comma_and( $tgmpa_plugins_optional );

												echo '<p>';
												printf(
													/* translators: a list of plugins */
													esc_html__( 'It will also install some optional plugins: %s.', 'ubit' ),
													$tgmpa_plugins_optional
												);
												echo '</p>';
											}
										}
										?>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>

			</div>
			<?php
		}
	}

	Ubit_Admin::get_instance();

endif;
