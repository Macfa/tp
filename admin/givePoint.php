<?php
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
require_once($cfg['path']."/headBlank.inc.php");			// 헤더 부분 (스킨포함)

$memberPoint = DB::queryFirstField("SELECT mbPoint FROM tmMember WHERE mbEmail=%s", $_GET['mbEmail']);
$memberPoint = number_format($memberPoint);

require_once("givePoint.skin.php");
require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)

?>