<?

require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
include_once(PATH_LIB."/lib.snoopy.inc.php");
include_once(PATH_LIB."/lib.parsing.inc.php");
//include_once(PATH_LIB."/lib.calculator.inc.php");

try{
	$applyMember = DB::queryFirstRow("SELECT * FROM tmApply WHERE mbEmail=%s AND taCancel = 0 ", $mb['mbEmail']);
	$isApplyMemberExist = (int)DB::count();	 


	if($isApplyMemberExist === 0 && $_GET['v'] === 'edit')
		throw new Exception('구매후 수정이 가능합니다', 2);
	
	if($isApplyMemberExist === 1 && $_GET['v'] != 'edit' )
		throw new Exception('이미 신청서를 작성하셨습니다.', 3);
	
} catch (Exception $e) {
	if ($e->getCode() === 2)	
		alert($e->getMessage(), $cfg['path']."/page/galaxys7Apply.php");
	
	if ($e->getCode() === 3)	
		alert($e->getMessage(), $cfg['path']."/user/galaxys7EdgeState.php");
	}

$add_css = '<link rel="stylesheet" href="'.PATH_CSS.'/preOrderNote7.css" type="text/css">';
$js_file = '<script type="text/javascript" src="'.PATH_JS.'/preorderNote7.js"></script>';
//$js_file .= '<script type="text/javascript" src="'.PATH_JS.'/calculator.js"></script>';
$js_file .= '<script type="text/javascript" src="'.PATH_JS.'/input.js"></script>';
$js_file .= '<script type="text/javascript" src="'.PATH_JS.'/validate.js"></script>';
$cfg['title'] = '갤럭시 S7 S7엣지 구매안내';

$validEmail = '';
$validPhone = '';

if  (isPhoneNum($mb['mbPhone']) == true || isTelNum($mb['mbPhone']) == true && $isLogged === TRUE){
	$validPhone = $mb['mbPhone'];
}


//어드민에서 수정할때 
if (isEmail($mb['mbEmail']) === true && $isLogged === TRUE)
	$validEmail = $mb['mbEmail'];



require_once($cfg['path']."/head.inc.php");			// 헤더 부분 (스킨포함)
require_once("galaxys7Apply.skin.php");
require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)
?>