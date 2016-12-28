<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
//phpinfo();

try
{
	if($isLogged === false) 
		throw new Exception('로그인 중에만 정보수정이 가능합니다.', 3);

	if (chkToken($_POST['token']) === FALSE){
		throw new Exception('잘못된 접근입니다.', 1);
	}
	if($mb['mbSns'] === '0' && $_POST['newPw']) {
		$mbPwInDB = DB::queryFirstField("SELECT mbPw FROM tmMember WHERE mbEmail=%s", $mb['mbEmail']);
		if (pwEncrypt($_POST['mbPw']) !== $mbPwInDB) {
			throw new Exception('기존 v비밀번호를 잘못 입력하셨습니다.', 3);
		}
		if(isPw($_POST['newPw']) === FALSE || strlen($_POST['newPw']) < 8){
			throw new Exception('새 비밀번호는 8글자 이상, 영문과 숫자가 반드시 포함되어야 하며 대소문자를 구별하고 특수문자도 사용할 수 있습니다.', 3);
		}
		if($_POST['newPw'] !== $_POST['newPwCheck']){
			throw new Exception('새 비밀번호 확인 값이 다릅니다.', 3);
		}
		$set['mbPw'] = $_POST['newPw'];
	}
	if(isKorEng($_POST['mbName']) === FALSE){
        throw new Exception('성함은 한글이나 영어만 가능합니다.', 3);
    }
	if(isPhoneNum($_POST['mbPhone']) === FALSE){
        throw new Exception('휴대폰 번호는 000-0000-0000 방식으로 입력해주세요.', 3);
    }
}
catch(Exception $e)
{
    alert($e->getMessage());
}

if($mb['mbSns'] === '0' && $_POST['newPw']) {
	$arrSet['mbPw'] = $_POST['newPw'];
}

$arrSet['mbName'] = $_POST['mbName'];
$arrSet['mbPhone'] = $_POST['mbPhone'];
DB::update('tmMember', $arrSet, 'mbEmail = %s', $mb['mbEmail']);

if ($_POST['returnURL'] == false)
	$_POST['returnURL'] = '/user/mySpace.php';

goURL($_POST['returnURL']);