<?php
/**
 * Skytells-AV Security Scanner - Bootstrap
 *
 * Set up the environment.
 *
 * @package sky-av-security-scanner
 * @author  Skytells, Inc
 */

/**
 * Do not execute this file directly.
 */
if (!defined('ABSPATH')) {
	exit;
}



// Bootstrap.
// phpab -e "./node_modules/*" -o ./lib/autoload.php .
require(SKYELLSAV_PLUGIN_DIR . 'lib/autoload.php');

// Actions!
add_action('admin_enqueue_scripts', array(SKYELLSAV_BASE_CLASS . 'admin', 'enqueue_scripts'));
add_action('admin_notices', array(SKYELLSAV_BASE_CLASS . 'admin', 'update_notice'));
add_action('admin_notices', array(SKYELLSAV_BASE_CLASS . 'admin', 'warnings'));
add_action('init', array(SKYELLSAV_BASE_CLASS . 'ajax', 'init'));
add_action('init', array(SKYELLSAV_BASE_CLASS . 'cron', 'init'));
add_action('plugins_loaded', array(SKYELLSAV_BASE_CLASS . 'admin', 'localize'));
add_action('plugins_loaded', array(SKYELLSAV_BASE_CLASS . 'admin', 'server_name'));
add_action('plugins_loaded', array(SKYELLSAV_BASE_CLASS . 'db', 'check'));

// Registration!
register_activation_hook(SKYELLSAV_INDEX, array(SKYELLSAV_BASE_CLASS . 'db', 'check'));

// And a few bits that don't need to wait.
\skytells\wp\skyav\admin::register_menus();
\skytells\wp\skyav\files::init();

// WP-CLI functions.
if (defined('WP_CLI') && WP_CLI) {
	require(SKYELLSAV_PLUGIN_DIR . 'lib/skytells/wp/skyav/cli.php');
}

// --------------------------------------------------------------------- end setup

