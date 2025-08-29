<?php 
 
class Admin{

public $JSON_FILE = 0;
public $JSON_DATA = 0;
public $JSON_DECODED_DATA = 0;
public $JSON_UPDATES = 0;

public function setDataFile($PATH){
	$this->JSON_FILE = $PATH;
	$this->JSON_DATA = file_get_contents($this->JSON_FILE);
}

public function getData(){
	return json_decode($this->JSON_DATA, true);
}

public function update($root, $arr){
	$data = $this->getData();
		foreach($arr as $k=>$v){
		$data[$root][$k] = str_replace('"', "'", $v);
		$update = json_encode($data);
		file_put_contents($this->JSON_FILE, $update);
		}

}

}



?>