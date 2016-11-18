<?
require_once("./_common.inc.php");	

$isNeedToken = true;
if($_POST['authentication'] === $cfg['authentication'])
	$isNeedToken = false;

if ($isNeedToken === true && chkToken($_POST['token']) === false) {
	exit;
}


//DB::debugMode();
$device = DB::queryFirstRow("SELECT * FROM tmDevice WHERE dvId = %s and dv".strtoupper($_POST['carrier'])." = 1", $_POST['id']);

$deviceInfo = new deviceInfo();
$deviceInfo->setCarrier($_POST['carrier'])->setMode($device['dvCate']);

$output['deviceType'] = $deviceInfo->getArrDeviceType();
$output['applyType'] = $deviceInfo->getArrApplyType();
$output['discountType'] = $deviceInfo->getArrDiscountType();
$output['carrier'] = $deviceInfo->getArrCarrierType($device['dvKey']);

if((int)$device['dvParent'] !== 0) {
	$childs = DB::queryOneColumn('dvTit', "SELECT * FROM tmDevice WHERE dvDisplay = 1 and dvParent = %i and dv".strtoupper($_POST['carrier'])." = 1", $device['dvParent']);
	foreach($childs as $capacity)
		$output['capacity'][] = $capacity;
}

$arrPlan = $deviceInfo->getArrPlan();
//var_dump($arrPlan);
foreach($arrPlan as $val) {
 	$isExistPlan = DB::queryFirstField("SELECT count(*) FROM tmSupport WHERE dvKey = %i and spCarrier = %s and spPlan = %i", $device['dvKey'], $_POST['carrier'], $val);
 	if((int)$isExistPlan <= 0)	continue;
	$output['plan'][$val]['name'] = $deviceInfo->getPlanName($val);
	$output['plan'][$val]['info'] = $deviceInfo->getPlanInfo($val);
}

echo json_encode($output); 