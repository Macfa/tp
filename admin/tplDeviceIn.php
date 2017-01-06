<?php 
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
require_once($cfg['path']."/adminhead.php");			// 헤더 부분 (스킨포함)

$import->addJS('tplDevice.js');

$parent = DB::query("SELECT dvKey FROM tmDevice WHERE dvParent=%i", 0);

foreach($parent as $one => $key){
	$check = DB::query("SELECT dvModelCode FROM tmDevice WHERE dvParent=%i", $key['dvKey']); /*자식기종 불러오기*/
	foreach($check as $two => $value) {
		if($value) {
			$modelList[] = $value['dvModelCode'];
		} else {
			$modelList[] = $key['dvModelCode'];
		}
	}
}
$modelList = array_filter($modelList);

require_once("tplDeviceIn.skin.php");
require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)

 ?>
