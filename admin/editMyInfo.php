<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
 
$add_css = '<link rel="stylesheet" href="'.PATH_CSS.'/mypageList.css" type="text/css">';
$js_file = '<script type="text/javascript" src="'.PATH_JS.'/cart.js"></script>';
$js_file .= '<script type="text/javascript" src="'.PATH_JS.'/modifyInfo.js"></script>';

$defAddress = DB::queryFirstRow("SELECT * FROM tmAddress WHERE mbEmail = %s and arIsDefault = 1", $mb['mbEmail']);
$arrAddress = DB::query("SELECT * FROM tmAddress WHERE mbEmail = %s", $mb['mbEmail']);

require_once($cfg['path']."/head.inc.php");			// 헤더 부분 (스킨포함)
require_once("editMyInfo.skin.php");		
require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)
