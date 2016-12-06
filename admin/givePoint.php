<?php
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
require_once($cfg['path']."/adminhead.php");			// 헤더 부분 (스킨포함)

list($memberPoint, $mbKey) = DB::queryFirstList("SELECT mbPoint, mbKey FROM tmMember WHERE mbEmail=%s", $_GET['mbEmail']);
$memberPoint = number_format($memberPoint);
list($prParent, $prGrand) = DB::queryFirstList("SELECT prParent, prGrand FROM tmPointRelationship WHERE mbKey=%i", $mbKey);


$prParentEmail = DB::queryFirstField("SELECT mbEmail FROM tmMember WHERE mbKey=%i", $prParent);
$prGrandEmail = DB::queryFirstField("SELECT mbEmail FROM tmMember WHERE mbKey=%i", $prGrand);

require_once("givePoint.skin.php");
require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)

?>