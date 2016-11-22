<?

require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
include_once(PATH_LIB."/lib.snoopy.inc.php");
include_once(PATH_LIB."/lib.parsing.inc.php");
//include_once(PATH_LIB."/lib.calculator.inc.php");

$add_css = '<link rel="stylesheet" href="'.PATH_CSS.'/preOrderNote7.css" type="text/css">';
$js_file = '<script type="text/javascript" src="'.PATH_JS.'/preorderNote7.js"></script>';
$js_file .= '<script type="text/javascript" src="'.PATH_JS.'/calculator.js"></script>';
$js_file .= '<script type="text/javascript" src="'.PATH_JS.'/input.js"></script>';
$js_file .= '<script type="text/javascript" src="'.PATH_JS.'/validate.js"></script>';
$cfg['title'] = '갤럭시 노트7 신청 안내';
$deviceTrackingAction = '';


//$calculator = new calculator('galaxynote7');
//$calculator->setCarrierSelect()->setDeviceTypeSelect()->setCapacitySelect()->setApplyTypeSelect()->setDiscountTypeSelect()->setVatContainSelect()->setPlanSelect();

if($isLogged) {
	list($fsKey, $pnDeviceTracking) = DB::queryFirstList("SELECT fsKey, pnDeviceTracking FROM tmPreorderNote7 WHERE mbEmail = %s", $mb['mbEmail']);
	$fileName = DB::queryFirstField("SELECT fsOriginalName FROM tmFileStorage WHERE fsKey = %i", $fsKey);
	if (isExist($fileName)) 
		$isUploadedClass = 'display:inline !important;';
	else {
		unset($fsKey);
		unset($fileName);
	}

	if(isExist($pnDeviceTracking)) {
		$deviceTrackingAction = ' href="https://service.epost.go.kr/trace.RetrieveDomRigiTraceList.comm?sid1='.str_replace('-', '', $pnDeviceTracking).'&displayHeader=N" target="_blank" ';
	}else{
		$deviceTrackingAction = ' onclick="alert(\'배송시작 후 배송추적이 가능합니다.\');return false;" ';
	}
}

$cutline = '2016-08-28 12:00:00';
if ($cfg['time_ymdhis'] < $cutline) {
	$affixSKapply = '('.getRelativeDate('2016-08-28').' 점심 12시 부터 가능)';
}

require_once($cfg['path']."/head.inc.php");			// 헤더 부분 (스킨포함)

require_once("preOrderNote7.skin.php");	
require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)
?>