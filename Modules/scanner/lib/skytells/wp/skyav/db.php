<?php
/**
 * Skytells-AV Security Scanner database.
 *
 * This class manages the database extensions.
 *
 * @package sky-av-security-scanner
 * @author  Skytells, Inc
 */

namespace skytells\wp\skyav;

use \skytells\wp\skyav\vendor\common;

class db {
	const VERSION = '3.1.4';

	// Core, Plugin, Theme checksums.
	const SCHEMA_CORE = "CREATE TABLE %PREFIX%skyav3_core (
  type enum('core','plugin','theme') NOT NULL DEFAULT 'core',
  slug char(20) NOT NULL DEFAULT '',
  version int(10) UNSIGNED NOT NULL DEFAULT '0',
  file_hash char(20) NOT NULL DEFAULT '',
  file_path text NOT NULL,
  checksum char(20) NOT NULL DEFAULT '',
  PRIMARY KEY  (type,slug,version,file_hash),
  KEY checksum (checksum)
) %CHARSET%;";

	// Scan metadata.
	const SCHEMA_SCANS = "CREATE TABLE %PREFIX%skyav3_scans (
  scan_id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  user_id int(10) UNSIGNED NOT NULL DEFAULT '0',
  scheduled tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  date_created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  date_finished timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  status enum('created','building-core','building-plugins','building-themes','building-local','building-history','scanning','finished') NOT NULL DEFAULT 'created',
  tries tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  details text NOT NULL,
  error enum('','timeout','user-abort','other') NOT NULL DEFAULT '',
  PRIMARY KEY  (scan_id),
  KEY date_created (date_created),
  KEY date_finished (date_finished),
  KEY status (status),
  KEY tries (tries)
) %CHARSET%;";

	// Scan files.
	const SCHEMA_SCAN_FILES = "CREATE TABLE %PREFIX%skyav3_scan_files (
  scan_id bigint(20) UNSIGNED NOT NULL,
  file_hash char(20) NOT NULL,
  file_path text NOT NULL,
  type enum('','core','plugin','theme') NOT NULL DEFAULT '',
  date_scanned timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  checksum_expected char(20) NOT NULL DEFAULT '',
  checksum char(20) NOT NULL DEFAULT '',
  mime varchar(100) NOT NULL DEFAULT '',
  size bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  date_modified timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  chmod smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  chown varchar(65) NOT NULL DEFAULT '',
  tries tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  status enum('','timeout','skipped','new','deleted','modified','ok') NOT NULL DEFAULT '',
  PRIMARY KEY  (scan_id,file_hash),
  KEY type (type),
  KEY date_scanned (date_scanned),
  KEY checksum_expected (checksum_expected),
  KEY checksum (checksum),
  KEY tries (tries),
  KEY status (status)
) %CHARSET%;";

	// Scan files.
	const SCHEMA_SCAN_WARNINGS = "CREATE TABLE %PREFIX%skyav3_scan_warnings (
  warning_id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  scan_id bigint(20) UNSIGNED NOT NULL,
  file_hash char(20) NOT NULL,
  warning enum('chmod','chown','core-extra','core-missing','core-modified','core-old','dev-file','mime','php-eval','php-gibberish','php-phpinfo','php-system','timeout') NOT NULL DEFAULT 'timeout',
  PRIMARY KEY  (warning_id),
  KEY scan_id (scan_id,file_hash),
  KEY warning (warning)
) %CHARSET%;";


	/**
	 * Check if DB upgrade is needed.
	 *
	 * @since 21.0.0
	 *
	 * @return bool True/false.
	 */
	public static function check() {
		global $wpdb;

		// Don't let willynilly traffic trigger this.
		if (
			!is_admin() &&
			(!defined('WP_CLI') || !WP_CLI) &&
			(!defined('DOING_CRON') || !DOING_CRON)
		) {
			return false;
		}

		$installed = (string) get_option('skyav_db_version', '0');
		if (!preg_match('/^\d+(\.\d+)*$/', $installed) || !static::has_tables()) {
			$installed = 0;
		}

		if (version_compare($installed, static::VERSION) < 0) {
			return static::upgrade($installed);
		}

		return true;
	}

	/**
	 * Has Tables?
	 *
	 * A MySQL error might prevent the necessary tables from being
	 * created.
	 *
	 * @return bool True/false.
	 */
	public static function has_tables() {
		global $wpdb;

		$tables = array(
			"{$wpdb->prefix}skyav3_core",
			"{$wpdb->prefix}skyav3_scan_files",
			"{$wpdb->prefix}skyav3_scan_warnings",
			"{$wpdb->prefix}skyav3_scans",
		);

		foreach ($tables as $v) {
			if (is_null($wpdb->get_var("SHOW TABLES LIKE '$v'"))) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Do Upgrade
	 *
	 * @since 21.0.0
	 *
	 * @param string $version Installed version.
	 * @return bool True/false.
	 */
	public static function upgrade($version=null) {
		global $wpdb;
		require_once(trailingslashit(ABSPATH) . 'wp-admin/includes/upgrade.php');

		// WordPress might get called multiple times while this is
		// running. Let's go ahead and update the version string
		// early to mitigate parallel runs.
		update_option('skyav_db_version', static::VERSION);

		// Swap out our placeholders with real WP data.
		$replace_keys = array(
			'%PREFIX%',
			'%CHARSET%',
		);
		$replace_values = array(
			$wpdb->prefix,
			$wpdb->get_charset_collate(),
		);

		// Personalize the code.
		$tables = array(
			static::SCHEMA_CORE,
			static::SCHEMA_SCANS,
			static::SCHEMA_SCAN_FILES,
			static::SCHEMA_SCAN_WARNINGS,
		);
		foreach ($tables as $k=>$v) {
			$tables[$k] = str_replace($replace_keys, $replace_values, $v);
		}

		// Parse it.
		dbDelta($tables);

		// Maybe run a few migration-type tasks.
		return static::migrate();
	}

	/**
	 * Do Migrate
	 *
	 * Older versions of the plugin used a different data structure. We
	 * aren't referencing the old data anywhere, so let's remove it to
	 * keep things tidy.
	 *
	 * @since 21.0.0
	 *
	 * @return bool True.
	 */
	public static function migrate() {
		global $wpdb;

		// Old tables.
		$old = array(
			"{$wpdb->prefix}skyav2_core",
			"{$wpdb->prefix}skyav2_files",
			"{$wpdb->prefix}skyav_files",
		);
		foreach ($old as $v) {
			$wpdb->query("DROP TABLE IF EXISTS `$v`");
		}

		// Old options.
		$old = array(
			'skyav_checksum_version',
			'skyav_core_version',
			'skyav_file_permissions',
			'skyav_inside',
			'skyav_max_size',
			'skyav_scan',
			'skyav_scan_report',
			'skyav_skip_cache',
		);
		foreach ($old as $v) {
			delete_option($v);
		}

		return true;
	}
}
