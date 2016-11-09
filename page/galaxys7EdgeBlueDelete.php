<?

require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)


try{
	list($isApplyExist, $isMyEmail, $taProcess, $poKey) = DB::queryFirstList("SELECT count(*), mbEmail, taProcess, poKey FROM tmApply WHERE mbEmail=%s", $mb['mbEmail']);	
	$taProcess = (int)$taProcess;
	$isApplyExist = (int)$isApplyExist;
	$preorderTitle = DB::queryFirstRow("SELECT poDeviceName FROM tmPreorder WHERE poKey=%i",$poKey);
	if($isApplyExist === 0)
		throw new Exception('로그인후 취소해주세요', 3);
	
	if($taProcess >= 1)
		throw new Exception('신청완료 상태이므로 취소할 수 없습니다.', 3);
}
catch (Exception $e) {	
	alert($e->getMessage(), $cfg['path']."/user/galaxys7EdgeBlueState.php");

}

if($isApplyExist === 1 && $isMyEmail === $mb['mbEmail'])
DB::update('tmApply', array(
  'taCancel' => '1'
  ), "mbEmail=%s", $mb['mbEmail']);


goURL($cfg['url']."/user/galaxys7EdgeBlueState.php");
?>