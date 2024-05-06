/**
 * Theme options screen
 *
 * @package ubit
 */

'use strict';

// Read more expand/collapse.
var ubitReadMore = function() {
	var readMoreButton = document.querySelectorAll( '.ubit-read-more-button' );
	if ( ! readMoreButton.length ) {
		return;
	}

	readMoreButton.forEach( function( element ) {
		var readMoreId = element.getAttribute( 'data-read-more-id' );

		if ( ! readMoreId || ! document.querySelector( '#' + readMoreId ) ) {
			return;
		}

		element.addEventListener( 'click', function( e ) {
			e.preventDefault();

			// Toggle read more block.
			jQuery( '#' + readMoreId ).slideToggle();
		} );
	});
}

document.addEventListener( 'DOMContentLoaded', function() {
	ubitReadMore();
} );
