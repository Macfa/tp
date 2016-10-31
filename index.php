<?
require_once("common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
$add_css = '<link rel="stylesheet" href="'.PATH_CSS.'/main.css?v=2016-10-28" type="text/css">';
$gap = $cfg['server_time'] - 1469527362;
$hourDiff = $gap / 3600;
$applyCount = 794 + floor($hourDiff);

require_once("head.inc.php");			// 헤더 부분 (스킨포함)
require_once($includePrefix."index.skin.php");		
require_once("foot.inc.php");			// foot 부분 (스킨포함)
?>