`<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
//phpinfo();

try
{
	if($isLogged === true) 
		throw new Exception('로그인중에는 회원가입이 불가능합니다.', 3);

	if (chkToken($_POST['token']) === FALSE){
		throw new Exception('잘못된 접근입니다.', 1);
	}
	if ($_POST['agreePrivacyInfo'] != 1) {
        throw new Exception('개인정보수집약관/이용약관에 동의해주세요.', 1);
    }
	if($isSnsLogin == false) {
		if(isEmail($_POST['mbEmail']) === FALSE){
			throw new Exception('잘못된 이메일주소입니다. 아이디@주소 형식으로 입력해주세요.', 3);
		}
		$isExistMember = DB::queryFirstField("SELECT COUNT(*) FROM tmMember WHERE mbEmail=%s", $_POST['mbEmail']);
		if ($isExistMember > 0) {
			throw new Exception('이미 존재하는 이메일입니다.', 3);
		}
		if(isPw($_POST['mbPw']) === FALSE || strlen($_POST['mbPw']) < 8){
			throw new Exception('비밀번호는 8글자 이상, 영문과 숫자가 반드시 포함되어야 하며 대소문자를 구별하고 특수문자도 사용할 수 있습니다.', 3);
		}
		if($_POST['mbPw'] !== $_POST['mbPwCheck']){
			throw new Exception('비밀번호 확인 값이 다릅니다.', 3);
		}
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

$snsType = 0;
if ($isNaverLogin) {
	$jsonSnsResult= json_decode($naver->getUserProfile(), true);
	$snsUserInfo = $jsonSnsResult['response'];
	$snsUserId = $snsUserInfo['email'];
	$snsType = 2;
}

if ($isKakaoLogin) {
	$jsonSnsResult= json_decode($kakao->getUserProfile(), true);
	$snsUserId = $jsonSnsResult['id'];
	$snsType = 1;
}

if ($isSnsLogin) {
	$_POST['mbEmail'] = $snsUserId;
	$_POST['mbPw'] = md5(uniqid(rand(), true));

	$isExistMember = DB::queryFirstField("SELECT COUNT(*) FROM tmMember WHERE mbEmail=%s", $_POST['mbEmail']);
	if ($isExistMember > 0) {
		alert('이미 존재하는 이메일입니다.');
	}
}

DB::insert('tmMember', array(
	'mbEmail' => $_POST['mbEmail'],
	'mbPw' => pwEncrypt($_POST['mbPw']),
	'mbName' => $_POST['mbName'],
	'mbPhone' => str_replace('-', '', $_POST['mbPhone']),
	'mbDate' => $cfg['time_ymd'],
	'mbSns' => $snsType
	)
);

setSession('tmLoggedId', $_POST['mbEmail']);

if ($_POST['returnURL'] == false)
	$_POST['returnURL'] = '/';

alert('회원가입이 완료되었습니다.', $_POST['returnURL']);