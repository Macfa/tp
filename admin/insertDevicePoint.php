<?php
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
require_once($cfg['path']."/headSimple.inc.php");			// 헤더 부분 (스킨포함)

$incList['deviceSql'] = "SELECT * FROM tmDevice WHERE dvParent = 0 and dvDisplay = 1 ";

$incList['deviceResults'] = DB::query($incList['deviceSql']);

require_once("insertDevicePoint.skin.php");
require_once($cfg['path']."/foot.inc.php");	// foot 부분 (스킨포함)