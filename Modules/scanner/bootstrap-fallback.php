<?php
/**
 * Skytells-AV Security Scanner - Fallback Bootstrap
 *
 * This is run on environments that do not meet the main plugin
 * requirements. It will either deactivate the plugin (if it has never
 * been active) or provide a semi-functional fallback environment to
 * keep the site from breaking, and suggest downgrading to the legacy
 * version.
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



// ---------------------------------------------------------------------
// Compatibility Checking
// ---------------------------------------------------------------------

// There will be errors. What are they?
$skyav_errors = array();

if (version_compare(PHP_VERSION, '5.6.0') < 0) {
	$skyav_errors['version'] = __('PHP 5.6.0 or newer is required.', SKYELLSAV_L10N);
}

if (function_exists('is_multisite') && is_multisite()) {
	$skyav_errors['multisite'] = __('This plugin cannot be used on Multi-Site.', SKYELLSAV_L10N);
}

// Miscellaneous extensions.
foreach (array('date', 'filter', 'json', 'pcre', 'spl') as $v) {
	if (!extension_loaded($v)) {
		$skyav_errors[$v] = sprintf(
			__('This plugin requires the PHP extension %s.', SKYELLSAV_L10N),
			$v
		);
	}
}

if (!function_exists('hash_algos') || !in_array('sha512', hash_algos(), true)) {
	$skyav_errors['hash'] = __('PHP must support basic hashing algorithms like SHA512.', SKYELLSAV_L10N);
}

// Will downgrading to the legacy version help?
$skyav_downgrade = (
	!SKYELLSAV_MUST_USE &&
	(1 === count($skyav_errors)) &&
	isset($skyav_errors['version']) &&
	version_compare(PHP_VERSION, '5.4.0') >= 0
);

// --------------------------------------------------------------------- end compatibility



// ---------------------------------------------------------------------
// Functions
// ---------------------------------------------------------------------

/**
 * Admin Notice
 *
 * @return bool True/false.
 */
function skyav_admin_notice() {
	global $skyav_errors;
	global $skyav_downgrade;

	if (!is_array($skyav_errors) || !count($skyav_errors)) {
		return false;
	}
	?>
	<div class="notice notice-error">
		<p><?php
		echo sprintf(
			esc_html__('Your server does not meet the requirements for running %s. You or your system administrator should take a look at the following:', SKYELLSAV_L10N),
			'<strong>Skytells-AV Security Scanner</strong>'
		);
		?></p>

		<?php
		foreach ($skyav_errors as $error) {
			echo '<p>&nbsp;&nbsp;&mdash; ' . esc_html($error) . '</p>';
		}

		// Can we recommend the old version?
		if (isset($skyav_errors['disabled'])) {
			unset($skyav_errors['disabled']);
		}

		if ($skyav_downgrade) {
			echo '<p>' .
			sprintf(
				esc_html__('As a *stopgap*, you can %s the Skytells-AV Security Scanner plugin to the legacy *20.x* series. The legacy series *will not* receive updates or development support, so please ultimately plan to remove the plugin or upgrade your server environment.', SKYELLSAV_L10N),
				'<a href="' . admin_url('update-core.php') . '">' . esc_html__('downgrade', SKYELLSAV_L10N) . '</a>'
			) . '</p>';
		}
		?>
	</div>
	<?php
	return true;
}
add_action('admin_notices', 'skyav_admin_notice');

/**
 * Self-Deactivate
 *
 * If the environment can't support the plugin and the environment never
 * supported the plugin, simply remove it.
 *
 * @return bool True/false.
 */
function skyav_deactivate() {
	// Can't deactivate an MU plugin.
	if (SKYELLSAV_MUST_USE) {
		return false;
	}

	require_once(trailingslashit(ABSPATH) . 'wp-admin/includes/plugin.php');
	deactivate_plugins(SKYELLSAV_INDEX);

	global $skyav_errors;
	global $skyav_downgrade;
	$skyav_downgrade = false;
	$skyav_errors['disabled'] = __('The plugin has been automatically disabled.', SKYELLSAV_L10N);

	if (isset($_GET['activate'])) {
		unset($_GET['activate']);
	}

	return true;
}
add_action('admin_init', 'skyav_deactivate');

/**
 * Downgrade Update
 *
 * Pretend the legacy version is newer to make it easier for people to
 * downgrade. :)
 *
 * @param StdClass $option Plugin lookup info.
 * @return StdClass Option.
 */


/**
 * Localize
 *
 * @return void Nothing.
 */
function skyav_localize() {
	if (SKYELLSAV_MUST_USE) {
		load_muplugin_textdomain(SKYELLSAV_L10N, basename(SKYELLSAV_PLUGIN_DIR) . '/languages');
	}
	else {
		load_plugin_textdomain(SKYELLSAV_L10N, false, basename(SKYELLSAV_PLUGIN_DIR) . '/languages');
	}
}
add_action('plugins_loaded', 'skyav_localize');

// --------------------------------------------------------------------- end functions
