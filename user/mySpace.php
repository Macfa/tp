<?php


require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

$add_css = '<link rel="stylesheet" href="'.PATH_CSS.'/myspace.css" type="text/css">';
$js_file = '<script type="text/javascript" src="'.PATH_JS.'/myspace.js"></script>';

$isV20ApplyExist = DB::queryFirstField("SELECT COUNT(*) FROM tmPreorderV20 WHERE mbEmail=%s and pvCancel = 0", $mb['mbEmail']);	
$isIphone7Exist = DB::queryFirstField("SELECT COUNT(*) FROM tmPreorderApplyList WHERE mbEmail=%s and paCancel = 0 and poKey = 3", $mb['mbEmail']);	
$preorderTable = DB::queryFirstRow("SELECT * FROM tmPreorder WHERE poDisplay=1");
$isExchangeRefundNote7Exist = DB::queryFirstRow("SELECT * FROM tmExchangeRefundNote7 WHERE mbEmail=%s", $mb['mbEmail']);	
$isGalaxyS7edgeBlueExist = DB::queryFirstField("SELECT COUNT(*) FROM tmApply WHERE mbEmail=%s AND poKey = 4 AND taCancel = 0", $mb['mbEmail']);	
$isBeyExist = DB::queryFirstField("SELECT COUNT(*) FROM tmPreorderApplyList WHERE mbEmail=%s and paCancel = 0 and poKey = 5", $mb['mbEmail']);	

$isIphone7Exist = (int)$isIphone7Exist;
$isV20ApplyExist = (int)$isV20ApplyExist;
$isExchangeRefundNote7Count = (int)$isExchangeRefundNote7Exist;
$isGalaxyS7edgeBlueExist =(int)$isGalaxyS7edgeBlueExist;
$isBeyExist = (int)$isBeyExist;


$type = array(
	'exchange' => '교환',
	'refund' => '환불'
);



require_once($cfg['path']."/head.inc.php");			// 헤더 부분 (스킨포함)

require_once($includePrefix."mySpace.skin.php");		

require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)