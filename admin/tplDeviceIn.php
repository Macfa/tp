<?php 
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
require_once($cfg['path']."/adminhead.php");			// 헤더 부분 (스킨포함)

$import->addJS('tplDevice.js');
$parent = DB::query("SELECT dvKey,dvModelCode FROM tmDevice WHERE dvParent=%i", 0);

foreach($parent as $one => $key){	// parent is dvKey value
	// echo $key['dvKey']."<br/>";
	$check = DB::queryOneField('dvModelCode', "SELECT * FROM tmDevice WHERE dvParent=%i", $key['dvKey']); /*자식기종 불러오기*/
	if(isExist($check))
		$modelList[] = $check;
	else
		$modelList[] = $key['dvModelCode'];
}

$modelList = array_filter($modelList);

$modelColor = DB::queryOneColumn('dcColor', "SELECT * FROM tmDeviceColor");
$modelColor = array_unique($modelColor);

require_once("tplDeviceIn.skin.php");
require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)

 ?>
