<?

// 파일명.inc.php 는 다른 파일에 종속(include)되는 파일로 단독적으로 활용될수 없습니다.
// 파일명.skin.php 는 다른 파일의 html 부분을 담당하는 파일로 단독적으로 활용될수 없습니다.

require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

$isNeedToken = true;
if($_POST['authentication'] === $cfg['authentication'])
	$isNeedToken = false;

if ($isNeedToken === true && chkToken($_POST['token']) === false) {
	exit;
}

//-------------------------------

if (isExist($_POST['capacity']))
	$dvId = $_POST['id'].strtolower($_POST['capacity'])

$device = DB::queryFirstRow("SELECT * FROM tmDevice WHERE dvDisplay = 1 and dvId = %s and dv{strtoupper($_POST['carrier'])} = 1", $dvId);

$deviceInfo = new deviceInfo();
$deviceInfo->setCarrier($_POST['carrier'])->setMode($device['dvCate'])->setMonth(24)->setPlan($_POST['plan']);
$deviceInfo->setDevicePrice($device['dvRetailPrice']);

$result	= DB::query("SELECT * FROM tmSupport WHERE dvKey = %i0 and spPlan = %i1 and spCarrier = %s2 ORDER BY spDate DESC LIMIT 5", $device['dvKey'], $_POST['plan'], $_POST['carrier']);
$output = $result[0];


if ($_POST['discountType'] == 'support')
	$resultDevicePrice = $device['dvRetailPrice'] - ($output['spSupport'] + $output['spAddSupport']);
else if ($_POST['discountType'] == 'selectPlan') {
	$resultDevicePrice = $device['dvRetailPrice'];
	$output['selectPlanDiscount'] = $deviceInfo->getSelectPlanDiscount() * 24;
}

$output['repayment'] = $deviceInfo->calcInterest($resultDevicePrice)->getRepayment();
$output['planFee'] = $deviceInfo->getPlanFee();
$output['dvRetailPrice'] = $device['dvRetailPrice'];
//$output['containVatInterest'] = $deviceInfo->getContainVatInterest();

$cdCode = DB::queryOneField("SELECT cdCode FROM tmCode WHERE dvKey = %i0 and spPlan = %i1 and cdType = %i2", $device['dvKey'], $_POST['plan'], (int)$_POST['applyType']);

if (isExist($cdCode) === true) {
	$output['applyUrl'] = $deviceInfo->getApplyURL($cdCode, $_POST['applyType']);
}else{ 
	$output['applyUrl'] ="https://docs.google.com/forms/d/e/1FAIpQLScQfOiyAu4Seha7aDXdj0RUzKYV36n9ZlI3QIz4w-xATXGiAQ/viewform";
}

$cntDevicePlanGraph = count($result);
$isGraphChanged = TRUE;

foreach ($result as $key => $val) {
	$output['supportGraph']['spDate'][] = $val['spDate'];
	$output['supportGraph']['spSupport'][] = $val['spSupport'];

	if($cntDevicePlanGraph == 1) {
		$isGraphChanged = FALSE;
		$output['supportGraph']['spDate'][] = $val['spDate'];
		$output['supportGraph']['spSupport'][] = $val['spSupport'];
	}
}

$output['supportGraph']['spDate'][$cntDevicePlanGraph-1] = $cfg['time_ymd'];
$output['supportGraph']['spDate'] = array_reverse($output['supportGraph']['spDate']);
$output['supportGraph']['spSupport'] = array_reverse($output['supportGraph']['spSupport']);
$isCurrentBigger = FALSE;

if($cntDevicePlanGraph > 1){
	foreach($output['supportGraph']['spSupport'] as $val){
		if($graphMinValue == false) {
			$graphMinValue = $val;
		}else if($val < $graphMinValue) {
			$graphMinValue = $val;
		}

		if($graphMaxValue == false) {
			$graphMaxValue = $val;
		}else if($val > $graphMaxValue) {
			$graphMaxValue = $val;
		}
	}
	
	$graphPrevVal = $output['supportGraph']['spSupport'][$cntDevicePlanGraph-2];
	$graphCurrentVal = $output['supportGraph']['spSupport'][$cntDevicePlanGraph-1];

	//바로전 값과 최근값이 같다면
	if ($graphPrevVal == $graphCurrentVal)
		$graphPrevVal = $output['supportGraph']['spSupport'][$cntDevicePlanGraph-3];

	//가장 최근값의 값이 더클때
	if($graphPrevVal < $graphCurrentVal){
		$isCurrentBigger = TRUE;
	}
	if ($isCurrentBigger) {
		$graphStartValue = ($graphMinValue-10000);
		$graphEndValue = $graphMaxValue;
		$graphStep = 2;
	} else{
		$graphStartValue = ($graphMinValue/2);
		$graphEndValue  = $graphMaxValue*1.5;	
		$graphStep = 10;
	}

	//그래프 단계간 값차이
	$graphStepGap = floor(($graphEndValue-$graphStartValue) / $graphStep);	

	$output['graphStartValue'] = $graphStartValue;
	$output['graphStep'] = $graphStep;
	$output['graphStepGap'] = $graphStepGap;
	$output['isGraphChanged'] = $isGraphChanged;

	for($i=0;$i<$graphStep;$i++){
		$output['graphStepYLabels'][] = $output['graphStartValue'] + $graphStep*$i;
	}
}

//-------------------------------------

$rpPoint = DB::queryFirstField("SELECT rpPoint FROM tmRewardPoint WHERE dvKey = %i_dvKey and rpPlan = %i_rpPlan and rpCarrier = %s_rpCarrier and rpApplyType = %i_rpApplyType and rpDiscountType = %s_rpDiscountType", 
	array(
		'dvKey' => $device['dvKey'],
		'rpPlan' => $_POST['plan'],
		'rpCarrier' => $_POST['carrier'],
		'rpApplyType' => (int)$_POST['applyType'],
		'rpDiscountType' => $_POST['discountType']
	)
);

$output['rewardPoint'] = $rpPoint;

//-------------------------------------

echo json_encode($output);

?>
