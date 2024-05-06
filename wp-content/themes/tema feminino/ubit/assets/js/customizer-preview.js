/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @package ubit
 */

'use strict';

// Remove class with prefix.
jQuery.fn.removeClassPrefix = function ( prefix ) {
	this.each( function ( i, it ) {
		var classes = it.className.split( ' ' ).map( function ( item ) {
			var j = 0 === item.indexOf( prefix ) ? '' : item;
			return j;
		});

		it.className = classes.join( ' ' );
	});

	return this;
};

// Colors.
function ubit_colors_live_update( id, selector, property, default_value ) {
	default_value = 'undefined' !== typeof default_value ? default_value : 'initial';

	wp.customize( 'ubit_setting[' + id + ']', function( value ) {
		value.bind( function( newval ) {
			newval = ( '' !== newval ) ? newval : default_value;

			if ( jQuery( 'style#' + id ).length ) {
				jQuery( 'style#' + id ).html( selector + '{' + property + ':' + newval + ';}' );
			} else {
				jQuery( 'head' ).append( '<style id="' + id + '">' + selector + '{' + property + ':' + newval + '}</style>' );

				setTimeout( function() {
					jQuery( 'style#' + id ).not( ':last' ).remove();
				}, 1000 );
			}
		} );
	} );
}

// Units.
function ubit_unit_live_update( id, selector, property, default_value, unit, default_unit ) {
	// Default parameters.
	unit         = 'undefined' !== typeof unit ? unit : 'px';
	default_unit = 'undefined' !== typeof default_unit ? default_unit : 'px';

	// WordPress customize.
	wp.customize( 'ubit_setting[' + id + ']', function( value ) {
		value.bind( function( newval ) {

			// Sometime `unit` and `default_unit` are not use.
			if ( false == unit ) {
				unit = '';
			}

			if ( false == default_unit ) {
				default_unit = '';
			}

			// Get style.
			var data = ! newval ? '' : selector + '{ ' + property + ': ' + newval + unit + '}';

			// Default value.
			if ( ! newval && 'undefined' !== typeof default_value && '' != default_value ) {
				data = selector + '{ ' + property + ': ' + default_value + default_unit + '}';
			}

			// Append style.
			if ( jQuery( 'style#' + id ).length ) {
				jQuery( 'style#' + id ).html( data );
			} else {
				jQuery( 'head' ).append( '<style id="' + id + '">' + data + ' }</style>' );

				setTimeout( function() {
					jQuery( 'style#' + id ).not( ':last' ).remove();
				}, 100 );
			}
		} );
	} );
}

// Append data.
function ubit_append_data( id, selector, property ) {
	wp.customize( 'ubit_setting[' + id + ']', function( value ) {
		value.bind( function( newval ) {
			jQuery( 'head' ).append( '<style id="' + id + '">' + selector + '{' + property + ':' + newval + ';}</style>' );

			setTimeout( function() {
				jQuery( 'style#' + id ).not( ':last' ).remove();
			}, 100 );
		} );
	} );
}

// Html.
function ubit_html_live_update( id, selector, fullId ) {
	var fullId  = ( arguments.length > 0 && undefined !== arguments[2] ) ? arguments[2] : false,
		setting = 'ubit_setting[' + id + ']';

	if ( fullId ) {
		setting = id;
	}

	wp.customize( setting, function( value ) {
		value.bind( function( newval ) {
			var element = document.querySelector( selector );
			if ( element ) {
				element.innerHTML = newval;
			}
		} );
	} );
}

// Hidden product meta.
function ubit_hidden_product_meta( id, selector ) {
	wp.customize( 'ubit_setting[' + id + ']', function( value ) {
		value.bind( function( newval ) {
			if ( false === newval ) {
				document.body.classList.add( selector );
			} else {
				document.body.classList.remove( selector );
			}
		} );
	} );
}

// Update body class.
function ubit_update_element_class( id, selector, prefix ) {
	wp.customize( 'ubit_setting[' + id + ']', function( value ) {
		value.bind( function( newval ) {
			jQuery( selector ).removeClassPrefix( prefix ).addClass( prefix + newval );
		} );
	} );
}

/**
 * Upload background image.
 *
 * @param      string  id  The setting id
 * @param      string  dependencies  The dependencies with background image.
 * Must follow: Size -> Repeat -> Position -> Attachment.
 * @param      string  selector      The css selector
 */
