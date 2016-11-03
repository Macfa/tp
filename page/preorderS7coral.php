<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

$import->addCSS('preorderS7coral.css');
$import->addJS('preorderS7coral.js');

require_once($cfg['path']."/head.inc.php");			// 헤더 부분 (스킨포함)
require_once("preorderS7coral.skin.php");	
require_once($cfg['path']."/foot.inc.php");			// 헤더 부분 (스킨포함)
?>