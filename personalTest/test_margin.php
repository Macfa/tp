<?php 
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

$dvKey = array(845, 846, 848, 849);
$discountType = 'support';
$carrier = 'kt';
$plan = array(
	21 => 19800,
	22 => 31800
	);
$apply = array(1, 2, 6);
// $plan = array(21, 22);
// $point = array(30000, 42000);


foreach($apply as $applyval) {
	foreach($dvKey as $dvval) {
		foreach($plan as $key => $plans) {
			$arr[] = array(
				'dvKey' => $dvval,
				'rpDiscountType' => $discountType,
				'rpCarrier' => $carrier,
				'rpApplyType' => $applyval,
				'rpPlan' => $key,
				'rpPoint' => $plans,
				'rpDate' => $cfg['time_ymdhis']
				);
			// }
		}
	}
}


foreach ($plan as $key => $plans) {
	$arrUpdate[] = array(
		'rpPoint' => $plans
	);
}

DB::update('tmRewardPoint', array(
	'rpPoint' => 31800), "rpPlan=%i", 22);

echo "<pre>arr";
print_r($arr);
echo "</pre>";


echo "<pre>arrUpdate";
print_r($arrUpdate);
echo "</pre>";

// DB::insert('tmRewardPoint', $arr);

 ?>
 