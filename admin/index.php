<?

require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

$add_css = '<link rel="stylesheet" href="'.PATH_CSS.'/myspace.css" type="text/css">';

$gap = $cfg['server_time'] - 1469032698;
$hourDiff = $gap / 3600;
$applyCount = 60 + floor($hourDiff);

require_once($cfg['path']."/headSimple.inc.php");			// 헤더 부분 (스킨포함)



require_once("index.skin.php");		

consoleLog($applyCount);

require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)
?>`