<?php

require_once("functions.php");
function getTheUserRealIP(){ if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) { $_SERVER['HTTP_X_REAL_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"]; $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"]; } $client = @$_SERVER['HTTP_CLIENT_IP']; $forward = @$_SERVER['HTTP_X_FORWARDED_FOR']; $remote = $_SERVER['REMOTE_ADDR']; if(filter_var($client, FILTER_VALIDATE_IP)){ $ip = $client; } elseif(filter_var($forward, FILTER_VALIDATE_IP)){ $ip = $forward; } else{ $ip = $remote; } return $ip; }
$ips = array(getTheUserRealIP(),);
$checklist = new IpBlockList( );
foreach ($ips as $ip ) {
	$result = $checklist->ipPass( $ip );
	if ( !$result ) {
		header_remove();
		header("Connection: close\r\n");
		http_response_code(404);
		exit;
		}
}

?>
