<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
include_once(PATH_LIB."/lib.snoopy.inc.php");
include_once(PATH_LIB."/lib.parsing.inc.php");
require_once(PATH_LIB."/lib.calculator.inc.php");


// 어드민에서 직접 신청서를 수정하는 경우
if(isExist($_GET['mbEmail'])){
	$mb['mbEmail'] = $_GET['mbEmail'];
	list($mb['mbKey'],$mb['mbPhone']) = DB::queryFirstList("SELECT mbKey, mbPhone FROM tmMember WHERE mbEmail = %s", $_GET['mbEmail']);
}
//--------------------------------------------------------------------------------------------------------

$dvKey = $_GET['dvKey'];

if(isExist($_GET['v']) === true){
	//수정할 신청서 정보
	$modifyApply = DB::queryFirstRow("SELECT * FROM tmApplyTmp AS apply LEFT JOIN tmDevice AS device ON apply.dvKey = device.dvKey WHERE apply.apKey=%i AND apply.apCancel=0", $_GET['apKey']);
	$dvKey = $modifyApply['dvKey'];
}


$device = DB::queryFirstRow("SELECT * FROM tmDevice WHERE dvDisplay = 1 and dvKey = %s", $dvKey);

if($device['dvParent']){
	$applyTitle = DB::queryFirstField("SELECT dvTit FROM tmDevice WHERE dvKey = %s", $device['dvParent']);

}else{
	$applyTitle = $device['dvTit'];
}

try{
	if(isExist($_GET['v']) === false){
		if(isNotExist($_GET['carrier']) === true 
			|| isNotExist($_GET['dvId']) === true
			|| isNotExist($_GET['applyType']) === true 
			|| isNotExist($_GET['discountType']) === true 
			|| isNotExist($_GET['dvKey']) === true 
			|| isNotExist($_GET['plan']) === true)
			throw new Exception('기본정보입력 후 가능합니다.', 1);	

		if(isExist($device) === FALSE)
			throw new Exception('존재하지 않는 기기입니다.', 3);
	}

}catch(Exception $e){
	if($e->getCode === 1) {
		$URL = URL.'/device/'.$_GET['dvId'];

    	alert($e->getMessage(), $URL);
	}else 
		alert($e->getMessage());
}
$deviceInfo = new deviceInfo();

$getPlanInfo = getPlanInfo(
			array(
				'capacity' => $_GET['capacity'],
				'plan' => $_GET['plan'],
				'carrier' => $_GET['carrier'],
				'applyType' => (int)$_GET['applyType'],
				'discountType' => $_GET['discountType'],
				'id' => $_GET['dvId']
			)
		);

$defaultRewardPoint = $getPlanInfo['rewardPoint']; 


//VAR_DUMP($defaultRewardPoint);
$mbPoint = (isExist($mb['mbPoint'])===TRUE)?$mb['mbPoint']:0;
	$totalPoint = number_format($defaultRewardPoint);
if((int)$defaultRewardPoint === 0) {
	$totalPoint = "미정";
}

$isRecommedId = DB::queryFirstField("SELECT prParent FROM tmPointRelationship WHERE mbKey=%i", $mb['mbKey']);
$recommedMbEmail = DB::queryFirstField("SELECT mbEmail FROM tmMember WHERE mbKey=%i", $isRecommedId);


$name = $deviceInfo->getCarrierName($_GET['carrier']);

if  (isPhoneNum($mb['mbPhone']) == true || isTelNum($mb['mbPhone']) == true && $isLogged === TRUE){

	$validPhone = $mb['mbPhone'];

}

//--------------------------------------------------------------------------------------------------------

$defAddress = DB::queryFirstRow("SELECT * FROM tmAddress WHERE mbEmail = %s and arIsDefault = 1", $mb['mbEmail']);
$arrAddress = DB::query("SELECT * FROM tmAddress WHERE mbEmail = %s", $mb['mbEmail']);

//-----------------------------------------------------------------------------------------------------------

$naver->setReturnURL('http://tplanit.co.kr/user/snsLoginForApply.php');
$kakao->setReturnURL('http://tplanit.co.kr/user/snsLoginForApply.php');

//----------------------------------------------------------------------------------------------------------

$import->addJS('apply.js')->addJS('gifts.js')->addJS('modifyInfo.js')->addJS('calculator.js')->addJS('input.js')->addCSS('apply.css');

//----------------------------------------------------------------------------------------------------------
// 직접 고객이 수정할때 & 어드민 수정시에 나오는 계산기 



if($_GET[v] === 'edit'){
	$isEdit = true;

	if((int)$modifyApply['dvParent'] != 0){
		$modifyApply['dvId'] = DB::queryFirstField("SELECT dvId FROM tmDevice WHERE dvKey=%i", $modifyApply['dvParent']);
	
	}

	$planCalculator = new planCalculator();
	$planCalculator->setDevice($modifyApply['dvId'])->setCarrier($modifyApply['apChangeCarrier'])->setCapacity($modifyApply['dvTit'])->setDeviceType()->setApplyType($modifyApply['apApplyType'])->setDiscountType($modifyApply['apDiscountType'])->setPlan($modifyApply['apPlan']);	


	try{
		if(isExist($modifyApply) === FALSE)
			throw new Exception('신청후 수정할수 있습니다', 3);

	}catch(Exception $e){
		alert($e->getMessage());

	}
	$editClass = "editWrap";

}

$countApply = DB::queryFirstField('SELECT COUNT(*) FROM tmApplyTmp WHERE mbEmail = %s', $mb['mbEmail']);
$countApply = (int)$countApply;
// var_dump($countApply);
$isExistApply = ($countApply > 0)?TRUE:FALSE;

if($isExistApply !== true || ($countApply <= 1 && $isEdit === TRUE)) {
	$isNeedReferrerChannel = TRUE;
}

$arrReferrerChannel = array('네이버 파워링크', '네이버 블로그', '네이버 카페', '페이스북(인스타그램)', '커뮤니티(클리앙,뽐뿌 등)', '지인소개', '기타 검색');
//----------------------------------------------------------------------------------------------------------

require_once($cfg['path']."/headSimple.inc.php");		// 헤더 부분 (스킨포함)
require_once("apply.skin.php");	
require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)