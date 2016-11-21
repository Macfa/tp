<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)



$js_file = '<script type="text/javascript" src="'.PATH_JS.'/cart.js"></script>';
$js_file .= '<script type="text/javascript" src="'.PATH_JS.'/gifts.js"></script>';

$arrOrderList = DB::query("SELECT * FROM tmOrder as a LEFT JOIN tmMember m ON a.mbEmail = m.mbEmail ORDER BY a.orKey DESC");
require_once($cfg['path']."/adminhead.php");			// 헤더 부분 (스킨포함)
require_once("orderList.skin.php");		
require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)