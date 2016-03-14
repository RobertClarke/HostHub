<?php

namespace HostList;

use phpFastCache\CacheManager;
use MysqliDb;
use Twig_Loader_Filesystem;
use Twig_Environment;


// Page load start (for load timing)
define('LOAD_START', microtime(true));

define('DIR',			dirname(__DIR__));
define('DIR_APP',		DIR . '/app');
define('DIR_PUBLIC',	DIR . '/public');
define('DIR_CACHE',		DIR . '/cache');

$https = false;

// Check if current request is being made through HTTPS
if ( !empty( filter_input(INPUT_SERVER, 'HTTPS') ) || filter_input(INPUT_SERVER, 'SERVER_PORT') == 443 )
	$https = true;

// Main site URL
define('MAIN_URL', 'http'. ( $https ? 's' : '' ) .'://' . filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_DEFAULT));

// Composer autoloader for vendor resources
require_once('vendor/autoload.php');

// Load config array
$config = require_once('config.php');

define('MANDRILL_API_KEY', $config['MANDRILL_API_KEY']);

// Database
$db = new MysqliDb( $config['DB_HOST'], $config['DB_USERNAME'], $config['DB_PASSWORD'], $config['DB_TABLE'] );

// Secret Keys + Salts: keep these private! Change at any time to invalidate all
// current logins to the website. Recommended for major code upgrades. Recommended
// length for all keys is 64 randomly generated characters.
define('KEY_SECRET', $config['KEY_SECRET']);

// Cache setup
$cache_config = [
	"storage"	=> "files",
	"path"		=> DIR_CACHE,
];

CacheManager::setup($cache_config);
CacheManager::CachingMethod('phpfastcache');

// Twig setup
$loader = new Twig_Loader_Filesystem(DIR_APP . '/views');
$twig = new Twig_Environment($loader, array(
    //'cache' => DIR . '/cache/templates',
));

// Routes
require_once('routes.php');

// Controller Base
require_once('core/Controller.php');

// View Base
require_once('core/View.php');

// Model Base
require_once('core/Model.php');

// Auth
require_once('core/Auth.php');

// Models
require_once('models/User.php');

// Error
require_once('core/Error.php');

$error_container = new ErrorContainer;

// Cache
require_once('core/Cache.php');

$cache = new Cache;

/**
 * Sets the value of a cookie
 *
 * @since 3.0.0
 *
 * @param string $name The name of the cookie to set
 * @param string|int $value The value to assign to the cookie
 * @param int $expiry The expiry time, in seconds
 * @param string $path The path for the cookie to be valid in
 * @param string $domain The domain for the cookie to be valid in
 * @param boolean $secure Whether or not this is an HTTPS cookie
 * @param boolean $http Whether or not this is an HTTP only cookie
**/
function cookie_set( $name, $value, $expiry, $path='/', $domain='', $secure=false, $http=true ) {
	setcookie($name, $value, $expiry, $path, $domain, $secure, $http);
	return;
}

/**
 * Expires a given cookie
 *
 * @since 3.0.0
 *
 * @param string $name The name of the cookie to expire
**/
function cookie_expire( $name ) {
	return cookie_set($name, '', time()-1);
}

function redirect( $target, $permanent=false ) {
	header('Location: '. MAIN_URL . $target, true, $permanent ? 301 : 302);
	exit;
}

function is_ajax() {
	return ( !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' );
}

function ajax_return( $status, $extra=[] ) {

	// Set HTTP header
	header('Content-type: application/json');

	$return = ['status' => $status];

	// Merge $extra array, if it's not empty
	if ( !empty($extra) )
		$return = array_merge($return, $extra);

	echo json_encode($return);

	exit;

}

/**
 * Generate a random string, using a cryptographically secure
 * pseudorandom number generator (random_int)
 *
 * For PHP 7, random_int is a PHP core function
 * For PHP 5.x, depends on https://github.com/paragonie/random_compat
 *
 * @param int $length      How many characters do we want?
 * @param string $keyspace A string of all possible characters to select from
 *
 * @return string
 */
function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
{
    $str = '';
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $str .= $keyspace[random_int(0, $max)];
    }
    return $str;
}
