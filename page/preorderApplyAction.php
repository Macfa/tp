<?php
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

header("Content-Type: text/html; charset=UTF-8");

$preorderTableList = DB::queryFirstRow("SELECT * FROM tmPreorder WHERE poKey=%s", $_POST['poKey']);

try{
	
	if($isLogged === false){
		throw new Exception('로그인 해주세요!', 1);
	}

	if(isExist($_POST['paKey'])){
		$isValidPaKey = (int)DB::queryFirstField("SELECT COUNT(*) FROM tmPreorderApplyList WHERE paKey = %i and mbEmail = %s and poKey=%s", $_POST['paKey'], $mb['mbEmail'], $_POST['poKey']);
		if($isValidPaKey === 0)
			throw new Exception('올바르지 않은 요청입니다.', 3);
	}
	$isApplyExist= DB::queryFirstField("SELECT COUNT(*) FROM tmPreorderApplyList WHERE mbEmail = %s and paCancel = 0 and poKey=%s", $mb['mbEmail'],$_POST['poKey']); 
	$isApplyExist = (int)$isApplyExist;
	
	if($isApplyExist >= 1 && $isValidPaKey === 0)
		throw new Exception('이미 신청하셨습니다.', 2);

	if($isV20ApplyExist['pvProcess'] >= 1)
		throw new Exception('신청완료 상태이므로 수정할수 없습니다.', 3);

	$paBirth = parsingNum($_POST['paBirth']);
	$paBirthLen = strlen($paBirth);
	if(isNullVal($paBirth) || isDate($paBirth) === false || $paBirthLen != '8' && $paBirthLen !='6') 
		throw new Exception('생년월일을 0000-00-00 형식으로 입력해주세요 ', 3);

	if(isNullVal($_POST['paSexType']))		
		throw new Exception('성별을 선택해주세요 ', 3);

	if(isNullVal($_POST['paDevice']))		
		throw new Exception('모델명을 선택해주세요 ', 3);

	if(isNullVal($_POST['paDeviceRam']))		
		throw new Exception('모델명을 선택해주세요 ', 3);

	if(isNullVal($_POST['paCurrentCarrier']))
		throw new Exception('현재이용중인통신사를 선택해주세요 ', 3);

	if(isNullVal($_POST['paApplyType']))
		throw new Exception('가입유형을 선택해주세요 ', 3);

	if(isNullVal($_POST['paChangeCarrier']))
		throw new Exception('변경할 통신사를 선택해주세요 ', 3);	

	if(isNullVal($_POST['paColorType']))
		throw new Exception('색상을 선택해주세요 ', 3);	

	/*if(isNullVal($_POST['pa2ndColor']))
		throw new Exception('2지망색상을 선택해주세요 ', 3);

	if($_POST['paColorType'] === $_POST['pa2ndColor'])
		throw new Exception('서로 다른 색상을 선택해주세요 ', 3);
		$checkedCount = count($_POST['paGift']);

	if(($_POST['paChangeCarrier'] === 'sk' && $_POST['paApplyType'] ==='06') && $checkedCount > '0') // sk로 기변
		throw new Exception( '사은품 선택을 할수 없습니다', 3);
	
	if(($_POST['paChangeCarrier'] === 'sk' && $_POST['paApplyType'] ==='02') && $checkedCount > '1') // sk로 번이
		throw new Exception( '사은품선택 초과하였습니다', 3);

	if(($_POST['paChangeCarrier'] === 'kt' && $_POST['paApplyType'] ==='06') && $checkedCount > '1') // kt로 기변
		throw new Exception( '사은품선택 초과하였습니다', 3);
	
	if(($_POST['paChangeCarrier'] === 'kt' && $_POST['paApplyType'] ==='02') && $checkedCount > '2') // kt로 번이
		throw new Exception( '사은품선택 초과하였습니다', 3);

	if(($_POST['paChangeCarrier'] === 'kt' && $_POST['paApplyType'] ==='02') && $checkedCount == '1' ) // kt로 번이
		throw new Exception( '사은품 하나를 더 선택해주세요', 3);

	if(($_POST['paChangeCarrier'] === 'sk' && $_POST['paApplyType'] ==='02' && $checkedCount == '0') || ($_POST['paChangeCarrier'] === 'kt' && $checkedCount == '0'))
		throw new Exception('사은품을 선택해주세요 ', 3);
	*/
	if(isNullVal($_POST['paPlan']))		
		throw new Exception('요금제를 선택해주세요 ', 3);

	if($_POST['paPlan'] === 'etc' &&  isExist($_POST['etcPlan']) === false)
		throw new Exception('기타요금제를 입력해주세요 ', 3);

	if (isNullVal($_POST['paPhone']))
		throw new Exception('연락처를 입력해주세요.', 3);

	$_POST['paPhone'] = parsingNum($_POST['paPhone']);
	if (isPhoneNum($_POST['paPhone']) == false && isTelNum($_POST['paPhone']) == false)
		throw new Exception('핸드폰을 000-0000-0000 형식으로 입력해주세요', 3);

	if (isNullVal($_POST['paEmail']) === true || isEmail($_POST['paEmail']) === false)
		throw new Exception('이메일을 00000@주소 형식으로 입력해주세요', 3);

/*	$startTime= '2016-10-27 13:00:00';
	$jetBlackApply = DB::queryFirstField("SELECT count(*) FROM tmPreorderApplyList WHERE paColorType = %s and paDatetime >= %s", 'jetBlack', $startTime);
	if ($jetBlackApply > '100')
		throw new Exception('제트블랙 색상 이벤트가 마감되었습니다', 3);
*/
	$startTime= '2016-10-28 10:00:00';
    if($_POST['paColorType'] === 'jetBlack') {
        $jetBlackApply = (int)DB::queryFirstField("SELECT count(*) FROM tmPreorderApplyList WHERE paColorType = %s and paDatetime >= %s", 'jetBlack', $startTime);
        if ($jetBlackApply >= 20)
            throw new Exception('제트블랙 색상 이벤트가 마감되었습니다', 3);
    }

    if($_POST['paColorType'] === 'black') {
        $blackApply = (int)DB::queryFirstField("SELECT count(*) FROM tmPreorderApplyList WHERE paColorType = %s and paDatetime >= %s", 'black', $startTime);
        if ($blackApply >= 20)
            throw new Exception('매트블랙 색상 이벤트가 마감되었습니다', 3);
    }

} catch (Exception $e) {	
	
		if ($e->getCode() === 1)
			$errorURL = $cfg['login_url'];
		else if ($e->getCode() === 2)
			$errorURL = $cfg['url']."/user/preorderState.php?device=".$preorderTableList['poDeviceName'];

		else if($e->getCode() === 3){
			if(isExist($_POST['mbEmail']) === TRUE && isExist($_POST['isEditKey']) === FALSE)
				$errorURL = $cfg['url']."/page/preorderApply.php?device=".$preorderTableList['poDeviceName']."&mbEmail=".$_POST['mbEmail'];
			else if(isExist($_POST['mbEmail']) === FALSE && isExist($_POST['isEditKey']) === FALSE){
				$errorURL = $cfg['url']."/page/preorderApply.php?device=".$preorderTableList['poDeviceName'];
			}
			else if(isExist($_POST['isEditKey']) ===TRUE){
				$errorURL = $cfg['url']."/page/preorderApply.php?device=".$preorderTableList['poDeviceName']."&v=edit";
			}
		alert($e->getMessage(), $errorURL);
	}
	
}


		
$isEdit = false;
if(isExist($_POST['paKey']))
	$isEdit = true;


