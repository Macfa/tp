<?php
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

header("Content-Type: text/html; charset=UTF-8");


try{
	
	if($isLogged == false)
		throw new Exception('로그인 해주세요!', 1);

	if($_POST['isReceivedNote7'] === '0')
		throw new Exception('노트7 수령후 신청해주세요', 3);

	$isApplyExist = DB::queryFirstField("SELECT COUNT(*) FROM tmExchangeRefundNote7 WHERE mbEmail = %s", $mb['mbEmail']);
	$isApplyExist = (int)$isApplyExist;
	
	if($isApplyExist > 0)
		throw new Exception('이미 교환/환불 신청을 하셨습니다.', 2);


	if(isNullVal($_POST['isReceivedNote7']))		
		throw new Exception('노트7 기기를 받으셨나요? ', 3);

	if(isNullVal($_POST['enReceivedGift']))		
		throw new Exception('사은품을 받았는지 선택해주세요 ', 3);

	if (isNullVal($_POST['enPhone']))
		throw new Exception('연락처를 입력해주세요.', 3);

	$_POST['enPhone'] = parsingNum($_POST['enPhone']);
	if (isPhoneNum($_POST['enPhone']) == false && isTelNum($_POST['enPhone']) == false)
		throw new Exception('핸드폰을 000-0000-0000 형식으로 입력해주세요', 3);

	if(isNullVal($_POST['enApplyCarrier']))		
		throw new Exception('신청하신 통신사를 선택해주세요 ', 3);

	if(isNullVal($_POST['enWay']))		
		throw new Exception('진행 방법을 선택해주세요 ', 3);
	
	if(isNullVal($_POST['enApplyType']))		
		throw new Exception('교환/환불을 선택해주세요 ', 3);

	if($_POST['enApplyType'] === 'exchange'){

		if(isNullVal($_POST['enTargetDevice']))		
			throw new Exception('교환하고 싶은 기기를 선택해주세요 ', 3);

		if($_POST['enTargetDevice'] === 'etc' && isNullVal($_POST['enTargetDeviceEtc']))
			throw new Exception('원하시는 기기를 써주세요 ', 3);

		if((isExist($_POST['enTargetDevice']) && $_POST['enTargetDevice'] != 'etc') && isNullVal($_POST['enColorType']))		
			throw new Exception('색상을 선택해주세요 ', 3);

		if((isExist($_POST['enTargetDevice']) && $_POST['enTargetDevice'] != 'etc') && isNullVal($_POST['enDeviceCapacity']))		
			throw new Exception('용량을 선택해주세요 ', 3);
	}

	if($_POST['enColorType'] === 'jetBlack' && $_POST['enDeviceCapacity'] === '32G')
		throw new Exception('제트 블랙은 128GB와 256GB 모델만 선택할 수 있습니다', 3);

	if($_POST['enTargetDevice'] === 'galaxys7edge' && $_POST['enDeviceCapacity'] === '64G')
		throw new Exception('갤럭시S7엣지 64G는 현재 판매하지 않습니다', 3);	

	if($_POST['enWay'] === 'delivery'){

		if (isNullVal($_POST['enSubPhone']))
			throw new Exception('비상연락처를 입력해주세요.', 3);

		$_POST['enSubPhone'] = parsingNum($_POST['enSubPhone']);
		if (isPhoneNum($_POST['enSubPhone']) == false && isTelNum($_POST['enSubPhone']) == false)
			throw new Exception('핸드폰을 000-0000-0000 형식으로 입력해주세요', 3);

		if(isNullVal($_POST['enPostCode']))
			throw new Exception('우편번호를 써주세요 ', 3);
		
		if(isNullVal($_POST['enAddress']))
			throw new Exception('주소를 써주세요 ', 3);
		
		if(isNullVal($_POST['enSubAddress']))
			throw new Exception('상세주소를 써주세요 ', 3);

	}


	
} catch (Exception $e) {	
	if ($e->getCode() === 1)
		$errorURL = $cfg['login_url'];	
	else if ($e->getCode() === 2)
		$errorURL = $cfg['url']."/user/exchangeRefundNote7State.php";
	else if ($e->getCode() === 3)
		$errorURL = $cfg['url']."/page/exchangeRefundNote7.php";

	alert($e->getMessage(), $errorURL);

}


$enTargetDevice = $_POST['enTargetDevice'];
if($_POST['enTargetDevice'] === 'etc') $enTargetDevice = $_POST['enTargetDeviceEtc'];

if(isPhoneNum($mb['mbEmail']) === false) {
	DB::update('tmMember', array(
		'mbPhone' => $_POST['enPhone']
	), "mbEmail = %s", $mb['mbEmail']);
}



$arrApplyMember = array(
	'enKey' => $_POST['enKey'],
	'mbEmail' => $mb['mbEmail'],
	'mbName' =>  $mb['mbName'],
	'enApplyType' => $_POST['enApplyType'],
	'enWay' => $_POST['enWay'],
	'enReceivedGift' => $_POST['enReceivedGift'],
	'enPhone' => $_POST['enPhone'],
	'enApplyCarrier' => $_POST['enApplyCarrier'],
	'enTargetDevice' => $enTargetDevice,
	'enColorType' => $_POST['enColorType'],
	'enDeviceCapacity' => $_POST['enDeviceCapacity'],
	'enDatetime' => $cfg['time_ymdhis'],
	'enSubPhone' => $_POST['enSubPhone'],
	'enPostCode' => $_POST['enPostCode'],
	'enAddress' => $_POST['enAddress'],
	'enSubAddress' => $_POST['enSubAddress'],
	'enProcess' => '0'



);


if( $isApplyExist===0 ){	

/*	if(isExist($_POST['paEtc']))
		$arrApplyMember['paEtc'] = $_POST['paEtc'];
*/

	DB::insert('tmExchangeRefundNote7', $arrApplyMember);
	
/*	
	$SMS = new SMS();
	$sendCont = "[티플 아이폰7 사전예약] 티플에서 아이폰7을 사전예약해주셔서 감사합니다. 사전예약이 처리되면 공지해드리겠습니다.";
	$SMS->sendMode('SMS')->sendMemberPhone($_POST['paPhone'])->sendMemberName($mb['mbName'])->sendCont($sendCont)->send();	
*/
}



alert('완료되었습니다.', "/user/exchangeRefundNote7State.php");


?>