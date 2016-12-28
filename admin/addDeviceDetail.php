<?

require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

require_once($cfg['path']."/adminhead.php");			// 헤더 부분 (스킨포함)

$result = DB::query("SELECT * FROM tmDevice WHERE dvParent = 0 AND dvDisplay = 1 order by dvTit");

require_once("addDeviceDetail.skin.php");		

require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)
?>