<?php
/**
 * Skytells-AV Security Scanner CLI.
 *
 * Yay WP-CLI!
 *
 * @package sky-av-security-scanner
 * @author  Skytells, Inc
 */

namespace skytells\wp\skyav;

use \skytells\wp\skyav\vendor\common;
use \WP_CLI;
use \WP_CLI\Formatter;
use \WP_CLI\Utils;

// Add the main command.
if (!class_exists('WP_CLI') || !class_exists('WP_CLI_Command')) {
	return;
}

if (WP_CLI::add_command(
	'sky-av',
	SKYELLSAV_BASE_CLASS . 'cli',
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
)) {
	// Bootstrap the subcommands.
	foreach (array('checksums', 'scan') as $class) {
		require_once(dirname(__FILE__) . "/cli/$class.php");
	}
}

/**
 * Skytells-AV Security Scanner
 *
 * Look-see Security Scanner is designed to help you quickly and easily
 * spot the sorts of file system irregularities that happen when a site
 * is hacked.
 *
 * ## EXAMPLES
 *
 *     wp skyav --help
 */
class cli extends \WP_CLI_Command {

	/**
	 * Configuration Analysis
	 *
	 * Check the WordPress configuration for various issues, room for
	 * improvement, etc.
	 *
	 * @return bool True.
	 */
	public function analyze() {
		$warnings = array();

		if (!core::analyze_administrators()) {
			$warnings[__('Administrator Accounts', SKYELLSAV_L10N)] = array(
				sprintf(
					__('Generic usernames like "admin" or "administrator" are present and should be renamed. Plugins like %s (pro) and %s can help with this.', SKYELLSAV_L10N),
					WP_CLI::colorize('%yhttps://wordpress.org/plugins/apocalypse-meow/%n'),
					WP_CLI::colorize('%yhttps://wordpress.org/plugins/rename-users/%n')
				),
			);
		}

		if (!core::analyze_salts(true)) {
			$warnings[__('Authentication Salts & Keys', SKYELLSAV_L10N)] = array(
				sprintf(
					__('Your site contains weak and/or missing authentication salts. Visit %s and copy the output into %s.', SKYELLSAV_L10N),
					WP_CLI::colorize('%yhttps://api.wordpress.org/secret-key/1.1/salt/%n'),
					'wp-config.php'
				),
			);
		}

		if (!core::analyze_prefix()) {
			$warnings[__('Database Prefix', SKYELLSAV_L10N)] = array(
				sprintf(
					__('Your site is currently using the default table prefix, %s. It is not completely straightforward to retroactively fix this, however %s can point you in the right direction.', SKYELLSAV_L10N),
					'"wp_"',
					WP_CLI::colorize('%yhttp://www.wpbeginner.com/wp-tutorials/how-to-change-the-wordpress-database-prefix-to-improve-security/%n')
				),
			);
		}

		if (!core::analyze_index()) {
			$warnings[__('Directory Listing', SKYELLSAV_L10N)] = array(
				sprintf(
					__('Your site currently lists directory contents. For example, click %s. For information on how to fix this, visit %s.', SKYELLSAV_L10N),
					WP_CLI::colorize('%yhttp:' . SKYELLSAV_PLUGIN_URL . 'img/%n'),
					WP_CLI::colorize('%yhttps://www.netsparker.com/blog/web-security/disable-directory-listing-web-servers/%n')
				),
			);
		}

		if (!core::analyze_editor()) {
			$warnings[__('File Editor', SKYELLSAV_L10N)] = array(
				sprintf(
					__('The editor is currently enabled on your site. To disable it, add the following code to %s:', SKYELLSAV_L10N),
					'wp-config.php'
				),
				WP_CLI::colorize("%Mdefine('DISALLOW_FILE_EDIT', true);%n"),
			);
		}

		if (!core::analyze_scan()) {
			$warnings[__('File Scans', SKYELLSAV_L10N)] = array(
				sprintf(
					__('You have not completed a file scan recently. Click %s to do that now.', SKYELLSAV_L10N),
					WP_CLI::colorize('%y' . admin_url('admin.php?page=skyav-scan') . '%n')
				),
			);
		}

		if (!core::analyze_ssl()) {
			$warnings[__('SSL', SKYELLSAV_L10N)] = array(
				__('It appears that your site might not be fully protected with SSL. Skytells-AV is not able to determine this with 100% accuracy, so if this assessment is wrong, please ignore it.', SKYELLSAV_L10N),
				sprintf(
					__("Otherwise, you're in for a treat! For a rundown on how to get an existing WordPress web site up and running over SSL, click %s.", SKYELLSAV_L10N),
					WP_CLI::colorize('%yhttps://skytells.com/2017/07/how-to-enable-ssl-for-wordpress/%n')
				),
			);
		}

		if (!core::analyze_svg()) {
			$warnings[__('SVG', SKYELLSAV_L10N)] = array(
				sprintf(
					__('SVG support has been manually enabled for your site, leaving you at extreme risk. In order to protect yourself, please install %s.', SKYELLSAV_L10N),
					WP_CLI::colorize('%yhttps://wordpress.org/plugins/blob-mimes/%n')
				),
			);
		}

		$inactive = array();
		if (!core::analyze_inactive_plugins()) {
			$tmp = core::get_plugins();
			foreach ($tmp as $k=>$v) {
				if (!$v['active']) {
					$inactive[] = WP_CLI::colorize('%m' . __('Plugin', SKYELLSAV_L10N) . '%n') . ": . {$v['name']}";
				}
			}
		}
		if (!core::analyze_inactive_themes()) {
			$tmp = core::get_themes();
			foreach ($tmp as $k=>$v) {
				if (!$v['active']) {
					$inactive[] = WP_CLI::colorize('%m' . __('Theme', SKYELLSAV_L10N) . '%n') . ": . {$v['name']}";
				}
			}
		}
		if (count($inactive)) {
			$warnings[__('Inactive Plugins & Themes', SKYELLSAV_L10N)] = array(
				__('The following inactive content is still publicly accessible on your server. You should fully delete any content you are not using.', SKYELLSAV_L10N),
			);
			foreach ($inactive as $v) {
				$warnings[__('Inactive Plugins & Themes', SKYELLSAV_L10N)][] = $v;
			}
		}

		if (!core::analyze_updates()) {
			$warnings[__('Updates & Security Patches', SKYELLSAV_L10N)] = array(
				sprintf(
					__('Your copy of WordPress is not fully up-to-date. Please head on over to %s to apply all available updates.', SKYELLSAV_L10N),
					WP_CLI::colorize('%y' . admin_url('update-core.php') . '%n')
				),
			);
		}

		if (count($warnings)) {
			foreach ($warnings as $k=>$v) {
				WP_CLI::log('');
				WP_CLI::warning($k);
				foreach ($v as $v2) {
					WP_CLI::log(wordwrap($v2));
				}
			}
			WP_CLI::log('');
		}
		else {
			WP_CLI::success(
				__('No warnings were detected. Great job!', SKYELLSAV_L10N)
			);
		}

		return true;
	}

