/**
 * Foreach polyfill for IE
 *
 * @package ubit
 */

if ( ! Object.getOwnPropertyDescriptor( NodeList.prototype, 'forEach' ) ) {
	Object.defineProperty( NodeList.prototype, 'forEach', Object.getOwnPropertyDescriptor( Array.prototype, 'forEach' ) );
}
