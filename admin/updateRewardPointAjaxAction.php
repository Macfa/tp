<?php 
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
include_once(PATH_LIB."/lib.snoopy.inc.php");
include_once(PATH_LIB."/lib.parsing.inc.php");
include_once(PATH_LIB.'/lib.PHPExcel.inc.php');
include_once(PATH_LIB.'/PHPExcel/IOFactory.php');
require_once($cfg['path']."/adminhead.php");			// 헤더 부분 (스킨포함)

DB::insert('tmRewardPoint', $_POST['data']);
// DB::insert('tmTest', $_POST['data']);

// $arr = $_POST;

// var_dump($arr);
// foreach ($arr as $arr_index) {
// 	foreach($arr_index as $arr_list) {
// 		$data = array(
// 			'dvKey' => $arr_list['dvKey'],
// 			'rpPlan' => $arr_list['rpPlan'],
// 			'rpCarrier' => $arr_list['rpCarrier'],
// 			'rpPoint' => $arr_list['rpPoint'],
// 			'rpApplyType' => $arr_list['rpApplyType'],
// 			'rpDiscountType' => $arr_list['rpDiscountType'],
// 			'rpDate' => $arr_list['rpDate']
// 		);
// 			// var_dump($arr_list)

		// echo "<pre>";
		// var_dump($_POST['data']);
		// echo "</pre>";
	// }
// }

// echo "<pre>";
// print_r($data);
// echo "</pre>";

 ?>


<?php require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)
