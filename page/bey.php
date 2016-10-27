<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

$add_css = '<link rel="stylesheet" href="'.PATH_CSS.'/bey.css" type="text/css">';

$cutline = '2016-08-28 12:00:00';
if ($cfg['time_ymdhis'] < $cutline) {
	$affixSKapply = '('.getRelativeDate('2016-08-28').' 점심 12시 부터 가능)';
}

require_once($cfg['path']."/head.inc.php");			// 헤더 부분 (스킨포함)
require_once("bey.skin.php");	
require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)
?>