<?php
Namespace Skytells\SFA;
if (!defined('ABSPATH')) { exit; }
Class GeoIP {
  public static function getInfo($IP) {
    if ($IP == '::1' || $IP == '127.0.0.1') {
      $IP = '';
    }
    $data = \Skytells\Controllers\HTTP::get("http://freegeoip.net/json/$IP");
    if (empty($data)) {
      return false;
    }
    $data = json_decode($data);
    if ($data == false) { return false; }
    return $data;
  }
}
