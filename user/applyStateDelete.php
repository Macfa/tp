<?

require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

try{
	$isApplyExist = DB::queryFirstField("SELECT count(*) FROM tmApplyTmp WHERE mbEmail=%s and dvKey=%i and apCancel = 0", $mb['mbEmail'], $_POST['dvKey']);	
	
	$isApplyExist = (int)$isApplyExist;
	if($isApplyExist === 0)
		throw new Exception('신청서가 존재하지 않습니다', 1);

}
catch (Exception $e) {	
	if ($e->getCode() === 1){
		alert($e->getMessage(), $cfg['path']);
	}
	
}

DB::update('tmApplyTmp', array(
  'apCancel' => '1'
  ), "mbEmail=%s and dvKey=%i", $mb['mbEmail'], $_POST['dvKey']);


goURL($cfg['url']."/user/applyStateList.php");

?>