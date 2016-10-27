<?

require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

require_once($cfg['path']."/headSimple.inc.php");			// 헤더 부분 (스킨포함)

$arrResult = DB::query("SELECT d.* FROM tmDevice d LEFT JOIN tmMainSort o ON d.dvKey = o.maTargetKey WHERE d.dvDisplay=1 and d.dvParent = 0 ORDER BY o.maOrder is null ASC, o.maOrder ASC");
require_once("orderModifyMain.skin.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)
?>