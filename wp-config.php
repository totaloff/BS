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
//define('WP_CACHE', true); //Added by WP-Cache Manager
//define( 'WPCACHEHOME', 'E:\xampp\htdocs\brain\wp-content\plugins\wp-super-cache/' ); //Added by WP-Cache Manager
define('DB_NAME', 'sxqucjw0_9lV');

/** MySQL database username */
//define('DB_USER', 'sxqucjw0_9lV');

/** MySQL database password */
//define('DB_PASSWORD', 'uWiK0*Voacr9');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '3w/asavduQSzWov%36gS8v(nAj>mFRu?Q&Egy+]K_Y#PQ(cgp7!g@p*,/xSaor3u');
define('SECURE_AUTH_KEY',  'uY]oe<;Fv?vHGZ19q23#,?3&ruuf*ldKMJhip_)g)QC:j6MlIPyhd [ZvBdd I0M');
define('LOGGED_IN_KEY',    'tx7eX@Nbqq|](KJQ|E;aFv<=::L3gA, (eAWH4JFqRq=%nb@Q*8nGSpJm>^V_jWh');
define('NONCE_KEY',        'Qx@z-jA~>4=D$ eU*DRR6@Tw5HO~zH?uV+8UJMrnQsT(~SMR&dQG:/@OXoNS9nJo');
define('AUTH_SALT',        'zbFE0:4b/ik/=9aD4k8C,h|8O7(y#]NInh^RxH>(eWi+VvoB$X>!qn8yi@HnG7X&');
define('SECURE_AUTH_SALT', 'jQO)Y5aDA8C8(f=a%>StWN_xL(ht@A+sK4Naus#/8<8~Yy%xNyP|YJJb3@#U<.Jg');
define('LOGGED_IN_SALT',   'BxI9mLH&ha&C+<+&m)`8TDLtG1ULxxFC35p<Z>BzN:U(07Ad[mZ#okY=eRd*fyzC');
define('NONCE_SALT',       '6UaXS(nd]wtt9ZQ6Tw/5hbyrItnl+DOdx-lgqK_gAxBr!XHx[W/E;*9d~(R+LoE/');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'VKe_';

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
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

//define( 'WP_SITEURL', 'http://localhost:1234/brain' );  
//define( 'WP_HOME',    'http://localhost:1234/brain' );

