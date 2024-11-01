<?php
Namespace Skytells\Controllers;
if (!defined('ABSPATH')) { exit; }
Class HTTP {


  public static function getMethod() {
    $method = $_SERVER['REQUEST_METHOD'];
      $request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));

      switch ($method) {
        case 'PUT':
          return 'PUT';
          break;
        case 'POST':
          return 'POST';
          break;
        case 'GET':
          return 'GET';
          break;
        default:
          return 'UNKNOWN';
          break;
      }

  }


  public static function get( $url )
  {
      $options = array(
          CURLOPT_RETURNTRANSFER => true,     // return web page
          CURLOPT_HEADER         => false,    // don't return headers
          CURLOPT_FOLLOWLOCATION => true,     // follow redirects
          CURLOPT_ENCODING       => "",       // handle all encodings
          CURLOPT_USERAGENT      => "Skytells Guard", // who am i
          CURLOPT_AUTOREFERER    => true,     // set referer on redirect
          CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
          CURLOPT_TIMEOUT        => 120,      // timeout on response
          CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
          CURLOPT_SSL_VERIFYPEER => false     // Disabled SSL Cert checks
      );

      $ch      = curl_init( $url );
      curl_setopt_array( $ch, $options );
      $content = curl_exec( $ch );
      $err     = curl_errno( $ch );
      $errmsg  = curl_error( $ch );
      $header  = curl_getinfo( $ch );
      curl_close( $ch );

      $header['errno']   = $err;
      $header['errmsg']  = $errmsg;
      $header['content'] = $content;
      return $content;
  }
  public static function isSSL() {
        if (isset($_SERVER['HTTPS'])) {
            if ($_SERVER['HTTPS'] == 1) {
                return true;
            } elseif ($_SERVER['HTTPS'] == 'on') {
                return true;
            }
        }
        return false;
    }
  public static function isSecure() {
        return (
            (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
         || $_SERVER['SERVER_PORT'] == 443
         || (
                (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')
             || (!empty($_SERVER['HTTP_X_FORWARDED_SSL'])   && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on')
            )
        );
    }

  public static function requireHTTPS() {
    global $_SERVER;
    if (!HTTP::isSSL()) {
            @header('Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], TRUE, 301);
            exit;
        }
    }


  /**
  * getBrowser
  *
  * @return string
  */
 public static function getBrowser() {
     $browser = "Unknown Browser";
     $browser_array = array(
         '/msie/i'       =>  'Internet Explorer',
         '/firefox/i'    =>  'Firefox',
         '/safari/i'     =>  'Safari',
         '/chrome/i'     =>  'Chrome',
         '/edge/i'       =>  'Edge',
         '/opera/i'      =>  'Opera',
         '/netscape/i'   =>  'Netscape',
         '/maxthon/i'    =>  'Maxthon',
         '/konqueror/i'  =>  'Konqueror',
         '/mobile/i'     =>  'Handheld Browser'
     );
     foreach($browser_array as $regex => $value) {
         if(preg_match($regex, $_SERVER['HTTP_USER_AGENT'])) {
             $browser = $value;
         }
     }
     return $browser;
 }
 /**
  * getOS
  *
  * @return string
  */
  public static function getOS() {
     $os_platform = "Unknown OS Platform";
     $os_array = array(
         '/windows nt 10/i'      =>  'Windows 10',
         '/windows nt 6.3/i'     =>  'Windows 8.1',
         '/windows nt 6.2/i'     =>  'Windows 8',
         '/windows nt 6.1/i'     =>  'Windows 7',
         '/windows nt 6.0/i'     =>  'Windows Vista',
         '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
         '/windows nt 5.1/i'     =>  'Windows XP',
         '/windows xp/i'         =>  'Windows XP',
         '/windows nt 5.0/i'     =>  'Windows 2000',
         '/windows me/i'         =>  'Windows ME',
         '/win98/i'              =>  'Windows 98',
         '/win95/i'              =>  'Windows 95',
         '/win16/i'              =>  'Windows 3.11',
         '/macintosh|mac os x/i' =>  'Mac OS X',
         '/mac_powerpc/i'        =>  'Mac OS 9',
         '/linux/i'              =>  'Linux',
         '/ubuntu/i'             =>  'Ubuntu',
         '/iphone/i'             =>  'iPhone',
         '/ipod/i'               =>  'iPod',
         '/ipad/i'               =>  'iPad',
         '/android/i'            =>  'Android',
         '/blackberry/i'         =>  'BlackBerry',
         '/webos/i'              =>  'Mobile'
     );
     foreach($os_array as $regex => $value) {
         if(preg_match($regex, $_SERVER['HTTP_USER_AGENT'])) {
             $os_platform = $value;
         }
     }
     return $os_platform;
 }
 /**
  * getIP
  *
  * @return string
  */
  public static function getIP() {
     /* handle CloudFlare IP addresses */
     return (isset($_SERVER["HTTP_CF_CONNECTING_IP"])?$_SERVER["HTTP_CF_CONNECTING_IP"]:$_SERVER['REMOTE_ADDR']);
 }

}
