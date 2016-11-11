<?php
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

header("Content-Type: text/html; charset=UTF-8");


try{
	
	if($isLogged == false)
		throw new Exception('로그인 해주세요!', 1);


	$isApplyExist = DB::queryFirstField("SELECT COUNT(*) FROM tmNote7Program WHERE mbEmail = %s", $mb['mbEmail']);
	$isApplyExist = (int)$isApplyExist;
	
	if($isApplyExist > 0)
		throw new Exception('이미 신청을 하셨습니다.', 2);


	if(isNullVal($_POST['isBuyTplanitNote7']))
		throw new Exception('티플에서 구매여부를 선택해주세요 ', 3);

	if(isNullVal($_POST['tnCurrentCarrier']))		
		throw new Exception('현재통신사를 선택해주세요 ', 3);
	}


	
 catch (Exception $e) {	
	if ($e->getCode() === 1)
		$errorURL = $cfg['login_url'];	
	else if ($e->getCode() === 2)
		$errorURL = $cfg['url']."/page/programNote7.php";
	else if ($e->getCode() === 3)
		$errorURL = $cfg['url']."/page/note7Program.php";

	alert($e->getMessage(), $errorURL);

}


if(isPhoneNum($mb['mbEmail']) === false) {
	DB::update('tmMember', array(
		'mbPhone' => $_POST['tnPhone']
	), "mbEmail = %s", $mb['mbEmail']);
}



$arrApplyMember = array(

	'mbEmail' => $mb['mbEmail'],
	'mbName' =>  $mb['mbName'],
	'mbPhone' => $_POST['tnPhone'],
	'isBuyTplanitNote7' => $_POST['isBuyTplanitNote7'],
	'tnCurrentCarrier' => $_POST['tnCurrentCarrier']



);

	DB::insert('tmNote7Program', $arrApplyMember);
	
/*	
	$SMS = new SMS();
	$sendCont = "[티플 아이폰7 사전예약] 티플에서 아이폰7을 사전예약해주셔서 감사합니다. 사전예약이 처리되면 공지해드리겠습니다.";
	$SMS->sendMode(0)->sendMemberPhone($_POST['paPhone'])->sendMemberName($mb['mbName'])->sendCont($sendCont)->send();	
*/




alert('완료되었습니다.', "http://online.olleh.com/index.jsp?prdcID=1A279AC7-BD7B-4FCA-B33D-F4346AFEBCAE");


?>