<?

require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
include_once(PATH_LIB."/lib.snoopy.inc.php");
include_once(PATH_LIB."/lib.parsing.inc.php");

$add_css = '<link rel="stylesheet" href="'.PATH_CSS.'/preOrderNote7.css" type="text/css">';
$js_file = '<script type="text/javascript" src="'.PATH_JS.'/preorderNote7.js"></script>';
$js_file .= '<script type="text/javascript" src="'.PATH_JS.'/calculator.js"></script>';
$cfg['title'] = '갤럭시 노트7 사전예약안내';

require_once($cfg['path']."/headBlank.inc.php");			// 헤더 부분 (스킨포함)

require_once("preOrderNote7.skin.php");	
require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)
?>