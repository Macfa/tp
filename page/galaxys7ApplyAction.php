<?php
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

header("Content-Type: text/html; charset=UTF-8");

$etcText = $_POST['etcPlan'];

try{
	
	if($isLogged == false)
		throw new Exception('로그인 해주세요!', 1);

	if(isExist($_POST['taKey'])){
		$isValidPvKey = (int)DB::queryFirstField("SELECT COUNT(*) FROM tmApply WHERE taKey = %i and mbEmail = %s", $_POST['paKey'], $mb['mbEmail']);
		if($isValidPvKey === 0)
			throw new Exception('올바르지 않은 요청입니다.', 3);
	}
	$isapplyMember = DB::queryFirstField("SELECT COUNT(*) FROM tmApply WHERE mbEmail=%s", $mb['mbEmail']);
	$isapplyMember = (int)$isapplyMember;	

	if($isapplyMember >= 1 && $isValidPvKey === 0)
		throw new Exception('이미 신청하셨습니다.', 2);

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
		throw new Exception('성별을 선택해주세요 ', 3);

	if(isNullVal($_POST['currentCarrier']))
		throw new Exception('현재이용중인통신사를 선택해주세요 ', 3);

	if(isNullVal($_POST['applyType']))
		throw new Exception('가입유형을 선택해주세요 ', 3);

	if(isNullVal($_POST['taChangeCarrier']))
		throw new Exception('변경할 통신사를 선택해주세요 ', 3);	

	if(isNullVal($_POST['taDevice']))
		throw new Exception('모델명을 선택하세요 ', 3);	

	if(isNullVal($_POST['taDeviceCapacity']))
		throw new Exception('용량을 선택하세요 ', 3);	

	if(isNullVal($_POST['colorType']))
		throw new Exception('색상을 선택해주세요 ', 3);

	if(isNullVal($_POST['plan']))		
		throw new Exception('요금제를 선택해주세요 ', 3);

	if($_POST['plan'] === 'etc' &&  isExist($etcText) === false)
		throw new Exception('기타요금제를 입력해주세요 ', 3);	


	
} catch (Exception $e) {	
	if ($e->getCode() === 1)
		$errorURL = $cfg['login_url'];
	else if ($e->getCode() === 2)
		$errorURL = $cfg['url'];
	else if ($e->getCode() === 3)
		$errorURL = $cfg['url']."/page/galaxys7Apply.php";

	alert($e->getMessage(), $errorURL);

}


if($taBirthLen == '8')
$date = date("Y-m-d", strtotime($taBirth));
if($taBirthLen == '6')
$date = date("y-m-d", strtotime("00".$taBirth));

$Plan = $_POST['plan'];
if($_POST['plan'] === 'etc') $Plan = $etcText;


	

if(isPhoneNum($mb['mbEmail']) === false) {
	DB::update('tmMember', array(
		'mbPhone' => $_POST['taPhone']
	), "mbEmail = %s", $mb['mbEmail']);
}


$parentDeviceKey = DB::queryFirstField("SELECT dvKey FROM tmDevice WHERE dvId=%s", $_POST['taDevice']);
$applyDeviceKey = DB::queryFirstField("SELECT dvKey FROM tmDevice WHERE dvParent=%s AND dvTit=%s", $parentDeviceKey, $_POST['taDeviceCapacity']);

$arrApplyMember = array(
	'mbName' => $mb['mbName'],
	'mbEmail' => $mb['mbEmail'],
	'mbPhone' => $_POST['taPhone'],
	'taBirth' => $date,
	'taSexType' => $_POST['sexType'],
	'taCurrentCarrier' => $_POST['currentCarrier'],
	'taApplyType' => $_POST['applyType'],
	'taChangeCarrier' => $_POST['taChangeCarrier'],
	'taColor' => $_POST['colorType'],
	'dvKey' => $applyDeviceKey,
	'taPlan' => $Plan,
	'dateTime' => $cfg['time_ymdhis']
);

if($isapplyMember === 0){

	DB::insert('tmApply', $arrApplyMember);	
}


if($_POST['taDevice'] === 'galaxys7'){
	if($_POST['applyType'] === '02'){
		if($_POST['taDeviceCapacity'] === '32G'){
			$url = "http://online.olleh.com/index.jsp?prdcID=C468AA86-66D7-49AE-ABBF-935B2AC921D9";
		}else if($_POST['taDeviceCapacity'] === '64G'){
			$url = "http://online.olleh.com/index.jsp?prdcID=1F87CE02-0086-4AA8-A3C7-CFD5F431C438";
		}
	}else if($_POST['applyType'] === '06'){
		if($_POST['taDeviceCapacity'] === '32G'){
			$url = "http://online.olleh.com/index.jsp?prdcID=23343FEA-3A2E-46C3-99E7-CFD8BDE86F61";
		}else if($_POST['taDeviceCapacity'] === '64G'){
			$url = "http://online.olleh.com/index.jsp?prdcID=6412AC3A-AD31-4390-BE55-0BF6155A98F3";
		}
	}
}
if($_POST['taDevice'] === 'galaxys7edge'){
	if($_POST['applyType'] === '02'){
		if($_POST['taDeviceCapacity'] === '32G'){
			$url = "http://online.olleh.com/index.jsp?prdcID=6983FF8D-02E8-4E56-A0DF-5BF5E3BB4126";
		}else if($_POST['taDeviceCapacity'] === '64G'){
			$url = "http://online.olleh.com/index.jsp?prdcID=0CB7C865-7D8C-4AED-A85B-4A7DCE24450C";
		}
	}else if($_POST['applyType'] === '06'){
		if($_POST['taDeviceCapacity'] === '32G'){
			$url = "http://online.olleh.com/index.jsp?prdcID=CDBA9466-E3D7-4AD8-A632-E365978BB588";
		}else if($_POST['taDeviceCapacity'] === '64G'){
			$url = "http://online.olleh.com/index.jsp?prdcID=941E3454-F001-49EC-BB22-02A2593BF284";
		}
	}
}

alert('완료되었습니다.', $url);
?>