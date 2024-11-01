<?php
Namespace Skytells\SFA;
if (!defined('ABSPATH')) { exit; }
Class Notifications  {
  public static $SecurityScore = 100;

  public static function getScore() {
    Notifications::$SecurityScore = 100;
    Notifications::fetch();
    return Notifications::$SecurityScore;
  }
  public static function fetch() {
    $Data = Array();
     if ((bool)get_option('SFA_disable_JSONAPI') !== true) {
       $Data[] = [
         "category" => "HTTP Attacks",
         "score" => 4,
         "message" => "The JSON-API is currently ON",
         "desc" => "The JSON-API is a Public API for your WordPress website, This public API can be used by others to get and post data into your wordpress, These guys can target the JSON-API to perform a DDoS Attack on it or at least to attack your database, Please disable the JSON-API to prevent Cross callback attacks",
         "url" => admin_url('admin.php?page=sfa-settings')

       ];
        Notifications::$SecurityScore = Notifications::$SecurityScore -10;
     }

     if ((bool)get_option('SFA_disable_XMLRPC') !== true) {
       $Data[] = [
         "category" => "HTTP Attacks",
         "score" => 6,
         "message" => "The XML-RPC is currently ON",
         "desc" => "The XML-RPC is a built-in webhandler in your wordpress, It can be attacked by others, These guys can target the XML-RPC to perform a DDoS Attacks, Please disable the JSON-API to prevent Cross callback & DDoS attacks",
         "url" => admin_url('admin.php?page=sfa-settings')

       ];
       Notifications::$SecurityScore = Notifications::$SecurityScore -6;
     }


     if ((bool)get_option('SFA_recaptcha_module') !== true) {
       $Data[] = [
         "category" => "Flooding",
         "score" => 4,
         "message" => "The reCAPTCHA Module is disabled!",
         "desc" => "Your WordPress admin login page is not secured by recaptcha, This may open a window to the attackers to build a bots & tools to perform DDoS & SQL-DoS Attacks on your website, Please Enable the recaptcha module to prevent spamming & major web attacks!",
         "url" => admin_url('admin.php?page=sfa-settings')

       ];
         Notifications::$SecurityScore = Notifications::$SecurityScore -10;
     }


     if ((bool)get_option('SFA_CustomUrls') !== true) {
       $Data[] = [
         "category" => "Global",
         "score" => 8,
         "message" => "The Sensitive Login Pages are currently naked!",
         "desc" => "The most important thing here is to hide your wp-admin dir and most of sensitive login pages from public! - Please Enable the Custom Urls module to prevent spamming & major web attacks!",
         "url" => admin_url('admin.php?page=sfa-settings')

       ];
         Notifications::$SecurityScore = Notifications::$SecurityScore -10;
     }


     if ((bool)get_option('SFA_bruteforce') !== true) {
       $Data[] = [
         "category" => "Global",
         "score" => 9,
         "message" => "Brute Force Protection is currently disabled!",
         "desc" => "The Brute Force Protection protects you from Cross-HTTP Attacks & Password Guesses, Please Enable the Brute-Force as fast as possible!",
         "url" => admin_url('admin.php?page=sfa-settings')

       ];
         Notifications::$SecurityScore = Notifications::$SecurityScore -20;
     }


     if ((bool)get_option('SFA_firewall') !== true) {
       $Data[] = [
         "category" => "Global",
         "score" => 9,
         "message" => "Firewall is currently OFF",
         "desc" => "The Firewall protects your website from DDoS Attacks, SQL Injection & major PHP-HTTP Attacks, The firewall is the heart of everything here, Please enable the Firewall as fast as you can!",
         "url" => admin_url('admin.php?page=sfa-settings')
       ];
         Notifications::$SecurityScore = Notifications::$SecurityScore -20;
     }

     if ((bool)get_option('SFA_FaceID') !== true) {
       $Data[] = [
         "category" => "Global",
         "score" => 9,
         "message" => "FaceID is currently disabled!",
         "desc" => "The FaceID adds extra layer of protection using Skytells's Latest Enhanched AI, with These AI algorithms Your Website will have to look at your Face everytime you login to make sure that nobody else can login with your account.",
         "url" => admin_url('admin.php?page=sfa-faceid')

       ];
         Notifications::$SecurityScore = Notifications::$SecurityScore -20;
     }


     if (file_exists(ABSPATH.'/readme.html')) {
       if ((bool)get_option('SFA_Remove_WP_Dummy_Files') == true && unlink(ABSPATH.'/readme.html')){
         //
       }else {
         $Data[] = [
           "category" => "Global",
           "score" => 1,
           "message" => "WordPress Readme File still exist",
           "desc" => "The readme.html file is also located in the root of your site. It provides basic information about installation, upgrading, system requirements & resources. It also displays the WordPress version you are running, which can be used by hackers to exploit vulnerabilities. You should delete this file.",
           "url" => admin_url('admin.php?page=sfa-analysis')

         ];
           Notifications::$SecurityScore = Notifications::$SecurityScore -2;
       }

     }


     if (file_exists(ABSPATH.'/wp-config-sample.php')) {
       if ((bool)get_option('SFA_Remove_WP_Dummy_Files') == true && unlink(ABSPATH.'/wp-config-sample.php')){
        //
       }else {
       $Data[] = [
         "category" => "Global",
         "score" => 1,
         "message" => "WordPress's Dummy Config File stil exist",
         "desc" => "wp-config-sample.php is found in the root of your WordPress installation. If your hosting company offers a one-click installation, you will see both wp-config.php AND wp-config-sample.php in the root folder. Just go ahead & delete wp-config-sample.php. Your hosting company has already setup & created wp-config.php, and the sample file is not needed.",
         "url" => admin_url('admin.php?page=sfa-analysis')

       ];
         Notifications::$SecurityScore = Notifications::$SecurityScore -2;
       }
     }
     return json_decode(json_encode($Data));


  }



}
