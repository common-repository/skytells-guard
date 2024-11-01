<?
if (!defined('ABSPATH')) { exit("No Direct Access"); }
Class Skytells_Firewall {
   private static $ALLOWED_CHARS = '';
   private static $DDOS_EXP;
   private static $DDOS_TRIES;
   function Prepare() {

   }
   public static function isWhitelisted($url) {
      global $Firewall;
      $whitelisted = get_option('skfw_whitelisted');
      if (!empty($whitelisted)) {
        if (strpos($whitelisted, $url) !== false){
          return TRUE;
        }
      }
      return FALSE;
   }


  public static function get_user_ip_address() {
           foreach (array('HTTP_CF_CONNECTING_IP', 'HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
               if (array_key_exists($key, $_SERVER) === true){
                   foreach (explode(',', $_SERVER[$key]) as $ip){
                       $userIP = trim($ip);
                       if (filter_var($userIP, FILTER_VALIDATE_IP) !== false){
                           return $userIP;
                       }
                   }
               }
           }
           return ''; //if we get this far we have an invalid address - return empty string
       }
  public static function block_fake_googlebots() {
        $user_agent = (isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '');
        if (preg_match('/Googlebot/i', $user_agent, $matches)){
            //If user agent says it is googlebot start doing checks
            $ip = Skytells_Firewall::get_user_ip_address();
            $name = gethostbyaddr($ip); //let's get the internet hostname using the given IP address
            //TODO - maybe add check if gethostbyaddr() fails
            $host_ip = gethostbyname($name); //Reverse lookup - let's get the IP using the name
            if(preg_match('/Googlebot/i', $name, $matches)){
                if ($host_ip == $ip){
                    //Genuine googlebot allow it through....
                }else{
                    //fake googlebot - block it!
                    exit();
                }
            }else{
                //fake googlebot - block it!
                exit();
            }
        }
    }


   public static function blockIP($IP, $Reason = '-') {
     $Expiry = get_option('skfw_IPBanExpiry', false);
     return \Skytells\SFA\IP::BanIP($IP, $Expiry, $Reason, 'Skytells Firewall');

   }
   public static function getBlockedIPS() {
     return \Skytells\SFA\IP::getRecentBans();

   }
   public static function checkBlacklistedIPS() {

     if (Skytells\SFA\IP::isBanned(getenv('REMOTE_ADDR'))) {
       @header('HTTP/1.1 503 Service Unavailable');
        die(get_option('skfw_blockedmessage', "<title>Blocked</title><h1 style='padding-left:30px; padding-top:15px;'>You've been blocked!</h1>
        <hr><p style='padding-left:30px; padding-top:15px;'>You're blocked from accessing this website.</p>"));
     }
   }
   public static function allowUrl($url) {
        if (!isset($url)){ throw new \ErrorException("Error Processing Request: You need to bypass the URL that you want to allow.", 1); }
        global $Firewall;
        array_push($Firewall["WHITELISTED"], $url);
        return true;
   }

   public static function blockNonUserAgents() {
     $headers = @apache_request_headers();
     $valid = false;
        /* Check that the verification key, “referer” and user-agent headers are all present */
        if(isset($headers['X-Verification-Key']) && isset($headers['Referer']))
        {
          if(isset($keys[$headers['X-Verification-Key']]) && $keys[$headers['X-Verification-Key']][0] == $headers['Referer'] && !empty($_SERVER['HTTP_USER_AGENT'])) {
             $valid = true;
             return true;
            }
        }
        if(!$valid && empty($_SERVER['HTTP_USER_AGENT']))
          {
            Skytells_Firewall::blockIP(getenv('REMOTE_ADDR'), 'NO_USER_AGENT, NO_REFERER');
            header('HTTP/1.0 403 Forbidden');
            echo "Forbidden.\n";
            exit();
          }
   }
   public static function getReady($IsAdminPage = false) {

     if ((bool)get_option('SFA_firewall') !== true) {
       return false;
     }
     Skytells_Firewall::checkBlacklistedIPS();
     Skytells_Firewall::$ALLOWED_CHARS =  get_option('skfw_allowedchars', '/[^a-z0-9-=&#_]+/i');


     global $Firewall;
     if ((bool)get_option('skfw_status') === TRUE) {

       // Check White Listed.
       $whitelisted_ips = get_option('skfw_whitelisted_ips');
       if (strpos($whitelisted_ips, getenv('REMOTE_ADDR'))) {
         return true;
       }


       if ((bool)get_option('skfw_ddos_status') === TRUE) {

         Skytells_Firewall::$DDOS_EXP = (int)get_option('skfw_ddos_exp', 1);
         Skytells_Firewall::$DDOS_TRIES = (int)get_option('skfw_ddos_tries', 5);
         Skytells_Firewall::AntiDDoS();

       }

       if ((bool)get_option('skfw_block_empty_ref_ips') === TRUE && $_SERVER['REQUEST_METHOD'] == 'POST' && count($_POST) > 0) {
         Skytells_Firewall::blockNonUserAgents();
       }


       $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

       if (!Skytells_Firewall::isWhitelisted($actual_link) && $IsAdminPage == false) {
          Skytells_Firewall::SecureURI();
       }

       if ((bool)get_option('skfw_block_fake_googlebots') === TRUE && $IsAdminPage == false) {
         Skytells_Firewall::block_fake_googlebots();
      }

      $protectedUrls = (string)get_option('skfw_protected_urls');
      if (!empty($protectedUrls) && $IsAdminPage == false) {
        Skytells_Firewall::PerformProtectedUrlsCheck($protectedUrls, $actual_link);
      }

      if ((bool)get_option('skfw_force_ssl') === TRUE) {
        if (!\Skytells\Controllers\HTTP::isSSL()) {
          global $_SERVER;
            @header('Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);

        }


      }




    }
   }

   public static function PerformProtectedUrlsCheck($protectedUrls, $actual_link) {
     $protectedUrls = str_replace(['http://', 'https://'], '', $protectedUrls);
     $actual_link = str_replace(['http://', 'https://'], '', $actual_link);
     $actual_link = preg_replace('/\?.*/', '', $actual_link);
     $actual_link = rtrim($actual_link, '/');
     $actual_link = ltrim($actual_link, '/');
     if (strpos($protectedUrls, ',') !== false) {
       $protectedUrls = explode(',', $protectedUrls);
     }
     elseif (strpos($protectedUrls, "\n") !== false) {
       $protectedUrls = explode("\n", $protectedUrls);
     }else {
       $protectedUrls = [$protectedUrls];
     }

     if (is_array($protectedUrls) && !empty($protectedUrls)) {
       foreach ($protectedUrls as $url) {
         $url = rtrim($url, '/');
         $url = ltrim($url, '/');
         if ($url == $actual_link) {
           Skytells_Firewall::blockIP(getenv('REMOTE_ADDR'), 'ACCESS_PROTECTED_URL');
             exit("<title>Access Denied</title><h1 style='padding-left:30px; padding-top:15px;'>Protected URL</h1>
             <hr>
                  <p style='padding-left:30px; padding-top:15px;'>You do not have the right permission to access this url, because this URL is protected by Skytells Guard, You've been blocked from accessing our server.</p>");
         }
       }
     }

   }


   public static function SecureURI() {
    global $_SERVER;
    $inurl = $_SERVER['REQUEST_URI'];
    $securityUlrs_url = $_SERVER['QUERY_STRING'];
    if ($securityUlrs_url != '' && preg_match(Skytells_Firewall::$ALLOWED_CHARS, $securityUlrs_url)) {

      $URL = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
      \Skytells\SFA\Activities::addAttack($URL, $securityUlrs_url, 'SQL Injection');
      exit(require(SFA_PATH.'/Views/UI/Alerts/101.php'));
    }

    return true;
   }


   public static function __sendEmail($IP, $query) {
       $to = get_option('admin_email');
       $subject = __('Skytells Firewall just detected an Attack!', 'skytells-firewall');
       $message = sprintf(__('Skytells Firewall has protected you from a SQL Injection attack comes from IP ( %s ) tried to perform the mentioned query string ( %s ) on %s', 'sfa-brute-force'), $IP, $query, date('Y-m-d H:i:s'));

       return wp_mail($to, $subject, $message);
   }





   public static function getSQLAttacks() {
     return \Skytells\SFA\Activities::getRecentAttacks();
     $file = __DIR__.'/Logs/attacks.json';
     if (file_exists($file)) {
       $data  = file_get_contents($file);
        return json_decode($data);
     }else {
       return false;
     }

   }
   public static function startSession() {
     if(!session_id()) {
       @session_start();
     }
   }
   public static function AntiDDoS() {
        try {
            global $_SESSION; global $_SERVER;
            $uri = md5($_SERVER['REQUEST_URI']);

            $expireIn = time()+Skytells_Firewall::$DDOS_EXP;
            $hash = $uri .'|'. $expireIn;
            if (isset($_SESSION["Firewall_AntiDDoS"]) && !empty($_SESSION["Firewall_AntiDDoS"])) {
            $FDcheck = explode('|', $_SESSION["Firewall_AntiDDoS"]);
            $tmcheck = $FDcheck[1];

            if ($FDcheck[0] == $uri && time() < $tmcheck) {

                if ((bool)get_option('skfw_ddos_block_ip', false) == true) {
                  $ddos_allowed_expiry = (int)get_option('skfw_DDoS_Tries_Expiry', 30);
                  if (!isset($_SESSION["Firewall_AntiDDoS_TRIES_EX"]) || empty($_SESSION["Firewall_AntiDDoS_TRIES_EX"]) ) {
                      $timeTriesExpiry = time()+$ddos_allowed_expiry;
                    $_SESSION["Firewall_AntiDDoS_TRIES_EX"] = $timeTriesExpiry;
                  }else {
                    $timeTriesExpiry = $_SESSION["Firewall_AntiDDoS_TRIES_EX"];
                  }

                  if (!isset($_SESSION["Firewall_AntiDDoS_TRIES"]) || empty($_SESSION["Firewall_AntiDDoS_TRIES"]) ) {
                    $_SESSION["Firewall_AntiDDoS_TRIES"] = 1;
                  }else {
                    $_SESSION["Firewall_AntiDDoS_TRIES"] = $_SESSION["Firewall_AntiDDoS_TRIES"]+1;
                  }
                  if ((int)$_SESSION["Firewall_AntiDDoS_TRIES"] > (int)get_option('skfw_ddos_tries', 5) && $timeTriesExpiry < time()) {
                    Skytells_Firewall::BlockIP(getenv('REMOTE_ADDR'), 'DDoS Attack');
                  }
                }

                @header('HTTP/1.1 503 Service Unavailable');
                 die("<title>Security Warning</title><h1>DDoS Attack Detected!</h1>
                 <hr>
                      <p>Our System observed illegal requests during connecting our server!</p>
                      <p>You have been blocked from accessing our server for 1 minute due to illegal activity.</p>
                      ");
                die;
            }
          }
            // Save last request
            $_SESSION["Firewall_AntiDDoS"] = $hash;
        }
        catch(Exception $e)
          {
            throw new ErrorException("Firewall:".$e->getMessage(), 1);
          }
      }
 }
