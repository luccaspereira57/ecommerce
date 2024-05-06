<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'ecommerce' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'pt)QiZel%7a;x<{TEqCSDupx9v|zk*oX*_{90HUhV=rxaYAtlwTuilMd[f!c^Rc%' );
define( 'SECURE_AUTH_KEY',  'q[m3c%(#@fcjdpWIbQqAS~3.i*F6_g,*S[24iyy&/r|]K6K=IHMl029|J 2!1H>v' );
define( 'LOGGED_IN_KEY',    'b1=Gr#MEBKn#Wcm3a~.0b2P1xZwKyCEo/b*9s=#CzbwpkSygkR2km!DDeBy$[j($' );
define( 'NONCE_KEY',        'Lm(W}<6Mrwn9G!j0^=,GyrbS#=<xI<8aceV7cj9Rh*<1>Qp!9b`-REN5e&:AxpWA' );
define( 'AUTH_SALT',        '@1l0.?!,TznD9Oz7VS MIO7GkiUct=7-~p`o8H=2W8][gku<}bX(gA;@O|w]0/:(' );
define( 'SECURE_AUTH_SALT', '_$)&=&DO9PiU.B*q2Nhhy:b#1>+nCaU|L^yKhv#*gYMXS6XBN,;B/Jk8O/xe=b^.' );
define( 'LOGGED_IN_SALT',   'qQ@v=.uh2A0^UuhEFN,^G]!D a+R&)cYxqUCDa95iXY{1 E98-wzpT CW]sn[|]~' );
define( 'NONCE_SALT',       'tmGc82*L}i4B({%25J;=zi<<E-vI8c-%9g@AyS|7KmYlQ&Z*ks&gLQ96mF=sRrqx' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