$isCanceled = (int)DB::queryFirstField("SELECT count(*) FROM tmPreorderApplyList WHERE mbEmail = %s and poKey=%s", $mb['mbEmail'],$_POST['poKey']);

if($paBirthLen == '8')
$date = date("Y-m-d", strtotime($paBirth));
if($paBirthLen == '6')
$date = date("y-m-d", strtotime("00".$paBirth));

$paPlan = $_POST['paPlan'];
if($_POST['paPlan'] === 'etc') $paPlan = $_POST['etcPlan'];

/*
if(isPhoneNum($mb['mbPhone']) === false && isTelNum($mb['mbPhone'] === false)
*/
	
if(isPhoneNum($mb['mbEmail']) === false) {
	DB::update('tmMember', array(
		'mbPhone' => $_POST['paPhone']
	), "mbEmail = %s", $mb['mbEmail']);
}

$perorderOrderNum = DB::queryFirstField("SELECT paWatingNumber FROM tmPreorderApplyList WHERE paChangeCarrier=%s_changeCarrier AND paCancel = %i_cancel AND poKey = %s_poKey ORDER BY paWatingNumber DESC", 
  array(
    'changeCarrier' => $_POST['paChangeCarrier'],
    'cancel' => '0',
    'poKey' => $_POST['poKey']
  ) 
);




$parentDeviceKey = DB::queryFirstField("SELECT dvKey FROM tmDevice WHERE dvId=%s", $_POST['paDevice']);
$applyDeviceKey = DB::queryFirstField("SELECT dvKey FROM tmDevice WHERE dvParent=%s AND dvTit=%s", $parentDeviceKey,$_POST['paDeviceRam']);



$arrApplyMember = array(
	'poKey' => $_POST['poKey'],
	'paCurrentCarrier' => $_POST['paCurrentCarrier'], 
	'paApplyType' => $_POST['paApplyType'],
	'paColorType' => $_POST['paColorType'],
	'paPlan' => $paPlan,
	'paBirth' => $date,
	'paSexType' => $_POST['paSexType'],
	'paPhone' => $_POST['paPhone'],
	'paEmail' => $_POST['paEmail'],		
	'paDatetime' => $cfg['time_ymdhis'],	
	'paChangeCarrier' => $_POST['paChangeCarrier'],
	'dvKey'=> $applyDeviceKey
/*	'pa2ndColor' => $_POST['pa2ndColor']*/
);

if(isExist($_POST['paEtc2'])){
	$arrApplyMember['paEtc2'] = 'egg';
}else{
	$arrApplyMember['paEtc2'] = '';
}

