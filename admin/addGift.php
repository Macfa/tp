<?

require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
$add_css = '<link rel="stylesheet" href="'.PATH_CSS.'/admin.css" type="text/css">';
require_once($cfg['path']."/headSimple.inc.php");			// 헤더 부분 (스킨포함)

require_once("addGift.skin.php");		

require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)
?>