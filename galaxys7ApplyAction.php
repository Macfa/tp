<?php
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

header("Content-Type: text/html; charset=UTF-8");

$etcText = $_POST['etcPlan'];
$isEdit = false;
if(isExist($_POST['isEditKey']))
	$isEdit = true;

try{
	
	if($isLogged == false)
		throw new Exception('로그인 해주세요!', 1);

	if(isExist($_POST['taKey'])){
		$isValidPvKey = (int)DB::queryFirstField("SELECT COUNT(*) FROM tmApply WHERE taKey = %i and mbEmail = %s", $_POST['taKey'], $mb['mbEmail']);
		if($isValidPvKey === 0)
			throw new Exception('올바르지 않은 요청입니다.', 3);
	}
	$isapplyMember = DB::queryFirstField("SELECT COUNT(*) FROM tmApply WHERE mbEmail=%s AND taCancel = 0" , $mb['mbEmail']); 
	$isapplyMember = (int)$isapplyMember;	

	if($isapplyMember >= 1 && $isValidPvKey === 0)
		throw new Exception('이미 신청하셨습니다.', 2);

	if (isNullVal($_POST['mbPhone']))
		throw new Exception('연락처를 입력해주세요.', 3);

	$_POST['mbPhone'] = parsingNum($_POST['mbPhone']);
	if (isPhoneNum($_POST['mbPhone']) == false && isTelNum($_POST['mbPhone']) == false)
		throw new Exception('핸드폰을 000-0000-0000 형식으로 입력해주세요', 3);

	$taBirth = parsingNum($_POST['taBirth']);
	$taBirthLen = strlen($taBirth);
	if(isNullVal($taBirth) || isDate($taBirth) === false || $taBirthLen != '8' && $taBirthLen !='6') 
		throw new Exception('생년월일을 0000-00-00 형식으로 입력해주세요 ', 3);

	if(isNullVal($_POST['taSexType']))		
		throw new Exception('성별을 선택해주세요 ', 3);

	if(isNullVal($_POST['isBuyNote7']))		
		throw new Exception('노트7 구매여부를 선택해주세요 ', 3);

	if(isNullVal($_POST['taCurrentCarrier']))
		throw new Exception('현재이용중인통신사를 선택해주세요 ', 3);

	if(isNullVal($_POST['taApplyType']))
		throw new Exception('가입유형을 선택해주세요 ', 3);

	if(isNullVal($_POST['taChangeCarrier']))
		throw new Exception('변경할 통신사를 선택해주세요 ', 3);	

	if(isNullVal($_POST['taDevice']))
		throw new Exception('모델명을 선택하세요 ', 3);	

	if(isNullVal($_POST['taDeviceCapacity']))
		throw new Exception('용량을 선택하세요 ', 3);	

	if(isNullVal($_POST['taColor']))
		throw new Exception('색상을 선택해주세요 ', 3);

	if(isNullVal($_POST['taPlan']))		
		throw new Exception('요금제를 선택해주세요 ', 3);

	if($_POST['taPlan'] === 'etc' &&  isExist($etcText) === false)
		throw new Exception('기타요금제를 입력해주세요 ', 3);	


	
} catch (Exception $e) {	
	if ($e->getCode() === 1)
		$errorURL = $cfg['login_url'];
	else if ($e->getCode() === 2)
		$errorURL = $cfg['url']."/user/mySpace.php";
	else if ($e->getCode() === 3)
		$errorURL = $cfg['url']."/page/galaxys7Apply.php";

	alert($e->getMessage(), $errorURL);

}


if($taBirthLen == '8')
$date = date("Y-m-d", strtotime($taBirth));
if($taBirthLen == '6')
$date = date("y-m-d", strtotime("00".$taBirth));

$taPlan = $_POST['taPlan'];
if($_POST['taPlan'] === 'etc') $taPlan = $etcText;


	

if(isPhoneNum($mb['mbEmail']) === false) {
	DB::update('tmMember', array(
		'mbPhone' => $_POST['mbPhone']
	), "mbEmail = %s", $mb['mbEmail']);
}


$parentDeviceKey = DB::queryFirstField("SELECT dvKey FROM tmDevice WHERE dvId=%s", $_POST['taDevice']);
$applyDeviceKey = DB::queryFirstField("SELECT dvKey FROM tmDevice WHERE dvParent=%s AND dvTit=%s", $parentDeviceKey, $_POST['taDeviceCapacity']);

$arrApplyMember = array(
	'mbName' => $mb['mbName'],
	'mbEmail' => $mb['mbEmail'],
	'mbPhone' => $_POST['mbPhone'],
	'taBirth' => $date,
	'taSexType' => $_POST['taSexType'],
	'taCurrentCarrier' => $_POST['taCurrentCarrier'],
	'taApplyType' => $_POST['taApplyType'],
	'taChangeCarrier' => $_POST['taChangeCarrier'],
	'taColor' => $_POST['taColor'],
	'dvKey' => $applyDeviceKey,
	'taPlan' => $taPlan,
	'isBuyNote7' => $_POST['isBuyNote7'],
	'dateTime' => $cfg['time_ymdhis'],
	'taProcess' => 2, //실가입 신청가능
	'poKey' => 6
	);

if($isapplyMember === 0 && $isEdit === FALSE){	

	if(isExist($_POST['taEtc']))
		$arrApplyMember['taEtc'] = $_POST['taEtc'];

	DB::insert('tmApply', $arrApplyMember);
	
	$SMS = new SMS();
	switch($applyDeviceKey) {	
		case '637' :
			$title = '갤럭시S7';			
			break;
		case '664' :
			$title = '갤럭시S7엣지';
			break;
	}	

	$sendCont = "[티플 ".$title."] 로그인 후 마이페이지에서 실가입을 신청해주세요.";
	$SMS->sendMode(0)->sendMemberPhone($_POST['mbPhone'])->sendMemberName($mb['mbName'])->sendCont($sendCont)->send();	
}


if($isapplyMember === 1 && $isEdit === TRUE){ 

	DB::update('tmApply', $arrApplyMember, 'taKey = %s', $_POST['taKey']);	


}



alert('완료되었습니다.', "/user/galaxys7EdgeState.php");

?>