<?php
Namespace Skytells\SFA;
Class SFA_Module {

  public static function InitSlimModules() {
    if ((bool)get_option('SFA_TCProtection', false)) {
      require SFA_PATH.'/Modules/TCProtection/Init.php';
      \Skytells\SFA\TCProtection::Start();
    }
  }

  public static function InitAdminFirewall() {
    if ((bool)get_option('skfw_status') === TRUE && (bool)get_option('SFA_firewall') == true) {
      \Skytells_Firewall::getReady(true);
    }
  }
}
