<?php
Namespace Skytells\SFA;
use Skytells\SFA\CloudFlare;
if (!defined('ABSPATH')) { exit("No Access - EXCODE: IPPX"); }
Class IP {
  private static $InformCloudFlare = false;
  public static function getIP() {
    return (isset($_SERVER["HTTP_CF_CONNECTING_IP"])?$_SERVER["HTTP_CF_CONNECTING_IP"]:$_SERVER['REMOTE_ADDR']);
  }

  public static function getInfo($IP = '') {
    return \Skytells\SFA\GeoIP::getInfo($IP);
  }

  public static function getReady() {
    IP::$InformCloudFlare = false;
  }
  public static function InformCloudFlare() {
    IP::$InformCloudFlare = true;
  }
  /**
  * @method BanIP
  * @return bool
  */
  public static function BanIP($IP, $Expiry = null, $Reason = 'SUSPECTED_ATTACKER', $Performer = 'Skytells Guard') {
    global $SFA;

    if ($Expiry == null || empty($Expiry) || $Expiry == false || $Expiry = '0' || $Expiry = 0) {
      $Expiry =  calcStamp('+360 days');
      }
      $geo = \Skytells\SFA\GeoIP::getInfo(getenv('REMOTE_ADDR'));
      $OS = \Skytells\Controllers\HTTP::getOS();
      $Browser = \Skytells\Controllers\HTTP::getBrowser();
      $IP = esc_sql($IP);
      $cf = get_option('SFA_cloudflare_syncBans');
      $cfBanned = false;
      if ($cf != false) {
        $cfID = CloudFlare::BanIP($IP, $Reason);
        if ($cfID != false) {
          $cfBanned = true;
        }
      }
      elseif (IP::$InformCloudFlare == true && \Skytells\SFA::CL()) {
        $cfID = CloudFlare::BanIP($IP, $Reason);
        if ($cfID != false) {
          $cfBanned = true;
        }
      }else {
          $cfBanned = true;
          $cfID = '0';
      }

      $Data = [
        "stamp" => getStamp(),
        "ip"       => $IP,
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
        'performer' => $Performer,
        'expiry'  => $Expiry,
        'cfbanned' => $cfBanned,
        'banid' => $cfID,
        'reason' => $Reason
      ];
      $status = $SFA->db->insert('SFAIPBans', $Data);
      if ($status) {
        \Skytells\SFA\Reports::UpdateDailyReports('Bans', false, '+');
        if ((bool)get_option('skfw_block_ip_notification') == true) {
          $subject = __('Skytells Firewall Just Blocked an IP', 'skytells-firewall');
          if (!$cfBanned){
            $message = "Just to inform you that Skytells Guard Firewall just blocked an IP!\r\n------\r\n \r\nDatetime:".gmdate('Y-m-d H:i:s')."\r\n \r\nIP: $IP\r\nReason: $Reason\r\n \r\nPerformer: $Performer\r\n \r\nThis IP is no longer have access to your WordPress, You can unblock this IP from Skytells Guard Dashboard!";
          }else {
            $message = "Just to inform you that Skytells Guard Firewall just blocked an IP!\r\nWe've also informed CloudFlare to ban this IP from accessing your server.------\r\n \r\nDatetime:".gmdate('Y-m-d H:i:s')."\r\n \r\nIP: $IP\r\nReason: $Reason\r\n \r\nPerformer: $Performer\r\n \r\nCloudFlare Rule: $cfID\r\n \r\nThis IP is no longer have access to your WordPress, You can unblock this IP from Skytells Guard Dashboard!";
          }
          \Skytells\SFA\Mailer::send($subject, $message);
        }
        IP::$InformCloudFlare = false;
        return true;
      }
      IP::$InformCloudFlare = false;
      return false;

    }

  public static function UnbanIP($IP, $cfbanID = '') {
    global $wpdb, $SFA;
    $IP = esc_sql($IP);
    $ac = $wpdb->query("DELETE FROM {$wpdb->prefix}SFAIPBans WHERE ip = '$IP'");
    if (IP::$InformCloudFlare == true && \Skytells\SFA::CL()) {
      $cfID = CloudFlare::UnbanIP($cfbanID);
    }
    if ($ac) {
      \Skytells\SFA\Reports::UpdateDailyReports('Bans', false, '-');
      return true;
    }
    return false;
  }

  public static function isBanned($IP) {
    global $SFA, $wpdb;
    $IP = esc_sql($IP);
    $Result = $SFA->db->rawQueryOne ('SELECT * FROM '.$wpdb->prefix.'SFAIPBans WHERE ip=?', Array($IP));
    if (isset($Result['ip'])) { return true; } else { return $Result; }
  }

  public static function getRecentBans($LIMIT = 100) {
    global $SFA;
    $LIMIT = (int)$LIMIT;
    $SFA->db->orderBy("id","desc");
    return $SFA->db->get('SFAIPBans', $LIMIT);
  }


  public static function getBansByCountry($Country, $LIMIT = 100) {
    global $SFA;
    $LIMIT = (int)$LIMIT;
    $Country = (string)$Country;
    $SFA->db->where("country",$Country);
    $SFA->db->orderBy("id","desc");
    return $SFA->db->get('SFAIPBans', $LIMIT);
  }


  public static function getBansByCountryCode($Country, $LIMIT = 100) {
    global $SFA;
    $LIMIT = (int)$LIMIT;
    $Country = (string)$Country;
    $SFA->db->where("country_code",$Country);
    $SFA->db->orderBy("id","desc");
    return $SFA->db->get('SFAIPBans', $LIMIT);
  }


  public static function getBansSum() {
    global $SFA, $wpdb;
    return count($wpdb->get_results("SELECT id FROM {$wpdb->prefix}SFAIPBans"));
  }

  public static function getBannedVia($Via, $LIMIT = 100) {
    global $SFA;
    $LIMIT = (int)$LIMIT;
    $Via = (string)$Via;
    $SFA->db->where("performer",$Via);
    $SFA->db->orderBy("id","desc");
    return $SFA->db->get('SFAIPBans', $LIMIT);
  }

}
