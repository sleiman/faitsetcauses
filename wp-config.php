<?php
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache

/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wp_faitsetcauses');

/** MySQL database username */
define('DB_USER', 'faitsetcauses');

/** MySQL database password */
define('DB_PASSWORD', '33gy43_REf*B#hT4$ff2k33');

/** MySQL hostname */
define('DB_HOST', '10.128.14.243');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

define('WP_MEMORY_LIMIT', '256M');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'X,(o+CXzJm`9Z5U*}xJ$Za!x;hy^JKYC;}q/.h<E01& c?`_pSU|S2 F(:7?Lmg;');
define('SECURE_AUTH_KEY',  '`[[?E)-J)I*Oxo7Y2=byKnb|VB*#s:LKy(v5/=QWgt|]esT|nlx.N`G#kC^2gq%t');
define('LOGGED_IN_KEY',    '|=8O-*5mD$w<b10e&4t|O,3`Z &=Lhh5n_~2<5p;>R]AVhbos#dzd5{XHQvck |<');
define('NONCE_KEY',        'C$oH~=5L39+khbIiAp&,zIbZPJ!Yn{h57slA/Xj+UN3E*88iD+?^4tx(%v}=$h4)');
define('AUTH_SALT',        'L8s|n>Y,mN+WNp7b`H_7Yzrh{RnPHO),3E.M60s$Kz<eft>Ogu&.-`kyK~5`I>#4');
define('SECURE_AUTH_SALT', 'X[+FU#9195Ltc6f({kT6&bw%tL[QXT)e<t%A7j+L0_+)pd;pXCnGRUPevFPD{]Xh');
define('LOGGED_IN_SALT',   'd)DEQEF!*SK-E%9n-qd)h7QmuYT8N7yT{]z~f.=@tE2/^@_pX/oPW{(sqD]0:vf`');
define('NONCE_SALT',       '`Z5L2=rJUP6HSIv/}its$u?trt5:T_5WDSG=efpc+|O&aAE[F$|*?Faf2H;d-F?z');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress.  A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de.mo to wp-content/languages and set WPLANG to 'de' to enable German
 * language support.
 */
define ('WPLANG', 'fr_FR');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
    define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