function ubit_background_image_live_upload( id, dependencies, selector ) {
	var dep     = ( arguments.length > 0 && undefined !== arguments[1] ) ? arguments[1] : false,
		element = document.querySelector( selector );

	if ( ! element ) {
		return;
	}

	wp.customize( 'ubit_setting[' + id + ']', function( value ) {
		value.bind( function( newval ) {
			if ( newval ) {
				element.style.backgroundImage = 'url(' + newval + ')';
			} else {
				element.style.backgroundImage = 'none';
			}
		} );
	} );

	if ( dep ) {
		dep.forEach( function( el, i ) {
			wp.customize( 'ubit_setting[' + el + ']', function( value ) {
				value.bind( function( newval ) {
					if ( 0 == i ) {
						// Set background size.
						element.style.backgroundSize = newval;
					} else if ( 1 == i ) {
						// Set background repeat.
						element.style.backgroundRepeat = newval;
					} else if ( 2 == i ) {
						// Set background position.
						element.style.backgroundPosition = newval.replace( '-', ' ' );
					} else {
						// Set background attachment.
						element.style.backgroundAttachment = newval;
					}
				} );
			} );
		} );
	}
}

/**
 * Multi device slider update
 *
 * @param      array   array     The Array of settings id. Follow Desktop -> Tablet -> Mobile
 * @param      string  selector  The selector: css selector
 * @param      string  property  The property: background-color, display...
 * @param      string  unit      The css unit: px, em, pt...
 */
function ubit_range_slider_update( arr, selector, property, unit ) {
	arr.forEach( function( el, i ) {

		wp.customize( 'ubit_setting[' + el + ']', function( value ) {
			value.bind( function( newval ) {

				var styles = '';
				if ( arr.length > 1 ) {
					if ( 0 == i ) {
						styles = '@media ( min-width: 769px ) { ' + selector + ' { ' + property + ': ' + newval + unit + ' } }';
					} else if ( 1 == i ) {
						styles = '@media ( min-width: 321px ) and ( max-width: 768px ) { ' + selector + ' { ' + property + ': ' + newval + unit + ' } }';
					} else {
						styles = '@media ( max-width: 320px ) { ' + selector + ' { ' + property + ': ' + newval + unit + ' } }';
					}
				} else {
					styles = selector + ' { ' + property + ': ' + newval + unit + ' }';
				}

				// Append style.
				if ( jQuery( 'style#ubit_setting-' + el ).length ) {
					jQuery( 'style#ubit_setting-' + el ).html( styles );
				} else {
					jQuery( 'head' ).append( '<style id="ubit_setting-' + el + '">' + styles + ' }</style>' );

					setTimeout( function() {
						jQuery( 'style#ubit_setting-' + el ).not( ':last' ).remove();
					}, 100 );
				}
			} );
		} );
	} );
}

