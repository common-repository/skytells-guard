<?php
use Skytells\SFA\Foundation,
    Skytells\SFA\IP,
    Skytells\SFA\Core;
if (isset($_REQUEST['sfa_action']) && !empty($_REQUEST['sfa_action'])) {
if (!defined('ABSPATH') || !is_admin()) { exit("No Access"); }
  if ($_REQUEST['sfa_action'] == 'activate_sn' && isset($_REQUEST['sfa_sn'])) {
    @Foundation::doEvents($_REQUEST['sfa_sn'], true);
  }

  if ($_REQUEST['sfa_action'] == 'clearattackslog' && isset($_REQUEST['sfa_action'])) {
    @file_put_contents(SFA_PATH.'/Modules/firewall/Logs/attacks.json', '');
  }


  if ($_REQUEST['sfa_action'] == 'clearloginslog' && isset($_REQUEST['sfa_action'])) {
    global $SFA;
    global $wpdb;
    $wpdb->query("DELETE FROM {$wpdb->prefix}SFALogins");
  }


}

// Block IP
if (isset($_REQUEST['firewall_action']) && isset($_REQUEST['IP']) && !empty($_REQUEST['IP']) && $_REQUEST['firewall_action'] == 'blockip') {
  if (!defined('ABSPATH') || !is_admin()) { exit("No Access - EC: BIPA"); }
  global $SFA;
  if (!filter_var($_REQUEST['IP'], FILTER_VALIDATE_IP)) { exit("Incorrect IP Address Format."); }
  if (isset($_REQUEST['cfinform']) && $_REQUEST['cfinform'] == 'true') { IP::InformCloudFlare(); }
  $IP = SFA_Secure($_REQUEST['IP'], false, false, true, 'IP');
  IP::BanIP($IP);

}

// Unblock IP
if (isset($_REQUEST['firewall_action']) && isset($_REQUEST['IP']) && !empty($_REQUEST['IP']) && $_REQUEST['firewall_action'] == 'unblockip') {

  if (!defined('ABSPATH') || !is_admin()) { exit("No Access - - EC: UBIPA"); }
    if (!filter_var($_REQUEST['IP'], FILTER_VALIDATE_IP)) { exit("Incorrect IP Address Format."); }
    if (isset($_REQUEST['cfinform']) && $_REQUEST['cfinform'] == 'true') { IP::InformCloudFlare(); }
    $IP = SFA_Secure($_REQUEST['IP'], false, false, true, 'IP');
    IP::UnbanIP($IP, $_REQUEST['cid']);
}
