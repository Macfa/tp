<?php 
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
require_once($cfg['path']."/adminhead.php");			// 헤더 부분 (스킨포함)

$import->addJS('tplDevice.js');
$modelListResult = DB::query("SELECT * FROM tmDevice WHERE dvParent = 0 order by dvModelCode");

foreach($modelListResult as $val){	
	if(isNotExist($val['dvModelCode'])) continue;
	
	$dvChild = DB::query("SELECT * FROM tmDevice WHERE dvParent=%i", $val['dvKey']);	
	if($dvChild){
		foreach ($dvChild as $key => $value){
			$modelList[] = $value['dvModelCode'];
		}
	}else{
		$modelList[] = $val['dvModelCode'];
	}
}

$modelColor = DB::queryOneColumn('dcColor', "SELECT * FROM tmDeviceColor");
$modelColor = array_unique($modelColor);

$chName = DB::query("SELECT chKey, chName, chCarrier FROM tmChannel");

require_once("tplDeviceIn.skin.php");
require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)

 ?>
