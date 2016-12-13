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

//var_dump($_POST);
//DB::debugMode();

if (isExist($_POST['capacity']))
	$dvId = $_POST['id'].strtolower($_POST['capacity']);
else 
	$dvId = $_POST['id'];

$device = DB::queryFirstRow("SELECT * FROM tmDevice WHERE dvId = %s and dv".strtoupper($_POST['carrier'])." = 1", $dvId);

$deviceInfo = new deviceInfo();
$deviceInfo->setCarrier($_POST['carrier'])->setMode($device['dvCate'])->setMonth(24)->setPlan($_POST['plan']);
$deviceInfo->setDevicePrice($device['dvRetailPrice']);

$result	= DB::query("SELECT * FROM tmSupport WHERE dvKey = %i and spPlan = %i and spCarrier = %s ORDER BY spDate DESC LIMIT 5", $device['dvKey'], $_POST['plan'], $_POST['carrier']);
$cntDevicePlanGraph = DB::count();

if ($_POST['discountType'] == 'support') {
	$calcResult = $result[0];
	$resultDevicePrice = $device['dvRetailPrice'] - ($calcResult['spSupport'] + $calcResult['spAddSupport']);
}else if ($_POST['discountType'] == 'selectPlan') {
	$resultDevicePrice = $device['dvRetailPrice'];
	$calcResult['selectPlanDiscount'] = $deviceInfo->getSelectPlanDiscount();
}

$calcResult['repayment'] = $deviceInfo->calcInterest($resultDevicePrice)->getRepayment();
$calcResult['interestRate'] = $deviceInfo->getInterestRate();
$calcResult['planFee'] = $deviceInfo->getPlanFee();
$calcResult['dvRetailPrice'] = $device['dvRetailPrice'];
//$calcResult['containVatInterest'] = $deviceInfo->getContainVatInterest();

$cdCode = DB::queryFirstField("SELECT cdCode FROM tmCode WHERE dvKey = %i and spPlan = %i and cdType = %i", $device['dvKey'], $_POST['plan'], (int)$_POST['applyType']);

if (isExist($cdCode) === true) {
	$calcResult['applyUrl'] = $deviceInfo->getApplyURL($cdCode, $_POST['applyType']);
}else{ 
	$calcResult['applyUrl'] ="https://docs.google.com/forms/d/e/1FAIpQLScQfOiyAu4Seha7aDXdj0RUzKYV36n9ZlI3QIz4w-xATXGiAQ/viewform";
}

$isGraphChanged = TRUE;

foreach ($result as $key => $val) {
	$calcResult['supportGraph']['spDate'][] = $val['spDate'];
	$calcResult['supportGraph']['spSupport'][] = $val['spSupport'];

	if((int)$cntDevicePlanGraph === 1) {
		$isGraphChanged = FALSE;
		$calcResult['supportGraph']['spDate'][] = $val['spDate'];
		$calcResult['supportGraph']['spSupport'][] = $val['spSupport'];
	}
}

$calcResult['supportGraph']['spDate'][$cntDevicePlanGraph-1] = $cfg['time_ymd'];
$calcResult['supportGraph']['spDate'] = array_reverse($calcResult['supportGraph']['spDate']);
$calcResult['supportGraph']['spSupport'] = array_reverse($calcResult['supportGraph']['spSupport']);
$isCurrentBigger = FALSE;

if($cntDevicePlanGraph > 1){
	foreach($calcResult['supportGraph']['spSupport'] as $val){
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
	
	$graphPrevVal = $calcResult['supportGraph']['spSupport'][$cntDevicePlanGraph-2];
	$graphCurrentVal = $calcResult['supportGraph']['spSupport'][$cntDevicePlanGraph-1];

	//바로전 값과 최근값이 같다면
	if ($graphPrevVal == $graphCurrentVal)
		$graphPrevVal = $calcResult['supportGraph']['spSupport'][$cntDevicePlanGraph-3];

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

	$calcResult['graphStartValue'] = $graphStartValue;
	$calcResult['graphStep'] = $graphStep;
	$calcResult['graphStepGap'] = $graphStepGap;
	$calcResult['isGraphChanged'] = $isGraphChanged;

	for($i=0;$i<$graphStep;$i++){
		$calcResult['graphStepYLabels'][] = $calcResult['graphStartValue'] + $graphStep*$i;
	}
}

//-------------------------------------
$rpPoint = DB::queryFirstField("SELECT rpPoint FROM tmRewardPoint WHERE dvKey = %i_dvKey and rpPlan = %i_rpPlan and rpCarrier = %s_rpCarrier and rpApplyType = %i_rpApplyType and rpDiscountType = %s_rpDiscountType ORDER BY rpKey DESC", 
	array(
		'dvKey' => $device['dvKey'],
		'rpPlan' => $_POST['plan'],
		'rpCarrier' => $_POST['carrier'],
		'rpApplyType' => (int)$_POST['applyType'],
		'rpDiscountType' => $_POST['discountType']
	)
);

if((int)$_POST['plan'] === 21 && isContain('egg', $device['dvId']) === true)
	$rpPoint = $rpPoint * 2.5;


$calcResult['dvKey'] = $device['dvKey'];
$calcResult['rewardPoint'] = (isExist($rpPoint))?(int)$rpPoint:'미정';

//-------------------------------------

$output = $calcResult;
//$output['calculator'] = $calculator;

//-------------------------------------

echo json_encode($output);

?>