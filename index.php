<?
/*
Plugin Name: Skytells AI-Powered Guard
Plugin URI: https://www.skytells.org/products/guard?source=plugin
Description: The Ultimate AI-Powered Security System for your WordPress!
Author: Skytells, Inc.
Author URI: http://www.skytells.org
Tags: anti-virus, firewall, security, faceid, remove, version, generator, security, meta, appended version, css ver, js ver, faceid, face id, facial recognition, security, login security, change admin, scanner, anti-spam, anti-virus, protection, secure, ultimate security, sql injection, xss, secure wordpress
Version: 1.4.3
Text Domain: skytells-guard
License: GPLv2 or later.
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/
use Skytells\SFA,
    Skytells\SFA\Core,
    Skytells\SFA\Foundation,
    Skytells\SFA\Guard;
require __DIR__.'/Constants.php';
require SFA_PATH.'/Bootstrap.php';
if (SFA_CHECKLIST === true) {
global $SFA_SUMMARY, $SFA;
// ------------------

add_action( 'admin_enqueue_scripts', array('Skytells\SFA\Dashboard', 'initScripts' ) );
add_action('admin_menu',  array('Skytells\SFA\Dashboard', 'Init' ));

$SFA = new Guard();
 $SFA->run();
 SFA_ServeActions();
 SFA_Serve();
 try {
   @register_activation_hook( __FILE__, [$SFA,'activate']);
   @register_deactivation_hook( __FILE__, [$SFA,'deactivate']);
  } catch (\Exception $e) { }
 $SFA->db->__destruct();
}
