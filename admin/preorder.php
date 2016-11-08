<?php
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
$add_css = '<link rel="stylesheet" href="'.PATH_CSS.'/mypageList.css" type="text/css">';
$js_file .= '<script type="text/javascript" src="'.PATH_JS.'/input.js"></script>';
require_once($cfg['path']."/headBlank.inc.php");			// 헤더 부분 (스킨포함)

switch ($_GET['searchDevice']) {
    case 3:
		require_once("preorder.default.php");
		require_once("preorder.skin.php");
        break;
    case 4:

		require_once("preorderS7EdgeBlue.php");
        require_once("preorderS7EdgeBlue.skin.php");
        break;
	default:
		require_once("preorder.default.php");
		require_once("preorder.skin.php");
	break;
}


require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)

?>