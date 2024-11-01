<?php
/**
 * Skytells-AV Security Scanner options.
 *
 * Admin settings, menus, etc.
 *
 * @package sky-av-security-scanner
 * @author  Skytells, Inc
 */

namespace skytells\wp\skyav;

use \skytells\wp\skyav\vendor\common;

class admin {

	const ASSET_VERSION = '20170415';
	const EXTENSIONS = array(
		'date',
		'filter',
		'json',
		'pcre',
		'spl',
	);

	protected static $errors = array();
	protected static $version;
	protected static $remote_version;
	protected static $remote_home;

	// -----------------------------------------------------------------
	// General
	// -----------------------------------------------------------------

	/**
	 * Warnings
	 *
	 * @return bool True/false.
	 */
	public static function warnings() {
		global $pagenow;

		// Only show warnings to administrators, and only on relevant pages.
		if (
			!current_user_can('manage_options') ||
			('plugins.php' !== $pagenow && false === static::current_screen())
		) {
			return true;
		}

		if (!files::can_write()) {
			static::$errors[] = sprintf(
				__('Several operations require the ability to write changes to the filesystem. This does not seem possible under the current configuration. See %s for possible workarounds.', SKYELLSAV_L10N),
				'<a href="https://codex.wordpress.org/Editing_wp-config.php#WordPress_Upgrade_Constants" target="_blank" rel="noopener">' . __('here', SKYELLSAV_L10N) . '</a>'
			);
		}

		if (options::get('license') && !options::is_pro()) {
			static::$errors[] = __('The Skytells-AV Security Scanner license is not valid for this domain or plugin; premium features have been disabled.', SKYELLSAV_L10N);
		}

		elseif (options::is_pro() && !extension_loaded('openssl')) {
			static::$errors[] = __('The recommended PHP extension OpenSSL is missing; this will slow down some operations.', SKYELLSAV_L10N);
		}

		// Only warn about Intl if it appears to be needed.
		if (
			function_exists('mb_check_encoding') &&
			!function_exists('idn_to_ascii') &&
			(!mb_check_encoding(site_url(), 'ASCII') || (false !== strpos(site_url(), 'xn--')))
		) {
			static::$errors[] = __('The recommended PHP extension Intl is missing; you will not be able to handle internationalized or unicode domains.', SKYELLSAV_L10N);
		}

		// All good!
		if (!count(static::$errors)) {
			return true;
		}

		?>
		<div class="notice notice-error">
			<p><?php
			echo sprintf(
				esc_html__('Your server does not meet the requirements for running %s. You or your system administrator should take a look at the following:', SKYELLSAV_L10N),
				'<strong>Skytells-AV Security Scanner</strong>'
			);
			?><br>
			&nbsp;&nbsp;&bullet;&nbsp;&nbsp;<?php echo implode('<br>&nbsp;&nbsp;&bullet;&nbsp;&nbsp;', static::$errors); ?></p>
		</div>
		<?php

		return false;
	}

	/**
	 * Fix Server Name
	 *
	 * WordPress generates its wp_mail() "from" address from
	 * $_SERVER['SERVER_NAME'], which doesn't always exist. This will
	 * generate something to use as a fallback for CLI instances, etc.
	 *
	 * @return void Nothing.
	 */
	public static function server_name() {
		if (!array_key_exists('SERVER_NAME', $_SERVER)) {
			if (false === $_SERVER['SERVER_NAME'] = common\sanitize::hostname(site_url(), false)) {
				$_SERVER['SERVER_NAME'] = 'localhost';
			}
		}
	}

	/**
	 * Update Notice
	 *
	 * This adds an update notice to the plugins page in cases where the
	 * plugin has been installed in Must-Use mode.
	 *
	 * @return void Nothing.
	 */
	public static function update_notice() {
		if (SKYELLSAV_MUST_USE) {
			$screen = get_current_screen();
			if (
				('plugins' === $screen->id) &&
				static::has_update()
			) {
				echo '<div class="notice notice-warning"><p>' . sprintf(
					esc_html__('%s %s has been released! Must-Use plugins must be updated manually, so click %s to download the new version.', SKYELLSAV_L10N),
					'<em>Skytells-AV Security Scanner</em>',
					'<code>' . static::$remote_version . '</code>',
					'<a href="' . static::$remote_home . '" target="_blank" rel="noopener">' . esc_html__('here', SKYELLSAV_L10N) . '</a>'
				) . '</p></div>';
			}
		}
	}

