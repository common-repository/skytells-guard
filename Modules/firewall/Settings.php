<?php
if (!defined('ABSPATH') ) { exit("No Direct Access"); }
use Skytells\SFA\Dashboard;
use Skytells\SFA\UI;
Class SFAFirewall {
  private $__options;

  public function __construct() {
    $this->__setDefaultOptions();

      //Activation and deactivation hooks
      register_activation_hook(__FILE__, array($this, 'activate'));
      register_deactivation_hook(__FILE__, array($this, 'deactivate'));
      add_action('init', array('Skytells_Firewall', 'startSession'), 1);
      add_action('admin_menu', array($this, 'menuInit'));
      add_action('admin_init', array($this, 'adminInit'));

  }

  public function adminInit() {

    $this->__registerOptions();
  }
  public function menuInit() {
    Dashboard::InitModule(__('Firewall', 'sfa-firewall'), 'Firewall', 'sfa-firewall', array($this, 'SettingsPage'));
  }


  public function __showError($message) {
      echo '<div class="error"><p>' . esc_html($message) . '</p></div>';
  }

  public function Notify($message, $type = 'success', $icon = 'ti-gift') {
    UI::render('Alerts.Notify', ['message' => $message, 'type' => $type, 'icon' => $icon]);
  }

  public function SettingsPage() {
    if (isset($_POST['reset'])) { //Reset settings
        $this->__deleteOptions();
        $this->__setDefaultOptions();

    }
    $this->__fillOptions();

    UI::render('Modules.Firewall', ['options' => $this->__options]);


    if (isset($_POST['reset'])) {
      $this->Notify(__('The Options have been successfully reset'));
    }
  }
  public function activate() {

  }


  public function deactivate() {

  }


  private function __setDefaultOptions() {
      $this->__options = array(
          'status'         => false,
          'whitelisted'    => '',
          'ddos_exp'       => '1',
          'ddos_status'    => true,
          'send_email'     => false,
          'block_fake_googlebots' => false,
          'allowedchars'  => '/[^a-z0-9-=&#_]+/i',
          'whitelisted_ips' => '',
          'block_empty_ref_ips' => false,
          'block_ip_notification' => true,
          'force_ssl'      => false,
          'protected_urls' => '',
          'IPBanExpiry' => '365 days',
          'ddos_tries' => '5',
          'ddos_block_ip' => false,
          'DDoS_Tries_Expiry' => 30,
          'blockedmessage' => "<title>Blocked</title><h1 style='padding-left:30px; padding-top:15px;'>You've been blocked!</h1>
          <hr>
               <p style='padding-left:30px; padding-top:15px;'>You're blocked from accessing this website.</p>"
      );
  }

  private function __fillOption($name) {
      $this->__options[$name] = get_option('skfw_' . $name, $this->__options[$name]);
  }

  public function __deleteOptions() {
      delete_option('skfw_status');
      delete_option('skfw_ddos_status');
      delete_option('skfw_send_email');
      delete_option('skfw_whitelisted');
      delete_option('skfw_allowedchars');
      delete_option('skfw_blockedmessage');
      delete_option('skfw_block_fake_googlebots');
      delete_option('skfw_whitelisted_ips');
      delete_option('skfw_block_empty_ref_ips');
      delete_option('skfw_ddos_exp');
      delete_option('skfw_block_ip_notification');
      delete_option('skfw_force_ssl');
      delete_option('skfw_protected_urls');
      delete_option('skfw_IPBanExpiry');
      delete_option('skfw_DDoS_Tries_Expiry');
  }

  private function __registerOptions() {
      register_setting('sfa-firewall', 'skfw_status');
      register_setting('sfa-firewall', 'skfw_ddos_status');
      register_setting('sfa-firewall', 'skfw_send_email');
      register_setting('sfa-firewall', 'skfw_whitelisted', array($this, 'validateWitelisted'));
      register_setting('sfa-firewall', 'skfw_allowedchars', array($this, 'validateAllowedChars'));
      register_setting('sfa-firewall', 'skfw_blockedmessage', array($this, 'validateblockedmessage'));
      register_setting('sfa-firewall', 'skfw_block_fake_googlebots');
      register_setting('sfa-firewall', 'skfw_whitelisted_ips');
      register_setting('sfa-firewall', 'skfw_block_empty_ref_ips');
      register_setting('sfa-firewall', 'skfw_ddos_exp');
      register_setting('sfa-firewall', 'skfw_block_ip_notification');
      register_setting('sfa-firewall', 'skfw_force_ssl');
      register_setting('sfa-firewall', 'skfw_protected_urls');
      register_setting('sfa-firewall', 'skfw_IPBanExpiry', array($this, 'validateIPBanExpiry'));

      register_setting('sfa-firewall', 'skfw_ddos_tries');
      register_setting('sfa-firewall', 'skfw_ddos_block_ip');
      register_setting('sfa-firewall', 'skfw_DDoS_Tries_Expiry');





  }

  public function validateAllowedChars($input) {
    if (!empty($input)) {
        return $input;
    } else {
        add_settings_error('skfw_allowedchars', 'skfw_allowedchars', __('Allowed Chars cannot be empty', 'sfa-firewall'));
        $this->__fillOption('allowedchars');
        return $this->__options['allowedchars'];
    }
  }

  public function validateWitelisted($input) {
      return $input;
  }

  public function validateIPBanExpiry($input) {
    $dates = ['seconds', 'minutes', 'hours', 'days', 'months', 'years'];
    if (!empty($input) && in_array($input, $dates)) {
      return $input;
    }else {
      add_settings_error('skfw_IPBanExpiry', 'skfw_IPBanExpiry', __('Error: Incorrect IP Ban Expiry value format', 'sfa-firewall'));
      $this->__fillOption('IPBanExpiry');
      return $this->__options['IPBanExpiry'];
    }

    return $input;
  }

  public function validateblockedmessage($input) {
    if (!empty($input)) {
        return $input;
    } else {
        add_settings_error('skfw_blockedmessage', 'skfw_blockedmessage', __('Blocked Message cannot be empty', 'sfa-firewall'));
        $this->__fillOption('blockedmessage');
        return $this->__options['blockedmessage'];
    }
  }


  private function __fillOptions() {
      $this->__options['status'] = get_option('skfw_status', $this->__options['status']);
      $this->__options['ddos_status'] = get_option('skfw_ddos_status', $this->__options['ddos_status']);
      $this->__options['ddos_exp'] = get_option('skfw_ddos_exp', $this->__options['ddos_exp']);
      $this->__options['allowedchars'] = get_option('skfw_allowedchars', $this->__options['allowedchars']);
      $this->__options['whitelisted'] = get_option('skfw_whitelisted', $this->__options['whitelisted']);
      $this->__options['blockedmessage'] = get_option('skfw_blockedmessage', $this->__options['blockedmessage']);
      $this->__options['send_email'] = get_option('skfw_send_email', $this->__options['send_email']);
      $this->__options['block_fake_googlebots'] = get_option('skfw_block_fake_googlebots', $this->__options['block_fake_googlebots']);
      $this->__options['whitelisted_ips'] = get_option('skfw_whitelisted_ips', $this->__options['whitelisted_ips']);
      $this->__options['block_empty_ref_ips'] = get_option('skfw_block_empty_ref_ips', $this->__options['block_empty_ref_ips']);
      $this->__options['block_ip_notification'] = get_option('skfw_block_ip_notification', $this->__options['block_ip_notification']);
      $this->__options['force_ssl'] = get_option('skfw_force_ssl', $this->__options['force_ssl']);
      $this->__options['protected_urls'] = get_option('skfw_protected_urls', $this->__options['protected_urls']);
      $this->__options['IPBanExpiry'] = get_option('skfw_IPBanExpiry', $this->__options['IPBanExpiry']);

      $this->__options['ddos_tries'] = (int)get_option('skfw_ddos_tries', $this->__options['ddos_tries']);
      $this->__options['ddos_block_ip'] = get_option('skfw_ddos_block_ip', $this->__options['ddos_block_ip']);
      $this->__options['DDoS_Tries_Expiry'] = (int)get_option('skfw_DDoS_Tries_Expiry', $this->__options['DDoS_Tries_Expiry']);

  }







}
