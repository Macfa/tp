<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

$add_css = '<link rel="stylesheet" href="'.PATH_CSS.'/mypageList.css" type="text/css">';



$programNote7Member = DB::queryFirstRow("SELECT * FROM tmNote7Program WHERE mbEmail=%s and tnCancel = 0 ", $mb['mbEmail']);	
$isprogramNote7Exist = (int)$programNote7Member;
try{
 	if($isprogramNote7Exist === 0)
		throw new Exception('신청후 확인 부탁드립니다.', 3);

}catch (Exception $e) {	
	if ($e->getCode() === 2)	
		alert($e->getMessage(), $cfg['path']);

	else if ($e->getCode() === 3)	
		alert($e->getMessage(), $cfg['path']."/page/programNote7Apply.php");
}




$buy = array(
	0 => '비구매',
	1 => '구매'
);

$type = array(
	'02' => '번호이동',
	'06' => '기기변경'
);



require_once($cfg['path']."/head.inc.php");			// 헤더 부분 (스킨포함)

if($programNote7Member['tnApplyType'] ==='02'){
	$applyLinkUrl = "http://online.olleh.com/index.jsp?prdcID=1A279AC7-BD7B-4FCA-B33D-F4346AFEBCAE"; // 비와이 번이
}else if($programNote7Member['tnApplyType'] ==='06'){
	$applyLinkUrl = "http://online.olleh.com/index.jsp?prdcID=7F2C0678-C959-44A2-9032-BEC084E9337E"; // 비와이 기변
}

require_once("programNote7State.skin.php");		

require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)
