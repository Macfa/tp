<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

//print_r($_POST['mainDevice']);

foreach($_POST['listDevice'] as $key => $val){
	$isExist = DB::queryFirstField('SELECT count(*) as cnt FROM tmSort WHERE soTargetKey = %i', $val);
	if ($isExist < 1){
		DB::insert('tmSort', array(
			'soTargetKey' => $val,
			'soOrder' => $key
		));
	} else {
		DB::Update('tmSort', array(
			'soOrder' => $key,
		), 'soTargetKey = %i', $val);
	}
}

goURL('orderModifyDevice.php');
//print_r($arrInsert);
