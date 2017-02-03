<?php 
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
$import->addCSS('preOrderNote7.css');
$cfg['subTitle'] = '노트7 교환&환불 공지사항';
require_once($cfg['path']."/head.inc.php");			// 헤더 부분 (스킨포함)
require_once("note7ExchangeRefundNotice.skin.php");
require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)
?>