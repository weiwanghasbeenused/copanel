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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'copanel_local' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'f3f4p4ax' );

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
define( 'AUTH_KEY',         'L8#QFcNg@SD)ft}H4M>^nqar/Pb!<S#)]9?WD%H9@ujw&+y9_Hs<>v1Sa$?Im4uV' );
define( 'SECURE_AUTH_KEY',  '@)9,#*7l(zQh/@V4re#xFe0?[v~aXHg9tV33<e2yqnMXWau)JUAn=tJuB-[|+!t]' );
define( 'LOGGED_IN_KEY',    '||M]3{V]7$uEabo=DTb{(9}E?rzzMakeH|MqKHh8 #WrU =2G<UbDDzB%:G,X)+W' );
define( 'NONCE_KEY',        'K+(6MfylI;0T_@Q;v1>fe}Oh-!?MQ9CzU|Fl;jU;56C$Cvm4cY*XGSRJa1GLh%xX' );
define( 'AUTH_SALT',        'F)z p&={O@[sLyg_jXTS-0I6X)Eu9Iqp#M|Tp.gJp0;#dt,de)7XRt)JrhP[220f' );
define( 'SECURE_AUTH_SALT', '-]6f3Zw~X<M- (<WYx^6|I.Y=dR7)[6J?3gu%c%UVW40h%LtOzP-EWF}$_XDMUER' );
define( 'LOGGED_IN_SALT',   'oMr1we,@?q~1>U.p/0)RVZ@}T%C~(St8&puf~=ER_ohogRKv+Y6S!F`>wrH4k[Ee' );
define( 'NONCE_SALT',       'P%SnGO2R9`cFg.Y#C,>}X|}%,aipw_KWWJqnF!6!UCFc+Ivmo_4x?(=L*#47y|g!' );

define( 'TC_POST', 'Feel free to make use of the contact details below if you have any questions,
comments, or feedback:[[br]]
[[br]]
* Leave a comment on this ticket[[br]]
* Send an email to the Theme Review email list[[br]]
* Use the #wordpress-themes IRC channel on Freenode.' );

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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
