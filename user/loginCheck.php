<?
// 파일명.inc.php 는 다른 파일에 종속(include)되는 파일로 단독적으로 활용될수 없습니다.
// 파일명.skin.php 는 다른 파일의 html 부분을 담당하는 파일로 단독적으로 활용될수 없습니다.
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

try
{
	if($isLogged === true) 
		throw new Exception('로그인중에는 로그인이 불가능합니다.');

	if (chkToken($_POST['token']) === FALSE){
		throw new Exception('잘못된 접근입니다.', 1);
	}
    if(isEmail($_POST['mbEmail']) === FALSE){
        throw new Exception('잘못된 이메일주소입니다. 아이디@주소 형식으로 입력해주세요.', 3);
    }
	if(isPw($_POST['mbPw']) === FALSE || strlen($_POST['mbPw']) < 8){
        throw new Exception('비밀번호는 8글자 이상, 영문과 숫자가 반드시 포함되어야 하며 대소문자를 구별하고 특수문자도 사용할 수 있습니다.', 3);
    }

	list($isNotExistMember, $mbPwInDB) = DB::queryFirstList("SELECT COUNT(*), mbPw FROM tmMember WHERE mbEmail=%s", $_POST['mbEmail']);
	if ($isNotExistMember < 1) {
		throw new Exception('존재하지 않는 이메일이거나 이메일 또는 비밀번호를 잘못 입력하셨습니다.', 3);
	}

	if (pwEncrypt($_POST['mbPw']) !== $mbPwInDB) {
		throw new Exception('존재하지 않는 이메일이거나 이메일 또는 비밀번호를 잘못 입력하셨습니다.', 3);
	}
}
catch(Exception $e)
{
    alert($e->getMessage());
}

setSession('tmLoggedId', $_POST['mbEmail']);

if ($_POST['returnURL'] == false)
	$_POST['returnURL'] = '/';

goURL($_POST['returnURL']);

?>