	/**
	 * Has Update?
	 *
	 * We need to query the API because WordPress won't check for
	 * updates if this plugin is installed as Must-Use.
	 *
	 * @return bool True/false.
	 */
	public static function has_update() {
		return (version_compare(static::get_version(), static::get_remote_version()) < 0);
	}

	/**
	 * Get Plugin Version
	 *
	 * @return string Version.
	 */
	public static function get_version() {
		if (is_null(static::$version)) {
			$plugin_data = get_plugin_data(SKYELLSAV_INDEX, false, false);
			if (isset($plugin_data['Version'])) {
				static::$version = $plugin_data['Version'];
			}
			else {
				static::$version = '0.0';
			}
		}

		return static::$version;
	}

	/**
	 * Get Remote Version
	 *
	 * @return string Version.
	 */
	public static function get_remote_version() {
		if (is_null(static::$remote_version)) {
			require_once(trailingslashit(ABSPATH) . 'wp-admin/includes/plugin.php');
			require_once(trailingslashit(ABSPATH) . 'wp-admin/includes/plugin-install.php');

			$response = plugins_api(
				'plugin_information',
				array('slug'=>'skytells-guard')
			);
			if (
				!is_wp_error($response) &&
				is_a($response, 'stdClass') &&
				isset($response->version)
			) {
				static::$remote_version = $response->version;
				static::$remote_home = $response->homepage;
			}
			else {
				static::$remote_version = '0.0';
			}
		}

		return static::$remote_version;
	}

	/**
	 * Localize
	 *
	 * @return void Nothing.
	 */
	public static function localize() {
		if (SKYELLSAV_MUST_USE) {
			load_muplugin_textdomain(SKYELLSAV_L10N, basename(SKYELLSAV_PLUGIN_DIR) . '/languages');
		}
		else {
			load_plugin_textdomain(SKYELLSAV_L10N, false, basename(SKYELLSAV_PLUGIN_DIR) . '/languages');
		}
	}

	/**
	 * Current Screen
	 *
	 * The WP Current Screen function isn't ready soon enough for our
	 * needs, so we need to get creative.
	 *
	 * @return bool|string WH screen type or false.
	 */
	public static function current_screen() {
		// Obviously this needs to be an admin page.
		if (!is_admin()) {
			return false;
		}

		// Could be a miscellaneous page.
		if (array_key_exists('page', $_GET)) {
			if (preg_match('/^skyav\-/', $_GET['page'])) {
				return $_GET['page'];
			}
		}


		if (array_key_exists('page', $_GET)) {
			if (preg_match('/^sfa\-/', $_GET['page'])) {
				return $_GET['page'];
			}
		}

		return false;
	}

	/**
	 * Sister Plugins
	 *
	 * Get a list of other plugins by Blobfolio.
	 *
	 * @return array Plugins.
	 */
	public static function sister_plugins() {
		require_once(trailingslashit(ABSPATH) . 'wp-admin/includes/plugin.php');
		require_once(trailingslashit(ABSPATH) . 'wp-admin/includes/plugin-install.php');
		$response = plugins_api(
			'query_plugins',
			array(
				'author'=>'skytells',
				'per_page'=>20,
			)
		);

		if (!isset($response->plugins) || !is_array($response->plugins)) {
			return array();
		}

		// We want to know whether a plugin is on the system, not
		// necessarily whether it is active.
		$plugin_base = trailingslashit(WP_PLUGIN_DIR);
		$mu_base = defined('WPMU_PLUGIN_DIR') ? trailingslashit(WPMU_PLUGIN_DIR) : false;

		$plugins = array();
		foreach ($response->plugins as $p) {
			if (
				('sky-av-security-scanner' === $p->slug) ||
				file_exists("{$plugin_base}{$p->slug}") ||
				($mu_base && file_exists("{$mu_base}{$p->slug}"))
			) {
				continue;
			}

			$plugins[] = array(
				'name'=>$p->name,
				'slug'=>$p->slug,
				'description'=>$p->short_description,
				'url'=>$p->homepage,
				'version'=>$p->version,
			);
		}

		usort(
			$plugins,
			function($a, $b) {
				if ($a['name'] === $b['name']) {
					return 0;
				}

				return $a['name'] > $b['name'] ? 1 : -1;
			}
		);

		return $plugins;
	}

