<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

$add_css = '<link rel="stylesheet" href="'.PATH_CSS.'/mypageList.css" type="text/css">';
try{
	
	if($isLogged == false)
		throw new Exception('로그인 해주세요!', 1);

	$arrOrderList = DB::queryFirstRow("SELECT * FROM tmPreorderV20 WHERE mbEmail = %s and pvCancel = 0", $mb['mbEmail']);
	$isExist = (int)DB::count();
	if($isExist === 0)
		throw new Exception('구매신청 후 이용해주세요!', 2);	

} catch (Exception $e) {	

	if ($e->getCode() === 1)
		$errorURL = $cfg['login_url'];
	else if ($e->getCode() === 2)
		$errorURL = $cfg['url']."/page/preorderV20Apply.php";

	alert($e->getMessage(), $errorURL);
}



//DB::debugMode();

list($isExistApplyCode, $arrV20ApplyCode)  = DB::queryFirstList("SELECT COUNT(*), cdCode FROM tmCode WHERE dvKey = %i0 and spPlan = %s1 and cdType = %i2 and cdCarrier = %s3", 
739, $arrOrderList['pvPlan'], str_replace("0","",$arrOrderList['pvApplyType']), $arrOrderList['pvChangeCarrier']);

$applyLinkUrl = '""';
if($arrOrderList['pvChangeCarrier'] === 'sk'){
	$linkUrl1 = '"https://tgate.sktelecom.com/applform/main.do?prod_seq=';
	$linkUrl2 = '&scrb_cl='.$arrOrderList['pvApplyType'].'&mall_code=00001"';
	$applyLinkUrl = $linkUrl1.$arrV20ApplyCode.$linkUrl2;
}
if($arrOrderList['pvChangeCarrier'] === 'kt' && $arrOrderList['pvApplyType'] === '02' ){	
	$applyLinkUrl = '"http://online.olleh.com/index.jsp?prdcID=138FF8C1-BD4A-46EC-90E8-DCB5A0CCFC63"';
}
if($arrOrderList['pvChangeCarrier'] === 'kt' && $arrOrderList['pvApplyType'] === '06' ){	
	$applyLinkUrl = '"http://online.olleh.com/index.jsp?prdcID=0A93DFC4-A0D0-47F0-B515-CC4EA0EBB066"';
}



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

$state = array(
	0 => '예약접수',
	1 => '예약완료',
	/*2 => ,
	3 => , 
*/
	2 => '실가입필요',
	3 => '실가입확인',
	4 => '기기발송',
	5 => '기기도착',
	6 => '개통대기',
	7 => '개통완료',
	8 => '사은품발송대기',
	9 => '사은품발송',
	10 => '완료'	
);
$currentState[$arrOrderList['pvProcess']] = 'active';


require_once($cfg['path']."/head.inc.php");			// 헤더 부분 (스킨포함)

require_once("preorderV20State.skin.php");		

echo $arrOrderList['pvPlan'];

require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)