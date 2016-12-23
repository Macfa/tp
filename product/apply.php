<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
include_once(PATH_LIB."/lib.snoopy.inc.php");
include_once(PATH_LIB."/lib.parsing.inc.php");

$device = DB::queryFirstRow("SELECT * FROM tmDevice WHERE dvDisplay = 1 and dvKey = %s", $_GET['dvKey']);

if($device['dvParent']){
	$applyTitle = DB::queryFirstField("SELECT dvTit FROM tmDevice WHERE dvKey = %s", $device['dvParent']);
}else{
	$applyTitle = $device['dvTit'];
}

try{
	if(isNotExist($_GET['carrier']) === true 
		|| isNotExist($_GET['dvId']) === true
		|| isNotExist($_GET['applyType']) === true 
		|| isNotExist($_GET['discountType']) === true 
		|| isNotExist($_GET['dvKey']) === true 
		|| isNotExist($_GET['plan']) === true)
		throw new Exception('기본정보입력 후 가능합니다.', 1);	

	if(isExist($device) === FALSE)
		throw new Exception('존재하지 않는 기기입니다.', 3);

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
$add_css = '<link rel="stylesheet" href="'.PATH_CSS.'/apply.css" type="text/css">';
$js_file = '<script type="text/javascript" src="'.PATH_JS.'/apply.js"></script>';
$js_file .= '<script type="text/javascript" src="'.PATH_JS.'/gifts.js"></script>';
$js_file .= '<script type="text/javascript" src="'.PATH_JS.'/modifyInfo.js"></script>';
$js_file .= '<script type="text/javascript" src="'.PATH_JS.'/calculator.js"></script>';

require_once($cfg['path']."/headSimple.inc.php");		// 헤더 부분 (스킨포함)
require_once("apply.skin.php");	
require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)