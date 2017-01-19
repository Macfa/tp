<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
$isExist = DB::queryFirstField("SELECT COUNT(*) FROM tmAlarmEvent WHERE mbEmail = %s", $mb['mbEmail']);
$errorCode = 0;
try{
	
	if($isLogged == false)
		throw new Exception('로그인 해주세요!', 1);

	if($isExist > 0 )
		throw new Exception('이미 알림신청을 하셨습니다', 2);

	
} catch (Exception $e) {		

	if($e->getCode() === 1)
		$errorURL = $cfg['loginURLPrefix'].urlencode($_SERVER['HTTP_REFERER']);
	$errorCode = $e->getCode();
	$errorMsg = $e->getMessage();
}
	
if($errorCode === 0){
	DB::insert('tmAlarmEvent', array(
	  'mbEmail' => $mb['mbEmail'],
	  'aeEvent' => $_POST['aeEvent'],
	  'aeDatetime' => $cfg['time_ymdhis']

	)); 
}


//goURL("신청이 완료 되었습니다", $cfg['url']);


$data = array(
	'errorCode' => $errorCode,
	'errorMsg' => $errorMsg,
	'errorURL' => $errorURL
);

echo json_encode($data);

?>