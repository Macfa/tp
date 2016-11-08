<?

require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
include_once(PATH_LIB."/lib.snoopy.inc.php");
include_once(PATH_LIB."/lib.parsing.inc.php");
//include_once(PATH_LIB."/lib.calculator.inc.php");

if(isExist($_GET['mbEmail']) && $isAdmin === false)
	$mbEmail = $_GET['mbEmail'];
else
	$mbEmail = $mb['mbEmail'];

$preorderTitle = DB::queryFirstRow("SELECT * FROM tmPreorder WHERE poDeviceName=%s",$_GET['device']);
$editMember = DB::queryFirstRow("SELECT * FROM tmPreorderApplyList WHERE mbEmail=%s AND poKey=%s and paCancel = 0",$mbEmail,$preorderTitle['poKey']);


try{
	$preorder = DB::queryFirstRow("SELECT * FROM tmPreorderApplyList WHERE mbEmail=%s and paCancel = 0 AND poKey=%s", $mb['mbEmail'], $preorderTitle['poKey']);	
	$isApplyExist = (int)$preorder;

	if($isApplyExist === 0 && $_GET['v'] == 'edit')
		throw new Exception('구매후 수정이 가능합니다', 2);

	if(isExist($_GET['mbEmail']) === true && $isAdmin === FALSE)
		throw new Exception('잘못된 접근 입니다', 1);

	if($isApplyExist === 1 && $_GET['v'] != 'edit' )
		throw new Exception('이미 신청서를 작성하셨습니다.', 3);

	if($isApplyExist === 1 && $_GET['v'] == 'edit' && $preorder['paProcess'] >=3)
		throw new Exception('수정할수 없습니다.', 3);

	if(isExist($_GET['mbEmail']) === true){

		if(!$_GET['device'])
			throw new Exception('잘못된 접근 입니다', 1);

		if(isNullVal($_GET['device']) || $_GET['device'] != $preorderTitle ['poDeviceName'])
			throw new Exception('잘못된 접근 입니다', 1);
		if(isExist($editMember)){
			if($mbEmail != $editMember['mbEmail']){
				throw new Exception('잘못된 접근 입니다', 1);
			}
		}
	}


} catch (Exception $e) {	
	if ($e->getCode() === 1)
		alert($e->getMessage(), $cfg['path']);
	else if ($e->getCode() === 2)
		alert($e->getMessage(), $cfg['path']."/page/preorderApply.php?device=".$preorderTitle['poDeviceName']);
	else if ($e->getCode() === 3)	
		alert($e->getMessage(), $cfg['path']."/user/preorderState.php?device=".$preorderTitle['poDeviceName']);
}


//$calculator = new calculator('v20');
//$calculator->setCarrierTypeSelect()->setDeviceTypeSelect()->setCapacitySelect()->setApplyTypeSelect()->setDiscountTypeSelect()->setVatContainSelect()->setPlanSelect();


$add_css = '<link rel="stylesheet" href="'.PATH_CSS.'/preOrderNote7.css" type="text/css">';
$js_file = '<script type="text/javascript" src="'.PATH_JS.'/preorderNote7.js"></script>';
$js_file .= '<script type="text/javascript" src="'.PATH_JS.'/calculator.js"></script>';
$js_file .= '<script type="text/javascript" src="'.PATH_JS.'/input.js"></script>';
$js_file .= '<script type="text/javascript" src="'.PATH_JS.'/validate.js"></script>';
$cfg['title'] = $preorderTitle['poDeviceName'].' 구매안내';

$vailName ='';
$validEmail = '';
$validPhone = '';
$validBirth = str_replace('-','',$preorder['paBirth']);

if ($isLogged === TRUE)
	$vailName = $mb['mbName'];

if (isEmail($mb['mbEmail']) === true && $isLogged === TRUE)
	$validEmail = $mb['mbEmail'];

if  (isPhoneNum($mb['mbPhone']) == true || isTelNum($mb['mbPhone']) == true && $isLogged === TRUE){
	$validPhone = $mb['mbPhone'];
}

