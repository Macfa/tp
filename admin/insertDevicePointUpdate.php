<?php
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

try
{
	if (isNum($_POST['dvKey']) == false)
		throw new Exception('dvKey는 숫자만 입력이 가능합니다.', 3);

	if (isNum($_POST['spPoint']) == false)
		throw new Exception('spPoint는 숫자만 입력이 가능합니다.', 3);

	if (isNum($_POST['cdType']) == false)
		throw new Exception('cdType는 숫자만 입력이 가능합니다.', 3);
}
catch(Exception $e)
{
    alert($e->getMessage());
}

$arrSpPlan = explode(',', $_POST['spPlan']);

if($_POST['dcType'] === '1') $_POST['dcType'] = 'support';
if($_POST['dcType'] === '2') $_POST['dcType'] = 'selectPlan';

DB::debugMode();

foreach ($arrSpPlan as $val) {
	$arrRewardPoint = array(
		'dvKey' => $_POST['dvKey'],
		'rpPlan' => $val,
		'rpCarrier' => $_POST['spCarrier'],
		'rpApplyType' => $_POST['cdType'],
		'rpDiscountType' => $_POST['dcType']
	  );


	$isExst = DB::queryFirstField("SELECT count(*) FROM tmRewardPoint WHERE dvKey=%i_dvKey AND rpPlan=%i_rpPlan AND rpCarrier=%s_rpCarrier AND rpApplyType=%i_rpApplyType AND rpDiscountType=%s_rpDiscountType", $arrRewardPoint );


	if($isExst === '0'){

		$arrRewardPoint['rpPoint'] = ($_POST['spPoint']*10000);
		DB::insert('tmRewardPoint', $arrRewardPoint);	

	}
	if($isExst === '1'){
		DB::update('tmRewardPoint', array(
			'rpPoint' => ($_POST['spPoint']*10000)
		 ), "dvKey = %i AND rpPlan = %i AND rpCarrier = %s AND rpApplyType = %i AND rpDiscountType = %s", $_POST['dvKey'], $val, $_POST['spCarrier'],$_POST['cdType'],$_POST['dcType']);
	}

}


//alert('완료되었습니다', 'insertDevicePointDetail.php');