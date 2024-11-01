<?php
Namespace Skytells\Crypt;
 Class RSA {
  protected static $PassPhrase = "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCyOmaAM4tXUdI7g";

  public static function generateKeys() {
    if (file_exists(SFA_CERTS.'/public.pem') && file_exists(SFA_CERTS.'/private.pem')) {
      return false;
    }
    $res = openssl_pkey_new();
    openssl_pkey_export($res, $privKey, RSA::$PassPhrase);
    $pubKey = openssl_pkey_get_details($res);
    $pubKey = $pubKey["key"];
    file_put_contents(SFA_CERTS.'/public.pem', $pubKey);
    file_put_contents(SFA_CERTS.'/private.pem', $privKey);
    return true;
  }

  public static function Encrypt($source) {
      $Key=file_get_contents(SFA_CERTS.'/public.pem');
      openssl_get_publickey($Key);
      openssl_public_encrypt($source,$crypttext,$Key);
      return(base64_encode($crypttext));
    }



   public static function Decrypt($source) {
        $Key=file_get_contents(SFA_CERTS.'/private.pem');
        $PK2=openssl_get_privatekey($Key, RSA::$PassPhrase);
        openssl_private_decrypt(base64_decode($source), $out, $PK2);
        return $out;

    }
 }


?>
