<?

require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)



$gap = $cfg['server_time'] - 1469032698;
$hourDiff = $gap / 3600;
$applyCount = 60 + floor($hourDiff);

require_once($cfg['path']."/adminhead.php");			// 헤더 부분 (스킨포함)

	

consoleLog($applyCount);

require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)
?>`