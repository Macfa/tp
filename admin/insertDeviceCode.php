<?php
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

require_once($cfg['path']."/adminhead.php");			// 헤더 부분 (스킨포함)


$arrChannel = DB::query("SELECT * FROM tmChannel");


$sktDeviceList = DB::query("SELECT * FROM tmDevice WHERE dvParent = 0 order by dvModelCode");

foreach($sktDeviceList as $val){	


$arrDevice = DB::query("SELECT * FROM tmDevice WHERE dvParent = 0 order by dvModelCode");

foreach($arrDevice as $val){	
	
	$dvChild = DB::query("SELECT * FROM tmDevice WHERE dvParent=%i", $val['dvKey']);	
	if($dvChild){
		foreach ($dvChild as $key => $value){

				$device[$value['dvKey']]['id'] = $value['dvId'];
				$device[$value['dvKey']]['model'] = $value['dvModelCode'];
			}
		}else{
			$device[$val['dvKey']]['id'] = $val['dvId'];
			$device[$val['dvKey']]['model'] = $val['dvModelCode'];
		}
	}
}
// echo '<pre>';
// var_dump($device);
// echo '</pre>';

require_once("insertDeviceCode.skin.php");


require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)

?>