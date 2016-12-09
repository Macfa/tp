<?php 
// header('Content-Type: application/vnd.ms-excel');
// header('Content-Disposition: attachment;filename=업로드목록.xls');
// header('Cache-Control: max-age=0');
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
require_once($cfg['path']."/adminhead.php");			// 헤더 부분 (스킨포함)
require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<form name="formName" method="post" action="margin_test.php" enctype="multipart/form-data">
<input type="file" name="selectfile"><br/><br/>
<input type="radio" name="chk_info" value="sk">SK
<input type="radio" name="chk_info" value="kt">KT
<input type="submit" value="Submit">
</body>
</html>
tplanit.co.kr/admin/