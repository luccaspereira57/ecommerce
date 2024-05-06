/**
 * General js
 *
 * @package ubit
 */

'use strict';

// Run scripts only elementor loaded.
function onElementorLoaded( callback ) {
	if ( undefined === window.elementorFrontend || undefined === window.elementorFrontend.hooks ) {
		setTimeout( function() {
			onElementorLoaded( callback )
		} );

		return;
	}

	callback();
}

// Disable popup/sidebar/menumobile.
function closeAll() {
	// Use ESC key.
	document.body.addEventListener( 'keyup', function( e ) {
		if ( 27 === e.keyCode ) {
			document.documentElement.classList.remove( 'cart-sidebar-open' );
		}
	} );

	// Use `X` close button.
	var closeCartSidebarBtn = document.getElementById( 'close-cart-sidebar-btn' );

	if ( closeCartSidebarBtn ) {
		closeCartSidebarBtn.addEventListener( 'click', function() {
			document.documentElement.classList.remove( 'cart-sidebar-open' );
		} );
	}

	// Use overlay.
	var overlay = document.getElementById( 'ubit-overlay' );

	if ( overlay ) {
		overlay.addEventListener( 'click', function() {
			document.documentElement.classList.remove( 'cart-sidebar-open', 'sidebar-menu-open' );
		} );
	}
}

// Dialog search form.
function dialogSearch() {
	var headerSearchIcon = document.getElementsByClassName( 'header-search-icon' ),
		dialogSearchForm = document.querySelector( '.site-dialog-search' ),
		searchField      = document.querySelector( '.site-dialog-search .search-field' ),
		closeBtn         = document.querySelector( '.site-dialog-search .dialog-search-close-icon' );

	if ( ! headerSearchIcon.length || ! dialogSearchForm || ! searchField || ! closeBtn ) {
		return;
	}

	// Disabled field suggestions.
	searchField.setAttribute( 'autocomplete', 'off' );

	// Field must not empty.
	searchField.setAttribute( 'required', 'required' );

	var dialogOpen = function() {
		document.documentElement.classList.add( 'dialog-search-open' );
		document.documentElement.classList.remove( 'dialog-search-close' );

		if ( window.matchMedia( '( min-width: 992px )' ).matches ) {
			searchField.focus();
		}
	}

	var dialogClose = function() {
		document.documentElement.classList.add( 'dialog-search-close' );
		document.documentElement.classList.remove( 'dialog-search-open' );
	}

	for ( var i = 0, j = headerSearchIcon.length; i < j; i++ ) {
		headerSearchIcon[i].addEventListener( 'click', function( e ) {
			e.preventDefault();
			dialogOpen();

			// Use ESC key.
			document.body.addEventListener( 'keyup', function( e ) {
				if ( 27 === e.keyCode ) {
					dialogClose();
				}
			} );

			// Use dialog overlay.
			dialogSearchForm.addEventListener( 'click', function( e ) {
				if ( this !== e.target ) {
					return;
				}

				dialogClose();
			} );

			// Use closr button.
			closeBtn.addEventListener( 'click', function() {
				dialogClose();
			} );
		} );
	}
}

// Footer action.
function footerAction() {
	var scroll = function() {
		var item = document.getElementsByClassName( 'footer-action' )[0];
		if ( ! item ) {
			return;
		}

		var pos = arguments.length > 0 && undefined !== arguments[0] ? arguments[0] : window.scrollY;

		if ( pos > 200 ) {
			item.classList.add( 'active' );
		} else {
			item.classList.remove( 'active' );
		}
	}

	window.addEventListener( 'load', function() {
		scroll();
	} );

	window.addEventListener( 'scroll', function() {
		scroll();
	} );
}

// Scroll to top.
function scrollToTop() {
	var top = jQuery( '#scroll-to-top' );
	if ( ! top.length ) {
		return;
	}

	top.on( 'click', function() {
		jQuery( 'html, body' ).animate( { scrollTop: 0 }, 300 );
	} );
}

// Scrolling detect direction.
function scrollingDetect() {
	var body = document.body;

	if ( window.oldScroll > window.scrollY ) {
		body.classList.add( 'scrolling-up' );
		body.classList.remove( 'scrolling-down' );
	} else {
		body.classList.remove( 'scrolling-up' );
		body.classList.add( 'scrolling-down' );
	}

	// Reset state.
	window.oldScroll = window.scrollY;
}

document.addEventListener( 'DOMContentLoaded', function() {
	dialogSearch();
	footerAction();
	scrollToTop();
} );
