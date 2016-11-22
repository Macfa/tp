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
$output['carrier'] = $deviceInfo->getArrCarrier($device['dvKey']);

$childs = DB::queryOneColumn('dvTit', "SELECT * FROM tmDevice WHERE dvDisplay = 1 and dvParent = %i and dv".strtoupper($_POST['carrier'])." = 1", $device['dvKey']);
//var_dump($childs);
if($childs !== array()){
	foreach($childs as $capacity) {
		$output['capacity'][] = $capacity;
	}
}


$defaultKey = DB::queryFirstField("SELECT dvKey FROM tmDevice WHERE dvId = %s", $_POST['id'].strtolower($output['capacity'][0]));

$arrPlan = $deviceInfo->getArrPlan($defaultKey);
//var_dump($defaultKey);

foreach($arrPlan as $plan) {
	$output['plan'][$plan]['name'] = $deviceInfo->getPlanName($plan);
	$output['plan'][$plan]['info'] = $deviceInfo->getPlanInfo($plan);
}

echo json_encode($output); 