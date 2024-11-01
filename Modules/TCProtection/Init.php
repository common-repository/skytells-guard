<?php
Namespace Skytells\SFA;
use Skytells\SFA\SF_Module;
Class TCProtection extends SFA_Module {
  public static function Start() {

     add_action( 'wp_footer', function(){
       $msg = get_option('SFA_TCProtection_msg', 'Copy & Paste is not allowed in our website!');
       echo "<script>document.addEventListener('copy', function(e) {
       e.clipboardData.setData('text/plain', '$msg');
       e.clipboardData.setData('text/html', '<b>$msg</b>');
       e.preventDefault();});</script>";
     });
    
  }
}
