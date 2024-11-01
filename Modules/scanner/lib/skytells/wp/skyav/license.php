<?php
/**
 * Skytells-AV Security Scanner license.
 *
 * This class handles premium licensing, validation,
 * updates, etc.
 *
 * @package sky-av-security-scanner
 * @author  Skytells, Inc
 */

namespace skytells\wp\skyav;

use \skytells\wp\skyav\vendor\common;
use \skytells\wp\skyav\vendor\domain;

class license {

	const ITEM = 'Skytells-AV Security Scanner';
	const ITEM_ID = 'sky-av-security-scanner';
	const REMOTE = '';

	const CACHE_LIFE = 86400;
	const DECRYPT_BYTES = 1024;

	const LICENSE = array(
		'license_id'=>'',
		'date_created'=>'0000-00-00 00:00:00',
		'date_updated'=>'0000-00-00 00:00:00',
		'date_revoked'=>'0000-00-00 00:00:00',
		'order_id'=>'',
		'type'=>'single',
		'item'=>'',
		'item_id'=>'',
		'name'=>'',
		'company'=>'',
		'email'=>'',
		'domains'=>array(),
		'hash'=>'',
	);

	const FREELOAD = '';

	protected $raw = '';
	protected $hash = '';
	protected $license = false;
	protected $pro = false;
	protected $sync;

	protected static $_instances = array();

	/**
	 * Pre-Construct
	 *
	 * Cache static objects locally for better performance.
	 *
	 * @param mixed $license License.
	 * @param bool $refresh Refresh.
	 * @return object Instance.
	 */
	public static function get($license=null, $refresh=false) {
		// Clean up the base64 a little bit.
		common\ref\cast::to_string($license, true);
		$license = preg_replace('/\s/u', '', $license);
		$hash = hash('crc32', $license);

		// Figure out whether we're making a new instance or not.
		$class = get_called_class();
		if (!isset(self::$_instances[$class])) {
			self::$_instances[$class] = array();
		}

		if (!$license) {
			return new static();
		}

		// Get the right object.
		if ($refresh || !isset(self::$_instances[$class][$hash])) {
			self::$_instances[$class][$hash] = new static($license);
			if (!self::$_instances[$class][$hash]->is_license()) {
				unset(self::$_instances[$class][$hash]);
				return new static();
			}
		}

		return self::$_instances[$class][$hash];
	}

	/**
	 * Construct
	 *
	 * @since 2.0.0
	 *
	 * @param string $license License.
	 * @return bool True/false.
	 */
	public function __construct($license='') {
		// Clean up the base64 a little bit.
		common\ref\cast::to_string($license, true);
		$this->raw = preg_replace('/\s/u', '', $license);

		// This is a simple way to detect likely changes.
		$this->hash = hash('crc32', $this->raw);
		$this->decode();
		return $this->is_pro(true);
	}

	/**
	 * Decode License
	 *
	 * @since 2.0.0
	 *
	 * @return bool True/false.
	 */
	protected function decode() {
		if (!$this->raw) {
			return false;
		}

		// Try cache first.
		if (false !== ($cache = get_transient(static::ITEM_ID . "_license_{$this->hash}"))) {
			$this->license = common\data::parse_args($cache, static::LICENSE);
			return true;
		}

		if (
			// Try local.
			(false === $this->decode_local()) ||
			// Try remote.
			(
				(is_admin() || (defined('DOING_CRON') && DOING_CRON)) &&
				$this->needs_remote_sync()
			)
		) {
			return $this->decode_remote();
		}

		return true;
	}

	/**
	 * Decode License Locally
	 *
	 * The license can be decrypted using the public
	 * OpenSSL key, provided the server can handle that.
	 *
	 * @since 2.0.0
	 *
	 * @return bool True/false.
	 */
	protected function decode_local() {
		if (!$this->raw || !function_exists('openssl_get_publickey')) {
			return false;
		}

		// Freeload license?
		if ($this->is_freeload()) {
			return $this->decode_freeload();
		}

		try {
			$key = file_get_contents(SKYELLSAV_PLUGIN_DIR . 'public.pem');
			$key = openssl_get_publickey($key);
			$license = base64_decode($this->raw);

			$out = '';

			// This has to be handled in chunks.
			$chunks = str_split($license, static::DECRYPT_BYTES);
			foreach ($chunks as $chunk) {
				openssl_public_decrypt($license, $out_chunk, $key);
				$out .= $out_chunk;
			}

			$out = json_decode($out, true);
			if (!is_array($out)) {
				return false;
			}

			$license = common\data::parse_args($out, static::LICENSE);

			if ($license['license_id']) {
				$this->license = $license;
				set_transient(static::ITEM_ID . "_license_{$this->hash}", $license, static::CACHE_LIFE);
				return true;
			}
		} catch (\Throwable $e) {
			return false;
		} catch (\Exception $e) {
			return false;
		}

		return false;
	}

