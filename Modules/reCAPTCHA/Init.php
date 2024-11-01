<?php
if ( !function_exists( 'add_action' ) ) {
    die();
}

class SFA_reCaptcha {

    public static function init() {
        add_action( 'plugins_loaded', array('SFA_reCaptcha', 'load_textdomain') );
        add_action( 'admin_menu', array('SFA_reCaptcha', 'register_menu_page' ));
        add_action( 'admin_init', array('SFA_reCaptcha', 'register_settings' ));
      //  add_action( 'admin_notices', array('SFA_reCaptcha', 'admin_notices' ));

    }
    public static function PerformModuleActions() {
      if (SFA_reCaptcha::valid_key_secret(get_option('sfa_recaptcha_key')) &&
          SFA_reCaptcha::valid_key_secret(get_option('sfa_recaptcha_secret')) ) {
        add_action('login_enqueue_scripts', array('SFA_reCaptcha', 'enqueue_scripts_css'));
        add_action('admin_enqueue_scripts', array('SFA_reCaptcha', 'enqueue_scripts_css'));
        add_action('login_form',array('SFA_reCaptcha', 'nocaptcha_form'));
        //add_action('lostpassword_form', array('SFA_reCaptcha', 'nocaptcha_form'));
        add_action('authenticate', array('SFA_reCaptcha', 'authenticate'), 30, 3);
        //add_action('lostpassword_post', array('SFA_reCaptcha', 'authenticate'), 30, 3);
      }
    }
    public function InitAdminMenu() {

    }
    public static function viewSettings() {
      require __DIR__.'/Settings.php';
    }
    public static function load_textdomain() {
        load_plugin_textdomain( 'sfa_recaptcha', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    }

    public static function register_menu_page(){
        add_submenu_page('skytells-guard', 'reCaptcha Options', 'reCaptcha Options', 'manage_options', 'sfa-recaptcha', array('SFA_reCaptcha', 'viewSettings'));
    }

    public static function register_settings() {

        /* user-configurable values */
        add_option('sfa_recaptcha_key', '');
        add_option('sfa_recaptcha_secret', '');

        /* user-configurable value checking public static functions */
        register_setting( 'sfa_recaptcha', 'sfa_recaptcha_key', 'SFA_reCaptcha::filter_string' );
        register_setting( 'sfa_recaptcha', 'sfa_recaptcha_secret', 'SFA_reCaptcha::filter_string' );

        /* system values to determine if captcha is working and display useful error messages */
        add_option('sfa_recaptcha_working', false);
        add_option('sfa_recaptcha_error', sprintf(__('Skytells reCaptcha has not been properly configured. <a href="%s">Click here</a> to configure.','sfa_recaptcha'), 'admin.php?page=sfa-recaptcha'));
        add_option('sfa_recaptcha_message_type', 'update-nag');
        if (SFA_reCaptcha::valid_key_secret(get_option('sfa_recaptcha_key')) &&
           SFA_reCaptcha::valid_key_secret(get_option('sfa_recaptcha_secret')) ) {
            update_option('sfa_recaptcha_working', true);
        } else {
            update_option('sfa_recaptcha_working', false);
            update_option('sfa_recaptcha_message_type', 'update-nag');
            update_option('sfa_recaptcha_error', sprintf(__('Skytells reCaptcha has not been properly configured. <a href="%s">Click here</a> to configure.','sfa_recaptcha'), 'admin.php?page=sfa-recaptcha'));
        }
    }

    public static function filter_string( $string ) {
        return trim(filter_var($string, FILTER_SANITIZE_STRING)); //must consist of valid string characters
    }

    public static function valid_key_secret( $string ) {
        if (strlen($string) === 40) {
            return true;
        } else {
            return false;
        }
    }

    public static function register_scripts_css() {
        wp_register_script('sfa_recaptcha_google_api', 'https://www.google.com/recaptcha/api.js?hl='.get_locale() );
        wp_register_style('sfa_recaptcha_css', plugin_dir_url( __FILE__ ) . 'css/style.css');
    }

    public static function enqueue_scripts_css() {
        if(!wp_script_is('sfa_recaptcha_google_api','registered')) {
            SFA_reCaptcha::register_scripts_css();
        }
        wp_enqueue_script('sfa_recaptcha_google_api');
        wp_enqueue_style('sfa_recaptcha_css');
    }

    public static function get_google_errors_as_string( $g_response ) {
        $string = '';
        $codes = array( 'missing-input-secret' => __('The secret parameter is missing.','sfa_recaptcha'),
                        'invalid-input-secret' => __('The secret parameter is invalid or malformed.','sfa_recaptcha'),
                        'missing-input-response' => __('The response parameter is missing.','sfa_recaptcha'),
                        'invalid-input-response' => __('The response parameter is invalid or malformed.','sfa_recaptcha')
                        );
        foreach ($g_response->{'error-codes'} as $code) {
            $string .= $codes[$code].' ';
        }
        return trim($string);
    }

    public static function nocaptcha_form() {
        echo sprintf('<div class="g-recaptcha" data-sitekey="%s" data-callback="submitEnable" data-expired-callback="submitDisable"></div>', get_option('sfa_recaptcha_key'))."\n";
        echo '<script>'."\n";
		echo "    function submitEnable() {document.getElementById('wp-submit').removeAttribute('disabled');}";
		echo "    function submitDisable() {document.getElementById('wp-submit').setAttribute('disabled','disabled');}";
        echo "    function docready(fn){/in/.test(document.readyState)?setTimeout('docready('+fn+')',9):fn()}";
        echo "    docready(function() {submitDisable();});";
		echo '</script>'."\n";
        echo '<noscript>'."\n";
        echo '  <div style="width: 100%; height: 473px;">'."\n";
        echo '      <div style="width: 100%; height: 422px; position: relative;">'."\n";
        echo '          <div style="width: 302px; height: 422px; position: relative;">'."\n";
        echo sprintf('              <iframe src="https://www.google.com/recaptcha/api/fallback?k=%s"', get_option('sfa_recaptcha_key'))."\n";
        echo '                  frameborder="0" scrolling="no"'."\n";
        echo '                  style="width: 302px; height:422px; border-style: none;">'."\n";
        echo '              </iframe>'."\n";
        echo '          </div>'."\n";
        echo '          <div style="width: 100%; height: 60px; border-style: none;'."\n";
        echo '              bottom: 12px; left: 25px; margin: 0px; padding: 0px; right: 25px; background: #f9f9f9; border: 1px solid #c1c1c1; border-radius: 3px;">'."\n";
        echo '              <textarea id="g-recaptcha-response" name="g-recaptcha-response"'."\n";
        echo '                  class="g-recaptcha-response"'."\n";
        echo '                  style="width: 250px; height: 40px; border: 1px solid #c1c1c1;'."\n";
        echo '                  margin: 10px 25px; padding: 0px; resize: none;" value="">'."\n";
        echo '              </textarea>'."\n";
        echo '          </div>'."\n";
        echo '      </div>'."\n";
        echo '</div><br>'."\n";
        echo '</noscript>'."\n";
    }

    public static function authenticate($user, $username, $password) {
        if (isset($_POST['g-recaptcha-response'])) {
            $response = SFA_reCaptcha::filter_string($_POST['g-recaptcha-response']);
            $remoteip = $_SERVER["REMOTE_ADDR"];
            $secret = get_option('sfa_recaptcha_secret');
            $payload = array('secret' => $secret, 'response' => $response, 'remoteip' => $remoteip);
            $result = wp_remote_post('https://www.google.com/recaptcha/api/siteverify', array('body' => $payload) );
            if (is_a($result,'WP_Error')) { // disable SSL verification for older cURL clients
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                $result = curl_exec($ch);
                $g_response = json_decode( $result );
            } else {
                $g_response = json_decode($result['body']);
            }
            if (is_object($g_response)) {
                if ( $g_response->success ) {
                    update_option('sfa_recaptcha_working', true);
                    return $user; // success, let them in
                } else {
                    if ( isset($g_response->{'error-codes'}) && $g_response->{'error-codes'} && in_array('missing-input-response', $g_response->{'error-codes'})) {
                        update_option('sfa_recaptcha_working', true);
                        return new WP_Error('denied', __('Please check the ReCaptcha box.','sfa_recaptcha'));
                    } else if ( isset($g_response->{'error-codes'}) && $g_response->{'error-codes'} &&
                                (in_array('missing-input-secret', $g_response->{'error-codes'}) || in_array('invalid-input-secret', $g_response->{'error-codes'})) ) {
                        update_option('sfa_recaptcha_working', false);
                        update_option('sfa_recaptcha_google_error', 'error');
                        update_option('sfa_recaptcha_error', sprintf(__('Skytells reCaptcha is not working. <a href="%s">Please check your settings</a>. The message from Google was: %s', 'sfa_recaptcha'),
                                                               'admin.php?page=sfa-recaptcha',
                                                                self::get_google_errors_as_string($g_response)));
                        return $user; //invalid secret entered; prevent lockouts
                    } else if( isset($g_response->{'error-codes'})) {
                        update_option('sfa_recaptcha_working', true);
                        return new WP_Error('denied', __('Incorrect ReCaptcha, please try again.','sfa_recaptcha'));
                    } else {
                        update_option('sfa_recaptcha_working', false);
                        update_option('sfa_recaptcha_google_error', 'error');
                        update_option('sfa_recaptcha_error', sprintf(__('Skytells reCaptcha is not working. <a href="%s">Please check your settings</a>.', 'sfa_recaptcha'), 'admin.php?page=sfa-recaptcha').' '.__('The response from Google was not valid.','sfa_recaptcha'));
                        return $user; //not a sane response, prevent lockouts
                    }
                }
            } else {
                update_option('sfa_recaptcha_working', false);
                update_option('sfa_recaptcha_google_error', 'error');
                update_option('sfa_recaptcha_error', sprintf(__('Skytells reCaptcha is not working. <a href="%s">Please check your settings</a>.', 'sfa_recaptcha'), 'admin.php?page=sfa-recaptcha').' '.__('The response from Google was not valid.','sfa_recaptcha'));
                return $user; //not a sane response, prevent lockouts
            }
        } else {
            update_option('sfa_recaptcha_working', false);
            update_option('sfa_recaptcha_google_error', 'error');
            update_option('sfa_recaptcha_error', sprintf(__('Skytells reCaptcha is not working. <a href="%s">Please check your settings</a>.', 'sfa_recaptcha'), 'admin.php?page=sfa-recaptcha').' '.__('There was no response from Google.','sfa_recaptcha') );
            return $user; //no response from Google
        }
    }

    public static function admin_notices() {
        if(false == get_option('sfa_recaptcha_working')) {
            echo '<div class="update-nag">'."\n";
            echo '    <p>'."\n";
            echo get_option('sfa_recaptcha_error');
            echo '    </p>'."\n";
            echo '</div>'."\n";
        }
    }
}
