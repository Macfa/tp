<?

require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
include_once(PATH_LIB."/lib.snoopy.inc.php");
include_once(PATH_LIB."/lib.parsing.inc.php");
//include_once(PATH_LIB."/lib.calculator.inc.php");

try{
	$preorder = DB::queryFirstRow("SELECT * FROM tmPreorderV20 WHERE mbEmail=%s and pvCancel = 0", $mb['mbEmail']);	 ///////////////////////////////////
	$isV20ApplyExist = (int)DB::count();	 
	if($isV20ApplyExist === 1 && $_GET['v'] != 'edit')
		throw new Exception('이미 신청서를 작성하셨습니다.', 3);
	//if($preorder['pvProcess'] >= 1)
		//throw new Exception('신청완료 상태이므로 수정할수 없습니다.', 3);
	
} catch (Exception $e) {	
	alert($e->getMessage(), $cfg['path']."/user/preorderV20State.php");
}

//$calculator = new calculator('v20');
//$calculator->setCarrierSelect()->setDeviceTypeSelect()->setCapacitySelect()->setApplyTypeSelect()->setDiscountTypeSelect()->setVatContainSelect()->setPlanSelect();


$add_css = '<link rel="stylesheet" href="'.PATH_CSS.'/preOrderNote7.css" type="text/css">';
$js_file = '<script type="text/javascript" src="'.PATH_JS.'/preorderNote7.js"></script>';
$js_file .= '<script type="text/javascript" src="'.PATH_JS.'/calculator.js"></script>';
$js_file .= '<script type="text/javascript" src="'.PATH_JS.'/input.js"></script>';
$js_file .= '<script type="text/javascript" src="'.PATH_JS.'/validate.js"></script>';
$cfg['title'] = 'LG V20 구매안내';

$validEmail = '';
$validPhone = '';
if (isEmail($mb['mbEmail']) === true && $isLogged === TRUE)
	$validEmail = $mb['mbEmail'];

if  (isPhoneNum($mb['mbPhone']) == true || isTelNum($mb['mbPhone']) == true && $isLogged === TRUE){
	$validPhone = $mb['mbPhone'];
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

require_once($cfg['path']."/head.inc.php");			// 헤더 부분 (스킨포함)
require_once("preorderV20Apply.skin.php");
require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)
?>