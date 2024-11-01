<?php
Namespace Skytells\SFA;
Class Migrations {

  private static function getTables($version = false) {
    global $wpdb;
    $Prefix = $wpdb->prefix;
    $Tables = [
      // Core Table.
      "CREATE TABLE IF NOT EXISTS {$Prefix}SFACore (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        version VARCHAR(30) NULL,
        sn VARCHAR(300) NULL,
        domain VARCHAR(300) NULL,
        pid VARCHAR(300) NULL,
        stamp TIMESTAMP)",

      // Login Activities
      "CREATE TABLE IF NOT EXISTS {$Prefix}SFALogins (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(300) NULL,
        ip VARCHAR(100) NULL,
        os VARCHAR(100) NULL,
        browser VARCHAR(300) NULL,
        country VARCHAR(300) NULL,
        country_code VARCHAR(100) NULL,
        region VARCHAR(100) NULL,
        region_code VARCHAR(150) NULL,
        zipcode VARCHAR(150) NULL,
        state VARCHAR(300) NULL,
        city VARCHAR(300) NULL,
        geo  VARCHAR(100) NULL,
        status VARCHAR(100) NULL,
        stamp TIMESTAMP)",

      // Protected URLs
      "CREATE TABLE IF NOT EXISTS {$Prefix}SFAIPBans (
          id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
          reason VARCHAR(300) NULL,
          ip VARCHAR(100) NULL,
          os VARCHAR(100) NULL,
          browser VARCHAR(300) NULL,
          country VARCHAR(300) NULL,
          country_code VARCHAR(100) NULL,
          region VARCHAR(100) NULL,
          region_code VARCHAR(150) NULL,
          zipcode VARCHAR(150) NULL,
          state VARCHAR(300) NULL,
          city VARCHAR(300) NULL,
          geo  VARCHAR(100) NULL,
          performer VARCHAR(100) NULL,
          banid VARCHAR(200) NULL,
          unbanid VARCHAR(200) NULL,
          cfbanned BOOLEAN NOT NULL DEFAULT FALSE,
          expiry TIMESTAMP,
          stamp TIMESTAMP)",


        // Protected URLs
        "CREATE TABLE IF NOT EXISTS {$Prefix}SFAAttacks (
          id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
          type VARCHAR(300) NULL,
          ip VARCHAR(100) NULL,
          os VARCHAR(100) NULL,
          browser VARCHAR(300) NULL,
          country VARCHAR(300) NULL,
          country_code VARCHAR(100) NULL,
          region VARCHAR(100) NULL,
          region_code VARCHAR(150) NULL,
          zipcode VARCHAR(150) NULL,
          state VARCHAR(300) NULL,
          city VARCHAR(300) NULL,
          geo  VARCHAR(100) NULL,
          referer VARCHAR(100) NULL,
          url VARCHAR(1000) NULL,
          querystring VARCHAR(1000) NULL,
          method VARCHAR(100) NULL,
          stamp TIMESTAMP)",


          // Protected URLs
        "CREATE TABLE IF NOT EXISTS {$Prefix}SFADailyReports (
          id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
          DayFormat VARCHAR(100) NULL,
          Attacks int(32) NULL DEFAULT '0',
          SQLAttacks int(32) NULL DEFAULT '0',
          DDoSAttacks int(32) NULL DEFAULT '0',
          Logins int(32) NULL DEFAULT '0',
          Bans int(32) NULL DEFAULT '0',
          stamp TIMESTAMP)",

         // Face ID
         "ALTER TABLE `{$Prefix}users` ADD `faceid_enrolled` BOOLEAN NOT NULL DEFAULT FALSE AFTER `user_status`",
         "ALTER TABLE `{$Prefix}users` ADD `faceid_hash`  VARCHAR(900) NULL AFTER `user_status`",
         "ALTER TABLE `{$Prefix}users` ADD `faceid` BOOLEAN NOT NULL DEFAULT FALSE AFTER `user_status`"
    ];

    return $Tables;
  }


  public static function doCheck() {
    global $SFA, $wpdb, $_SERVER;
    if (!defined('ABSPATH') || !is_admin()) { exit("No Direct Access"); }
    $prefix = esc_sql($wpdb->prefix);
    $table_name = $wpdb->prefix.'SFACore';
    $check = $wpdb->get_var( "SHOW TABLES LIKE '$table_name' ");
    if( $check != $table_name ) {
      @define('SFA_INSTALLED', false);
      @define('SFA_REQUIRE_UPGRADE', false);
    }else {
      $stm = $wpdb->get_results("SELECT * FROM $table_name WHERE id = '1'");

      if (isset($stm['version']) && $stm['version'] == SFA_VERSION) {
          @define('SFA_INSTALLED', true);
          @define('SFA_REQUIRE_UPGRADE', false);
      }
      else
      {
        if (isset($stm['version'])) {
            @define('SFA_INSTALLED', true);
        }else {
          @define('SFA_INSTALLED', false);
        }

        @define('SFA_REQUIRE_UPGRADE', true);

      }

    }
  }
  public static function Install() {
    try {

      if (!defined('ABSPATH') || !is_admin()) { exit("No Direct Access"); }

      if (!defined('SFA_INSTALLED')) { Migration::doCheck(); }
      if (defined('SFA_REQUIRE_UPGRADE') && SFA_REQUIRE_UPGRADE == true) {
        return Migrations::PerformUpgrade();
      }

      if (defined('SFA_INSTALLED') && SFA_INSTALLED == true && defined('SFA_REQUIRE_UPGRADE') && SFA_REQUIRE_UPGRADE == false) {
        return true;
      }


      global $wpdb;
      $Tables = Migrations::getTables();
      if (empty($Tables)) { return false; }

      $Errors = [];
      foreach ($Tables as $Table) {

        if (!$wpdb->query($Table)) {
          $Errors[] = $wpdb->last_error;
        }
      }
      if (count($Errors) == 0) {
        Migrations::doEvents();
      }else {
        add_action( 'admin_notices',  Array('\Skytells\SFA\Migrations', '_IENotice'));
      }
    } catch (\Exception $e) {
        add_action( 'admin_notices',  Array('\Skytells\SFA\Migrations', '_IENotice'));
      throw new \Exception($e->getMessage(), 1);

    }

  }

  public static function _IENotice() {
    return '<div class="notice notice-error is-dismissible">
          <p><b>Warning!</b> - There was an errors during the installation of Skytells Guard!<br>Please Reinstall Skytells Guard!.</p>
      </div>';
  }

  public static function PerformUpgrade() {
    global $wpdb, $SFA;
    $CURRENT = SFA_VERSION;
    $Core = $SFA->db->rawQueryOne( "SELECT * FROM {$wpdb->prefix}SFACore WHERE id = '1'");
    if (isset($Core['version'])) {
      switch ($Core['version']) {
        // Upgrade Version 1.2.2 to the current.
        case '1.2.2':
          $err = false; $Data = Migrations::getUpgrade('1.2.2');
          foreach ($Data as $v) {
          $v = str_replace('{Prefix}', $wpdb->prefix, $v); if ($wpdb->query($v)) { $err = false; }else{ $err = true; } }
          if ($err == false) { if ($wpdb->query("UPDATE {$wpdb->prefix}SFACore SET version = '{$CURRENT}' WHERE id = '1'")) { return true; } }

        // Upgrade Version 1.3.0 to the current.
        case '1.3.0':
            $wpdb->query("UPDATE {$wpdb->prefix}SFACore SET version = '{$CURRENT}' WHERE id = '1'");


        // Upgrade Version 1.3.1 to the current.
        case '1.3.1':
          $err = false;
          $Data = Migrations::getUpgrade('1.3.1');
          foreach ($Data as $v) { $v = str_replace('{Prefix}', $wpdb->prefix, $v); if ($wpdb->query($v)) { $err = false; }else{ $err = true; } }
          if ($err == false) { if ($wpdb->query("UPDATE {$wpdb->prefix}SFACore SET version = '{$CURRENT}' WHERE id = '1'")) { return true; } }


        // Upgrade Version 1.3.2 to the current.
        case '1.3.2':
          $wpdb->query("UPDATE {$wpdb->prefix}SFACore SET version = '{$CURRENT}' WHERE id = '1'");

        // Upgrade Version 1.3.3 to the current.
        case '1.3.3':
          $wpdb->query("UPDATE {$wpdb->prefix}SFACore SET version = '{$CURRENT}' WHERE id = '1'");

        // Upgrade Version 1.4.0 to the current.
        case '1.4.0':
          $wpdb->query("UPDATE {$wpdb->prefix}SFACore SET version = '{$CURRENT}' WHERE id = '1'");

        // Upgrade Version 1.4.0 to the current.
        case '1.4.1':
          $wpdb->query("UPDATE {$wpdb->prefix}SFACore SET version = '{$CURRENT}' WHERE id = '1'");

        // Upgrade Version 1.4.1 to the current.
        case '1.4.2':
          $wpdb->query("UPDATE {$wpdb->prefix}SFACore SET version = '{$CURRENT}' WHERE id = '1'");
        default:
          return false;
      }
    }
    return false;
  }

  public static function getUpgrade($v) {
    global $wpdb;
    $upgradeFile = SFA_DATA.'/Migrations/v'.$v;
    $File = str_replace('.', '', $upgradeFile);
    $data = include($File.'.php');

    return $data;
  }

  public static function doEvents($version = false) {
    if (!defined('ABSPATH') || !is_admin()) { exit("No Direct Access"); }
    global $SFA, $wpdb, $_SERVER;
    $domain = esc_sql($_SERVER['SERVER_NAME']);
    $prefix = esc_sql($wpdb->prefix);
    $table_name = esc_sql($wpdb->prefix.'SFACore');
    if( $wpdb->get_var( "SHOW TABLES LIKE '$table_name' ") == $table_name ) {
      $Data = Array('version' => SFA_VERSION, 'pid' => base64_encode(6000), 'sn' => base64_encode('0'), 'domain' => $domain, 'stamp' => getStamp());
      if ($SFA->db->insert('SFACore', $Data)) {
        return true;
      }
      return false;
    }
    return false;
  }


  public static function Uninstall() {
    if (!defined('ABSPATH') || !is_admin()) { exit("No Direct Access"); }
    global $wpdb;
    $tables = array(
      "{$wpdb->prefix}SFAIPBans",
      "{$wpdb->prefix}SFALogins",
      "{$wpdb->prefix}SFACore",
      "{$wpdb->prefix}SFAAttacks",
      "{$wpdb->prefix}SFADailyReports"
    );
    foreach ($tables as $v) {
      $wpdb->query("DROP TABLE IF EXISTS `$v`");
    }
    return true;
  }


}
