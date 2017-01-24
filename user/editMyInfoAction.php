<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
//phpinfo();

try
{		
	if(isPw($_POST['mbPw']) === FALSE || strlen($_POST['mbPw']) < 8)
		throw new Exception('비밀번호는 8글자 이상, 영문과 숫자가 반드시 포함되어야 하며 대소문자를 구별하고 특수문자도 사용할 수 있습니다.', 3);
		
	if($_POST['mbPw'] !== $_POST['mbPwCheck'])
		throw new Exception('비밀번호 확인 값이 다릅니다.', 3);

	if(isExist($_POST['mbName']) === false)
		throw new Exception('이름을 입력해주세요', 3);
	
	if(isExist($_POST['mbPhone']) === false)
		throw new Exception('전화번호를 입력해주세요', 3);
			

}
catch(Exception $e)
{
    alert($e->getMessage());
}


DB::update('tmMember', array(
  'mbPw' => pwEncrypt($_POST['mbPw']),
  'mbName' => $_POST['mbName'],
  'mbPhone' => $_POST['mbPhone']
  ), "mbEmail=%s", $mb['mbEmail']);


alert('수정이 완료되었습니다');

?>