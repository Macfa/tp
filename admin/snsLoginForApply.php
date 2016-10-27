<?

// 파일명.inc.php 는 다른 파일에 종속(include)되는 파일로 단독적으로 활용될수 없습니다.
// 파일명.skin.php 는 다른 파일의 html 부분을 담당하는 파일로 단독적으로 활용될수 없습니다.

require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
?>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<h1 class="tit-sub center">로그인 중입니다. 잠시만 기다려주세요.</h1>
<script>
function doWhenExistMember(){
	var $parent = window.opener;
	$parent.$('.js-loginSection').hide();
	window.close();
}
function isNewMember(){
	var $parent = window.opener;
	$parent.$('.js-isNotLoggedWrap').removeClass('active');
	$parent.$('.js-signupWrap').addClass('active');
	$parent.$('.js-normalSignupWrap').removeClass('active');
	window.close();
}
</script>
<?
/*
if($isLogged === true) 
	alert('로그인중에는 로그인이 불가능합니다.');
*/

if ($isNaverLogin) {
	$jsonSnsResult= json_decode($naver->getUserProfile(), true);
	$snsUserInfo = $jsonSnsResult['response'];
	$snsUserId = $snsUserInfo['email'];
}

if ($isKakaoLogin) {
	$jsonSnsResult= json_decode($kakao->getUserProfile(), true);
	$snsUserId = $jsonSnsResult['id'];
}

$isExistMember = DB::queryFirstField("SELECT COUNT(*) FROM tmMember WHERE mbEmail=%s", $snsUserId);
$isExistMember = ($isExistMember>0)?true:false;
if ($isExistMember === true) {
	//setSession('tmLoggedId', $snsUserId);
	echo '<script>doWhenExistMember();</script>';
} else {
	echo "<script>isNewMember(); </script>";
}
