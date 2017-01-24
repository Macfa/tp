<?php


require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

$add_css = '<link rel="stylesheet" href="'.PATH_CSS.'/myspace.css" type="text/css">';
$js_file = '<script type="text/javascript" src="'.PATH_JS.'/myspace.js"></script>';

$preorderTable = DB::queryFirstRow("SELECT * FROM tmPreorder WHERE poDisplay=1");

//V20 신청현황
$isV20ApplyExist = (int)DB::queryFirstField("SELECT COUNT(*) FROM tmPreorderV20 WHERE mbEmail=%s and pvCancel = 0", $mb['mbEmail']);	
//아이폰7 신청현황
$isIphone7Exist = (int)DB::queryFirstField("SELECT COUNT(*) FROM tmPreorderApplyList WHERE mbEmail=%s and paCancel = 0 and poKey = 3", $mb['mbEmail']);	


//노트7 교환 환불 현황
$isExchangeRefundNote7Exist = DB::queryFirstRow("SELECT * FROM tmExchangeRefundNote7 WHERE mbEmail=%s", $mb['mbEmail']);	
$isExchangeRefundNote7Count =(int)$isExchangeRefundNote7Exist;

//갤럭시S7 시리즈 신청현황
$isS7edgeBlueExist = (int)DB::queryFirstField("SELECT COUNT(*) FROM tmApply WHERE mbEmail=%s AND poKey = 4 AND taCancel = 0 ", $mb['mbEmail']);	
$isS7edgeExist = (int)DB::queryFirstField("SELECT COUNT(*) FROM tmApply WHERE mbEmail=%s AND taCancel = 0 AND poKey = 6 ", $mb['mbEmail']);	



//비와이폰 신청현황
$isBeyExist = (int)DB::queryFirstField("SELECT COUNT(*) FROM tmPreorderApplyList WHERE mbEmail=%s and paCancel = 0 and poKey = 5", $mb['mbEmail']);	

$isprogramNote7Exist = (int)DB::queryFirstField("SELECT COUNT(*) FROM tmNote7Program WHERE mbEmail=%s and tnCancel = 0 ", $mb['mbEmail']);	

$type = array(
	'exchange' => '교환',
	'refund' => '환불'
);


require_once($cfg['path']."/head.inc.php");			// 헤더 부분 (스킨포함)

require_once($includePrefix."mySpace.skin.php");		

require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)