<?

require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
include_once(PATH_LIB."/lib.snoopy.inc.php");
include_once(PATH_LIB."/lib.parsing.inc.php");
//include_once(PATH_LIB."/lib.calculator.inc.php");


$preorderTitle = DB::queryFirstRow("SELECT poKey, poDeviceName FROM tmPreorder WHERE poDeviceName=%s",$_GET['device']);
$editMember = DB::queryFirstRow("SELECT * FROM tmPreorderApplyList WHERE mbEmail=%s",$_GET['mbEmail']);


try{
	$preorder = DB::queryFirstRow("SELECT * FROM tmPreorderApplyList WHERE mbEmail=%s and paCancel = 0", $mb['mbEmail']);	
	$isApplyExist = (int)$preorder;

	if($isApplyExist === 0 && $_GET['v'] === 'edit' && isExist($_GET['mbEmail']) === FALSE)
		throw new Exception('구매후 수정이 가능합니다', 2);

	if(isExist($_GET['mbEmail']) === true && $isAdmin === FALSE)
		throw new Exception('잘못된 접근 입니다', 1);

	if($isApplyExist === 1 && $_GET['v'] != 'edit' && isExist($_GET['mbEmail']) === FALSE)
		throw new Exception('이미 신청서를 작성하셨습니다.', 3);

	if($isApplyExist === 1 && $_GET['v'] === 'edit' && $_GET['device'] && $preorder['paProcess']>='2')
		throw new Exception('수정하실수 없습니다.', 3);

	if(!$_GET['device'])
		throw new Exception('잘못된 접근 입니다', 1);

	if($_GET['device']=== '' || $_GET['device'] != $preorderTitle ['poDeviceName'])
		throw new Exception('잘못된 접근 입니다', 1);

	if($_GET['mbEmail'] != $editMember['mbEmail'])
		throw new Exception('잘못된 접근 입니다', 1);




	
} catch (Exception $e) {	
	if ($e->getCode() === 1)
		alert($e->getMessage(), $cfg['path']);
	else if ($e->getCode() === 2)
		alert($e->getMessage(), $cfg['path']."/page/preorderIphone7.php");
	else if ($e->getCode() === 3)	
		alert($e->getMessage(), $cfg['path']."/user/preorderState.php");
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

$startTime= '2016-10-27 19:00:00';
$jetBlackApply = (int)DB::queryFirstField("SELECT count(*) FROM tmPreorderApplyList WHERE paColorType = %s and paDatetime >= %s", 'jetBlack', $startTime);
if ($jetBlackApply >= 20) $isDisableJetBlack = 'disabled';

$blackApply = (int)DB::queryFirstField("SELECT count(*) FROM tmPreorderApplyList WHERE paColorType = %s and paDatetime >= %s", 'black', $startTime);
if ($blackApply >= 20) $isDisableBlack = 'disabled';

require_once($cfg['path']."/head.inc.php");			// 헤더 부분 (스킨포함)

require_once("preorderApply.skin.php");
require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)
?>