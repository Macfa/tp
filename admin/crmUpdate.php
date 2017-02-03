<?php 
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
require_once($cfg['path']."/adminhead.php");			// 헤더 부분 (스킨포함)


if(isExist($_GET['apKey'])) {	/* 값이 존재한다면 */
	DB::update('tmApplyTmp', array(
		'apDonetype' => 1
		), "apKey=%i", $_GET['apKey']);
}

alert('완료처리 되었습니다', 'crm.php');

 ?>
