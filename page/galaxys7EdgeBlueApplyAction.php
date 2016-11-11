<?php
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

header("Content-Type: text/html; charset=UTF-8");

$isEdit = false;
if(isExist($_POST['isEditKey']))
	$isEdit = true;

try{
	
	if($isLogged == false)
		throw new Exception('로그인 해주세요!', 1);

	$isApplyExist = DB::queryFirstField("SELECT COUNT(*) FROM tmApply WHERE mbEmail = %s AND taColor='blue' AND dvKey=664 AND taCancel=0", $mb['mbEmail']);
	$isApplyExist = (int)$isApplyExist;

	if($isApplyExist >= 1 && $isEdit === FALSE)
		throw new Exception('이미 신청을 하셨습니다.', 2);

	if (isNullVal($_POST['taEmail']) === true || isEmail($_POST['taEmail']) === false)
		throw new Exception('이메일을 00000@주소 형식으로 입력해주세요', 3);

	if (isNullVal($_POST['taPhone']))
		throw new Exception('연락처를 입력해주세요.', 3);

	$_POST['taPhone'] = parsingNum($_POST['taPhone']);
	if (isPhoneNum($_POST['taPhone']) == false && isTelNum($_POST['taPhone']) == false)
		throw new Exception('핸드폰을 000-0000-0000 형식으로 입력해주세요', 3);

	
	$taBirth = parsingNum($_POST['taBirth']);
	$taBirthLen = strlen($taBirth);
	if(isNullVal($taBirth) || isDate($taBirth) === false || $taBirthLen != '8' && $taBirthLen !='6') 
		throw new Exception('생년월일을 0000-00-00 형식으로 입력해주세요 ', 3);


	if(isNullVal($_POST['taSexType']))		
		throw new Exception('성별를 선택해주세요 ', 3);

	if(isNullVal($_POST['isBuyNote7']))		
		throw new Exception('노트7 구매여부를 선택해주세요 ', 3);

	if(isNullVal($_POST['currentCarrier']))		
		throw new Exception('현재통신사를 선택해주세요 ', 3);

	if(isNullVal($_POST['applyType']))		
		throw new Exception('가입유형을 선택해주세요 ', 3);

	if(isNullVal($_POST['taChangeCarrier']))		
		throw new Exception('변경할 통신사를 선택해주세요 ', 3);

	if(isNullVal($_POST['taDevice']))		
		throw new Exception('모델명을 선택해주세요 ', 3);

	if(isNullVal($_POST['taDeviceCapacity']))		
		throw new Exception('용량을 선택해주세요 ', 3);

	if(isNullVal($_POST['colorType']))		
		throw new Exception('색상을 선택해주세요 ', 3);

	if(isNullVal($_POST['plan']))		
		throw new Exception('요금제를 선택해주세요 ', 3);

	if($_POST['plan'] === 'etc' &&  isExist($_POST['etcPlan']) === false)
		throw new Exception('기타요금제를 입력해주세요 ', 3);

	
} catch (Exception $e) {	
	if ($e->getCode() === 1)
		$errorURL = $cfg['login_url'];	
	else if ($e->getCode() === 2)
		$errorURL = $cfg['url']."/user/galaxys7EdgeBlueState.php";
	else if ($e->getCode() === 3)
		$errorURL = $cfg['url']."/page/galaxys7EdgeBlueApply.php";

	alert($e->getMessage(), $errorURL);

}

if(isPhoneNum($mb['mbEmail']) === false) {
	DB::update('tmMember', array(
		'mbPhone' => $_POST['taPhone']
	), "mbEmail = %s", $mb['mbEmail']);
}

if($taBirthLen == '8')
$date = date("Y-m-d", strtotime($taBirth));
if($taBirthLen == '6')
$date = date("y-m-d", strtotime("00".$taBirth));


$parentDeviceKey = DB::queryFirstField("SELECT dvKey FROM tmDevice WHERE dvId=%s", $_POST['taDevice']);
$applyDeviceKey = DB::queryFirstField("SELECT dvKey FROM tmDevice WHERE dvParent=%s AND dvTit=%s", $parentDeviceKey,$_POST['taDeviceCapacity']);

$taPlan = $_POST['plan'];
if($_POST['plan'] === 'etc') $taPlan = $_POST['etcPlan'];

$preorderOrderNum = DB::queryFirstField("SELECT taWatingNumber FROM tmApply WHERE taChangeCarrier=%s_changeCarrier AND taCancel = %i_cancel AND taColor='blue' ORDER BY taWatingNumber DESC", 
  array(
    'changeCarrier' => $_POST['taChangeCarrier'],
    'cancel' => '0'
  ) 
);

$arrApplyMember = array(
	'mbName' =>  $mb['mbName'],
	'mbEmail' => $mb['mbEmail'],
	'mbPhone' => $_POST['taPhone'],
	'taBirth' => $date,
	'taSexType' => $_POST['taSexType'],
	'taCurrentCarrier' => $_POST['currentCarrier'],
	'taApplyType' => $_POST['applyType'],
	'taChangeCarrier' =>  $_POST['taChangeCarrier'],
	'taColor' => $_POST['colorType'],
	'dvKey' => $applyDeviceKey,
	'taPlan' => $taPlan,	
	'isBuyNote7' => $_POST['isBuyNote7'],
	'dateTime' => $cfg['time_ymdhis'],
	'poKey' => 4,
	'taProcess' => 2

);


if($isApplyExist === 0 && $isEdit === FALSE){	

	if(isExist($_POST['taEtc']))
		$arrApplyMember['taEtc'] = $_POST['taEtc'];

	$arrApplyMember['taWatingNumber'] = $preorderOrderNum+1;
	DB::insert('tmApply', $arrApplyMember);
	
	
	$SMS = new SMS();
	$sendCont = "[티플 갤럭시S7엣지 블루코랄] 로그인 후 마이페이지에서 실가입을 신청해주세요.";
	$SMS->sendMode(0)->sendMemberPhone($_POST['taPhone'])->sendMemberName($mb['mbName'])->sendCont($sendCont)->send();	
}

list($myWatingNumber, $myChangeCarrier) = DB::queryFirstList("SELECT taWatingNumber,taChangeCarrier FROM tmApply WHERE mbEmail = %s AND taColor = 'blue' AND taCancel = 0", $mb['mbEmail']);

if($isEdit === TRUE && $_POST['taChangeCarrier'] == $myChangeCarrier ){ // 

	$arrApplyMember['taWatingNumber'] = $myWatingNumber;
	
	DB::update('tmApply', $arrApplyMember, 'taKey = %s', $_POST['taKey']);	


}
if($isEdit === TRUE && $_POST['taChangeCarrier'] != $myChangeCarrier ){

	$arrApplyMember['taWatingNumber'] = $preorderOrderNum +1;
	DB::update('tmApply', $arrApplyMember, 'taKey = %s', $_POST['taKey']);
	

}


alert('완료되었습니다.', "/user/galaxys7EdgeBlueState.php");


?>