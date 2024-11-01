<?php
/**
 * Skytells-AV Security Scanner Cron.
 *
 * Scheduled tasks.
 *
 * @package sky-av-security-scanner
 * @author  Skytells, Inc
 */

namespace skytells\wp\skyav;

use \skytells\wp\skyav\vendor\common;

class cron {

	protected static $_init;

	// -----------------------------------------------------------------
	// Init/Setup
	// -----------------------------------------------------------------

	/**
	 * Init
	 *
	 * Run a couple things early on so the environment is ready for us.
	 *
	 * @return void Nothing.
	 */
	public static function init() {
		if (!static::$_init) {
			static::$_init = true;

			$class = get_called_class();

			// Scheduling is a Pro feature.
			$timestamp = wp_next_scheduled('skyav_cron_scan');
			if (options::is_pro()) {
				// CRON setup.
				add_filter('cron_schedules', array($class, 'cron_schedules'));
				add_action('skyav_cron_scan', array($class, 'scan'));

				// Schedule the event if needed.
				if (false === $timestamp) {
					wp_schedule_event(time() + 60, 'oneminute', 'skyav_cron_scan');
				}
			}
			// Unschedule the event.
			elseif (false !== $timestamp) {
				wp_unschedule_event($timestamp, 'skyav_cron_scan');
			}

			// Transient Cleanup.
			add_action('skyav_cron_expired_transients', array($class, 'expired_transients'));
			if (false === ($timestamp = wp_next_scheduled('skyav_cron_expired_transients'))) {
				wp_schedule_event(time(), 'daily', 'skyav_cron_expired_transients');
			}
		}
	}

	// ----------------------------------------------------------------- end init



	// -----------------------------------------------------------------
	// Filters
	// -----------------------------------------------------------------

	/**
	 * Cron Frequencies
	 *
	 * Certain operations, like scheduled scans, need more frequent
	 * scheduling options than "once an hour". Haha.
	 *
	 * @param array $schedules Schedules.
	 * @return array Schedules.
	 */
	public static function cron_schedules($schedules) {
		// Every minute.
		$schedules['oneminute'] = array(
			'interval'=>60,
			'display'=>'Every 1 minute',
		);

		// Every other minute.
		$schedules['twominutes'] = array(
			'interval'=>120,
			'display'=>'Every 2 minutes',
		);

		// Every five minutes.
		$schedules['fiveminutes'] = array(
			'interval'=>300,
			'display'=>'Every 5 minutes',
		);

		return $schedules;
	}

	// ----------------------------------------------------------------- end filters



	// -----------------------------------------------------------------
	// Actions
	// -----------------------------------------------------------------

	/**
	 * Expired Transients
	 *
	 * WordPress only cleans up expired transient data when/if that key
	 * is requested. If that never happens, the data lives on in the
	 * database indefinitely.
	 *
	 * Skytells-AV leverages the WordPress transient cache system heavily,
	 * so could end up contributing a lot of bloat. So let's clean up
	 * after ourselves!
	 *
	 * @return bool True/false.
	 */
	public static function expired_transients() {
		global $wpdb;

		// Give it a couple days to account for timezone shifts.
		$cutoff = strtotime('-2 days');
		$dbResult = $wpdb->get_results("
			SELECT `option_name`
			FROM `{$wpdb->options}`
			WHERE
				`option_name` LIKE '_transient_timeout_skyav%' AND
				`option_value` < $cutoff
			ORDER BY `option_value` ASC
		", ARRAY_A);
		if (is_array($dbResult) && count($dbResult)) {
			foreach ($dbResult as $Row) {
				$key = substr($Row['option_name'], 19);
				delete_transient($key);
			}
		}

		return true;
	}

	/**
	 * Scheduled Scans
	 *
	 * Start or continue a scheduled scan.
	 *
	 * @return bool True/false.
	 */
	public static function scan() {
		$schedule = options::get('schedule');
		if (!$schedule['active']) {
			echo 'false';
			return false;
		}

		// Nothing already happening?
		if (false === ($scan = scan::get_open_scan(true))) {
			// Start a scan!
			if ($schedule['date_next'] < current_time('mysql')) {
				// Bump the next date.
				$schedule['date_next'] = options::calculate_date_next();
				options::save('schedule', $schedule);

				// Make a scan!
				$scan = new scan();
				return $scan->save(array('scheduled'=>1));
			}

			echo 'no scan';
			return false;
		}

		// Run the next step!
		$scan->scan();

		// Are we done? Do we need to notify the user?
		if (
			('finished' === $scan->get_status()) &&
			$schedule['email']
		) {
			$scan->email();
		}

		return true;
	}

	// ----------------------------------------------------------------- end actions
}
