<?

// 파일명.inc.php 는 다른 파일에 종속(include)되는 파일로 단독적으로 활용될수 없습니다.
// 파일명.skin.php 는 다른 파일의 html 부분을 담당하는 파일로 단독적으로 활용될수 없습니다.

require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
require_once(PATH_LIB."/lib.calculator.inc.php");


$import->addJS('calculator.js')->addJS('excanvas.js')->addJS('gifts.js')->addJS('detail.js')->addCSS('detail.css');

$showDetailHead = true;
if($isAdmin == true) 
	$onlyAdminSQL='';
else 
	$onlyAdminSQL='dvDisplay = 1 and ';

$device = DB::queryFirstRow("SELECT *,COUNT(*) as cnt FROM tmDevice WHERE ".$onlyAdminSQL."dvId = %s", $_GET['id']);
if($device['cnt'] == 0 && !$isAdmin) {
	alert('존재하지 않거나 판매하지 않는 기종입니다.');
}

$devicePlanGraph = DB::query("SELECT spSupport,spDate,spAddSupport FROM tmSupport WHERE dvKey = %i0 and spPlan = %i1 and spCarrier = 'sk' ORDER BY spDate DESC LIMIT 5", $defaultVal['dvKey'], $defaultPlanId);

switch($device['dvId']) {
	case 'galaxys7':
		$detailSpecLink= 'http://www.samsung.com/sec/consumer/mobile-tablet/mobile-phone/galaxy-s/SM-G930SZIASKO';
		break;

	default:
		$detailSpecLink= '#';
		break;
}

$devicePlanGraph = array_reverse($devicePlanGraph);
$cntDevicePlanGraph = count($devicePlanGraph);
$devicePlanLastKey = $cntDevicePlanGraph-1;
$isCurrentBigger = FALSE;
$isGraphChanged = FALSE;
if($cntDevicePlanGraph == 1){
	$devicePlanGraph[] = $devicePlanGraph[0];
	$graphStartValue = 'null';
}else{
	$isGraphChanged = TRUE;
	foreach($devicePlanGraph as $val){
		if($graphMinValue == false) {
			$graphMinValue = $val['spSupport'];
		}else if($val['spSupport'] < $graphMinValue) {
			$graphMinValue = $val['spSupport'];
		}

		if($graphMaxValue == false) {
			$graphMaxValue = $val['spSupport'];
		}else if($val['spSupport'] > $graphMaxValue) {
			$graphMaxValue = $val['spSupport'];
		}
	}
	
	$graphPrevVal = $devicePlanGraph[$cntDevicePlanGraph-2];
	$graphCurrentVal = $devicePlanGraph[$cntDevicePlanGraph-1];

	//바로전 값과 최근값이 같다면
	if ($graphPrevVal == $graphCurrentVal)
		$graphPrevVal = $devicePlanGraph[$cntDevicePlanGraph-3];

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
}

$cntDevicePlanGraph = count($devicePlanGraph);
$devicePlanGraph[$cntDevicePlanGraph-1]['spDate'] = $cfg['time_ymd'];

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

//-----------------------------------------------------------------------------------------



//-----------------------------------------------------------------------------------------

if ($supportCount == 1 && $arrApplyTypeCnt == 1) {
		$rewardPoint = DB::queryFirstField("SELECT rpPoint FROM tmRewardPoint WHERE dvKey = %i_dvKey and rpPlan = %i_rpPlan and rpCarrier = %s_rpCarrier and rpApplyType = %i_rpApplyType and rpDiscountType = %s_rpDiscountType", 
		array(
			'dvKey' => $defaultVal['dvKey'],
			'rpPlan' => $defaultPlanId,
			'rpCarrier' => 'sk',
			'rpApplyType' => $applyTypeDefaultKey,
			'rpDiscountType' => $defDiscountType
		)
	);
	$defAvailablePoint = number_format($rewardPoint).'별';
} else {
	$defAvailablePoint = '선택사항을 모두 선택해주세요';
}

//---------------------------------------------------------------------------------------

$planCalculator = new planCalculator();
$planCalculator->setDevice($_GET['id'])->setCarrier('sk');


$cfg['subTitle'] = $device['dvTit'].' 상세 페이지';
require_once($cfg['path']."/head.inc.php");			// 헤더 부분 (스킨포함)
if($device['dvRefer'] > 0) print_r($device);
require_once($includePrefix."detail.skin.php");	
//echo $deviceInfo->setCarrier('sk')->setMonth(24)->calcInterest()->test()->getRepayment();
//print_r($arrSelectPlan);
//print_r($graphMinValue);
require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)
?>