	// ----------------------------------------------------------------- end general



	// -----------------------------------------------------------------
	// Menus & Pages
	// -----------------------------------------------------------------

	/**
	 * Register Scripts & Styles
	 *
	 * Register our assets and enqueue some of them maybe.
	 *
	 * @return bool True/false.
	 */
	public static function enqueue_scripts() {
		if (
			!current_user_can('manage_options') ||
(false === ($screen = static::current_screen()))
		) {
			return false;
		}

		// Find our CSS and JS roots. Easy if this
		// is a regular plugin.
		$js = SKYELLSAV_PLUGIN_URL . 'js/';
		$css = SKYELLSAV_PLUGIN_URL . 'css/';

		// Prism CSS.
		wp_register_style(
			'skyav_css_prism',
			"{$css}prism.css",
			array(),
			static::ASSET_VERSION
		);
		if (\Skytells\SFA::CL() &&  in_array($screen, array('skyav-scan'), true) ) {
			wp_enqueue_style('skyav_css_prism');
		}

		if (\Skytells\SFA::CL() &&  in_array($screen, array('sfa-scanner'), true) ) {
			wp_enqueue_style('skyav_css_prism');
		}




		// Main CSS.
		wp_register_style(
			'skyav_css',
			"{$css}core.css",
			array(),
			static::ASSET_VERSION
		);
		wp_enqueue_style('skyav_css');

		// Clipboard JS.
		wp_register_script(
			'skyav_js_clipboard',
			"{$js}clipboard.min.js",
			array(),
			static::ASSET_VERSION,
			true
		);

		// Prism JS.
		wp_register_script(
			'skyav_js_prism',
			"{$js}prism.min.js",
			array('skyav_js_clipboard'),
			static::ASSET_VERSION,
			true
		);

		// Vue JS.
		wp_register_script(
			'skyav_js_vue',
			"{$js}vue.min.js",
			array('jquery'),
			static::ASSET_VERSION,
			true
		);

		// Analysis JS.
		wp_register_script(
			'skyav_js_analysis',
			"{$js}core-analysis.min.js",
			array(
				'skyav_js_vue',
			),
			static::ASSET_VERSION,
			true
		);
		if ('skyav-analysis' === $screen) {
			wp_enqueue_script('skyav_js_analysis');
		}

		if ('sfa-analysis' === $screen) {
			wp_enqueue_script('skyav_js_analysis');
		}

		// Vulnerability JS.
		wp_register_script(
			'skyav_js_exploits',
			"{$js}core-exploits.min.js",
			array(
				'skyav_js_vue',
			),
			static::ASSET_VERSION,
			true
		);
		if ('skyav-exploits' === $screen) {
			wp_enqueue_script('skyav_js_exploits');
		}

		if ('sfa-exploits' === $screen) {
			wp_enqueue_script('skyav_js_exploits');
		}

		if ('sfa-vulnerabilities-scanner' === $screen) {
			wp_enqueue_script('skyav_js_exploits');
		}

		// Pro JS.
		wp_register_script(
			'skyav_js_pro',
			"{$js}core-pro.min.js",
			array(
				'skyav_js_vue',
			),
			static::ASSET_VERSION,
			true
		);
		if ('skyav-pro' === $screen) {
			wp_enqueue_script('skyav_js_pro');
		}

		// Scan JS.
		wp_register_script(
			'skyav_js_scan',
			"{$js}core-scan.min.js",
			array(
				'skyav_js_vue',
				'skyav_js_prism',
			),
			static::ASSET_VERSION,
			true
		);
		if ('skyav-scan' === $screen) {
			wp_enqueue_script('skyav_js_scan');
		}


		if ('sfa-scanner' === $screen) {
			wp_enqueue_script('skyav_js_scan');
		}


		return true;
	}

	/**
	 * Register Menus
	 *
	 * @return void Nothing.
	 */
	public static function register_menus() {
		$pages = array(
			'scan',
			'analysis',
			'exploits',
			'pro',
			'rename',
		);
		$class = get_called_class();

		foreach ($pages as $page) {
			add_action('admin_menu', array($class, "{$page}_menu"));
		}


		// Register plugins page quick links if we aren't running in
		// Must-Use mode.
		if (!SKYELLSAV_MUST_USE) {
			add_filter('plugin_action_links_' . plugin_basename(SKYELLSAV_INDEX), array($class, 'plugin_action_links'));
		}
	}

