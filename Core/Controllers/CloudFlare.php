<?php
Namespace Skytells\SFA;
Class CloudFlare {

  public static function BanIP($ipaddr, $Reason = 'SUSPECTED_ATTACKER'){
    $Email = (get_option('SFA_cloudflare_email') != false && !empty(get_option('SFA_cloudflare_email'))) ? get_option('SFA_cloudflare_email') : null;
    $Key = (get_option('SFA_cloudflare_key') != false && !empty(get_option('SFA_cloudflare_key'))) ? get_option('SFA_cloudflare_key') : null;

  	$cfheaders = array(
  		'Content-Type: application/json',
  		'X-Auth-Email: '.$Email,
  		'X-Auth-Key: '.$Key
  	);
  	$data = array(
  		'mode' => 'block',
  		'configuration' => array('target' => 'ip', 'value' => $ipaddr),
  		'notes' => 'Banned on '.date('Y-m-d H:i:s').' by Skytells Guard, Reason: '.$Reason
  	);
  	$json = json_encode($data);
  	$ch = curl_init();
  	curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
  	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  	curl_setopt($ch, CURLOPT_HTTPHEADER, $cfheaders);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,  false);
  	curl_setopt($ch, CURLOPT_URL, 'https://api.cloudflare.com/client/v4/user/firewall/access_rules/rules');
  	$return = curl_exec($ch);
  	curl_close($ch);
  	if ($return === false){
  		return false;
  	}else{
  		$return = json_decode($return,true);
  		if(isset($return['success']) && $return['success'] == true){
  			return $return['result']['id'];
  		}else{
  			return false;
  		}
  	}
  }

  public static function UnbanIP($block_rule_id){
    $Email = (get_option('SFA_cloudflare_email') != false && !empty(get_option('SFA_cloudflare_email'))) ? get_option('SFA_cloudflare_email') : null;
    $Key = (get_option('SFA_cloudflare_key') != false && !empty(get_option('SFA_cloudflare_key'))) ? get_option('SFA_cloudflare_key') : null;

  	$cfheaders = array(
  		'Content-Type: application/json',
  		'X-Auth-Email: '.$Email,
  		'X-Auth-Key: '.$Key
  	);
  	$ch = curl_init();
  	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
  	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  	curl_setopt($ch, CURLOPT_HTTPHEADER, $cfheaders);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,  false);
  	curl_setopt($ch, CURLOPT_URL, 'https://api.cloudflare.com/client/v4/user/firewall/access_rules/rules/'.$block_rule_id);
  	$return = curl_exec($ch);
  	curl_close($ch);
  	if ($return === false){
  		return false;
  	}else{
  		$return = json_decode($return,true);
  		if(isset($return['success']) && $return['success'] == true){
  			return $return['result']['id'];
  		}else{
  			return false;
  		}
  	}
  }
}