	/**
	 * Plugin & Theme Vulnerabilities
	 *
	 * Pull WPScan Vulnerability Database links for installed plugins
	 * and themes.
	 *
	 * @param array $args N/A.
	 * @param array $assoc_args Flags.
	 * @return bool True.
	 */
	public function vulnerabilities($args=null, $assoc_args=array()) {
		$content = array(
			'plugin'=>core::get_plugins(),
			'theme'=>core::get_themes(),
		);

		$fixed = !!Utils\get_flag_value($assoc_args, 'include-fixed');

		$total = count($content['plugin']) + count($content['theme']);

		$headers = array(
			__('Name', SKYELLSAV_L10N),
			__('URL', SKYELLSAV_L10N),
		);

		$progress = Utils\make_progress_bar(__('Querying wpvulndb', SKYELLSAV_L10N), $total);
		$out = array();

		foreach ($content as $k=>$v) {
			foreach ($v as $v2) {
				$progress->tick();
				if (false === ($url = core::get_vulnerabilities_url($v2['slug'], $k))) {
					continue;
				}

				$out[] = array(
					'Name'=>$v2['name'],
					'URL'=>$url,
				);
			}
		}

		$progress->finish();

		if (count($out)) {
			WP_CLI::warning(
				__('The following plugins and themes have vulnerability references.', SKYELLSAV_L10N)
			);
			Utils\format_items('table', $out, $headers);
		}
		else {
			WP_CLI::success(
				__('No vulnerability references were found.', SKYELLSAV_L10N)
			);
		}

		return true;
	}