( function( $ ) {
	// Refresh Preview when remove Custom Logo.
	wp.customize( 'custom_logo', function( value ) {
		value.bind( function( newval ) {
			if ( ! newval ) {
				wp.customize.preview.send( 'refresh' );
			}
		} );
	} );

	// Update the site title in real time...
	ubit_html_live_update( 'blogname', '.site-title.beta a', true );

	// Update the site description in real time...
	ubit_html_live_update( 'blogdescription', '.site-description', true );

	// Topbar.
	ubit_colors_live_update( 'topbar_text_color', '.topbar *', 'color' );
	ubit_colors_live_update( 'topbar_background_color', '.topbar', 'background-color' );
	ubit_range_slider_update( ['topbar_space'], '.topbar', 'padding', 'px 0' );
	ubit_html_live_update( 'topbar_left', '.topbar .topbar-left' );
	ubit_html_live_update( 'topbar_center', '.topbar .topbar-center' );
	ubit_html_live_update( 'topbar_right', '.topbar .topbar-right' );

	// HEADER.
	// Header background.
	ubit_colors_live_update( 'header_background_color', '.site-header-inner', 'background-color' );
	// Header transparent: border bottom width.
	ubit_unit_live_update( 'header_transparent_border_width', '.has-header-transparent .site-header-inner', 'border-bottom-width', 0 );
	// Header transparent: border bottom color.
	ubit_colors_live_update( 'header_transparent_border_color', '.has-header-transparent .site-header-inner', 'border-bottom-color' );

	// Logo width.
	ubit_range_slider_update( ['logo_width', 'tablet_logo_width', 'mobile_logo_width'], '.site-branding img', 'max-width', 'px' );

	// Header transparent enable on...
	ubit_update_element_class( 'header_transparent_enable_on', 'body', 'header-transparent-for-' );

	// PAGE HEADER.
	// Text align.
	ubit_update_element_class( 'page_header_text_align', '.page-header .ubit-container', 'content-align-' );

	// Title color.
	ubit_colors_live_update( 'page_header_title_color', '.page-header .entry-title', 'color' );

	// Breadcrumb text color.
	ubit_colors_live_update( 'page_header_breadcrumb_text_color', '.ubit-breadcrumb, .ubit-breadcrumb a', 'color' );

	// Background color.
	ubit_colors_live_update( 'page_header_background_color', '.page-header', 'background-color' );

	// Background image.
	ubit_background_image_live_upload(
		'page_header_background_image',
		[
			'page_header_background_image_size',
			'page_header_background_image_repeat',
			'page_header_background_image_position',
			'page_header_background_image_attachment'
		],
		'.page-header'
	);

	// Padding top.
	ubit_range_slider_update( ['page_header_padding_top'], '.page-header', 'padding-top', 'px' );

	// Padding bottom.
	ubit_range_slider_update( ['page_header_padding_bottom'], '.page-header', 'padding-bottom', 'px' );

	// Margin bottom.
	ubit_range_slider_update( ['page_header_margin_bottom'], '.page-header', 'margin-bottom', 'px' );

	// BODY.
	// Body font size.
	ubit_unit_live_update( 'body_font_size', 'body, button, input, select, textarea, .woocommerce-loop-product__title', 'font-size', 14 );

	// Body line height.
	ubit_unit_live_update( 'body_line_height', 'body', 'line-height', 28 );

	// Body font weight.
	ubit_append_data( 'body_font_weight', 'body, button, input, select, textarea', 'font-weight' );

	// Body text transform.
	ubit_append_data( 'body_font_transform', 'body, button, input, select, textarea', 'text-transform' );

	// MENU.
	// Menu font weight.
	ubit_append_data( 'menu_font_weight', '.primary-navigation a', 'font-weight' );

	// Menu text transform.
	ubit_append_data( 'menu_font_transform', '.primary-navigation a', 'text-transform' );

	// Parent menu font size.
	ubit_unit_live_update( 'parent_menu_font_size', '.site-header .primary-navigation > li > a', 'font-size', 14 );

	// Parent menu line-height.
	ubit_unit_live_update( 'parent_menu_line_height', '.site-header .primary-navigation > li > a', 'line-height', 50 );

	// Sub-menu font-size.
	ubit_unit_live_update( 'sub_menu_font_size', '.site-header .primary-navigation .sub-menu a', 'font-size', 12 );

	// Sub-menu line-height.
	ubit_unit_live_update( 'sub_menu_line_height', '.site-header .primary-navigation .sub-menu a', 'line-height', 24 );

	// HEADING.
	// Heading line height.
	ubit_unit_live_update( 'heading_line_height', 'h1, h2, h3, h4, h5, h6', 'line-height', '1.5', false, false );

	// Heading font weight.
	ubit_append_data( 'heading_font_weight', 'h1, h2, h3, h4, h5, h6', 'font-weight' );

	// Heading text transform.
	ubit_append_data( 'heading_font_transform', 'h1, h2, h3, h4, h5, h6', 'text-transform' );

	// H1 font size.
	ubit_unit_live_update( 'heading_h1_font_size', 'h1', 'font-size', 48 );

	// H2 font size.
	ubit_unit_live_update( 'heading_h2_font_size', 'h2', 'font-size', 36 );

	// H3 font size.
	ubit_unit_live_update( 'heading_h3_font_size', 'h3', 'font-size', 30 );

	// H4 font size.
	ubit_unit_live_update( 'heading_h4_font_size', 'h4', 'font-size', 28 );

	// H5 font size.
	ubit_unit_live_update( 'heading_h5_font_size', 'h5', 'font-size', 26 );

	// H6 font size.
	ubit_unit_live_update( 'heading_h6_font_size', 'h6', 'font-size', 18 );

	// BUTTONS.
	// Color.
	// Background color.
	// Hover color
	// Hover background color.
	// Border radius.
	ubit_unit_live_update(
		'buttons_border_radius',
		'.cart .quantity, .button, .woocommerce-widget-layered-nav-dropdown__submit, .clear-cart-btn, .form-submit .submit, .elementor-button-wrapper .elementor-button, .has-ubit-contact-form input[type="submit"], #secondary .widget a.button, .ps-layout-1 .product-loop-meta.no-transform .button',
		'border-radius',
		4
	);

	// Hidden product meta.
	ubit_hidden_product_meta( 'shop_single_skus', 'hid-skus' );
	ubit_hidden_product_meta( 'shop_single_categories', 'hid-categories' );
	ubit_hidden_product_meta( 'shop_single_tags', 'hid-tags' );

	// Footer.
	ubit_range_slider_update( ['footer_space'], '.site-footer', 'margin-top', 'px' );
} )( jQuery );
