<?php
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
require_once($cfg['path']."/headSimple.inc.php");			// 헤더 부분 (스킨포함)



$sktDeviceList = DB::query("SELECT * FROM tmDevice WHERE dvSK = 1 AND dvParent = 0 order by dvId");

foreach($sktDeviceList as $val){	
	
	$dvChild = DB::query("SELECT * FROM tmDevice WHERE dvSK = 1 AND dvParent=%i", $val['dvKey']);	
	if($dvChild){
		foreach ($dvChild as $key => $value){
			$sktDevice[$value['dvKey']] = $value['dvId'];
		}
	}else{
		$sktDevice[$val['dvKey']] = $val['dvId'];
	}
}

$ktDeviceList = DB::query("SELECT * FROM tmDevice WHERE dvKT = 1 AND dvParent = 0 order by dvId");

foreach($ktDeviceList as $val){	
	
	$dvChild = DB::query("SELECT * FROM tmDevice WHERE dvKT = 1 AND dvParent=%i", $val['dvKey']);	
	if($dvChild){
		foreach ($dvChild as $key => $value){
			$ktDevice[$value['dvKey']] = $value['dvId'];
		}
	}else{

		$ktDevice[$val['dvKey']] = $val['dvId'];
	}
} 


require_once("insertDeviceCode.skin.php");


require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)

?>