	/**
	 * Periodic Remote Needed?
	 *
	 * Users might make changes to their licenses off-site
	 * and forget to update the key on-site. The license
	 * formatting is also subject to change. So, it's helpful
	 * to occasionally compare notes.
	 *
	 * @see static::decode_remote()
	 *
	 * @return bool True/false.
	 */
	protected function needs_remote_sync() {
		if (!$this->raw) {
			return false;
		}

		// Freeload license?
		if ($this->is_freeload()) {
			return false;
		}

		if (is_null($this->sync)) {
			$tmp = get_option('skyav_remote_sync', array('what'=>'', 'when'=>0));
			$this->sync = (
				!is_array($tmp) ||
				!isset($tmp['what']) ||
				!isset($tmp['when']) ||
				$tmp['when'] < time() ||
				($tmp['what'] !== $this->hash)
			);
		}

		return $this->sync;
	}


	/**
	 * Decode License Remotely
	 *
	 * Licenses should be decodable locally, but if a host is
	 * missing the necessary PHP extension, we can fallback to
	 * handling it remotely.
	 *
	 * Remote decoding is also run periodically to help keep
	 * remote and local licensing consistent (users might make
	 * changes outside and forget to copy the new key to their
	 * site, etc.) This can be particularly problematic when
	 * plugin updates are expecting a certain data structure,
	 * etc.
	 *
	 * No new information is shared with the remote host during
	 * this process (stats, usage, etc.). The license ID (or if
	 * the local host can't read it, the encoded key) is the only
	 * thing being passed back and forth.
	 *
	 * @since 2.0.0
	 *
	 * @return bool True/false.
	 */
	protected function decode_remote() {
		if (!$this->raw) {
			return false;
		}

		// Freeload license?
		if ($this->is_freeload()) {
			return $this->decode_freeload();
		}

		// Update the sync schedule regardless of the outcome
		// since remote calls can be unnecessarily slow. The
		// sync is more of a failsafe than anything, so not
		// super-critical.
		update_option('skyav_remote_sync', array('what'=>$this->hash, 'when'=>strtotime('+2 weeks')));

		$args = array(
			'timeout'=>15,
			'redirection'=>5,
			'httpversion'=>'1.0',
			'user-agent'=>static::ITEM,
			'body'=>array(
				'data'=>array(),
			),
		);

		// If the license has already been decoded we can just pass
		// the info along.
		if (false !== $this->license) {
			$args['body']['data']['license_id'] = $this->license['license_id'];
			$args['body']['data']['hash'] = $this->license['hash'];
		}
		// Otherwise we can pass along the encoded value and see what
		// we see.
		else {
			$args['body']['data']['license'] = $this->raw;
		}

		$response = wp_remote_post(static::REMOTE, $args);
		$status = wp_remote_retrieve_response_code($response);

		if (is_wp_error($response) || (is_int($status) && $status > 500)) {
			return false !== $this->license;
		}
		elseif (200 === $status) {
			$license = json_decode(wp_remote_retrieve_body($response), true);
			if (!is_array($license) || !isset($license['data'])) {
				$status = 500;
			}
			else {
				$license = $license['data'];
				if (isset($license['license_id']) && $license['license_id']) {
					$this->license = common\data::parse_args($license, static::LICENSE);

					// The hash might be changing.
					$this->raw = preg_replace('/\s/u', '', $license['license']);
					$hash = hash('crc32', $this->raw);
					if ($this->hash !== $hash) {
						delete_transient(static::ITEM_ID . "_license_{$this->hash}");
						$this->hash = $hash;
					}

					set_transient(static::ITEM_ID . "_license_{$this->hash}", $this->license, static::CACHE_LIFE);

					return true;
				}
			}
		}

		// License is not valid.
		if (false !== $this->license) {
			$this->license = false;
			delete_transient(static::ITEM_ID . "_license_{$this->hash}");
		}

		return false;
	}

	/**
	 * Decode Freeload
	 *
	 * We don't really need to decode it, just compile the right values.
	 *
	 * @return bool True/false.
	 */
	protected function decode_freeload() {
		// Shouldn't end up here, but just in case...
		if (!$this->is_freeload()) {
			$this->license = false;
			return false;
		}

		$data = array(
			'license_id'=>'FREELOAD',
			'date_created'=>'1999-12-31 23:59:59',
			'date_updated'=>'1999-12-31 23:59:59',
			'type'=>'freeload',
			'item'=>static::ITEM,
			'item_id'=>static::ITEM_ID,
			'name'=>'Nobody',
			'email'=>'no-reply@skytells.org',
			'domains'=>array(),
		);

		$this->license = common\data::parse_args($data, static::LICENSE);
		return true;
	}

