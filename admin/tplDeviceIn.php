<?php 
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
require_once($cfg['path']."/adminhead.php");			// 헤더 부분 (스킨포함)

$model = DB::queryOneColumn("dvModelCode", "SELECT * FROM tmDevice WHERE dvModelCode != ''");
$import->addJS('tplDevice.js');

require_once("tplDeviceIn.skin.php");

require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)



 ?>