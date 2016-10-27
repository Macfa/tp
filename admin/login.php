<?

// 검색엔진이 페이지를 잘 해석할 수 있게 html 마크업과 디자인을 리뉴얼한 버전

// 파일명.inc.php 는 다른 파일에 종속(include)되는 파일로 단독적으로 활용될수 없습니다.
// 파일명.skin.php 는 다른 파일의 html 부분을 담당하는 파일로 단독적으로 활용될수 없습니다.

require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

if($isLogged === true && $isSnsLogin === true) 
	goURL($_GET['returnURL']);

if($isLogged === true) 
	alert('로그인중에는 로그인이 불가능합니다.');


setSession('signupReturnURL', $_GET['returnURL']);

$containerClass = 'login';
$add_css = '<link rel="stylesheet" href="'.PATH_CSS.'/login.css" type="text/css">';
$js_file = '<script type="text/javascript" src="'.PATH_JS.'/login.js"></script>';
require_once($cfg['path']."/headSimple.inc.php");			// 헤더 부분 (스킨포함)

require_once("login.skin.php");		

require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)
?>