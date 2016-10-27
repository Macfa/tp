<?

require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
include_once(PATH_LIB."/lib.snoopy.inc.php");
include_once(PATH_LIB."/lib.parsing.inc.php");
//include_once(PATH_LIB."/lib.calculator.inc.php");

$preorder = DB::queryFirstRow("SELECT * FROM tmPreorderApplyList WHERE mbEmail=%s AND paChangeCarrier = 'kt' AND paCancel = 0", $mb['mbEmail']);	
$isApplyExist = (int)$preorder;

try{

	if($isLogged == false)
		throw new Exception('로그인 해주세요!', 1);

	if($isApplyExist === 0)
		throw new Exception('신청하신후 실가입이 가능합니다', 3);

	if($preorder['paProcess'] != 2)
		throw new Exception('실가입 신청단계가 아닙니다', 2);

	if(isExist($preorder['paContactTime']))
		throw new Exception('연락가능한 시간에 연락드리겠습니다', 2);
	
} catch (Exception $e) {	

	if ($e->getCode() === 1)
		$errorURL = $cfg['login_url'];

	if ($e->getCode() === 2)
		alert($e->getMessage(), $cfg['path']."/user/preorderState.php?device=아이폰7");

	if ($e->getCode() === 3)	
		alert($e->getMessage(), $cfg['path']."/page/preorderApply.php?device=아이폰7");

}


$add_css = '<link rel="stylesheet" href="'.PATH_CSS.'/preorderIphone7.css" type="text/css">';
$js_file = '<script type="text/javascript" src="'.PATH_JS.'/preorderNote7.js"></script>';
$js_file .= '<script type="text/javascript" src="'.PATH_JS.'/calculator.js"></script>';
$js_file .= '<script type="text/javascript" src="'.PATH_JS.'/input.js"></script>';
$js_file .= '<script type="text/javascript" src="'.PATH_JS.'/validate.js"></script>';
$cfg['title'] = $preorderTitle['poDeviceName'].' 구매안내';

$device = array(
	'741' => '아이폰7 32G',
	'742' => '아이폰7 128G',
	'743' => '아이폰7 256G',
	'745' => '아이폰7 플러스 32G',
	'746' => '아이폰7 플러스 128G',
	'747' => '아이폰7 플러스 256G',
	'0' => '아이폰'
);

$plan = array(
	0 => 'T시그니쳐 Master',
	1 => 'T시그니쳐 Classic',
	2 => 'band 데이터 퍼펙트S',
	3 => 'band 데이터 퍼펙트',
	4 => 'band 데이터 6.5G',
	5 => 'band 데이터 3.5G',
	6 => 'band 데이터 2.2G',
	7 => 'band 데이터 1.2G',
	8 => 'band 데이터 세이브',
	15 => 'LTE 데이터 선택 109',
	16 => 'LTE 데이터 선택 76.8',
	17 => 'LTE 데이터 선택 65.8',
	18 => 'LTE 데이터 선택 54.8',
	19 => 'LTE 데이터 선택 49.3',
	20 => 'LTE 데이터 선택 43.8',
	23 => 'LTE 데이터 선택 38.3',
	24 => 'LTE 데이터 선택 32.8'
);

$type = array(
	'01' => '신규',
	'02' => '번호이동',
	'06' => '기기변경'
);

require_once($cfg['path']."/head.inc.php");			// 헤더 부분 (스킨포함)

require_once("ktApplyIphone7.skin.php");

require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)
?>