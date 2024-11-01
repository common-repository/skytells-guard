<?php
Namespace Skytells\SFA;
use Skytells\SFA\Mailer;
Class Activities {

  public static function getRecentLogins($LIMIT = 25) {
    global $SFA;
    $LIMIT = (int)$LIMIT;
    $SFA->db->orderBy("id","desc");
    return $SFA->db->get('SFALogins', $LIMIT);
  }


  public static function addLogin($user) {
    global $SFA;
    $geo = \Skytells\SFA\GeoIP::getInfo(getenv('REMOTE_ADDR'));
    $OS = \Skytells\Controllers\HTTP::getOS();
    $Browser = \Skytells\Controllers\HTTP::getBrowser();
    $Data = [
      "username" => $user,
      "stamp" => getStamp(),
      "ip"       => getenv('REMOTE_ADDR'),
      "os"       => $OS,
      "browser"  =>  $Browser,
      'country' => $geo->country_name,
      'country_code' => $geo->country_code,
      'region' => $geo->region_name,
      'region_code' => $geo->region_code,
      'state'  => $geo->region_code,
      'city' => $geo->city,
      'zipcode' => $geo->zip_code,
      'geo' => $geo->latitude.','.$geo->longitude,
      'status' => 'SUCCESS'
    ];

    $status = $SFA->db->insert('SFALogins', $Data);
    \Skytells\SFA\Reports::UpdateDailyReports('Logins');
    if ((bool)get_option('SFA_LoginNotifications') == true) {
      $rawIP = getenv('REMOTE_ADDR');
      Mailer::send('Skytells Guard - Successful Login Notification!', "Hello,\r\nJust to inform you that $user just logged in!\r\nThis activity has been monitored by Skytells Guard with the given information\r\n------\r\nIP: $rawIP\r\nOS: $OS\r\n Browser: $Browser\r\nLocation: $geo->city, $geo->region_name, $geo->country_name\r\nThanks for choosing Skytells Guard!");
    }
    return true;
  }



  public static function addAttack($URL, $QueryString, $TYPE) {
    global $SFA, $_SERVER;
    $headers = @apache_request_headers();
    $TYPE = (string)$TYPE;
    $geo = \Skytells\SFA\GeoIP::getInfo(getenv('REMOTE_ADDR'));
    $OS = \Skytells\Controllers\HTTP::getOS();
    $Browser = \Skytells\Controllers\HTTP::getBrowser();
    $Method = \Skytells\Controllers\HTTP::getMethod();
    $Datetime = getStamp();
    $IP = IP::getIP();

    $Ref = (isset($headers['Referer'])) ? $headers['Referer'] : $_SERVER['HTTP_REFERER'];
    $Ref = esc_sql($Ref); // must be secured also.
    $Data = [
      'type' => $TYPE,
      'ip' => $IP,
      'os' => $OS,
      'browser' => $Browser,
      'querystring' => $QueryString,
      'url' => $URL,
      'method'  => $Method,
      'referer' => $Ref,
      'country' => $geo->country_name,
      'country_code' => $geo->country_code,
      'region' => $geo->region_name,
      'region_code' => $geo->region_code,
      'city' => $geo->city,
      'state' => $geo->region_name,
      'zipcode' => $geo->zip_code,
      'geo' => $geo->latitude.','.$geo->longitude,
      'stamp' => $Datetime
    ];

    $FormattedGeo = $geo->city.', '.$geo->region_name.', '.$geo->country_name;
    $status = $SFA->db->insert('SFAAttacks', $Data);
    \Skytells\SFA\Reports::UpdateDailyReports('Attacks', 'SQLAttacks');
    if ((bool)get_option('skfw_send_email') == true) {
      $subject = __("Skytells Guard - Your WordPress is Under Attack!", 'skytells-firewall');
      $message = "Hello,\nJust to inform you that Skytells Guard just stopped an attacker from performing an SQL Injection Attack on your WordPress site.\r\n \r\nThe Attacker's information including the logs have been saved\r\n \r\n------------\r\n \r\nURL:  ( $URL ) \r\nThis Attack comes from : $FormattedGeo\r\nIP : $IP\r\nDatetime: $Datetime\r\n \r\nPlease login to your WordPress admin-panel to see all information about this attempt!\r\nThanks for using Skytells Guard!\r\nStay Safe!";
      Mailer::send($subject, $message);
    }
    return true;
  }


  public static function getRecentAttacks($LIMIT = 100) {
    global $SFA;
    $LIMIT = (int)$LIMIT;
    $SFA->db->orderBy("id","desc");
    return $SFA->db->get('SFAAttacks', $LIMIT);
  }

  public static function getAttacksSum() {
    global $SFA, $wpdb;
    return count($wpdb->get_results("SELECT id FROM {$wpdb->prefix}SFAAttacks"));
  }





  public static function getAttackById($ID) {
    global $SFA;
    $SFA->db->where('id', $ID);
    return $SFA->db->getOne('SFAAttacks');
  }



  public static function getLoginDetailsById($ID) {
    global $SFA;
    $SFA->db->where('id', $ID);
    return $SFA->db->getOne('SFALogins');
  }




}
