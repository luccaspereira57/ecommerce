/**
 * Ubit condition control
 *
 * @package ubit
 */

( function( api ) {
	'use strict';

	api.bind( 'ready', function() {

		/**
		 * Condition controls.
		 *
		 * @param string  id            Setting id.
		 * @param array   dependencies  Setting id dependencies.
		 * @param string  value         Setting value.
		 * @param array   parentvalue   Parent setting id and value.
		 * @param boolean operator      Operator.
		 */
		var condition = function( id, dependencies, value, operator ) {
			var value    = undefined !== arguments[2] ? arguments[2] : false,
				operator = undefined !== arguments[3] ? arguments[3] : false;

			api( id, function( setting ) {

				/**
				 * Update a control's active setting value.
				 *
				 * @param {api.Control} control
				 */
				var dependency = function( control ) {
					var visibility = function() {
						// wp.customize.control( parentValue[0] ).setting.get();.
						if ( operator ) {
							if ( value === setting.get() ) {
								control.container.show( 200 );
							} else {
								control.container.hide( 200 );
							}
						} else {
							if ( value === setting.get() ) {
								control.container.hide( 200 );
							} else {
								control.container.show( 200 );
							}
						}
					}

					// Set initial active state.
					visibility();

					// Update activate state whenever the setting is changed.
					setting.bind( visibility );
				};

				// Call dependency on the setting controls when they exist.
				for ( var i = 0, j = dependencies.length; i < j; i++ ) {
					api.control( dependencies[i], dependency );
				}
			} );
		}

		/**
		 * Condition controls.
		 *
		 * @param string  id            Setting id.
		 * @param array   dependencies  Setting id dependencies.
		 * @param string  value         Setting value.
		 * @param array   parentvalue   Parent setting id and value.
		 * @param boolean operator      Operator.
		 * @param array   arr           The parent setting value.
		 */
		var subCondition = function( id, dependencies, value, operator, arr ) {
			var value    = undefined !== arguments[2] ? arguments[2] : false,
				operator = undefined !== arguments[3] ? arguments[3] : false,
				arr      = undefined !== arguments[4] ? arguments[4] : false;

			api( id, function( setting ) {

				/**
				 * Update a control's active setting value.
				 *
				 * @param {api.Control} control
				 */
				var dependency = function( control ) {
					var visibility = function() {
						// arr[0] = control setting id.
						// arr[1] = control setting value.
						if ( ! arr || arr[1] !== wp.customize.control( arr[0] ).setting.get() ) {
							return;
						}

						if ( operator ) {
							if ( value === setting.get() ) {
								control.container.show( 200 );
							} else {
								control.container.hide( 200 );
							}
						} else {
							if ( value === setting.get() ) {
								control.container.hide( 200 );
							} else {
								control.container.show( 200 );
							}
						}
					}

					// Set initial active state.
					visibility();

					// Update activate state whenever the setting is changed.
					setting.bind( visibility );
				};

				// Call dependency on the setting controls when they exist.
				for ( var i = 0, j = dependencies.length; i < j; i++ ) {
					api.control( dependencies[i], dependency );
				}
			} );
		}

		// HEADER SECTION.
		// Search product only.
		condition(
			'ubit_setting[header_search_icon]',
			['ubit_setting[header_search_only_product]']
		);

		// Always show add to cart button.
		condition(
			'ubit_setting[product_style]',
			['ubit_setting[product_style_defaut_add_to_cart]'],
			'layout-1',
			true
		);

		// HEADER TRANSPARENT SECTION.
		// Enable transparent header.
		condition(
			'ubit_setting[header_transparent]',
			[
				'ubit_setting[header_transparent_disable_archive]',
				'ubit_setting[header_transparent_disable_index]',
				'ubit_setting[header_transparent_disable_page]',
				'ubit_setting[header_transparent_disable_post]',
				'ubit_setting[header_transparent_disable_shop]',
				'ubit_setting[header_transparent_disable_product]',
				'ubit_setting[header_transparent_enable_on]',
				'header_transparent_border_divider',
				'ubit_setting[header_transparent_border_width]',
				'ubit_setting[header_transparent_border_color]'
			]
		);

		// PAGE HEADER
		// Enable page header.
		condition(
			'ubit_setting[page_header_display]',
			[
				'ubit_setting[page_header_breadcrumb]',
				'ubit_setting[page_header_text_align]',
				'ubit_setting[page_header_title_color]',
				'ubit_setting[page_header_background_color]',
				'ubit_setting[page_header_background_image]',
				'ubit_setting[page_header_background_image_size]',
				'ubit_setting[page_header_background_image_position]',
				'ubit_setting[page_header_background_image_repeat]',
				'ubit_setting[page_header_background_image_attachment]',
				'page_header_breadcrumb_divider',
				'page_header_title_color_divider',
				'page_header_spacing_divider',
				'ubit_setting[page_header_breadcrumb_text_color]',
				'ubit_setting[page_header_padding_top]',
				'ubit_setting[page_header_padding_bottom]',
				'ubit_setting[page_header_margin_bottom]'
			]
		);

		// Background image.
		subCondition(
			'ubit_setting[page_header_background_image]',
			[
				'ubit_setting[page_header_background_image_size]',
				'ubit_setting[page_header_background_image_position]',
				'ubit_setting[page_header_background_image_repeat]',
				'ubit_setting[page_header_background_image_attachment]'
			],
			'',
			false,
			[
				'ubit_setting[page_header_display]',
				true
			]
		);
		// And trigger if parent control update.
		wp.customize( 'ubit_setting[page_header_display]', function( value ) {
			value.bind( function( newval ) {
				if ( newval ) {
					subCondition(
						'ubit_setting[page_header_background_image]',
						[
							'ubit_setting[page_header_background_image_size]',
							'ubit_setting[page_header_background_image_position]',
							'ubit_setting[page_header_background_image_repeat]',
							'ubit_setting[page_header_background_image_attachment]'
						],
						'',
						false,
						[
							'ubit_setting[page_header_display]',
							true
						]
					);
				}
			} );
		} );

		// FOOTER SECTION.
		// Disable footer.
		condition(
			'ubit_setting[footer_display]',
			[
				'ubit_setting[footer_space]',
				'ubit_setting[footer_column]',
				'ubit_setting[footer_background_color]',
				'ubit_setting[footer_heading_color]',
				'ubit_setting[footer_link_color]',
				'ubit_setting[footer_text_color]',
				'ubit_setting[footer_custom_text]',
				'footer_text_divider',
				'footer_background_color_divider'
			]
		);

	} );

}( wp.customize ) );
