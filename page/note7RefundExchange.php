<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

$add_css = '<link rel="stylesheet" href="'.PATH_CSS.'/note7RefundExchange.css" type="text/css">';
$cfg['subTitle'] = '갤럭시 노트7 교환&환불';


require_once($cfg['path']."/head.inc.php");			// 헤더 부분 (스킨포함)

require_once("note7RefundExchange.skin.php");	

require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)
?>