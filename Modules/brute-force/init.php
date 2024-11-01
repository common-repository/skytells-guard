<?php
if (!defined('ABSPATH')) { exit; }
use Skytells\SFA\Dashboard;
require_once ABSPATH . '/wp-admin/includes/file.php';
require_once 'includes/htaccess.php';

class SFABruteForce {

    public $__options, $__htaccess;

    /**
     * Initializes $__options and $__htaccess.
     * Interacts with WordPress hooks.
     *
     * @return void
     */
    public function __construct() {
        //Default options
        $this->__setDefaultOptions();

        //Instantiate SFAHtaccess class
        $this->__htaccess = new SFAHtaccess();

        //Activation and deactivation hooks
        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));

        //Init hooks
        add_action('plugins_loaded', array($this, 'init'));
        add_action('admin_init', array($this, 'adminInit'));
        add_action('admin_menu', array($this, 'menuInit'));

      //  add_action('admin_menu', array($this, 'menuInit'));



        if ((bool)get_option('SFA_bruteforce') !== false) {
          //Login hooks
          add_action('wp_login_failed', array($this, 'loginFailed'));
          add_action('wp_login', array($this, 'loginSucceeded'));

          //Auth cookie hooks
          add_action('auth_cookie_bad_username', array($this, 'loginFailed'));
          add_action('auth_cookie_bad_hash', array($this, 'loginFailed'));
        }

    }

    /**
     * Called once any activated plugins have been loaded.
     *
     * @return void
     */
    public function init() {
        //Load textdomain for i18n
        load_plugin_textdomain('sfa-brute-force', false, dirname(plugin_basename(__FILE__)) . '/languages/');
    }

    /**
     * Called when a user accesses the admin area.
     *
     * @return void
     */
    public function adminInit() {
        //Register plugin settings
        $this->__registerOptions();

        //Set htaccess path
        $this->__setSFAHtaccessPath();

        //Call checkRequirements to check for .htaccess errors
        add_action('admin_notices', array($this, 'showRequirementsErrors'));
    }

    /**
     * Called after the basic admin panel menu structure is in place.
     *
     * @return void
     */
    public function menuInit() {
        //Add settings page to the Settings menu
        Dashboard::InitModule(__('Brute Force', 'sfa-brute-force'), 'Brute Force', 'sfa-brute-force',
        array($this, 'showSettingsPage'));
      //  add_options_page(__('Skytells Brute Force Settings', 'sfa-brute-force'), 'Skytells Brute Force', 'manage_options', 'sfa-brute-force', array($this, 'showSettingsPage'));
    }

    /**
     * Called When the plugin is activated
     *
     * @return boolean
     */
    public function activate() {
        $this->__setSFAHtaccessPath();
        $this->__htaccess->uncommentLines();
    }

    /**
     * Called When the plugin is deactivated
     *
     * @return boolean
     */
    public function deactivate() {
        $this->__htaccess->commentLines();
    }

    /**
     * Checks requirements and shows errors
     *
     * @return void
     */
    public function showRequirementsErrors() {
        $status = $this->__htaccess->checkRequirements();

        if (!$status['found']) {
            $this->__showError(__('Skytells Brute Force error: .htaccess file not found', 'sfa-brute-force'));
        } elseif (!$status['readable']) {
            $this->__showError(__('Skytells Brute Force error: .htaccess file not readable', 'sfa-brute-force'));
        } elseif (!$status['writeable']) {
            $this->__showError(__('Skytells Brute Force error: .htaccess file not writeable', 'sfa-brute-force'));
        }
    }

    /**
     * Shows settings page and handles user actions.
     *
     * @return void
     */
    public function showSettingsPage() {
        if (isset($_POST['IP'])) {
            $IP = $_POST['IP'];
            if (!filter_var($IP, FILTER_VALIDATE_IP)) {
                return false;
                $this->__showError(sprintf(__('Incorrect IP format.', 'sfa-brute-force'), SFA_Secure($IP, true, true)));
            }
            if (isset($_POST['block'])) { //Manually block IP
                $whitelist = $this->__getWhitelist();
                if (in_array($IP, $whitelist)) {
                    $this->__showError(sprintf(__('You can\'t block a whitelisted IP', 'sfa-brute-force'), $IP));
                } elseif ($this->__htaccess->denyIP($IP)) {
                    $this->__showMessage(sprintf(__('IP %s blocked', 'sfa-brute-force'), $IP));
                } else {
                    $this->__showError(sprintf(__('An error occurred while blocking IP %s', 'sfa-brute-force'), $IP));
                }
            } elseif (isset($_POST['unblock'])) { //Unblock IP
                if ($this->__htaccess->undenyIP($IP)) {
                    $this->__showMessage(sprintf(__('IP %s unblocked', 'sfa-brute-force'), $IP));
                } else {
                    $this->__showError(sprintf(__('An error occurred while unblocking IP %s', 'sfa-brute-force'), $IP));
                }
            } elseif (isset($_POST['whitelist'])) { //Add IP to whitelist
                if ($this->__whitelistIP($IP)) {
                    $this->__showMessage(sprintf(__('IP %s added to whitelist', 'sfa-brute-force'), $IP));
                } else {
                    $this->__showError(sprintf(__('An error occurred while adding IP %s to whitelist', 'sfa-brute-force'), $IP));
                }
            } elseif (isset($_POST['unwhitelist'])) { //Remove IP from whitelist
                if ($this->__unwhitelistIP($IP)) {
                    $this->__showMessage(sprintf(__('IP %s removed from whitelist', 'sfa-brute-force'), $IP));
                } else {
                    $this->__showError(sprintf(__('An error occurred while removing IP %s from whitelist', 'sfa-brute-force'), $IP));
                }
            }
        } elseif (isset($_POST['reset'])) { //Reset settings
            $this->__htaccess->remove403Message();
            $this->__deleteOptions();
            $this->__setDefaultOptions();
            $this->__setSFAHtaccessPath();
            $this->__showMessage(sprintf(__('The Options have been successfully reset', 'sfa-brute-force'), $IP));
        }

        $this->__fillOptions();
        \Skytells\SFA\UI::render('Modules.BruteForce', ['options' => $this->__options, 'htaccess' => $this->__htaccess, 'ctl' => $this]);
        //include 'includes/settings-page.php';
    }

    /**
     * Called when a user login has failed
     * Increase number of attempts for clients IP. Deny IP if max attempts is reached.
     *
     * @return void
     */
    public function loginFailed() {
        $IP = $this->__getClientIP();
        $whitelist = $this->__getWhitelist();

        if (!in_array($IP, $whitelist)) {
            $this->__fillOptions();

            sleep($this->__options['login_failed_delay']);

            $attempts = get_option('bflp_login_attempts');
            if (!is_array($attempts)) {
                $attempts = array();
                add_option('bflp_login_attempts', $attempts, '', 'no');
            }

            $denyIP = false;
            if ($IP && isset($attempts[$IP]) && $attempts[$IP]['time'] > (time() - ($this->__options['reset_time'] * 60))) {
                $attempts[$IP]['attempts'] ++;
                if ($attempts[$IP]['attempts'] >= $this->__options['allowed_attempts']) {
                    $denyIP = true;
                    unset($attempts[$IP]);
                } else {
                    $attempts[$IP]['time'] = time();
                }
            } else {
                $attempts[$IP]['attempts'] = 1;
                $attempts[$IP]['time'] = time();
            }

            update_option('bflp_login_attempts', $attempts);

            if ($denyIP) {
                if ($this->__options['send_email']) {
                    $this->__sendEmail($IP);
                }
                $this->__setSFAHtaccessPath();
                $this->__htaccess->denyIP($IP);
                header('HTTP/1.0 403 Forbidden');
                die($this->__options['403_message']);
            }

            if ($this->__options['inform_user']) {
                global $error;
                $remainingAttempts = $this->__options['allowed_attempts'] - $attempts[$IP]['attempts'];
                $error .= '<br />';
                $error .= sprintf(_n("%d attempt remaining.", "%d attempts remaining.", $remainingAttempts, 'sfa-brute-force'), $remainingAttempts);
            }
        }
    }

    /**
     * Called when a user has successfully logged in
     * Removes IP from bflp_login_attempts if exist.
     *
     * @return void
     */
    public function loginSucceeded() {
        $attempts = get_option('bflp_login_attempts');
        if (is_array($attempts)) {
            $IP = $this->__getClientIP();
            if (isset($attempts[$IP])) {
                unset($attempts[$IP]);
                update_option('bflp_login_attempts', $attempts);
            }
        }
    }

    /**
     * Settings validation functions
     */

    /**
     * Validates bflp_allowed_attempts field.
     *
     * @param mixed $input
     * @return int
     */
    public function validateAllowedAttempts($input) {
        if (is_numeric($input) && ($input >= 1 && $input <= 100)) {
            return $input;
        } else {
            add_settings_error('bflp_allowed_attempts', 'bflp_allowed_attempts', __('Allowed login attempts must be a number (between 1 and 100)', 'sfa-brute-force'));
            $this->__fillOption('allowed_attempts');
            return $this->__options['allowed_attempts'];
        }
    }

    /**
     * Validates bflp_reset_time field.
     *
     * @param mixed $input
     * @return int
     */
    public function validateResetTime($input) {
        if (is_numeric($input) && $input >= 1) {
            return $input;
        } else {
            add_settings_error('bflp_reset_time', 'bflp_reset_time', __('Minutes before resetting must be a number (higher than 1)', 'sfa-brute-force'));
            $this->__fillOption('reset_time');
            return $this->__options['reset_time'];
        }
    }

    /**
     * Validates bflp_login_failed_delay field.
     *
     * @param mixed $input
     * @return int
     */
    public function validateLoginFailedDelay($input) {
        if (is_numeric($input) && ($input >= 1 && $input <= 10)) {
            return $input;
        } else {
            add_settings_error('bflp_login_failed_delay', 'bflp_login_failed_delay', __('Failed login delay must be a number (between 1 and 10)', 'sfa-brute-force'));
            $this->__fillOption('login_failed_delay');
            return $this->__options['login_failed_delay'];
        }
    }

    /**
     * Saves bflp_403_message field to .htaccess.
     *
     * @param mixed $input
     * @return string
     */
    public function validate403Message($input) {
        $message = htmlentities($input);

        if ($this->__htaccess->edit403Message($message)) {
            return $message;
        } else {
            add_settings_error('bflp_403_message', 'bflp_403_message', __('An error occurred while saving the blocked users message', 'sfa-brute-force'));
            $this->__fillOption('403_message');
            return $this->__options['403_message'];
        }
    }

    /**
     * Private functions
     */

    /**
     * Sets htaccess path to $__options['htaccess_dir'].
     *
     * @return void
     */
    public function __setSFAHtaccessPath() {
        $this->__fillOption('htaccess_dir');
        $this->__htaccess->setPath($this->__options['htaccess_dir']);
    }

    /**
     * Sets default options into $__options
     *
     * @return void
     */
    public function __setDefaultOptions() {
        $this->__options = array(
            'allowed_attempts'   => 20, //Allowed login attempts before deny,
            'reset_time'         => 60, //Minutes before resetting login attempts count
            'login_failed_delay' => 1, //Delay in seconds when a user login has failed
            'inform_user'        => true, //Inform user about remaining login attempts on login page
            'send_email'         => false, //Send email to administrator when an IP has been blocked
            '403_message'        => '', //Message to show to a blocked user
            'htaccess_dir'       => get_home_path() //.htaccess file location
        );
    }

    /**
     * Registers options (settings).
     *
     * @return void
     */
    public function __registerOptions() {
        register_setting('sfa-brute-force', 'bflp_allowed_attempts', array($this, 'validateAllowedAttempts'));
        register_setting('sfa-brute-force', 'bflp_reset_time', array($this, 'validateResetTime'));
        register_setting('sfa-brute-force', 'bflp_login_failed_delay', array($this, 'validateLoginFailedDelay'));
        register_setting('sfa-brute-force', 'bflp_inform_user');
        register_setting('sfa-brute-force', 'bflp_send_email');
        register_setting('sfa-brute-force', 'bflp_403_message', array($this, 'validate403Message'));
        register_setting('sfa-brute-force', 'bflp_htaccess_dir');
    }

    /**
     * Deletes options from database.
     *
     * @return void
     */
    public function __deleteOptions() {
        delete_option('bflp_allowed_attempts');
        delete_option('bflp_reset_time');
        delete_option('bflp_login_failed_delay');
        delete_option('bflp_inform_user');
        delete_option('bflp_send_email');
        delete_option('bflp_403_message');
        delete_option('bflp_htaccess_dir');
    }

    /**
     * Fills options with value (from database).
     *
     * @return void
     */
    public function __fillOptions() {
        $this->__options['allowed_attempts'] = get_option('bflp_allowed_attempts', $this->__options['allowed_attempts']);
        $this->__options['reset_time'] = get_option('bflp_reset_time', $this->__options['reset_time']);
        $this->__options['login_failed_delay'] = get_option('bflp_login_failed_delay', $this->__options['login_failed_delay']);
        $this->__options['inform_user'] = get_option('bflp_inform_user', $this->__options['inform_user']);
        $this->__options['send_email'] = get_option('bflp_send_email', $this->__options['send_email']);
        $this->__options['403_message'] = get_option('bflp_403_message', $this->__options['403_message']);
    }

    /**
     * Fills single option with value (from database).
     *
     * @param string $name
     * @return void
     */
    private function __fillOption($name) {
        $this->__options[$name] = get_option('bflp_' . $name, $this->__options[$name]);
    }

    /**
     * Returs array of whitelisted IP addresses.
     *
     * @return array
     */
    public function __getWhitelist() {
        $whitelist = get_option('bflp_whitelist');

        if (!is_array($whitelist)) {
            return array();
        }

        return $whitelist;
    }

    /**
     * Adds IP to whitelist.
     *
     * @param string $IP
     * @return boolean
     */
    public function __whitelistIP($IP) {
        if (!filter_var($IP, FILTER_VALIDATE_IP)) {
            return false;
        }

        $this->__htaccess->undenyIP($IP);

        $whitelist = get_option('bflp_whitelist');
        if (!is_array($whitelist)) {
            $whitelist = array($IP);
            return add_option('bflp_whitelist', $whitelist, '', 'no');
        }

        $whitelist[] = $IP;

        return update_option('bflp_whitelist', array_unique($whitelist));
    }

    /**
     * Removes IP from whitelist.
     *
     * @param string $IP
     * @return boolean
     */
    public function __unwhitelistIP($IP) {
        if (!filter_var($IP, FILTER_VALIDATE_IP)) {
            return false;
        }

        $whitelist = get_option('bflp_whitelist');
        if (!is_array($whitelist)) {
            return false;
        }

        $IPKey = array_search($IP, $whitelist);

        if ($IPKey === false) {
            return false;
        }

        unset($whitelist[$IPKey]);

        return update_option('bflp_whitelist', $whitelist);
    }

    /**
     * Returns the client ip address.
     *
     * @return mixed
     */
    public function __getClientIP() {
        return $_SERVER['REMOTE_ADDR'];
    }

    /**
     * Sends email to admin with info about blocked IP
     *
     * @return mixed
     */
    public function __sendEmail($IP) {
        $to = get_option('admin_email');
        $subject = sprintf(__('IP %s has been blocked', 'sfa-brute-force'), $IP);
        $message = sprintf(__('Skytells Brute Force has blocked IP %s from access to %s on %s', 'sfa-brute-force'), $IP, get_site_url(), date('Y-m-d H:i:s'));

        return wp_mail($to, $subject, $message);
    }

    /**
     * Echoes message with class 'updated'.
     *
     * @param string $message
     * @return void
     */
    public function __showMessage($message) {
        echo '<div class="updated"><p>' . esc_html($message) . '</p></div>';
    }

    /**
     * Echoes message with class 'error'.
     *
     * @param string $message
     * @return void
     */
    public function __showError($message) {
        echo '<div class="error"><p>' . esc_html($message) . '</p></div>';
    }

}
