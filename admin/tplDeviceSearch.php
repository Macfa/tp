<?php 
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

if(isExist($_POST['serial'])) {
	foreach($_POST as $value) {
		$serialCount = DB::query("SELECT * FROM tmInventoryIn WHERE inSerialNumber=%s", $value);	/* 입고테이블에서 시리얼이 있는지 확인한다 */
		$inCount = DB::query("SELECT count(*) FROM tmInventoryIn WHERE inSerialNumber=%s", $value);	/* 입고테이블에서 시리얼이 있는지 확인한다 */
		$outCount = DB::query("SELECT count(*) FROM tmInventoryOut WHERE inSerialNumber=%s", $value);	/* 출고테이블에서 시리얼이 있는지 확인한다 */
		$result;

		if(isExist($serialCount) == true) {	/* 값이 존재한다면.. */
			if($inCount > $outCount) {	/* 입고건이 출고건보다 많다면 ( 출고페이지 이기에 입고가 출고건보다 많아야함 ) */
				$result = true;
				echo json_encode($result);
			} else {
				echo json_encode($result);
			}
		}
	}
}

 ?>