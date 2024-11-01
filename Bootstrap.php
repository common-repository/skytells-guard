<?php
if (file_exists(__DIR__.'/Core/Packages/vendor/autoload.php')) {
  require __DIR__.'/Core/Packages/vendor/autoload.php';
}
if (in_array($SFA_php, $SFA_SUPPORTED_PHP_VERSIONS)) {
  define('SFA_CHECKLIST', true);
}else {
  define('SFA_CHECKLIST', false);
  add_action( 'admin_notices', 'sfa_admin_notice_php' );
}
if (defined('WP_DEBUG') && WP_DEBUG == true) {
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
}
if (SFA_CHECKLIST === true) {
  require SFA_PATH.'/Core/Libraries/Options.php';
  require SFA_PATH.'/Core/Handlers/RestAPI.php';
  require SFA_PATH.'/Core/Handlers/Uri.php';
  require SFA_PATH.'/Core/Libraries/SQLManager.php';
  require SFA_PATH.'/Core/Controllers/Migrations.php';
  require SFA_PATH.'/Core/Controllers/Mailer.php';
  require SFA_PATH.'/Core/Libraries/RSA.php';
  require SFA_PATH.'/Functions.php';
  require SFA_PATH.'/Core/Controllers/Http.php';
  require SFA_PATH.'/Core/Controllers/GeoIP.php';
  require SFA_PATH.'/Core/Controllers/API.php';
  require SFA_PATH.'/Core/Libraries/Foundation.php';
  require SFA_PATH.'/Core/Libraries/SFA.php';
  require SFA_PATH.'/Core/Libraries/Core.php';
  require SFA_PATH.'/Core/Guard.php';
  require SFA_PATH.'/Core/Controllers/Activities.php';
  require SFA_PATH.'/Core/Controllers/CloudFlare.php';
  require SFA_PATH.'/Core/Controllers/IP.php';
  require SFA_PATH.'/Core/Controllers/Reports.php';
  require SFA_PATH.'/Core/Dashboard/Init.php';
  require SFA_PATH.'/Modules/brute-force/init.php';
  require SFA_PATH.'/Modules/firewall/Init.php';
  require SFA_PATH.'/Modules/MetainfoProtection/Init.php';
  require SFA_PATH.'/Modules/scanner/index.php';
  require SFA_PATH.'/Modules/reCAPTCHA/Init.php';
  require SFA_PATH.'/Core/Libraries/Notifications.php';
  require SFA_PATH.'/Core/Libraries/UI.php';
  require SFA_PATH.'/Core/Libraries/SFA_Module.php';
  require SFA_PATH.'/Modules/FaceID/Init.php';
  require SFA_PATH.'/Core/Controllers/FaceID.php';

}

// ---------------------------------------------------------------
