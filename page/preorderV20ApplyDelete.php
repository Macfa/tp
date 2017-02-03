<?

require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)


try{
	list($isV20ApplyExist, $isMyEmail, $pvProcess) = DB::queryFirstList("SELECT count(*), mbEmail, pvProcess FROM tmPreorderV20 WHERE mbEmail=%s", $mb['mbEmail']);	
	
	$pvState = (int)$pvState;
	$isV20ApplyExist = (int)$isV20ApplyExist;
	if($isV20ApplyExist === 0)
		throw new Exception('로그인후 취소해주세요', 3);
	
	if($pvState >= 1)
		throw new Exception('신청완료 상태이므로 취소할 수 없습니다.', 3);
}
catch (Exception $e) {	

	alert($e->getMessage(), $cfg['path']."/user/preorderV20State.php");

}

if($isV20ApplyExist === 1 && $isMyEmail === $mb['mbEmail'])
DB::update('tmPreorderV20', array(
  'pvCancel' => '1'
  ), "mbEmail=%s", $mb['mbEmail']);


goURL($cfg['url']."/user/preorderV20State.php");
?>