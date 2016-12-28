<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

//print_r($_POST['mainDevice']);

$i = 1;
foreach($_POST['mainDevice'] as $key => $val){
	DB::update('tmMainSort', array('maTargetKey' => $val), "maOrder = %i", $key);
	$i++;
	if ($i > 10) break;
}

goURL('orderModifyMain.php');
//print_r($arrInsert);