// 어드민에서 신청정보 수정시 ================================

if(isExist($_GET['mbEmail']) === true && $isAdmin === TRUE){	
	$vailName = $editMember['paName'];
	$validEmail = $editMember['mbEmail'];
	$validPhone = $editMember['paPhone'];
	$validBirth = str_replace('-','',$editMember['paBirth']);
	$plan = array(
		0 => 'T시그니쳐 Master',
		1 => 'T시그니쳐 Classic',
		2 => 'band 데이터 퍼펙트S',
		3 => 'band 데이터 퍼펙트',
		4 => 'band 데이터 6.5G',
		5 => 'band 데이터 3.5G',
		6 => 'band 데이터 2.2G',
		7 => 'band 데이터 1.2G',
		8 => 'band 데이터 세이브',
		15 => 'LTE 데이터 선택 109',
		16 => 'LTE 데이터 선택 76.8',
		17 => 'LTE 데이터 선택 65.8',
		18 => 'LTE 데이터 선택 54.8',
		19 => 'LTE 데이터 선택 49.3',
		20 => 'LTE 데이터 선택 43.8',
		23 => 'LTE 데이터 선택 38.3',
		24 => 'LTE 데이터 선택 32.8'
	);

$arreditGift =  explode(',', $editMember['paGift']);

$gift = array(
	'tablet' => '엠피지오 태블릿',
	'externalHard' => '외장SSD 128G',
	'skMirroring' => 'SK 미러링'
);



list($deviceRamKey,$parentKey) = DB::queryFirstList("SELECT dvTit, dvParent FROM tmDevice WHERE dvKey=%i", $editMember['dvKey']);
$deviceKey = DB::queryFirstField("SELECT dvId FROM tmDevice WHERE dvKey=%i",$parentKey );

} 

// END================================



switch($preorderTitle ['poKey']){
	case 3 :
	$deviceName = array (
	'iphone7' => '아이폰7',
	'iphone7plus' => '아이폰7 플러스'
	);
	break;
	case 5 : 
	$deviceName =array(		
	'bey' => '비와이폰'
	);
	break;
}

switch($preorderTitle ['poKey']){
	case 3 :
	$paColorType = array (
	'silver' => '실버',
	'gold' => '골드',
	'roseGold' => '로즈골드'
	);
	break;
	case 5 : 
	$paColorType =array(		
	'white' => '화이트',
	'black' => '블랙'
	);
	break;
}

switch($preorderTitle ['poKey']){
	case 3 :
	$paDeviceRam = array (
	'128G' => '128G',
	'256G' => '256G'
	);
	break;
	case 5 : 
	$paDeviceRam =array(		
	'64G' => '14 + 64G'
	);
	break;
}



/*
$phone = new deviceInfo();
$arrPlan = $phone->setCarrier('sk')->setMode('phone')->getArrPlan();
foreach($arrPlan as $plan){
	$select .= '<option value="'.$plan.'" class="option-sk">'.$phone->getPlanName($plan).' | '.$phone->getPlanInfo($plan).'</option>';
}
$arrPlan = $phone->setCarrier('kt')->setMode('phone')->getArrPlan();
foreach($arrPlan as $plan){
	$select .= '<option value="'.$plan.'" class="option-kt">'.$phone->getPlanName($plan).' | '.$phone->getPlanInfo($plan).'</option>';
}
*/

$startTime= '2016-10-28 10:00:00';
$jetBlackApply = (int)DB::queryFirstField("SELECT count(*) FROM tmPreorderApplyList WHERE paColorType = %s and paDatetime >= %s", 'jetBlack', $startTime);
if ($jetBlackApply >= 20) $isDisableJetBlack = 'disabled';

$blackApply = (int)DB::queryFirstField("SELECT count(*) FROM tmPreorderApplyList WHERE paColorType = %s and paDatetime >= %s", 'black', $startTime);
if ($blackApply >= 20) $isDisableBlack = 'disabled';

require_once($cfg['path']."/head.inc.php");			// 헤더 부분 (스킨포함)
require_once("preorderApply.skin.php");
require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)
?>