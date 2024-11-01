<?php

/**
 * Do not execute this file directly.
 */
if (!defined('ABSPATH')) {
	exit;
}

// ---------------------------------------------------------------------
// Setup
// ---------------------------------------------------------------------

// This plugin has no frontend application, so we can avoid loading it
// at all if the shoe doesn't fit.
if (
	(!defined('WP_CLI') || !WP_CLI) &&
	(!defined('DOING_CRON') || !DOING_CRON) &&
	// The is_admin() function doesn't exist yet. This is close enough.
	(!isset($_SERVER['REQUEST_URI']) || (false === strpos($_SERVER['REQUEST_URI'], 'wp-admin')))
) {
	return;
}

// Constants.
define('SKYELLSAV_PLUGIN_DIR', dirname(__FILE__) . '/');
define('SKYELLSAV_INDEX', __FILE__);
define('SKYELLSAV_BASE_CLASS', 'skytells\\wp\\skyav\\');
define('SKYELLSAV_URL', 'https://www.skytells.org');
define('SKYELLSAV_EMAIL', 'sales@skytells.org');
define('SKYELLSAV_L10N', 'skytells-av');

// Is this installed as a Must-Use plugin?
$skyav_must_use = (
	defined('WPMU_PLUGIN_DIR') &&
	@is_dir(WPMU_PLUGIN_DIR) &&
	(0 === strpos(SKYELLSAV_PLUGIN_DIR, WPMU_PLUGIN_DIR))
);
define('SKYELLSAV_MUST_USE', $skyav_must_use);

// Now the URL root.
if (!SKYELLSAV_MUST_USE) {
	define('SKYELLSAV_PLUGIN_URL', preg_replace('/^https?:/i', '', trailingslashit(plugins_url('/', SKYELLSAV_INDEX))));
}
else {
	define('SKYELLSAV_PLUGIN_URL', preg_replace('/^https?:/i', '', trailingslashit(str_replace(WPMU_PLUGIN_DIR, WPMU_PLUGIN_URL, SKYELLSAV_PLUGIN_DIR))));
}

// --------------------------------------------------------------------- end setup



// ---------------------------------------------------------------------
// Requirements
// ---------------------------------------------------------------------

// If the server doesn't meet the requirements, load the fallback
// instead.
if (
	version_compare(PHP_VERSION, '5.6.0') < 0 ||
	(function_exists('is_multisite') && is_multisite()) ||
	(!function_exists('hash_algos') || !in_array('sha512', hash_algos(), true)) ||
	!extension_loaded('date') ||
	!extension_loaded('filter') ||
	!extension_loaded('json') ||
	!extension_loaded('pcre') ||
	!extension_loaded('spl')
) {
	require(SKYELLSAV_PLUGIN_DIR . 'bootstrap-fallback.php');
	return;
}

// --------------------------------------------------------------------- end requirements



// Otherwise we can continue as normal.
require(SKYELLSAV_PLUGIN_DIR . 'bootstrap.php');
