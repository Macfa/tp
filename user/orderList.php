<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)


$add_css = '<link rel="stylesheet" href="'.PATH_CSS.'/mypageList.css" type="text/css">';
$js_file = '<script type="text/javascript" src="'.PATH_JS.'/cart.js"></script>';
$js_file .= '<script type="text/javascript" src="'.PATH_JS.'/gifts.js"></script>';

$arrOrderList = DB::query("SELECT * FROM tmOrder WHERE mbEmail = %s ORDER BY orDate DESC", $mb['mbEmail']);
require_once($cfg['path']."/head.inc.php");			// 헤더 부분 (스킨포함)
require_once("orderList.skin.php");		
require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)