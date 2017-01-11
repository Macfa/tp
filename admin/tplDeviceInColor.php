<?php 
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
foreach($_POST as $value) {
$check_key = DB::queryFirstField("SELECT dvKey FROM tmDevice WHERE dvModelCode=%s", $value);
}
$check_color = DB::queryOneColumn('dcColor', "SELECT * FROM tmDeviceColor WHERE dvKey=%s", $check_key);	/* 디비키에 설정되어 있는 색상리스트*/

if(isExist($check_color) == true) {	/* 값이 tmDeviceColor 에 있다면... */
	foreach($check_color as $color) {	/* 색상리스트를 불러와 하나씩 넣는다 */
		$colors[] = $color;
	}
} else {
	$colors[] = '선택할 수 있는 색상이 없습니다 !';
}
// return $colors;
echo json_encode($colors);
 ?>