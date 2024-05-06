<?php
/**
 * Ubit Post Meta Box Class
 *
 * @package ubit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Meta Boxes setup
 */
if ( ! class_exists( 'Ubit_Meta_Boxes' ) ) {

	/**
	 * Meta Boxes setup
	 */
	class Ubit_Meta_Boxes {

		/**
		 * Instance
		 *
		 * @var $instance
		 */
		private static $instance;

		/**
		 * Meta Option
		 *
		 * @var $meta_option
		 */
		private static $meta_option;

		/**
		 * Initiator
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Constructor
		 */
		public function __construct() {
			add_action( 'load-post.php', array( $this, 'ubit_init_metabox' ) );
			add_action( 'load-post-new.php', array( $this, 'ubit_init_metabox' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'ubit_metabox_assets' ) );
		}

		/**
		 *  Init Metabox
		 */
		public function ubit_init_metabox() {

			add_action( 'add_meta_boxes', array( $this, 'ubit_setup_meta_box' ) ); // Design only.
			add_action( 'save_post', array( $this, 'ubit_save_meta_box' ) );

			/**
			 * Set metabox options
			 *
			 * @see http://php.net/manual/en/filter.filters.sanitize.php
			 */
			self::$meta_option = array(
				'site-container' => array(
					'default'  => 'default',
					'sanitize' => 'FILTER_DEFAULT',
				),
				'site-header-transparent' => array(
					'default'  => 'default',
					'sanitize' => 'FILTER_DEFAULT',
				),
				'site-page-header' => array(
					'default'  => 'default',
					'sanitize' => 'FILTER_DEFAULT',
				),
				'site-sidebar' => array(
					'default'  => 'default',
					'sanitize' => 'FILTER_DEFAULT',
				),
				'site-topbar' => array(
					'default'  => 'default',
					'sanitize' => 'FILTER_DEFAULT',
				),
				'site-header' => array(
					'default'  => 'default',
					'sanitize' => 'FILTER_DEFAULT',
				),
				'site-footer' => array(
					'default'  => 'default',
					'sanitize' => 'FILTER_DEFAULT',
				),
			);
		}


		/**
		 * Add script and style for meta boxs setting
		 */
		public function ubit_metabox_assets() {
			wp_enqueue_style(
				'ubit-metabox-setting',
				UBIT_THEME_URI . 'assets/css/admin/metabox.css',
				array(),
				ubit_version()
			);
		}

		/**
		 *  Setup Metabox
		 */
		public function ubit_setup_meta_box() {

			// Get all public posts.
			$post_types = apply_filters(
				'ubit_metabox_post_types',
				array( 'post', 'page' )
			);

			// Enable for all posts.
			foreach ( $post_types as $type ) {
				$metabox_name = ucwords( $type ) . ' ' . esc_html__( 'Settings', 'ubit' );

				add_meta_box( // Design only.
					'ubit_metabox_settings_general',           // Id.
					$metabox_name,                          // Title.
					array( $this, 'ubit_markup_meta_box' ),      // Callback.
					$type,                                  // Post_type.
					'side'                             // Context.
				);
			}
		}

		/**
		 * Get metabox options
		 */
		public static function ubit_get_meta_option() {
			return self::$meta_option;
		}

		/**
		 * Metabox Markup
		 *
		 * @param  object $post Post object.
		 * @return void
		 */
		public function ubit_markup_meta_box( $post ) {

			wp_nonce_field( basename( __FILE__ ), 'ubit_metabox_settings_general' );
			$stored = get_post_meta( $post->ID );

			// Set stored and override defaults.
			foreach ( $stored as $key => $value ) {
				self::$meta_option[ $key ]['default'] = isset( $stored[ $key ][0] ) ? $stored[ $key ][0] : '';
			}

			// Get defaults.
			$meta = self::ubit_get_meta_option();

			/**
			 * Get options
			 */
			$site_container          = isset( $meta['site-container']['default'] ) ? $meta['site-container']['default'] : 'default';
			$site_sidebar            = isset( $meta['site-sidebar']['default'] ) ? $meta['site-sidebar']['default'] : 'default';
			$site_header_transparent = isset( $meta['site-header-transparent']['default'] ) ? $meta['site-header-transparent']['default'] : 'default';
			$site_page_header        = isset( $meta['site-page-header']['default'] ) ? $meta['site-page-header']['default'] : 'default';

			$site_header             = isset( $meta['site-header']['default'] ) ? $meta['site-header']['default'] : 'default';
			$site_topbar             = isset( $meta['site-topbar']['default'] ) ? $meta['site-topbar']['default'] : 'default';
			$site_footer             = isset( $meta['site-footer']['default'] ) ? $meta['site-footer']['default'] : 'default';
			?>

			<div class="ubit-metabox-setting">
				<?php // Option: Container. ?>
				<div class="ubit-metabox-option">
					<div class="ubit-metabox-option-title">
						<span><?php esc_html_e( 'Container', 'ubit' ); ?>:</span>
					</div>

					<div class="ubit-metabox-option-content">
						<select name="site-container" id="site-container">
							<option value="default" <?php selected( $site_container, 'default' ); ?> >
								<?php esc_html_e( 'Customizer Setting', 'ubit' ); ?>
							</option>

							<option value="normal" <?php selected( $site_container, 'normal' ); ?> >
								<?php esc_html_e( 'Normal', 'ubit' ); ?>
							</option>

							<option value="boxed" <?php selected( $site_container, 'boxed' ); ?> >
								<?php esc_html_e( 'Boxed', 'ubit' ); ?>
							</option>

							<option value="full-width" <?php selected( $site_container, 'full-width' ); ?> >
								<?php esc_html_e( 'Full Width', 'ubit' ); ?>
							</option>
						</select>
					</div>
				</div>

				<?php // Option: Sidebar. ?>
				<div class="ubit-metabox-option">
					<div class="ubit-metabox-option-title">
						<span><?php esc_html_e( 'Sidebar', 'ubit' ); ?>:</span>
					</div>

					<div class="ubit-metabox-option-content">
						<select name="site-sidebar" id="site-sidebar">
							<option value="default" <?php selected( $site_sidebar, 'default' ); ?> >
								<?php esc_html_e( 'Customizer Setting', 'ubit' ); ?>
							</option>

							<option value="left" <?php selected( $site_sidebar, 'left' ); ?> >
								<?php esc_html_e( 'Left Sidebar', 'ubit' ); ?>
							</option>

							<option value="right" <?php selected( $site_sidebar, 'right' ); ?> >
								<?php esc_html_e( 'Right Sidebar', 'ubit' ); ?>
							</option>

							<option value="full" <?php selected( $site_sidebar, 'full' ); ?> >
									<?php esc_html_e( 'No Sidebar', 'ubit' ); ?>
							</option>
						</select>
					</div>
				</div>

				<?php // Option: Transparent Header. ?>
				<div class="ubit-metabox-option">
					<div class="ubit-metabox-option-title">
						<span><?php esc_html_e( 'Transparent Header', 'ubit' ); ?>:</span>
					</div>

					<div class="ubit-metabox-option-content">
						<select name="site-header-transparent" id="site-header-transparent">
							<option value="default" <?php selected( $site_header_transparent, 'default' ); ?> >
								<?php esc_html_e( 'Customizer Setting', 'ubit' ); ?>
							</option>

							<option value="enabled" <?php selected( $site_header_transparent, 'enabled' ); ?> >
								<?php esc_html_e( 'Enabled', 'ubit' ); ?>
							</option>

							<option value="disabled" <?php selected( $site_header_transparent, 'disabled' ); ?> >
								<?php esc_html_e( 'Disabled', 'ubit' ); ?>
							</option>
						</select>
					</div>
				</div>

				<?php // Option: Page Header. ?>
				<div class="ubit-metabox-option">
					<div class="ubit-metabox-option-title">
						<span><?php esc_html_e( 'Page Header', 'ubit' ); ?>:</span>
					</div>

					<div class="ubit-metabox-option-content">
						<select name="site-page-header" id="site-page-header">
							<option value="default" <?php selected( $site_page_header, 'default' ); ?> >
								<?php esc_html_e( 'Customizer Setting', 'ubit' ); ?>
							</option>

							<option value="enabled" <?php selected( $site_page_header, 'enabled' ); ?> >
								<?php esc_html_e( 'Enabled', 'ubit' ); ?>
							</option>

							<option value="disabled" <?php selected( $site_page_header, 'disabled' ); ?> >
								<?php esc_html_e( 'Disabled', 'ubit' ); ?>
							</option>
						</select>
					</div>
				</div>

				<?php // Option: Disable Sections - Primary Header, Title, Footer Widgets, Footer Bar. ?>
				<div class="ubit-metabox-option">
					<div class="ubit-metabox-option-title">
						<span><?php esc_html_e( 'Disable Sections', 'ubit' ); ?>:</span>
					</div>

					<div class="ubit-metabox-option-content">
						<div class="disable-section-meta">
							<div class="site-topbar-option-wrap">
								<label for="site-topbar">
									<input type="checkbox" id="site-topbar" name="site-topbar" value="disabled" <?php checked( $site_topbar, 'disabled' ); ?> />
									<?php esc_html_e( 'Disable Topbar', 'ubit' ); ?>
								</label>
							</div>

							<div class="site-header-option-wrap">
								<label for="site-header">
									<input type="checkbox" id="site-header" name="site-header" value="disabled" <?php checked( $site_header, 'disabled' ); ?> />
									<?php esc_html_e( 'Disable Header', 'ubit' ); ?>
								</label>
							</div>

							<div class="site-footer-option-wrap">
								<label for="site-footer">
									<input type="checkbox" id="site-footer" name="site-footer" value="disabled" <?php checked( $site_footer, 'disabled' ); ?> />
									<?php esc_html_e( 'Disable Footer', 'ubit' ); ?>
								</label>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
		}

		/**
		 * Metabox Save
		 *
		 * @param  number $post_id Post ID.
		 * @return void
		 */
		public function ubit_save_meta_box( $post_id ) {

			// Checks save status.
			$is_autosave    = wp_is_post_autosave( $post_id );
			$is_revision    = wp_is_post_revision( $post_id );
			$is_valid_nonce = ( isset( $_POST['ubit_metabox_settings_general'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ubit_metabox_settings_general'] ) ), basename( __FILE__ ) ) ) ? true : false;

			// Exits script depending on save status.
			if ( $is_autosave || $is_revision || ! $is_valid_nonce ) {
				return;
			}

			/**
			 * Get meta options
			 */
			$post_meta = self::ubit_get_meta_option();

			foreach ( $post_meta as $key => $data ) {

				// Sanitize values.
				$sanitize_filter = isset( $data['sanitize'] ) ? $data['sanitize'] : 'FILTER_DEFAULT';

				switch ( $sanitize_filter ) {

					case 'FILTER_SANITIZE_STRING':
							$meta_value = filter_input( INPUT_POST, $key, FILTER_SANITIZE_STRING );
						break;

					case 'FILTER_SANITIZE_URL':
							$meta_value = filter_input( INPUT_POST, $key, FILTER_SANITIZE_URL );
						break;

					case 'FILTER_SANITIZE_NUMBER_INT':
							$meta_value = filter_input( INPUT_POST, $key, FILTER_SANITIZE_NUMBER_INT );
						break;

					default:
							$meta_value = filter_input( INPUT_POST, $key, FILTER_DEFAULT );
						break;
				}

				// Store values.
				if ( $meta_value ) {
					update_post_meta( $post_id, $key, $meta_value );
				} else {
					delete_post_meta( $post_id, $key );
				}
			}

		}
	}

	/**
	 * Kicking this off by calling 'get_instance()' method
	 */
	Ubit_Meta_Boxes::get_instance();
}
