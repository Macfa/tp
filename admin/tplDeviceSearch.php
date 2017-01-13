<?php 
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

if(isExist($_POST['serial'])) {
	foreach($_POST as $value) {
		$serialCount = DB::query("SELECT * FROM tmInventoryIn WHERE inSerialNumber=%s", $value);	/* 입고테이블에서 시리얼이 있는지 확인한다 */

		$count = count($serialCount);
		$result;

		if($count > 0) {
			$result = true;
			echo json_encode($result);
		} else {
			echo json_encode($result);
		}
	}
}


 ?>