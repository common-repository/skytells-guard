<?php
Namespace Skytells\SFA;
Class Uri {

  public static function instance() { return new Uri(); }

  public static function get($Key, $ReturnType = 'default') {
    global $_GET;
    return Uri::getData($_GET, $Key, $ReturnType);
  }

  public static function post($Key, $ReturnType = 'default') {
    global $_POST;
    return Uri::getData($_POST, $Key, $ReturnType);
  }

  public static function request($Key, $ReturnType = 'default') {
    global $_REQUEST;
    return Uri::getData($_REQUEST, $Key, $ReturnType);
  }




  public static function getData($Array, $Key, $ReturnType = 'default') {
    if (isset($Array[$Key])) {
      switch ($ReturnType) {
        case 'bool':
          return (bool)$Key;
          break;
        case 'exist':
            return true;
          break;
        case 'exists':
            return true;
          break;
        case 'string':
          $Key = htmlspecialchars($Array[$Key], ENT_QUOTES, 'UTF-8');
          return (string)$Key;
          break;
        case 'int':
          $Key = (is_numeric($Array[$Key])) ? $Array[$Key] : false;
          return (string)$Key;
          break;

        case 'default':
          $Key = htmlspecialchars($Array[$Key], ENT_QUOTES, 'UTF-8');
          return (string)$Key;
          break;

        default:
          $Key = htmlspecialchars($Array[$Key], ENT_QUOTES, 'UTF-8');
          return $Key;
          break;
      }
    }
    return false;
  }


}