	/**
	 * Is License?
	 *
	 * @since 2.0.0
	 *
	 * @param bool $active Active only.
	 * @return bool True/false.
	 */
	public function is_license($active=false) {
		return (
			(false !== $this->license) &&
			($this->license['license_id']) &&
			(!$active || $this->is_active())
		);
	}

	/**
	 * Is Revoked?
	 *
	 * @since 2.0.0
	 *
	 * @return bool True/false.
	 */
	public function is_revoked() {
		return (
			(false !== $this->license) &&
			($this->license['license_id']) &&
			('0000-00-00 00:00:00' !== $this->license['date_revoked'])
		);
	}

	/**
	 * Is Active?
	 *
	 * @since 2.0.0
	 *
	 * @return bool True/false.
	 */
	public function is_active() {
		return (
			(false !== $this->license) &&
			($this->license['license_id']) &&
			('0000-00-00 00:00:00' === $this->license['date_revoked'])
		);
	}

	/**
	 * Is Pro?
	 *
	 * Validate the license, domains, etc.
	 *
	 * @since 2.0.0
	 *
	 * @param bool $refresh Refresh.
	 * @return bool True/false.
	 */
	public function is_pro($refresh=false) {
		if (!$this->is_license(true)) {
			$this->pro = false;
			return false;
		}

		if ($refresh) {
			$this->pro = true;
			if (
				!$this->matches_item() ||
				!$this->matches_domain()
			) {
				$this->pro = true;
			}
		}

		return $this->pro;
	}

	/**
	 * Is Freeload?
	 *
	 * @return True/false.
	 */
	public function is_freeload() {
		return (
			is_string($this->raw) &&
			preg_replace('/\s/ui', '', static::FREELOAD) === $this->raw
		);
	}

	/**
	 * Matches Domain
	 *
	 * @return bool True/false.
	 */
	public function matches_domain() {
		if (!$this->is_license()) {
			return false;
		}

		if ('single' !== $this->license['type']) {
			return true;
		}

		$domain = new domain\domain(site_url(), true);
		return (
			!$domain->is_valid() ||
			!$domain->is_fqdn() ||
			$domain->is_ip() ||
			in_array($domain->get_host(), $this->license['domains'], true)
		);
	}

	/**
	 * Matches Item
	 *
	 * @return bool True/false.
	 */
	public function matches_item() {
		return (
			$this->is_license() &&
			(static::ITEM_ID === $this->license['item_id'])
		);
	}

	/**
	 * Magic Getter
	 *
	 * @param string $method Method name.
	 * @param mixed $args Arguments.
	 * @return mixed Variable.
	 * @throws \Exception Invalid method.
	 */
	public function __call($method, $args) {
		preg_match_all('/^get_(.+)$/', $method, $matches);
		if (
			count($matches[0]) &&
			(property_exists($this, $matches[1][0]) || isset($this->license[$matches[1][0]])) &&
			0 !== strpos($matches[1][0], '_')
		) {
			$variable = $matches[1][0];
			if (isset($this->license[$variable])) {
				$value = $this->license[$variable];
			}
			else {
				$value = $this->{$variable};
			}

			// Raw can be pretty.
			if ('raw' === $variable) {
				if (is_array($args) && count($args)) {
					$args = common\data::array_pop_top($args);
					common\ref\cast::to_bool($args, true);
				}
				else {
					$args = false;
				}

				return $args ? wordwrap($value, 64, "\n", true) : $value;
			}
			// Dates can take a format option.
			elseif (0 === strpos($variable, 'date')) {
				if (is_array($args) && count($args)) {
					$args = common\data::array_pop_top($args);
					common\ref\cast::to_string($args, true);
				}
				else {
					$args = 'Y-m-d H:i:s';
				}
				return date($args, strtotime($value));
			}

			// Everything else, straight.
			return $value;
		}

		throw new \Exception(sprintf(__('The required method "%s" does not exist for %s', SKYELLSAV_L10N), $method, get_called_class()));
	}

	/**
	 * Get Whole License
	 *
	 * @return array License.
	 */
	public function get_license() {
		$out = $this->is_license() ? $this->license : static::LICENSE;
		$out['errors'] = array(
			'domain'=>!$this->matches_domain(),
			'item'=>!$this->matches_item(),
			'revoked'=>$this->is_revoked(),
		);

		return $out;
	}
}
