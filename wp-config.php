<?php

//Begin Really Simple Security session cookie settings
@ini_set('session.cookie_httponly', true);
@ini_set('session.cookie_secure', true);
@ini_set('session.use_only_cookies', true);
//END Really Simple Security cookie settings
//Begin Really Simple Security key
define('RSSSL_KEY', 'GYtkn0NB1NGe3Jp8N7H3nonO1e3JUfke5H025CMXJOmrT4ETV5jZoOakeXYl1ccD');
//END Really Simple Security key
define( 'WP_CACHE', true );

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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'u351502411_lBEh9' );

/** Database username */
define( 'DB_USER', 'u351502411_lPwFX' );

/** Database password */
define( 'DB_PASSWORD', 'LgTudQKA9j' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          'Cse^1Y&dGA&]]}))HZC>08DO!^-,$`jy,M>mE]cL?nzf)d_+%&|o** h-u/!ak8X' );
define( 'SECURE_AUTH_KEY',   'OQNR)DHJlut`lNTR4e,UQfU1~c#MpEJ58rZ7x%A;P4^fuC-Vz;U+jf,by=@zpabu' );
define( 'LOGGED_IN_KEY',     'S`V&}z)s[ P,O-R_^=T%kjel6yIXcVe86w%<Ab;&D64]|o}ge]?^J9!N{`U[z3dM' );
define( 'NONCE_KEY',         'wDcz[(TtqB/lE(*Fqaf]AW$:nzrCX@kRyKh.gz)`pGy[g!W3:&e>1sv1PswY;/oC' );
define( 'AUTH_SALT',         ' &7<R+d9^+1A=d=JvT!YOMcOrCQC,2)2Uqc)=hu{WH7UXF[bPv_b60iuju|)s2HA' );
define( 'SECURE_AUTH_SALT',  'lOWZRp})`C6]ve2h0u:O,:|Ynsk`*7!}V*C!n6WOx75gA/Sgb/&,| cis@WCddkm' );
define( 'LOGGED_IN_SALT',    'Wk2fO^dpf;dghl7zj5LtI6O-:8MQxgHZ`Y$7gS$%:8kp.`)o?#P~Y*4ig-cT*?XS' );
define( 'NONCE_SALT',        '/Od2rnk=WIEpxX5pFEA~&l9;Df5ciwvK{antEA:=EINNQzy#^qvhU6b _.sTZ30.' );
define( 'WP_CACHE_KEY_SALT', '6j ~tMd9^pUQoupGA-0< u3rU_<&O|=]fe|C!uWex ^C!GQ]vEqbDKvIt)TrdKz ' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'FS_METHOD', 'direct' );
define( 'COOKIEHASH', '3cb7591a8c7ab0c2f0c6fc6ca2a5e3a8' );
define( 'WP_AUTO_UPDATE_CORE', 'minor' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
