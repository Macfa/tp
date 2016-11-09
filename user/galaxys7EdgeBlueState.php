<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

$add_css = '<link rel="stylesheet" href="'.PATH_CSS.'/mypageList.css" type="text/css">';

$arrOrderList = DB::queryFirstRow("SELECT * FROM tmApply WHERE mbEmail = %s and taCancel = 0", $mb['mbEmail']);



try{
	
	if($isLogged == false)
		throw new Exception('로그인 해주세요!', 1);
	
	$isExist = (int)count($arrOrderList);
	if($isExist === 0)
		throw new Exception('구매신청 후 이용해주세요!', 2);	

} catch (Exception $e) {	

	if ($e->getCode() === 1)
		$errorURL = $cfg['login_url'];

	if ($e->getCode() === 3)
		alert($e->getMessage(), $cfg['path']);
	
	else if ($e->getCode() === 2)		
		$errorURL = $cfg['url']."/page/galaxys7EdgeBlueApply.php";
	alert($e->getMessage(), $errorURL);
}




list($isExistApplyCode, $arrApplyCode)  = DB::queryFirstList("SELECT COUNT(*), cdCode FROM tmCode WHERE dvKey = %i0 and cdType = %i1 and cdCarrier = %s2", 
$arrOrderList['dvKey'], str_replace("0","",$arrOrderList['taApplyType']), $arrOrderList['taChangeCarrier']);

/*
$applyLinkUrl = '""';
if($arrOrderList['paChangeCarrier'] === 'sk'){
	$linkUrl1 = '"https://tgate.sktelecom.com/applform/main.do?prod_seq=';
	$linkUrl2 = '&scrb_cl='.$arrOrderList['paApplyType'].'&mall_code=00001"';
	$applyLinkUrl = $linkUrl1.$arrApplyCode.$linkUrl2;
	if($arrOrderList['dvKey'] === '0'){
		$applyLinkUrl = '""';
	}
}

if($arrOrderList['paChangeCarrier'] === 'kt'){
	if($arrOrderList['dvKey'] === '741') { 

		if($arrOrderList['paApplyType'] === '02'){ //번이
			$applyLinkUrl = '"http://online.olleh.com/index.jsp?prdcID=16FD6727-297F-4396-BB67-308623146D82"';	

		}else if($arrOrderList['paApplyType'] === '06'){ //기변
			$applyLinkUrl = '"http://online.olleh.com/index.jsp?prdcID=4F133DF0-861B-44ED-B2BF-5A26AF28D876"';	
		}
	}
}
*/


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

/*

$arrOrderList['paGift'] =  explode(',', $arrOrderList['paGift']);

$gift = array(
	'tablet' => '엠피지오 태블릿',
	'externalHard' => '외장SSD 128G',
	'skMirroring' => 'SK 미러링'
);
*/
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
$currentState[$arrOrderList['taProcess']] = 'active';

$device = array(
	'664' => '갤럭시 S7 엣지'
);

$color = array(

	'blue' => '코랄블루'
);


$preorderOrderNum = DB::queryFirstField("SELECT taWatingNumber FROM tmApply WHERE taChangeCarrier=%s_changeCarrier AND taCancel = %i_cancel AND taColor='blue' ORDER BY taWatingNumber DESC", 
  array(
    'changeCarrier' => $_POST['taChangeCarrier'],
    'cancel' => '0'
  ) 
);



$preorderOrderNum = $arrOrderList['taWatingNumber'] + 100; 
$preorderOrderNumString = "01 - ".$preorderOrderNum;
	if($arrOrderList['taWatingNumber'] > 200){		
		$preorderOrderNum = $preorderOrderNum - 200;
		$preorderOrderNumString = "02 - ".$preorderOrderNum;
}

require_once($cfg['path']."/head.inc.php");			// 헤더 부분 (스킨포함)

require_once("galaxys7EdgeBlueState.skin.php");		

require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)