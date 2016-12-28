<?php


require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

$add_css = '<link rel="stylesheet" href="'.PATH_CSS.'/myspace.css" type="text/css">';
$js_file = '<script type="text/javascript" src="'.PATH_JS.'/myspace.js"></script>';

$isV20ApplyExist = DB::queryFirstField("SELECT COUNT(*) FROM tmPreorderV20 WHERE mbEmail=%s and pvCancel = 0", $mb['mbEmail']);	
$isApplyExist = DB::queryFirstField("SELECT COUNT(*) FROM tmPreorderApplyList WHERE mbEmail=%s and paCancel = 0", $mb['mbEmail']);	
$preorderTable = DB::queryFirstRow("SELECT * FROM tmPreorder WHERE poDisplay=1");
$isExchangeRefundNote7Exist = DB::queryFirstField("SELECT COUNT(*) FROM tmExchangeRefundNote7 WHERE mbEmail=%s", $mb['mbEmail']);	

$isApplyExist = (int)$isApplyExist;
$isV20ApplyExist = (int)$isV20ApplyExist;
$isExchangeRefundNote7Exist = (int)$isExchangeRefundNote7Exist;


if($isApplyExist >= 1){
	$applyUrl = "preorderState.php?device=".$preorderTable['poDeviceName'];
	$applyTitle =$preorderTable['poDeviceName']." 사전예약 신청현황";
	$deviceEngName = $preorderTable['poEngName'];
}


$type = array(
	'exchange' => '교환',
	'refund' => '환불'
);



require_once($cfg['path']."/head.inc.php");			// 헤더 부분 (스킨포함)

require_once($includePrefix."mySpace.skin.php");		

require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)