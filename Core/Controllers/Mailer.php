<?php
Namespace Skytells\SFA;
Class Mailer {
  public static function send($subject, $message) {
    $to = get_option('admin_email');
    $subject = $subject;
    $message = $message;
    if (defined('wp_mail')) {
        wp_mail($to, $subject, $message);
    }else {
      $headers = 'From: Skytells Guard <noreply@skytells.org>' . "\r\n";
      $headers .= "Reply-To: ". strip_tags($to) . "\r\n";
      $headers .= "MIME-Version: 1.0\r\n";
      $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
      $message = str_replace("\r\n", '<br>', $message);
      mail($to, $subject, $message, $headers);
    }

  }



}
