<?php
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

$js_file .= '<script type="text/javascript" src="'.PATH_JS.'/input.js"></script>';

require_once($cfg['path']."/adminhead.php");			// 헤더 부분 (스킨포함)


$search = $_GET['search'];
$sql = "SELECT * FROM tmNote7Program";

if(isExist($search) || isExist($_GET['serchProcess'])){
	$sql  .= " WHERE";
	$downloadUrl = $_SERVER['REQUEST_URI'];
	$downloadUrl = explode("?",$downloadUrl);
	$downloadFullUrl = "programNote7ListDownload.php?".$downloadUrl[1];
}

if(isExist($search)){
	$sql .= " (mbName LIKE %ss_search OR mbPhone LIKE %ss_search)";
	$array['search'] = $search;	
}


$existList = DB::query($sql, $array);
$count = DB::count();

$buy = array(
	'0' => '비구매',
	'1' => '구매'
);

$type = array(
	'02' => '번호이동',
	'06' => '기기변경'
);

$cancel = array(
	'0' => '-',
	'1' => '취소'
);


require_once("programNote7List.skin.php");
require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)

?>