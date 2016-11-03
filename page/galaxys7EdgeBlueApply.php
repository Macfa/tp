<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
include_once(PATH_LIB."/lib.snoopy.inc.php");
include_once(PATH_LIB."/lib.parsing.inc.php");
//include_once(PATH_LIB."/lib.calculator.inc.php");

$add_css = '<link rel="stylesheet" href="'.PATH_CSS.'/exchangeRefundNote7.css" type="text/css">';
$js_file = '<script type="text/javascript" src="'.PATH_JS.'/preorderNote7.js"></script>';
$js_file .= '<script type="text/javascript" src="'.PATH_JS.'/calculator.js"></script>';
$js_file .= '<script type="text/javascript" src="'.PATH_JS.'/input.js"></script>';
$js_file .= '<script type="text/javascript" src="'.PATH_JS.'/validate.js"></script>';
$js_file .= '<script type="text/javascript" src="'.PATH_JS.'/modifyInfo.js"></script>';
$cfg['title'] = '갤럭시S7 엣지 블루코랄 신청안내';

	
try{

	list($isApplyExistList, $taKey) = DB::queryFirstList("SELECT COUNT(*), taKey FROM tmApply WHERE mbEmail = %s AND taColor='blue' AND dvKey=664", $mb['mbEmail']);
	$isApplyExist = (int)$isApplyExistList;
	

	if($isApplyExist === 0 && $_GET['v'] === "edit")
		throw new Exception('구매후 수정이 가능합니다', 2);


 	if($isApplyExist === 1 && $_GET['v'] != 'edit')
		throw new Exception('이미 신청을 하셨습니다.', 3);


}catch (Exception $e) {
	if ($e->getCode() === 2)	
		alert($e->getMessage(), $cfg['path']);
	
	if ($e->getCode() === 3)	
		alert($e->getMessage(), $cfg['path']."/user/galaxys7EdgeBlueState.php");
	}

$validEmail = '';
$validPhone = '';
if (isEmail($mb['mbEmail']) === true && $isLogged === TRUE)
	$validEmail = $mb['mbEmail'];

if  (isPhoneNum($mb['mbPhone']) == true || isTelNum($mb['mbPhone']) == true && $isLogged === TRUE){
	$validPhone = $mb['mbPhone'];
}

/*
$defAddress = DB::queryFirstRow("SELECT * FROM tmAddress WHERE mbEmail = %s and arIsDefault = 1", $mb['mbEmail']);
$arrAddress = DB::query("SELECT * FROM tmAddress WHERE mbEmail = %s", $mb['mbEmail']);
*/
require_once($cfg['path']."/head.inc.php");			// 헤더 부분 (스킨포함)
require_once("galaxys7EdgeBlueApply.skin.php");
require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)
?>