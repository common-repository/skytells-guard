<?

function getSFAURL() {
  $url = trailingslashit(plugins_url("", __FILE__));
  return $url;
}

function sfa_boot($callback) {
    $callback = ucfirst($callback);
  $SFA_php = substr(phpversion(), 0, 3);
  $c = __DIR__.'/Core/Environments/env-'.$SFA_php.'/'.$callback.'.php';
  if (file_exists($c)) {
    require $c;
    return true;
  }else {
      require __DIR__.'/Core/Environments/env-global/'.$callback.'.php';
    return false;
  }
}



function SFA_xss_clean($data) {
  // Fix &entity\n;
  $data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
  $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
  $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
  $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

  // Remove any attribute starting with "on" or xmlns
  $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

  // Remove javascript: and vbscript: protocols
  $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
  $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
  $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

  // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
  $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
  $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
  $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

  // Remove namespaced elements (we do not need them)
  $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

  do
  {
      // Remove really unwanted tags
      $old_data = $data;
      $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
  }
  while ($old_data !== $data);

  // we are done...
  return $data;
}

function SFA_Secure($string, $HTMLFILTER = false, $XSSCLEAN = false, $USE_FILTERS = false, $FILTERS = '') {
    $string = stripslashes($string);
    $string = strip_tags($string);
    $string = htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    if ($HTMLFILTER === true) {
      $string = filter_var($string, FILTER_SANITIZE_EMAIL);
    }
    if ($XSSCLEAN === true) {
      $string = SFA_xss_clean($string);
    }
    if ($USE_FILTERS === true && $FILTERS == 'IP') {
      $string = filter_var($string, FILTER_VALIDATE_IP);
    }
    return $string;
}
function SFA_toObject($array) {
    $object = new stdClass();
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $value = SFA_toObject($value);
        }
        $object->$key = $value;
    }
    return $object;
  }


function calcStamp($Period = '+ 365 day') {
   return gmdate('Y-m-d G:i:s',strtotime(gmdate("Y-m-d G:i:s", time()) . $Period));
}
function sfa_view($file, $Data = false) {
  $file = str_replace('.', '/', $file);
  return include __DIR__.'/Views/'.$file.'.php';
}

function sfa_alert($file, $SFA_ALERT = false) {
  $file = str_replace('.', '/', $file);
  return include __DIR__.'/Views/UI/Alerts/'.$file.'.ui.php';
}

function layout_import($file, $_SKYVARS = false) {
  return include __DIR__.'/Views/Layouts/'.$file.'.php';
}

function SFA_ServeActions() {
  foreach (glob(SFA_PATH.'/Core/Actions/*.php') as $filename) {
    require $filename;
  }

}


function oxygen_import($file, $_SKYVARS = []) {
  \Skytells\SFA\UI::render($file, $_SKYVARS);
}



function sfa_enqueue_styles(){
  wp_enqueue_style('skytells-bootrtrap_css',  plugin_dir_url( __FILE__ ) . '/assets/css/bootstrap.min.css');
}

function skytells_ago($ptime, $tense='ago') {
  if (!is_numeric($ptime)) {
    $d = new DateTime($ptime);
    $ptime = $d->getTimestamp();
  }
  $etime = time() - $ptime;

    if( $etime < 1 )
    {
        return 'less than '.$etime.' second ago';
    }

    $a = array( 12 * 30 * 24 * 60 * 60  =>  'year',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60            =>  'day',
                60 * 60             =>  'hour',
                60                  =>  'minute',
                1                   =>  'second'
    );

    foreach( $a as $secs => $str )
    {
        $d = $etime / $secs;

        if( $d >= 1 )
        {
            $r = round( $d );
            return $r . ' ' . $str . ( $r > 1 ? 's' : '' ) . ' ago';
        }
    }
}

function sfa_admin_notice_download() {
    ?>
    <div class="notice notice-error is-dismissible">
        <p><?php _e( '<b>Warning!</b> - Skytells Guard Plugin is currently offline!<br>Skytells is unable to download the latest requirements for this plugin.' ); ?></p>
    </div>
    <?php
}


function sfa_admin_notice_php() {
    ?>
    <div class="notice notice-error is-dismissible">
        <p><?php _e( '<b>Warning!</b> - Skytells Guard Plugin is currently offline!<br>Because your PHP version is not supported by Skytells Guard<br>
        Please ask your web hosting provider to support one of the following php versions (5.5, 5.6 or 7.1)' ); ?></p>
    </div>
    <?php
}


function SFAdownloadZipFile($url, $filepath, $rawFile){
  $file_stamp = __DIR__.'/Core/Packages/'.md5(SFA_VERSION).'.pem';
  if (file_exists($file_stamp) && file_exists(SFA_PATH.'/Core/Foundation.php') && file_get_contents($file_stamp) == SFA_VERSION) {
    return true;
  }
  set_time_limit(0);

  $tmppath = $filepath;

  $fp = fopen ($tmppath, 'w+');

  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_TIMEOUT, 0);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt($ch, CURLOPT_FILE, $fp);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_exec($ch);
  curl_close($ch);
  fclose($fp);
  if (file_exists($file_stamp)) {  unlink($file_stamp); }
  file_put_contents($file_stamp, SFA_VERSION);
    return true;
 }


function sfa_install($file, $rawFile) {
  $file = __DIR__.'/Core/Packages/'.$file.'.zip';
  $file_stamp = __DIR__.'/Core/Packages/'.md5(SFA_VERSION).'.pem';
  $res = @SFAdownloadZipFile('https://v2.skytells.org/wp-plugins/skytells-guard-libs.zip', $file, $rawFile);
  $destination =  __DIR__.'/';
  $zip = new ZipArchive;
  $res = $zip->open($file);
  if ($res === TRUE)
  {
      @$zip->extractTo($destination);
      @$zip->close();
      define('SFA_DOWNLOADED', true);
      return true;
  }
  else
  {
    add_action( 'admin_notices', 'sfa_admin_notice_download' );
    define('SFA_DOWNLOADED', false);
    return false;
  }
}


function getStamp() {
  return gmdate('Y-m-d G:i:s');
}
function sfa_plugin_activation( $plugin, $network_activation ) {
}


function sfa_activate() {
}


function SFA_Serve() {
  if (is_admin()) {
    add_action( 'wp_ajax_sfa', 'SFA_AjaxActions' );
  }
}
define ('SKYTELLS_ASSETS', getSFAURL().'/assets/');
define ('SFA_ACTIONS_URL', getSFAURL().'/Core/Actions/');
define ('SFA_AJAX_URL', SFA_ACTIONS_URL.'Ajax.php');
