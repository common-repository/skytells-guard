<?php
/**
 * CLI: Checksums
 *
 * @package sky-av-security-scanner
 * @author  Skytells, Inc
 */

namespace skytells\wp\skyav\cli;

use \skytells\wp\skyav\files;
use \skytells\wp\skyav\core;
use \skytells\wp\skyav\options;
use \skytells\wp\skyav\vendor\common;
use \WP_CLI;
use \WP_CLI\Formatter;
use \WP_CLI\Utils;

// Add the main command.
if (!class_exists('WP_CLI') || !class_exists('WP_CLI_Command')) {
	return;
}

WP_CLI::add_command(
	'sky-av checksums',
	SKYELLSAV_BASE_CLASS . 'cli\\checksums',
	array(
		'before_invoke'=>function() {
			if (is_multisite()) {
				WP_CLI::error(__('This plugin cannot be used on Multi-Site.', SKYELLSAV_L10N));
			}

			if (!options::is_pro()) {
				WP_CLI::error(__('A premium license is required.', SKYELLSAV_L10N));
			}
		},
	)
);

/**
 * Skytells-AV Security Scanner
 *
 * WordPress-hosted content — the core and various plugins and themes —
 * provide an opportunity to compare site files against a Platonic
 * Ideal. Any deviation from the source material is worth a closer
 * look.
 */
class checksums extends \WP_CLI_Command {

	/**
	 * Reload Checksums
	 *
	 * By default, Skytells-AV will only calculate checksums for "Core"
	 * content as needed (i.e. as content is installed or updated).
	 * But sometimes plugin/theme authors may push updates to WP
	 * without altering version numbers, in which case things might
	 * fall slightly out of alignment.
	 *
	 * Use this command to force a hard rebuild of the checksum
	 * database.
	 *
	 * @return bool True.
	 */
	public function refresh() {
		global $wpdb;

		// First, delete everything.
		$wpdb->query("DELETE FROM `{$wpdb->prefix}skyav3_core`");

		// Core first.
		core::load_core_checksums();
		if (intval($wpdb->get_var("
			SELECT COUNT(*)
			FROM `{$wpdb->prefix}skyav3_core`
			WHERE `type`='core'
		"))) {
			WP_CLI::success(
				__('Refreshed: WordPress checksums.', SKYELLSAV_L10N)
			);
		}
		else {
			WP_CLI::warning(
				__('Core WordPress checkums could not be pulled.', SKYELLSAV_L10N)
			);
		}

		// Plugins.
		core::load_plugin_checksums();
		$plugins = intval($wpdb->get_var("
			SELECT COUNT(DISTINCT `slug`)
			FROM `{$wpdb->prefix}skyav3_core`
			WHERE `type`='plugin'
		"));
		if ($plugins > 0) {
			WP_CLI::success(
				sprintf(
					__('Refreshed: %d plugin checkums.', SKYELLSAV_L10N),
					$plugins
				)
			);
		}
		else {
			WP_CLI::warning(
				__('No plugin checksums could be pulled.', SKYELLSAV_L10N)
			);
		}

		// Themes.
		core::load_theme_checksums();
		$themes = intval($wpdb->get_var("
			SELECT COUNT(DISTINCT `slug`)
			FROM `{$wpdb->prefix}skyav3_core`
			WHERE `type`='theme'
		"));
		if ($themes > 0) {
			WP_CLI::success(
				sprintf(
					__('Refreshed: %d theme checkums.', SKYELLSAV_L10N),
					$themes
				)
			);
		}
		else {
			WP_CLI::warning(
				__('No theme checksums could be pulled.', SKYELLSAV_L10N)
			);
		}

		return true;
	}

	/**
	 * Verify Checksums
	 *
	 * This mini file scan focuses only on content with official
	 * checksums — WordPress and certain plugins and themes it hosts.
	 * Anything missing or modified will be reported.
	 *
	 * ## OPTIONS
	 *
	 * [--skip-readme]
	 * : Plugin readme files, used by WP.org for display purposes, are
	 * subject to change between releases, potentially causing checksums
	 * to mismatch. Use --no-skip-readme to negate.
	 * ---
	 * default: true
	 * ---
	 *
	 * @return bool True.
	 * @throws \Exception Scan error.
	 */
	public function verify() {
		global $wpdb;

		WP_CLI::log(
			__('Loading checksums.', SKYELLSAV_L10N)
		);
		core::load_core_checksums();
		core::load_plugin_checksums();
		core::load_theme_checksums();

		$dbResult = $wpdb->get_results("
			SELECT
				`file_path`,
				`checksum`
			FROM `{$wpdb->prefix}skyav3_core`
			ORDER BY `file_path` ASC
		", ARRAY_A);

		if (!is_array($dbResult) || !count($dbResult)) {
			WP_CLI::error(
				__('No checksums could be loaded.', SKYELLSAV_L10N)
			);
		}

		$readme = !!Utils\get_flag_value($assoc_args, 'skip-readme', true);

		$good = true;
		WP_CLI::log(
			sprintf(
				__('Scanning %d files.', SKYELLSAV_L10N),
				count($dbResult)
			)
		);

		// Scan them!
		foreach ($dbResult as $Row) {
			// Skipping readme files?
			if ($readme) {
				$filename = strtolower(basename($Row['file_path']));
				if (
					('readme.txt' === $filename) ||
					('readme.md' === $filename) ||
					('readme.html' === $filename)
				) {
					continue;
				}
			}

			$path = files::get_base_dir() . $Row['file_path'];
			if (!@is_file($path)) {
				$good = false;
				WP_CLI::warning(
					__('Missing', SKYELLSAV_L10N) . ": {$Row['file_path']}"
				);
			}
			else {
				try {
					if (false !== ($md5 = @md5_file($path))) {
						$md5 = core::md5($md5);
						if ($md5 !== $Row['checksum']) {
							$good = false;
							WP_CLI::warning(
								__('Modified', SKYELLSAV_L10N) . ": {$Row['file_path']}"
							);
						}
					}
					else {
						throw new \Exception('Scan error.');
					}
				} catch (\Throwable $e) {
					$good = false;
					WP_CLI::warning(
						__('Unreadable', SKYELLSAV_L10N) . ": {$Row['file_path']}"
					);
				} catch (\Exception $e) {
					$good = false;
					WP_CLI::warning(
						__('Unreadable', SKYELLSAV_L10N) . ": {$Row['file_path']}"
					);
				}
			}
		}

		if ($good) {
			WP_CLI::success(
				__('All checksums match.', SKYELLSAV_L10N)
			);
		}
		else {
			WP_CLI::error(
				__('Not all checksums match.', SKYELLSAV_L10N)
			);
		}

		return true;
	}
}
