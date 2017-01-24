<?php
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

$result = DB::queryFirstRow("SELECT * FROM tmAddress WHERE arKey = %i and mbEmail = %s", $_POST['key'], $mb['mbEmail']);

print_r(json_encode($result));