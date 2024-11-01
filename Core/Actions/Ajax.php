<?php
use Skytells\SFA\UI,
    Skytells\SFA\Core,
    Skytells\SFA\Activities,
    Skytells\SFA\Uri;

function SFA_AjaxActions() {
  if (isset($_REQUEST['action'])) {

    // Attacks Modal Callback
    if (isset($_REQUEST['attid']) && !empty($_REQUEST['attid']) && $_REQUEST['SFA_AjaxAction'] == 'getAttack') {
       if( md5($_REQUEST['attid'].$_REQUEST['ip']) != $_REQUEST['token']) { exit('error performing this request'); }
       if (!is_admin()) { die(); }
       UI::render('Modals.ViewAttack', ['attack' => Skytells\SFA\Activities::getAttackById((int)$_REQUEST['attid'])]);
       wp_die();
    }

    // Logins Modal Callback
    if (isset($_REQUEST['loginid']) && !empty($_REQUEST['loginid']) && $_REQUEST['SFA_AjaxAction'] == 'getLoginDetails') {
       if( md5($_REQUEST['loginid'].$_REQUEST['ip']) != $_REQUEST['token']) { exit('error performing this request'); }
       if (!is_admin()) { die(); }
       UI::render('Modals.ViewLogin', ['login' => Skytells\SFA\Activities::getLoginDetailsById((int)$_REQUEST['loginid'])]);
       wp_die();
    }

    // IP Whois Modal Callback
    if (Uri::request('SFA_AjaxAction') == 'getIPInfo' && Uri::request('ip', 'exists')) {
      if (!is_admin()) { die(); }
      if( Uri::request('token', 'exists') && md5($_REQUEST['ip']) != $_REQUEST['token']) {
         exit('error performing this request');
       }
       if (!Skytells\SFA::CL()) {  UI::render('Modals.IPInfo'); wp_die(); }
      $IP = Uri::request('ip', 'string');

      $Info = \Skytells\SFA\GeoIP::getInfo($IP);
      UI::render('Modals.IPInfo', ['data' => $Info]);
      wp_die();
    }




    // Face ID Train
    if (Uri::request('SFA_AjaxAction') == 'train_faceid_ui') {
      if (!is_admin()) { die("Cannot perform this request at the time."); }
      if (Uri::request('token')!= md5('faceid')) {
        die("Cannot perform this request at the time.");
      }
      global $SFA;
      echo "<style>";
      echo ".sweet-modal-content{padding:1px !important;}";
      echo "</style>";
      echo "<iframe src='".admin_url('admin.php?page=sfa-faceid-enroll&widget=true')."' style='border:none; padding:0px; margin:0px; width:100%; min-height:760px;'></iframe>";
      wp_die();
    }

    // Face ID Enroll
    if (Uri::request('SFA_Action') == 'train' && Uri::request('subject_id', 'exists') && Uri::request('image', 'exists') && Uri::request('uid', 'exists')) {
      if (!is_admin()) { die("Cannot perform this request at the time."); }
      if (Uri::request('subject_id').md5('o$v(2)') != (string)Uri::request('sfatoken')) {
        die("Cannot perform this request at the time.");
      }
      global $SFA;
      echo \Skytells\SFA\FaceID::Train((int)Uri::request('uid'), (string)Uri::request('subject_id'), Uri::request('image'), get_option('SFA_Skytells_API_KEY'));
      wp_die();
    }



    // Face ID Recognize
    if (Uri::request('SFA_Action') == 'recognize' && Uri::request('subject_id', 'exists') && Uri::request('image', 'exists') && Uri::request('uid', 'exists')) {
      if (!is_admin()) { die("Cannot perform this request at the time."); }
      if (Uri::request('subject_id').md5('o$v(2)') != (string)Uri::request('sfatoken')) {
        die("Cannot perform this request at the time.");
      }
      global $SFA;
      //@header('Content-Type: application/json;charset=utf-8');
      echo \Skytells\SFA\FaceID::Recognize((int)Uri::request('uid'), Uri::request('image'), get_option('SFA_Skytells_API_KEY'));
      wp_die();
    }






  }
}