	/**
	 * File Scan Menu
	 *
	 * @return bool True/false.
	 */
	public static function scan_menu() {
		add_menu_page(
			__('File Scan', SKYELLSAV_L10N),
			__('File Scan', SKYELLSAV_L10N),
			'manage_options',
			'skyav-scan',
			array(get_called_class(), 'scan_page'),
			'dashicons-search'
		);

		return true;
	}

	/**
	 * File Scan Page
	 *
	 * @return bool True/false.
	 */
	public static function scan_page() {
		require(SKYELLSAV_PLUGIN_DIR . 'admin/scan.php');
		return true;
	}

	/**
	 * Configuration Analysis Menu
	 *
	 * @return bool True/false.
	 */
	public static function analysis_menu() {
		add_submenu_page(
			'skyav-scan',
			__('Configuration Analysis', SKYELLSAV_L10N),
			__('Configuration Analysis', SKYELLSAV_L10N),
			'manage_options',
			'skyav-analysis',
			array(get_called_class(), 'analysis_page')
		);

		return true;
	}

	/**
	 * Configuration Analysis Page
	 *
	 * @return bool True/false.
	 */
	public static function analysis_page() {
		require(SKYELLSAV_PLUGIN_DIR . 'admin/analysis.php');
		return true;
	}

	/**
	 * Plugin/Theme Analysis Menu
	 *
	 * @return bool True/false.
	 */
	public static function exploits_menu() {
		add_submenu_page(
			'skyav-scan',
			__('Plugin & Theme Vulnerabilities', SKYELLSAV_L10N),
			__('Plugin & Theme Vulnerabilities', SKYELLSAV_L10N),
			'manage_options',
			'skyav-exploits',
			array(get_called_class(), 'exploits_page')
		);

		return true;
	}

	/**
	 * Plugin/Theme Analysis Page
	 *
	 * @return bool True/false.
	 */
	public static function exploits_page() {
		// Different path for Pro users because of license restrictions.
		if (options::is_pro()) {
			require(SKYELLSAV_PLUGIN_DIR . 'admin/exploits-pro.php');
		}
		else {
			require(SKYELLSAV_PLUGIN_DIR . 'admin/exploits.php');
		}
		return true;
	}

	/**
	 * Pro License
	 *
	 * @return bool True/false.
	 */
	public static function pro_menu() {
		add_submenu_page(
			'skyav-scan',
			__('Pro License', SKYELLSAV_L10N),
			__('Pro License', SKYELLSAV_L10N),
			'manage_options',
			'skyav-pro',
			array(get_called_class(), 'pro_page')
		);

		return true;
	}

	/**
	 * Pro Page
	 *
	 * @return bool True/false.
	 */
	public static function pro_page() {
		require(SKYELLSAV_PLUGIN_DIR . 'admin/pro.php');
		return true;
	}

	/**
	 * Rename Menu
	 *
	 * We want to change the main menu name but leave the main submenu
	 * link as is. This requires a bit of a hack after the menu has
	 * been populated.
	 *
	 * @return void Nothing.
	 */
	public static function rename_menu() {
		global $menu;
		$tmp = array_reverse($menu, true);
		foreach ($tmp as $k=>$v) {
			if (!is_array($v) || count($v) < 3) {
				continue;
			}
			if (isset($v[2]) && ('skyav-scan' === $v[2])) {
				$menu[$k][0] = 'Skytells AV';
				break;
			}
		}
		unset($tmp);
		remove_menu_page( 'skyav-scan' );
	}

	/**
	 * Plugin Links
	 *
	 * Add some quick links to the entry on the plugins page.
	 *
	 * @param array $links Links.
	 * @return array Links.
	 */
	public static function plugin_action_links($links) {
		// File Scan.
		$links[] = '<a href="' . esc_url(admin_url('admin.php?page=skyav-scan')) . '">' . esc_html__('Scan', SKYELLSAV_L10N) . '</a>';

		// License.
		if (!options::is_pro()) {
			$links[] = '<a href="' . esc_url(admin_url('admin.php?page=skyav-pro')) . '">' . esc_html__('Enter License', SKYELLSAV_L10N) . '</a>';
		}

		return $links;
	}

	// ----------------------------------------------------------------- end menus

}
