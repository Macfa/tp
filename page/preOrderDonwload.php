<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

if (!$isLogged) {
	$_SESSION['preorder']['downType'] = $_GET['type'];
	$_SESSION['preorder']['downCarrier'] = $_GET['carrier'];
	$_SESSION['preorder']['mode'] = $_GET['mode'];
	$returnURL = urlencode('/page/preOrderNote7.php');
	echo META_CHARSET;
	echo "<script>alert('로그인 후 다운로드 해주세요');parent.location.href = '".$cfg['url']."/user/login.php?returnURL=".$returnURL."';</script>";
	exit;
}

if ($_SESSION['preorder']['downType']) {
	$_GET['type'] = $_SESSION['preorder']['downType'];
	$_GET['carrier'] = $_SESSION['preorder']['downCarrier'];
	$_GET['mode'] = $_SESSION['preorder']['mode'];
	unset($_SESSION['preorder']);
}
if(isNullVal($_GET['carrier']) || isNullVal($_GET['type'])) 
	exit;


if($_GET['carrier'] == 'KT' && $_GET['mode'] == 'selectPlan') {
	if($_GET['type'] == 'cd') $url = 'http://online.olleh.com/index.jsp?prdcID=AE1D031F-315B-4830-9E09-CC11607060CB';
	if($_GET['type'] == 'cc') $url = 'http://online.olleh.com/index.jsp?prdcID=8EDD0BD9-1BF7-4EED-9180-A7E2B2146882';
	goURL($url);
}

if($_GET['carrier'] == 'KT')
	alert('KT 공시지원금(단말기할인)방식 가입은 가입이 가능할때 알려드리겠습니다.');

if($_GET['mode'] === 'guide') 
	$affix = '_guide';

if($_GET['type'] == 'cd') $file = 'changeDevice'.$affix.'.zip';
if($_GET['type'] == 'cc') $file = 'changeCarrier'.$affix.'.zip';

goURL($cfg['url'].'/file/'.$_GET['carrier'].'_'.$file);
?>