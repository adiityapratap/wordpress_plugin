<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'custom_db' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '~zTYQ}#;wl{V4)iL~Z-pzd!pDMzCVma>6!v8.[PAluwUB,Nd)>Zs{2?(-HSw?S4c' );
define( 'SECURE_AUTH_KEY',  'wu^aVD,XRLAf`1r?UuUh$bkk]M+F(V2Z~;3/CO&^Xs%N:}j4fQJ#]CT )=)3n-Cm' );
define( 'LOGGED_IN_KEY',    ',@@!ZK]e6Q9sJ:nHL^Apc!{{SH4(qd`3 OS7[P9+,ZHd7mPB_Rb^Io|K,Tr*Q;PO' );
define( 'NONCE_KEY',        'gLQh|oc_b^5<7mjQ F^S;CGx4ssvy}W`ANY.%8//vf62S!^yNGHX]$-43>#czjg<' );
define( 'AUTH_SALT',        'Wd,!^aqF%+v(dMl6::]aQj#/r;Pj$$[KhQDWiv(toU?y{k1[@#R<Lx{C-No?3.Ra' );
define( 'SECURE_AUTH_SALT', '(L0_2NVo .~kAJ9a5UEGTmY# X[DmnV@9~uIT&z!jF{p%T1$}|v.kAO.9(T/wcES' );
define( 'LOGGED_IN_SALT',   'P3Iww)lsA%OT0(ZeGs`y|5lc]Qz9]#YYKTfD+BT/mITH-x!?S/[U*dU2S$1)VO/o' );
define( 'NONCE_SALT',       '7PEO9l/5?MX-2(yWQV-CPv9(o->KVMeO(>kCtIgsaTv:}p dD|gEyXSL|~oT%SGB' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
