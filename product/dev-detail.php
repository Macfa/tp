<?

// 파일명.inc.php 는 다른 파일에 종속(include)되는 파일로 단독적으로 활용될수 없습니다.
// 파일명.skin.php 는 다른 파일의 html 부분을 담당하는 파일로 단독적으로 활용될수 없습니다.

require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
include_once(PATH_LIB."/lib.snoopy.inc.php");
include_once(PATH_LIB."/lib.parsing.inc.php");

$add_css = '<link rel="stylesheet" href="'.PATH_CSS.'/detail.css" type="text/css">';
$js_file = '<script type="text/javascript" src="'.PATH_JS.'/dev-detail.js"></script><!--[if lt IE 9]><script type="text/javascript" src="'.PATH_JS_LIB.'/excanvas.js"></script><![endif]-->';

$showDetailHead = true;


try{
	list($countDevice, $dvKey) = DB::queryFirstList("SELECT COUNT(*), dvKey FROM tmDevice WHERE dvDisplay = 1 and dvId = %s", $_GET['id']);
	$isExistDevice = ($countDevice>0)?TRUE:FALSE;
	if($isExistDevice === FALSE)
		throw new Exception('존재하지 않는 기기입니다.', 3);
}catch(Exception $e){
    alert($e->getMessage());
}

//-------------------------

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
if (isNullVal($_POST['applyType']) && count($arrApplyType) == 1) 
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
		break;
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


if ($device['dvId'] == 'iphonese'){
	$isApplyBtnDisabled = '';
	$defaultVal['href'] = 'href="https://docs.google.com/forms/d/1s_Nelfp3aixUkfoASPD5Hbc6uJsrT3joiWMkrvHnOUo/viewform"';
}

$isShowDeviceNav = true;
$deviceNavActive = 'active';
$deviceNavItemActive[$_GET['id']] = 'active';
$deviceNavSql = clearEscape(getSession('detailDeviceListSql'));
$defaultDeviceNavSql = "SELECT d.* FROM tmDevice d LEFT JOIN tmSort o ON d.dvKey = o.soTargetKey WHERE d.dvDisplay=1 and d.dvParent = 0 and d.dvCate = '".$device['dvCate']."' GROUP BY d.dvKey ORDER BY o.soOrder is null ASC, o.soOrder ASC"; 
if ($deviceNavSql) 
	$deviceNavResult = DB::query($deviceNavSql);
else
	$deviceNavResult = DB::query($defaultDeviceNavSql);

$isExistInDeviceNav = false;
foreach($deviceNavResult as $val){
	if ($device['dvTit'] == $val['dvTit']) {
		$isExistInDeviceNav = true;
		break;
	}
}

if ($isExistInDeviceNav === false) {
	unsetSession('detailDeviceListSql');
	$deviceNavResult = DB::query($defaultDeviceNavSql);
}


$cfg['subTitle'] = $device['dvTit'].' 상세 페이지';
require_once($cfg['path']."/head.inc.php");			// 헤더 부분 (스킨포함)

require_once($includePrefix."detail.skin.php");	
//echo $deviceInfo->setCarrier('sk')->setMonth(24)->calcInterest()->test()->getRepayment();
//print_r($arrSelectPlan);
//print_r($graphMinValue);

require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)
?>