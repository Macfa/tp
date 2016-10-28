<?
// 파일명.inc.php 는 다른 파일에 종속(include)되는 파일로 단독적으로 활용될수 없습니다.
// 파일명.skin.php 는 다른 파일의 html 부분을 담당하는 파일로 단독적으로 활용될수 없습니다.
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

if($isLogged === false) alert('로그인 중에만 로그아웃이 가능합니다.');

unsetSession('tmLoggedId');
$naver -> logout();
$kakao -> logout();

if ($_POST['returnURL'] == false)
	$_POST['returnURL'] = '/';

goURL($_POST['returnURL']);

?>