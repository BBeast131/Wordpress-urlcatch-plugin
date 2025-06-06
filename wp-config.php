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
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

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
define( 'AUTH_KEY',         'T[S#2h96hAcr! ToT%V,s)-|2DKm,2]: ePe^&p1;(<*7O;#6D?No9wAbx$ks:pY' );
define( 'SECURE_AUTH_KEY',  'OBi:%|,4./h|~c~j)Kh`0L0HdTCnw>fwZ|wCEHy(xm(p!~8Z9H{Ma&N^^Mo.z~DH' );
define( 'LOGGED_IN_KEY',    '+aE:(B#AfLWE{Q`ambXQ!a*SG%Ox2S~Jy!%++QsKwL7SJ@l+4_|$B#`!nnQ^+1CA' );
define( 'NONCE_KEY',        'eTM_)/Q)JIJ8f*:yC^^zYfTOCYxxTlVGmqy0Y@d_$z>S|w`KV~m}JWX=`R`<)![J' );
define( 'AUTH_SALT',        'm6!ywVnK{gP!qsDCLDtQQk|]%^Nru7J8f~X=Fzpw]w%^pt,+bx%ys9l4 haq:.;J' );
define( 'SECURE_AUTH_SALT', 'QD]H..zHd~rlI!>w*#PO|)T|w#E^pYpK=vAJ@yZB18yoPmIn(-G9;_d4aVz,yDfN' );
define( 'LOGGED_IN_SALT',   'xFW1%v:m@CoP&.~J#jmSNu[OR>$/@Lj)wLP:XK`O!b=WN9]we^I~l{Qk+a>Ip&G3' );
define( 'NONCE_SALT',       '^<?k:/X1DerQYmVHkhJmQmBR1V4l>8)i00RU68Z{e G%z&wB28<~vXzoL:::P[4 ' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
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
