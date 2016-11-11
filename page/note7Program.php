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
$cfg['title'] = '갤럭시노트7 타기기교환&환불 안내';

	

try{

	$isApplyExist = DB::queryFirstField("SELECT COUNT(*) FROM tmNote7Program WHERE mbEmail = %s", $mb['mbEmail']);
	$isApplyExist = (int)$isApplyExist;

 	if($isApplyExist === 1)
		throw new Exception('이미 신청을 하셨습니다.', 3);

}catch (Exception $e) {	
	if ($e->getCode() === 3)	
		alert($e->getMessage(), $cfg['path']."/page/programNote7.php");
}
$validEmail = '';
$validPhone = '';
if (isEmail($mb['mbEmail']) === true && $isLogged === TRUE)
	$validEmail = $mb['mbEmail'];

if  (isPhoneNum($mb['mbPhone']) == true || isTelNum($mb['mbPhone']) == true && $isLogged === TRUE){
	$validPhone = $mb['mbPhone'];
}




require_once($cfg['path']."/head.inc.php");			// 헤더 부분 (스킨포함)
require_once("note7Program.skin.php");
require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)
?>