	/**
	 * Skytells-AV Security Scanner Status
	 *
	 * This plugin allows a WordPress site to be scanned for file
	 * changes, exploits, etc.
	 *
	 * This command displays information about the locally-installed
	 * version.
	 *
	 * @return bool True.
	 */
	public function version() {
		// Ain't localization a bitch? Haha.
		$translated = array(
			'Author'=>__('Author', SKYELLSAV_L10N),
			'Company'=>__('Company', SKYELLSAV_L10N),
			'Copyright'=>__('Copyright', SKYELLSAV_L10N),
			'developer'=>__('Developer', SKYELLSAV_L10N),
			'Domains'=>__('Domains', SKYELLSAV_L10N),
			'Download'=>__('Download', SKYELLSAV_L10N),
			'Email'=>__('Email', SKYELLSAV_L10N),
			'External'=>__('External', SKYELLSAV_L10N),
			'freeload'=>__('Freeload Edition', SKYELLSAV_L10N),
			'Installed'=>__('Installed', SKYELLSAV_L10N),
			'Latest'=>__('Latest', SKYELLSAV_L10N),
			'License'=>__('License', SKYELLSAV_L10N),
			'Must-Use'=>__('Must-Use', SKYELLSAV_L10N),
			'N/A'=>__('N/A', SKYELLSAV_L10N),
			'Name'=>__('Name', SKYELLSAV_L10N),
			'No'=>__('No', SKYELLSAV_L10N),
			'Plugin'=>__('Plugin', SKYELLSAV_L10N),
			'Premium'=>__('Premium', SKYELLSAV_L10N),
			'Purchased'=>__('Purchased', SKYELLSAV_L10N),
			'single'=>__('Single', SKYELLSAV_L10N),
			'Timezone'=>__('Timezone', SKYELLSAV_L10N),
			'Type'=>__('Type', SKYELLSAV_L10N),
			'Upgrade'=>__('Upgrade', SKYELLSAV_L10N),
			'WordPress'=>__('WordPress', SKYELLSAV_L10N),
			'Yes'=>__('Yes', SKYELLSAV_L10N),
		);

		// Start gathering data.
		$out = array(
			$translated['Plugin']=>array(
				$translated['Name']=>about::get_local('Name'),
				$translated['Author']=>about::get_local('Author'),
				$translated['Premium']=>options::is_pro() ? $translated['Yes'] : $translated['No'],
				$translated['Must-Use']=>SKYELLSAV_MUST_USE ? $translated['Yes'] : $translated['No'],
				$translated['Timezone']=>about::get_timezone(),
				$translated['Installed']=>about::get_local('Version'),
				$translated['Latest']=>about::get_remote('version'),
				$translated['Upgrade']=>(version_compare(
						about::get_local('Version'),
						about::get_remote('version')
					) < 0) ? $translated['Yes'] : $translated['No'],
			),
		);

		// Output license information where applicable.
		if (options::is_pro()) {
			$license = license::get(options::get('license'));
			$license = $license->get_license();
			$out[$translated['License']] = array(
				$translated['Type']=>$translated[$license['type']],
				$translated['Purchased']=>$license['date_created'],
				$translated['Name']=>$license['name'],
				$translated['Company']=>$license['company'],
				$translated['Domains']=>('single' === $license['type']) ? implode('; ', $license['domains']) : $translated['N/A'],
			);
		}

		// Put together some external links.
		$out[$translated['External']] = array(
			'Blobfolio'=>SKYELLSAV_URL,
			$translated['WordPress']=>about::get_local('Plugin URI'),
			$translated['Download']=>about::get_remote('download_link'),
			$translated['Email']=>SKYELLSAV_EMAIL,
		);

		// We have to build our own damn table because WP-CLI's
		// formtter isn't really meant for in-row headers.
		$key_width = 0;
		foreach ($translated as $v) {
			$length = common\mb::strlen($v);
			if ($length > $key_width) {
				$key_width = $length;
			}
		}
		$key_width += 4;

		$value_width = 0;
		foreach ($out as $v) {
			foreach ($v as $v2) {
				$length = common\mb::strlen($v2);
				if ($length > $value_width) {
					$value_width = $length;
				}
			}
		}
		$value_width += 2;

		$row_width = $key_width + $value_width;

		$num = 0;
		foreach ($out as $k=>$v) {
			$num++;

			if (1 === $num) {
				WP_CLI::log(
					'+' . str_repeat('-', $row_width) . '+'
				);
			}
			WP_CLI::log(
				'|' .
				common\mb::str_pad($k, $row_width, ' ', STR_PAD_BOTH) .
				'|'
			);
			WP_CLI::log(
				'+' . str_repeat('-', $row_width) . '+'
			);

			foreach ($v as $k2=>$v2) {
				WP_CLI::log(
					'|' .
					WP_CLI::colorize('%B' . common\mb::str_pad("$k2:", ($key_width - 1), ' ', STR_PAD_LEFT) . '%n') . ' ' .
					common\mb::str_pad("$v2", $value_width, ' ', STR_PAD_RIGHT) .
					'|'
				);
			}

			WP_CLI::log(
				'+' . str_repeat('-', $row_width) . '+'
			);
		}

		return true;
	}

}
