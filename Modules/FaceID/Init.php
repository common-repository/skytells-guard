<?php
Namespace Skytells\SFA;
use Skytells\SFA\UI;
Class FaceIDModule {

  public $__options;
  public function __construct(){
    $this->__setDefaultOptions();
    register_activation_hook(__FILE__, array($this, 'activate'));
    register_deactivation_hook(__FILE__, array($this, 'deactivate'));
    add_action('admin_init', array($this, 'adminInit'));
    add_action('admin_menu', array($this, 'menuInit'));

    $this->SessionHash = '%48@9_2';

    return $this;
  }

  public function activate() {

  }


  public function deactivate() {

  }


  public function menuInit() {
       Dashboard::InitModule(__('Face ID', 'sfa-faceid'), 'Face ID', 'sfa-faceid', array($this, 'FaceIDSettings'));
  }
  public function FaceIDSettings() {

   global $_POST, $SFA;
   if (isset($_POST['reset'])) { //Reset settings
      $this->__deleteOptions();
       $this->__registerOptions();
    }
       $this->__fillOptions();
       $User = $SFA->db->where('id', $SFA->User->ID)->getOne('users');
       $News = $SFA->getAPINews();


       UI::render('Modules.FaceID.Settings', ['ctl' => $this, 'options' => $this->__options, 'news' => $News, 'User' => $User]);
       if (isset($_POST['reset']) ) {
        UI::render('Alerts.Notify', ['message' => 'Your changes has been successfully reset to the default settings!', 'type' => 'success', 'icon' => 'ti-shield']);
       }

  }
  public function adminInit() {

    $this->__registerOptions();
  }
  private function __setDefaultOptions() {
      $this->__options = array(
          'FaceID'  => false,
          'Skytells_API_KEY' => '',
          'FaceID_Auto'  => true,
          'FaceID_Timer' => 5,
          'FaceID_AI'  => true,
          'FaceID_Attention' => false,
          'FaceID_MaxTries' => 5,
          'FaceID_Limitation'  => true,
          'FaceID_Revoke_Session'  => false,
          'FaceID_Revoke_Session_Attempts' => 2,
          'FaceID_FrontendAllowed'  => false
      );
  }
  private function __fillOptions() {

      $this->__options['FaceID'] = get_option('SFA_'.'FaceID', $this->__options['FaceID']);
      $this->__options['Skytells_API_KEY'] = get_option('SFA_'.'Skytells_API_KEY', $this->__options['Skytells_API_KEY']);
      $this->__options['FaceID_Auto'] = get_option('SFA_'.'FaceID_Auto', $this->__options['FaceID_Auto']);
      $this->__options['FaceID_Timer'] = get_option('SFA_'.'FaceID_Timer', $this->__options['FaceID_Timer']);
      $this->__options['FaceID_AI'] = get_option('SFA_'.'FaceID_AI', $this->__options['FaceID_AI']);
      $this->__options['FaceID_Attention'] = get_option('SFA_'.'FaceID_Attention', $this->__options['FaceID_Attention']);
      $this->__options['FaceID_Limitation'] = get_option('SFA_'.'FaceID_Limitation', $this->__options['FaceID_Limitation']);
      $this->__options['FaceID_MaxTries'] = get_option('SFA_'.'FaceID_MaxTries', $this->__options['FaceID_MaxTries']);
      $this->__options['FaceID_Revoke_Session'] = get_option('SFA_'.'FaceID_Revoke_Session', $this->__options['FaceID_Revoke_Session']);
      $this->__options['FaceID_Revoke_Session_Attempts'] = get_option('SFA_'.'FaceID_Revoke_Session_Attempts', $this->__options['FaceID_Revoke_Session_Attempts']);
      $this->__options['FaceID_FrontendAllowed'] = get_option('SFA_'.'FaceID_FrontendAllowed', $this->__options['FaceID_FrontendAllowed']);
  }

  private function __fillOption($name) {
      $this->__options[$name] = get_option('SFA_' . $name, $this->__options[$name]);
  }

  private function __registerOptions() {
    register_setting('sfa-faceid', 'SFA_Skytells_API_KEY');
    register_setting('sfa-faceid', 'SFA_FaceID_Auto', true);
    register_setting('sfa-faceid', 'SFA_FaceID_Timer');
    register_setting('sfa-faceid', 'SFA_FaceID_AI');
    register_setting('sfa-faceid', 'SFA_FaceID_Attention');
    register_setting('sfa-faceid', 'SFA_FaceID_Limitation');
    register_setting('sfa-faceid', 'SFA_FaceID_MaxTries');
    register_setting('sfa-faceid', 'SFA_FaceID', false);
    register_setting('sfa-faceid', 'SFA_FaceID_Revoke_Session', false);
    register_setting('sfa-faceid', 'SFA_FaceID_Revoke_Session_Attempts');
    register_setting('sfa-faceid', 'SFA_FaceID_FrontendAllowed', false);
  }


  public function __deleteOptions() {
    delete_option('SFA_FaceID');
    delete_option('SFA_Skytells_API_KEY');
    delete_option('SFA_FaceID_Auto');
    delete_option('SFA_FaceID_Timer');
    delete_option('SFA_FaceID_AI');
    delete_option('SFA_FaceID_Attention');
    delete_option('SFA_FaceID_Limitation');
    delete_option('SFA_FaceID_MaxTries');
    delete_option('SFA_FaceID_Revoke_Session');
    delete_option('SFA_FaceID_Revoke_Session_Attempts');
    delete_option('SFA_FaceID_FrontendAllowed');

  }

}
