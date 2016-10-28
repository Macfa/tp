<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
include_once(PATH_LIB."/lib.snoopy.inc.php");
include_once(PATH_LIB."/lib.parsing.inc.php");

try{
	list($countDevice, $dvKey) = DB::queryFirstList("SELECT COUNT(*), dvKey FROM tmDevice WHERE dvDisplay = 1 and dvId = %s", $_GET['id']);
	$isExistDevice = ($countDevice>0)?TRUE:FALSE;
	if($isExistDevice === FALSE)
		throw new Exception('존재하지 않는 기기입니다.', 3);
}catch(Exception $e){
    alert($e->getMessage());
}

$defaultRewardPoint = 0;
$lockedPropertyCount = 0;
$child = DB::query("SELECT * FROM tmDevice WHERE dvDisplay = 1 and dvParent = %i", $dvKey);
$childCount = DB::count();
$isExistChild = ($childCount>0)?TRUE:FALSE;
$isCanChildSelect = ($childCount>1)?TRUE:FALSE;

if ($_POST['capacity']) {
	foreach ($child as $key => $val) {
		if ($val['dvTit'] == $_POST['capacity']) {
			$child[$key]['isChecked'] = 'checked';
		}
	}
}

if($isExistChild && isNullVal($_POST['capacity'])){
	$child[0]['isChecked'] = 'checked';
}

if(count($child) == 1) {
	$lockedPropertyCount += 1;
	$capacityLockIcon = "<i class='ico-lock'></i>";
} else {
	$capacityRowAffix = count($child);
}

//-----------------------------------------------------------------------------------------------------

$device = DB::queryFirstRow("SELECT * FROM tmDevice WHERE dvDisplay = 1 and dvKey = %i", $dvKey);

$deviceInfo = new deviceInfo();
$deviceInfo->setCarrier('sk')->setMonth(24)->setMode($device['dvCate']);

$arrApplyType = $deviceInfo->getArrApplyType();
if ($_POST['applyType']) {
	foreach ($arrApplyType as $key => $val) {
		if ($key == $_POST['applyType']) {
			$applyTypeChecked[$key]['isChecked'] = 'checked';
		}
	}
}
if (isNullVal($_POST['applyType'])) 
	$applyTypeChecked[getFirstArrKey($arrApplyType)]['isChecked'] = 'checked';

if(count($arrApplyType) == 1) {
	$lockedPropertyCount += 1;
	$applyTypeLockIcon = "<i class='ico-lock'></i>";
} else {
	$applyTypeRowAffix = count($arrApplyType);
}

//-----------------------------------------------------------------------------------------------------

$arrSelectPlan = $deviceInfo->getArrPlan();
if (isExist($_POST['plan'])) {
	foreach ($arrSelectPlan as $key => $val) {
		if ($key == $_POST['plan']) {
			$isPlanSelected[$key]['isChecked'] = 'selected';
		}
	}
}else{
	$isPlanSelected[getFirstArrKey($arrSelectPlan)]['isChecked'] = 'selected';
}

//-----------------------------------------------------------------------------------------------------

switch($device['dvCate']) {
	case 'watch':
		$is3G = TRUE;
		$lockedPropertyCount += 1;
	case 'pocketfi':
		unset($arrSelectPlan[9]);
	case 'kids':
		$onlySupportDiscount = true;
		break;
	default:
		break;
}
$discountTypeCount = 2;
if ($onlySupportDiscount) {
	$isSupportDiscountChecked = 'checked';
	$isSupportDiscountRowActive = 'active';
	$discountTypeCount = 1;
	$lockedPropertyCount += 1;
	$defaultDiscountType = 'support';
	$discountTypeLockIcon = "<i class='ico-lock'></i>";
} else {
	$discountTypeRowAffix = $discountTypeCount;
}
//-----------------------------------------------------------------------------------------------------

if(count($child) == 1) 
	$capacityRowAffix = 'lock-'.$lockedPropertyCount;

if(count($arrApplyType) == 1)
	$applyTypeRowAffix = 'lock-'.$lockedPropertyCount;

if ($discountTypeCount == 1) 
	$discountTypeRowAffix = 'lock-'.$lockedPropertyCount;

//--------------------------------------------------------------------------------------------------------

$defAddress = DB::queryFirstRow("SELECT * FROM tmAddress WHERE mbEmail = %s and arIsDefault = 1", $mb['mbEmail']);
$arrAddress = DB::query("SELECT * FROM tmAddress WHERE mbEmail = %s", $mb['mbEmail']);

//---------------------------------------------------------------------------------------------------------

$defCapacity = $_POST['capacity'] ?$_POST['capacity']: $child[0]['dvTit'];

$planData['dataCapacity'] = ($isExistChild)?$defCapacity:'noCapacity';
$planData['discountType'] = 'support';
$planData['plan'] = $_POST['plan']?$_POST['plan']:getFirstArrKey($arrSelectPlan);
$planData['id'] = $_GET['id'];
$calcDefaultValue = getPlanInfo($planData);

$calcDefaultValue['dvRetailPricePerMonth'] = round($calcDefaultValue['dvRetailPrice']/24);
$calcDefaultValue['spSupportPerMonth'] = round($calcDefaultValue['spSupport']/24);
$calcDefaultValue['spAddSupportPerMonth'] = round($calcDefaultValue['spAddSupport']/24);
$calcDefaultValue['result'] = $calcDefaultValue['dvRetailPricePerMonth'] - $calcDefaultValue['spSupportPerMonth'] - $calcDefaultValue['spAddSupportPerMonth'] + $calcDefaultValue['planFee'];

if(count($arrApplyType) == 1 && $onlySupportDiscount )
	$defaultRewardPoint = $calcDefaultValue['rewardPoint'][$defaultDiscountType][getFirstArrKey($arrApplyType)];

//-----------------------------------------------------------------------------------------------------------

$naver->setReturnURL('http://tplanit.co.kr/user/snsLoginForApply.php');
$kakao->setReturnURL('http://tplanit.co.kr/user/snsLoginForApply.php');

//----------------------------------------------------------------------------------------------------------

$add_css = '<link rel="stylesheet" href="'.PATH_CSS.'/apply.css" type="text/css">';
$js_file = '<script type="text/javascript" src="'.PATH_JS.'/apply.js"></script>';
$js_file .= '<script type="text/javascript" src="'.PATH_JS.'/gifts.js"></script>';
$js_file .= '<script type="text/javascript" src="'.PATH_JS.'/modifyInfo.js"></script>';
$js_file .= '<script type="text/javascript" src="'.PATH_JS.'/calculator.js"></script>';

require_once($cfg['path']."/headSimple.inc.php");			// 헤더 부분 (스킨포함)
require_once("apply.skin.php");	
require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)