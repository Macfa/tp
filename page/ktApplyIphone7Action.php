<?php
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

header("Content-Type: text/html; charset=UTF-8");



try{
	
	if($isLogged == false)
		throw new Exception('로그인 해주세요!', 1);

	$isApplyExist= DB::queryFirstRow("SELECT * FROM tmPreorderApplyList WHERE mbEmail=%s AND paChangeCarrier = 'kt' AND paCancel = 0", $mb['mbEmail']);
	$isApplyExist = (int)$isApplyExist;
	
	if($isApplyExist === 0)
		throw new Exception('신청하신후 실가입이 가능합니다.', 2);

	if(isNullVal($_POST['paFromTime']))		
		throw new Exception('연락가능한 시간을 선택해주세요 ', 3);

	if(isNullVal($_POST['paToTime']))		
		throw new Exception('연락가능한 시간을 선택해주세요 ', 3);

	if($_POST['paFromTime'] > $_POST['paToTime'])
		throw new Exception('올바르게 시간을 선택해주세요', 3);

	

	
} catch (Exception $e) {	
	if ($e->getCode() === 1)
		$errorURL = $cfg['login_url'];

	if ($e->getCode() === 2)
		$errorURL = $cfg['url']."/page/preorderApply.php?device=아이폰7";

	if ($e->getCode() === 3)
		$errorURL = $cfg['url']."/page/ktApplyIphone7.php";

	alert($e->getMessage(), $errorURL);

}



if($isApplyExist === 1){

	DB::update('tmPreorderApplyList', array(
	  'paContactTime' =>  $_POST['paFromTime']."시에서 ".$_POST['paToTime']."시"
	  ),"mbEmail=%s AND paChangeCarrier = 'kt' AND paCancel = 0", $mb['mbEmail']);

}
// 신청완료 페이지로 이동
//goURL($cfg['url']."/user/preorderState.php");

alert('완료되었습니다.', "/user/preorderState.php?device=아이폰7");


?>