$SMS = new SMS();


// 아이폰 일때 ===================================

if($_POST['poKey'] == '3'){
	$arrApplyMember['paGift'] = '태블릿PC(일반신청)';
	$arrApplyMember['paProcess'] = 2;
	$sendCont = "[티플 아이폰7] 로그인 후 마이페이지에서 실가입을 신청해주세요.";
}
// 비와이폰 일때 ===================================

if($_POST['poKey'] == '5'){
	$arrApplyMember['paGift'] = '';
	$arrApplyMember['paProcess'] = 2;
	$sendCont = "[티플 비와이폰] 로그인 후 마이페이지에서 실가입을 신청해주세요.";
}

//===============================================



if($isCanceled === 1){
	DB::delete('tmPreorderApplyList', "mbEmail = %s and paCancel = 1 and poKey=%s", $mb['mbEmail'],$_POST['poKey']);
}

list($myWatingNumber, $myChangeCarrier, $myProcess) = DB::queryFirstList("SELECT paWatingNumber,paChangeCarrier,paProcess FROM tmPreorderApplyList WHERE mbEmail = %s and poKey=%s", $mb['mbEmail'],$_POST['poKey']);

if($isApplyExist===0 && $isEdit === FALSE && isExist($_POST['mbEmail']) === FALSE){	

	if(isExist($_POST['paEtc']))
		$arrApplyMember['paEtc'] = $_POST['paEtc'];

	$arrApplyMember['paWatingNumber'] = $perorderOrderNum +1;
	$arrApplyMember['paName'] = $mb['mbName'];
	$arrApplyMember['mbEmail'] = $mb['mbEmail'];
	DB::insert('tmPreorderApplyList', $arrApplyMember);
	
	$SMS->sendMode('SMS')->sendMemberPhone($_POST['paPhone'])->sendMemberName($mb['mbName'])->sendCont($sendCont)->send();	

}


if($isEdit === TRUE && $_POST['paChangeCarrier'] === $myChangeCarrier && isExist($_POST['mbEmail']) === FALSE){

	$arrApplyMember['paWatingNumber'] = $myWatingNumber;
	$arrApplyMember['paName'] = $mb['mbName'];
	$arrApplyMember['mbEmail'] = $mb['mbEmail'];
	$arrApplyMember['paProcess'] = $myProcess;
	DB::update('tmPreorderApplyList', $arrApplyMember, 'paKey = %i', $_POST['paKey']);	

}
if($isEdit === TRUE && $_POST['paChangeCarrier'] != $myChangeCarrier && isExist($_POST['mbEmail']) === FALSE){

	$arrApplyMember['paWatingNumber'] = $perorderOrderNum +1;
	$arrApplyMember['paName'] = $mb['mbName'];
	$arrApplyMember['mbEmail'] = $mb['mbEmail'];
	$arrApplyMember['paProcess'] = $myProcess;
	DB::update('tmPreorderApplyList', $arrApplyMember, 'paKey = %i', $_POST['paKey']);	


}

// 어드민 회원 수정시 ============================

if($isAdmin === true){
	$editMember = DB::queryFirstRow("SELECT * FROM tmPreorderApplyList WHERE mbEmail=%s and poKey=%s",$_POST['mbEmail'],$_POST['poKey']);
	list($myWatingNumber, $myChangeCarrier,$myProcess) = DB::queryFirstList("SELECT paWatingNumber,paChangeCarrier,paProcess FROM tmPreorderApplyList WHERE mbEmail = %s",$_POST['mbEmail']);

	if(isExist($_POST['mbEmail']) === TRUE && $_POST['paChangeCarrier'] === $myChangeCarrier){

		$arrApplyMember['paWatingNumber'] = $myWatingNumber;
		$arrApplyMember['paName'] = $editMember['paName'];
		$arrApplyMember['mbEmail'] = $editMember['mbEmail'];
		$arrApplyMember['paProcess'] = $myProcess;
		DB::update('tmPreorderApplyList', $arrApplyMember, 'mbEmail = %s AND paKey = %i', $editMember['mbEmail'],$editMember['paKey']);	


	}
	if(isExist($_POST['mbEmail']) === TRUE && $_POST['paChangeCarrier'] != $myChangeCarrier){

		$arrApplyMember['paWatingNumber'] = $perorderOrderNum +1;
		$arrApplyMember['paName'] = $editMember['paName'];
		$arrApplyMember['mbEmail'] = $editMember['mbEmail'];
		$arrApplyMember['paProcess'] = $myProcess;
		DB::update('tmPreorderApplyList', $arrApplyMember, 'mbEmail = %s AND paKey = %i', $editMember['mbEmail'],$editMember['paKey']);	
		
	}

if(isExist($_POST['mbEmail']) === TRUE){
	alert('완료되었습니다.', "/admin/preorder.php?searchDevice=".$_POST['poKey']);
}

}



// 신청완료 페이지로 이동
//goURL($cfg['url']."/user/preorderState.php");


alert('완료되었습니다.', "/user/preorderState.php?device=".$preorderTableList['poDeviceName']);


?>