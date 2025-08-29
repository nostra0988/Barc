<?php 
session_start();
require "classes/admin.class.php";


$admin = new Admin;
$admin->setDataFile("data/admin.json");


if(isset($_POST['update'])){
	$block_pc = $_POST['block_pc'];
	$notif = $_POST['notifications'];
	$shutdown = $_POST['shutdown'];
	$bot = $_POST['bot_token'];
	$chat_id = $_POST['chat_id'];
	$arr = array("pc_block"=>$block_pc, "notifications"=>$notif, "shutdown"=>$shutdown, "telegram_bot"=>$bot,
	"telegram_id"=>$chat_id);
$admin->update("settings", $arr);
}

header("location: settings.php?update=success");

?>