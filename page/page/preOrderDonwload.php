<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

if (!$isLogged) {
	$returnURL = urlencode('/page/preOrderNote7.php?downCarrier='.$_GET['carrier'].'&downType='.$_GET['type']);
	echo "<script>alert('로그인 후 다운로드 해주세요');parent.location.href = '".$cfg['url']."/user/login.php?returnURL=".$returnURL."';</script>";
	exit;
}

if(isNullVal($_GET['carrier']) || isNullVal($_GET['type'])) 
	alert('잘못된 접근입니다.', '/page/preOrderNote7.php');

if($_GET['mode'] === 'guide') 
	$affix = '-guide';


if($_GET['type'] == 'cd') $file = 'changeDevice'.$affix.'.zip';
if($_GET['type'] == 'cc') $file = 'changeCarrier'.$affix.'.zip';

goURL($cfg['url'].'/file/'.$_GET['carrier'].'_'.$file);
?>