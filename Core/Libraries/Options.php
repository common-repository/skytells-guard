<?php
Namespace Skytells\SFA;
Class Option {
  private static $CurrentOptions = [];
  public static function setCurrentOptions($Options) {
    Option::$CurrentOptions = $Options;
  }
  public static function get($key, $type = '', $default = false) {
    switch ($type) {
      case 'bool':
        return (bool)get_option($key, $default);
        break;
      case 'string':
        return (string)get_option($key, $default);
        break;
      case 'int':
        return (int)get_option($key, $default);
        break;
      case 'int':
        return (float)get_option($key, $default);
        break;
      case 'exists':
        if (get_option($key) !== false) { return true; }else { return false; }
        break;
      default:
        return get_option($key, $default);
        break;
    }
  }


  public static function export() {
    $Options = base64_encode(json_encode(Option::$CurrentOptions));
    $file = "Settings.yml";
    file_put_contents(SFA_CORE.'/Data/'.$file, $Options);
    if (file_exists(SFA_CORE.'/Data/'.$file)) {
      @header('Content-Description: File Transfer');
      @header('Content-Type: application/octet-stream');
      @header('Content-Disposition: attachment; filename="'.basename(SFA_CORE.'/Data/'.$file).'"');
      @header('Expires: 0');
      @header('Cache-Control: must-revalidate');
      @header('Pragma: public');
      @header('Content-Length: ' . filesize(SFA_CORE.'/Data/'.$file));
      readfile(SFA_CORE.'/Data/'.$file);
      exit;
    }

  }





}
