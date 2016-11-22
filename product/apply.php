<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
include_once(PATH_LIB."/lib.snoopy.inc.php");
include_once(PATH_LIB."/lib.parsing.inc.php");

try{
	$isExistDevice = DB::queryFirstField("SELECT dvKey FROM tmDevice WHERE dvDisplay = 1 and dvKey = %i", $_GET['dvKey']);
	if(isExist($isExistDevice) === FALSE)
		throw new Exception('존재하지 않는 기기입니다.', 3);

	if(isNotExist($_GET['carrier']) === true 
		|| isNotExist($_GET['dvId']) === true
		|| isNotExist($_GET['applyType']) === true 
		|| isNotExist($_GET['discountType']) === true 
		|| isNotExist($_GET['dvKey']) === true 
		|| isNotExist($_GET['plan']) === true)
		throw new Exception('기본정보입력 후 가능합니다.', 1);
}catch(Exception $e){
	if($e->getCode === 1) {
		$URL = URL.'/device/'.$_GET['dvId'];

    	alert($e->getMessage(), $URL);
	}else 
		alert($e->getMessage());
}
$deviceInfo = new deviceInfo();


//--------------------------------------------------------------------------------------------------------

$defAddress = DB::queryFirstRow("SELECT * FROM tmAddress WHERE mbEmail = %s and arIsDefault = 1", $mb['mbEmail']);
$arrAddress = DB::query("SELECT * FROM tmAddress WHERE mbEmail = %s", $mb['mbEmail']);

//-----------------------------------------------------------------------------------------------------------

$naver->setReturnURL('http://tplanit.co.kr/user/snsLoginForApply.php');
$kakao->setReturnURL('http://tplanit.co.kr/user/snsLoginForApply.php');

//----------------------------------------------------------------------------------------------------------

$add_css = '<link rel="stylesheet" href="'.PATH_CSS.'/apply.css" type="text/css">';
$js_file = '<script type="text/javascript" src="'.PATH_JS.'/apply.js"></script>';
$js_file .= '<script type="text/javascript" src="'.PATH_JS.'/gifts.js"></script>';
$js_file .= '<script type="text/javascript" src="'.PATH_JS.'/modifyInfo.js"></script>';
$js_file .= '<script type="text/javascript" src="'.PATH_JS.'/calculator.js"></script>';

require_once($cfg['path']."/headSimple.inc.php");			// 헤더 부분 (스킨포함)
require_once("apply.skin.php");	
require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)