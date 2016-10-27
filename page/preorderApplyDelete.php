<?

require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)


try{
	list($isApplyExist, $isMyEmail, $paProcess, $poKey) = DB::queryFirstList("SELECT count(*), mbEmail, paProcess, poKey FROM tmPreorderApplyList WHERE mbEmail=%s", $mb['mbEmail']);	
	$paState = (int)$paState;
	$isApplyExist = (int)$isApplyExist;
	$preorderTitle = DB::queryFirstRow("SELECT poDeviceName FROM tmPreorder WHERE poKey=%i",$poKey);
	if($isApplyExist === 0)
		throw new Exception('로그인후 취소해주세요', 3);
	
	if($paState >= 1)
		throw new Exception('신청완료 상태이므로 취소할 수 없습니다.', 3);
}
catch (Exception $e) {	
	alert($e->getMessage(), $cfg['path']."/user/preorderState.php");

}

if($isApplyExist === 1 && $isMyEmail === $mb['mbEmail'])
DB::update('tmPreorderApplyList', array(
  'paCancel' => '1'
  ), "mbEmail=%s", $mb['mbEmail']);


goURL($cfg['url']."/user/preorderState.php");
?>