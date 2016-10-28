<?php
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

header("Content-Type: text/html; charset=UTF-8");

$etcText = $_POST['etcPlan'];

try{
	
	if($isLogged == false)
		throw new Exception('로그인 해주세요!', 1);

	if(isExist($_POST['pvKey'])){
		$isValidPvKey = (int)DB::queryFirstField("SELECT COUNT(*) FROM tmPreorderV20 WHERE pvKey = %i and mbEmail = %s", $_POST['pvKey'], $mb['mbEmail']);
		if($isValidPvKey === 0)
			throw new Exception('올바르지 않은 요청입니다.', 3);
	}

	$isV20ApplyExist= DB::queryFirstField("SELECT COUNT(*) FROM tmPreorderV20 WHERE mbEmail = %s and pvCancel = 0", $mb['mbEmail']); 
	$isV20ApplyExist = (int)$isV20ApplyExist;
	
	//예약신청자 DB에 존재하면 신청막기	
	if($isV20ApplyExist >= 1 && $isValidPvKey === 0)
		throw new Exception('이미 신청하셨습니다.', 2);

	//if($isV20ApplyExist['pvProcess'] >= 1)
		//throw new Exception('신청완료 상태이므로 수정할수 없습니다.', 3);

	$pvBirth = parsingNum($_POST['V20Birth']);
	$V20BirthLen = strlen($pvBirth);
	if(isNullVal($pvBirth) || isDate($pvBirth) === false || $V20BirthLen != '8' && $V20BirthLen !='6') 
		throw new Exception('생년월일을 0000-00-00 형식으로 입력해주세요 ', 3);

	if(isNullVal($_POST['current']))
		throw new Exception('현재이용중인통신사를 선택해주세요 ', 3);

	if(isNullVal($_POST['applyType']))
		throw new Exception('가입유형을 선택해주세요 ', 3);

	if(isNullVal($_POST['pvChangeCarrier']))
		throw new Exception('변경할 통신사를 선택해주세요 ', 3);	

	if(isNullVal($_POST['colorType']))
		throw new Exception('색상을 선택해주세요 ', 3);

	if(isNullVal($_POST['plan']))		
		throw new Exception('요금제를 선택해주세요 ', 3);

	if($_POST['plan'] === 'etc' &&  isExist($etcText) === false)
		throw new Exception('기타요금제를 입력해주세요 ', 3);


	if(isNullVal($_POST['sexType']))		
		throw new Exception('성별을 선택해주세요 ', 3);

	if (isNullVal($_POST['V20Phone']))
		throw new Exception('연락처를 입력해주세요.', 3);

	$_POST['V20Phone'] = parsingNum($_POST['V20Phone']);
	if (isPhoneNum($_POST['V20Phone']) == false && isTelNum($_POST['V20Phone']) == false)
		throw new Exception('핸드폰을 000-0000-0000 형식으로 입력해주세요', 3);

	if (isNullVal($_POST['V20Email']) === true || isEmail($_POST['V20Email']) === false)
		throw new Exception('이메일을 00000@주소 형식으로 입력해주세요', 3);
	


	
} catch (Exception $e) {	
	if ($e->getCode() === 1)
		$errorURL = $cfg['login_url'];
	else if ($e->getCode() === 2)
		$errorURL = $cfg['url']."/user/preorderV20State.php";

	alert($e->getMessage(), $errorURL);

}



$isEdit = false;
if(isExist($_POST['pvKey']))
	$isEdit = true;

$isCanceled = (int)DB::queryFirstField("SELECT count(*) FROM tmPreorderV20 WHERE mbEmail = %s", $mb['mbEmail']);

if($V20BirthLen == '8')
$date = date("Y-m-d", strtotime($pvBirth));
if($V20BirthLen == '6')
$date = date("y-m-d", strtotime("00".$pvBirth));

$Plan = $_POST['plan'];
if($_POST['plan'] === 'etc') $Plan = $etcText;

/*
if(isPhoneNum($mb['mbPhone']) === false && isTelNum($mb['mbPhone'] === false)
*/
	
if(isPhoneNum($mb['mbEmail']) === false) {
	DB::update('tmMember', array(
		'mbPhone' => $_POST['V20Phone']
	), "mbEmail = %s", $mb['mbEmail']);
}

$arrV20ApplyMember = array(
	'pvCurrent' => $_POST['current'], 
	'pvApplyType' => $_POST['applyType'],
	'pvColorType' => $_POST['colorType'],
	'pvPlan' => $Plan,
	'pvName' => $mb['mbName'],
	'pvBirth' => $date,
	'pvSexType' => $_POST['sexType'],
	'pvPhone' => $_POST['V20Phone'],
	'pvEmail' => $_POST['V20Email'],		
	'pvDatetime' => $cfg['time_ymdhis'],
	'mbEmail' => $mb['mbEmail'],
	'pvChangeCarrier' => $_POST['pvChangeCarrier'],
	'pvProcess' => 2
);

if($isCanceled === 1){
	DB::delete('tmPreorderV20', "mbEmail = %s and pvCancel = 1", $mb['mbEmail']);
}

if($isV20ApplyExist===0 && $isEdit === FALSE){
	if(isExist($_POST['pvEtc']))
		$arrV20ApplyMember['pvEtc'] = $_POST['pvEtc'];

	DB::insert('tmPreorderV20', $arrV20ApplyMember);	
}else if($isEdit === TRUE){

	DB::update('tmPreorderV20', $arrV20ApplyMember, 'pvKey = %i', $_POST['pvKey']);	
}

// 신청완료 페이지로 이동
//goURL($cfg['url']."/user/preorderV20State.php");

alert('완료되었습니다.', "/user/preorderV20State.php");
?>