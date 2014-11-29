<?php
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

if('holzman-jonlauters.rhcloud.com' === $_SERVER['HTTP_HOST']) {
    define('DB_NAME', $_ENV['OPENSHIFT_APP_NAMP']);
    define('DB_USER', $_ENV['OPENSHIFT_MYSQL_DB_USERNAME']);
    define('DB_PASSWORD', $_ENV['OPENSHIFT_MYSQL_DB_PASSWORD']);
    define('DB_HOST', $_ENV['OPENSHIFT_MYSQL_DB_HOST']);
} else {
    define('DB_NAME', 'holzman');
    define('DB_USER', 'jon');
    define('DB_PASSWORD', 'wppassword');
    define('DB_HOST', 'localhost');
}
define('DB_CHARSET', 'utf8');
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
define('AUTH_KEY',         '0so1j9kedzjhe1lvk5yy5zwwuwnb2rd0gqaaf05scqdy70utfmwdwspl34oo7hoc');
define('SECURE_AUTH_KEY',  'jrr63qsa3kh3zhqpwcv4fmr0ajxi5w7rorw8uciiqe4rhko9z2uotymdjgn8n3kt');
define('LOGGED_IN_KEY',    '0aqahdv8rwchwhyubccvrw7dxnhfc7rxphilw6djayw56tenttjimgr6uxe6cggg');
define('NONCE_KEY',        'o6isa8okghgoazawzoot2loojeo9rsz86zqtufi3rej6eb0nmjovn0ceijjxry9t');
define('AUTH_SALT',        'lvl28ongnfhxkzrtblkdsmzmmpprpn5y1i08n576ehth8vbdzc18y2n6pwrlb6d0');
define('SECURE_AUTH_SALT', 'hnqzh2rscwthlxdm2tqsnixvt78v3zlmzivs8g4opzhkghkrxujoq22ktwfmqyiz');
define('LOGGED_IN_SALT',   '0cewn1ucaqrm1ywhxgewmfkmjqygllqygrurxisgholc5rpbuwlvuecvh9int0dl');
define('NONCE_SALT',       'y4bjhjsyytsqm3exrfky8yxtjwad2vjgirg4h74dp28nxdyjk9j7qqf9xdry7f6y');

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
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

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
