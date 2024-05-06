/**
 * Ubit alpha color picker
 *
 * @package ubit
 */

jQuery( window ).on( 'load', function() {
	jQuery( 'html' ).addClass( 'colorpicker-ready' );
} );

wp.customize.controlConstructor[ 'ubit-color' ] = wp.customize.Control.extend( {

	ready: function() {

		'use strict';

		var control = this,
			value,
			thisInput,
			inputDefault,
			changeAction;

		control.container.find( '.ubit-color-picker-alpha' ).wpColorPicker( {
			/**
			 * Jquery event
			 *
			 * @param {Event} event - standard jQuery event, produced by whichever
			 * control was changed.
			 *
			 * @param {Object} ui - standard jQuery UI object, with a color member
			 * containing a Color.js object.
			 */
			change: function( event, ui ) {
				var element = event.target;
				var color = ui.color.toString();

				if ( jQuery( 'html' ).hasClass( 'colorpicker-ready' ) ) {
					control.setting.set( color );
				}
			},

			/**
			 * Clear event
			 *
			 * @param {Event} event - standard jQuery event, produced by "Clear"
			 * button.
			 */
			clear: function( event ) {
				var element = jQuery( event.target ).closest( '.wp-picker-input-wrap' ).find( '.wp-color-picker' )[ 0 ];
				var color = '';

				if ( element ) {
					control.setting.set( color );
				}
			}
		} );
	}
} );
