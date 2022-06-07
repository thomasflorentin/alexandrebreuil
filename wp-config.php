<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'alexandrebreuil_db' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost:8889' );

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
define('AUTH_KEY',         'efHzq=E>WvQcM!TH6@0M`H0%-u.-7O()DFR{v5rl!KtB>CTX3CBL<LME6OQEnt>M');
define('SECURE_AUTH_KEY',  'khg?-Eb>-]QgNm`9Ws}]`e|~DmuPG1w3FG!5M=c,DNtoh/{$p[R§MXX!R3§-`$`Z');
define('LOGGED_IN_KEY',    'NO=cgusqtMu,c@0+T§>sUr}xyo?;:|^Z8LI0CR,2` N CL~0;;^MV4}O+DW`pH&c');
define('NONCE_KEY',        '§/5MI5Rcp2Okwk7Zchq@m,xl[Uuw8L;oxbbmv=C9m0i@ps@}XPt}DEE=c]=§3Fo%');
define('AUTH_SALT',        '@RqOOp(0!c[&Jl0!>P^?8`t7h&F)v |=Ww<:$X30Ar}x=6lc`)Q):(zm4+9+JG-~');
define('SECURE_AUTH_SALT', 'oVPpH&u+-D`8++fgs :Vs:|76pF@^$TV9e S9OczP5A6%<7/P0e`ULnB-@}im`,w');
define('LOGGED_IN_SALT',   '!1AJRFK=:PN3-o%o+jLu?7Tz5+gfHX=!t{rGYhYatmlf]-pCExBfNWF,__O]§^b§');
define('NONCE_SALT',       ']V|de/|}yp/cb1Tyo,7?LVKOD@mLv7/<X[w]57-@w@gfwelxnD/=5|UR!:Y>r`-J');

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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
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
