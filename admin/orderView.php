<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

$add_css = '<link rel="stylesheet" href="'.PATH_CSS.'/normalize.css" type="text/css">';
$add_css = '<link rel="stylesheet" href="'.PATH_CSS.'/mypageList.css" type="text/css">';
$js_file = '<script type="text/javascript" src="'.PATH_JS.'/cart.js"></script>';
$js_file .= '<script type="text/javascript" src="'.PATH_JS.'/gifts.js"></script>';


$arrOrderItemList = DB::query("SELECT * FROM tmOrderItem as oi LEFT JOIN tmGift as g ON oi.gfKey = g.gfKey WHERE oi.orOrderNumber = %s", $_GET['id']);

require_once($cfg['path']."/headBlank.inc.php");			// 헤더 부분 (스킨포함)
require_once("orderView.skin.php");		
