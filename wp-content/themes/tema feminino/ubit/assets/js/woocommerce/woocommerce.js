/**
 * WooCommerce js
 *
 * @package ubit
 */

'use strict';

function cartSidebarOpen() {
	document.documentElement.classList.add( 'cart-sidebar-open' );
}

function eventCartSidebarOpen() {
	document.body.classList.add( 'updating-cart' );
	document.body.classList.remove( 'cart-updated' );
}

function eventCartSidebarClose() {
	document.body.classList.add( 'cart-updated' );
	document.body.classList.remove( 'updating-cart' );
}

// Event when click shopping bag button.
function shoppingBag() {
	var shoppingBag = document.getElementsByClassName( 'shopping-bag-button' );

	if ( ! shoppingBag.length || document.body.classList.contains( 'woocommerce-cart' ) ) {
		return;
	}

	for ( var i = 0, j = shoppingBag.length; i < j; i++ ) {
		shoppingBag[i].addEventListener( 'click', function( e ) {
			e.preventDefault();

			cartSidebarOpen();
			closeAll();
		} );
	}
}

// Get product item in cart.
function getProductItemInCart() {

	// Variables.
	var cart   = document.getElementsByClassName( 'cart' )[0],
		button = cart ? cart.getElementsByClassName( 'single_add_to_cart_button' )[0] : false;

	if ( ! cart || ! button || 'A' == button.tagName || cart.classList.contains( 'grouped_form' ) ) {
		return;
	}

	var addToCart     = cart.querySelector( '[name="add-to-cart"]' ),
		productId     = addToCart ? addToCart.value : false,
		input         = cart.getElementsByClassName( 'qty' )[0],
		quantity      = parseInt( input.value ),
		productInfo   = cart.getElementsByClassName( 'additional-product' )[0],
		inStock       = productInfo ? productInfo.getAttribute( 'data-in_stock' ) : 'no';

	if ( ! productId || 'no' == inStock ) {
		return;
	}

	// Product variations id.
	if ( cart.classList.contains( 'variations_form' ) ) {
		productId = cart.querySelector( '[name="product_id"]' ).value;
	}

	// Request.
	var request = new Request( ubit_woocommerce_data.ajax_url, {
		method: 'POST',
		body: 'action=get_product_item_incart&nonce=' + ubit_woocommerce_data.ajax_nonce + '&product_id=' + productId,
		credentials: 'same-origin',
		headers: new Headers({
			'Content-Type': 'application/x-www-form-urlencoded; charset=utf-8'
		})
	} );

	// Fetch API.
	fetch( request )
		.then( function( res ) {
			if ( 200 !== res.status ) {
				console.log( 1 );
				return;
			}

			res.json().then( function( data ) {
				console.log( 2 );
				productInfo.value = data.item;
			});
		} );
}

// Styled select fields for currency and language switchers using selectWoo.
// Used for WOOCS - WooCommerce Currency Switcher, Polylang and Polylang Connect for Elementor plugins.
function formatStyledSelectFieldsFlag( state ) {
	if ( typeof state.id !== 'undefined' ) {
		var flag_id = state.id.replace( 'en', 'us' ).toLowerCase();

		return '<img class="ubit-polylang-flag-img" src="' + ubit_woocommerce_data.plugins_url + '/polylang/flags/' + flag_id + '.png" />' + state.text;
	}

	return state;
}

function styledSelectFields() {
	if ( jQuery.isFunction( jQuery.fn.selectWoo ) ) {
		var currencySwitcherSelectWoo = '.widget-woocommerce-currency-switcher select';

		if ( jQuery( currencySwitcherSelectWoo ).length ) {
			jQuery( currencySwitcherSelectWoo ).selectWoo( {
				minimumResultsForSearch: 10,
				dropdownCssClass: 'woocommerce-selectWoo-clean-style',
				dropdownAutoWidth: true,
			} );

			jQuery( document ).on( 'mouseenter', currencySwitcherSelectWoo + ' + .select2' , function() {
			  jQuery( currencySwitcherSelectWoo ).select2( 'open' );
			} );

			jQuery( document ).on( 'mouseleave', '.select2-container', function( e ) {
			  if ( ! jQuery( e.toElement || e.relatedTarget ).closest( '.select2-container' ).length ) {
			    jQuery( currencySwitcherSelectWoo ).select2( 'close' );
			  }
			});
		}

		var polylangSelectWoo = '.elementor-widget-wp-widget-polylang select';

		if ( jQuery( polylangSelectWoo ).length ) {
			jQuery( polylangSelectWoo ).selectWoo( {
				minimumResultsForSearch: 10,
				dropdownCssClass: 'woocommerce-selectWoo-clean-style',
				dropdownAutoWidth: true,
				templateResult: formatStyledSelectFieldsFlag,
		    templateSelection: formatStyledSelectFieldsFlag,
		    escapeMarkup: function( m ) { return m; }
			} );

			jQuery( document ).on( 'mouseenter', polylangSelectWoo + ' + .select2' , function() {
			  jQuery( polylangSelectWoo ).select2( 'open' );
			} );

			jQuery( document ).on( 'mouseleave', '.select2-container', function( e ) {
			  if ( ! jQuery( e.toElement || e.relatedTarget ).closest( '.select2-container' ).length ) {
			    jQuery( polylangSelectWoo ).select2( 'close' );
			  }
			});
		}
	}
}

document.addEventListener( 'DOMContentLoaded', function() {
	styledSelectFields();
	shoppingBag();

	var storeNotice = document.getElementsByClassName( 'woocommerce-store-notice' )[0];

	window.addEventListener( 'scroll', function() {
		if (
			document.body.classList.contains( 'woocommerce-demo-store' ) &&
			storeNotice &&
			'none' != storeNotice.style.display
		) {
			scrollingDetect();
		}
	} );

	if ( storeNotice ) {
		storeNotice.addEventListener( 'click', function() {
			document.body.classList.remove( 'scrolling-down' );
		} );
	}

	jQuery( document.body ).on( 'adding_to_cart', function() {
		eventCartSidebarOpen();
		cartSidebarOpen();
	} ).on( 'added_to_cart', function() {
		eventCartSidebarClose();
		closeAll();
	} ).on( 'updated_cart_totals', function() {
		if ( 'function' === typeof quantity ) {
			quantity();
		}
	} ).on( 'removed_from_cart', function() {
		getProductItemInCart();
	} );

	jQuery( document ).on( 'click', '.ubit-trigger-cart-sidebar-open a', function( e ) {
		e.preventDefault();
		eventCartSidebarOpen();
		cartSidebarOpen();
		eventCartSidebarClose();
		closeAll();
	} );
} );
