<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

$add_css = '<link rel="stylesheet" href="'.PATH_CSS.'/mypageList.css" type="text/css">';

$arrOrderList = DB::queryFirstRow("SELECT * FROM tmPreorderApplyList WHERE mbEmail = %s and paCancel = 0", $mb['mbEmail']);
$preorderTitle = DB::queryFirstRow("SELECT poDeviceName FROM tmPreorder WHERE poKey=%i",$arrOrderList['poKey']);

$arrOrderDeleteList = DB::queryFirstRow("SELECT * FROM tmPreorderApplyList WHERE mbEmail = %s", $mb['mbEmail']);
$preorderDeleteTitle = DB::queryFirstRow("SELECT poDeviceName FROM tmPreorder WHERE poKey=%i",$arrOrderDeleteList['poKey']);


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
		$errorURL = $cfg['url']."/page/preorderApply.php?device=".$preorderDeleteTitle['poDeviceName'];
	alert($e->getMessage(), $errorURL);
}




list($isExistApplyCode, $arrApplyCode)  = DB::queryFirstList("SELECT COUNT(*), cdCode FROM tmCode WHERE dvKey = %i0 and cdType = %i1 and cdCarrier = %s2", 
$arrOrderList['dvKey'], str_replace("0","",$arrOrderList['paApplyType']), $arrOrderList['paChangeCarrier']);

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
	if($arrOrderList['dvKey'] === '741') { //아이폰7 32G

		if($arrOrderList['paApplyType'] === '02'){ //번이
			$applyLinkUrl = '"http://online.olleh.com/index.jsp?prdcID=2A8A14F9-789E-44AB-899B-F68167785EB6"';	

		}else if($arrOrderList['paApplyType'] === '06'){ //기변
			$applyLinkUrl = '"http://online.olleh.com/index.jsp?prdcID=BF06A2BC-3638-483A-B98B-756ABAD04A0F"';	
		}
	}

	if($arrOrderList['dvKey'] === '742') { //아이폰7 128G

		if($arrOrderList['paApplyType'] === '02'){ // 번이
			$applyLinkUrl = '"http://online.olleh.com/index.jsp?prdcID=5304D20B-D4C0-4681-A56C-C07BA43468EA"';	

		}else if($arrOrderList['paApplyType'] === '06'){ //기변
			$applyLinkUrl = '"http://online.olleh.com/index.jsp?prdcID=42E152E9-5B63-460B-9C0A-2CE0C2E0F3FD"';	
		}
	}
	if($arrOrderList['dvKey'] === '743') { //아이폰7 256G

		if($arrOrderList['paApplyType'] === '02'){ // 번이
			$applyLinkUrl = '"http://online.olleh.com/index.jsp?prdcID=702F3E0E-C4BF-40C9-98EB-04083DC1519C"';	

		}else if($arrOrderList['paApplyType'] === '06'){ //기변
			$applyLinkUrl = '"http://online.olleh.com/index.jsp?prdcID=C91C7101-BD1A-46C9-83B6-7DA13F989011"';	
		}
	}


	if($arrOrderList['dvKey'] === '745') { //아이폰7플러스 32G

		if($arrOrderList['paApplyType'] === '02'){ // 번이
			$applyLinkUrl = '"http://online.olleh.com/index.jsp?prdcID=2076C0B9-61FE-47FA-915A-4AC7059F5A00"';	

		}else if($arrOrderList['paApplyType'] === '06'){ //기변
			$applyLinkUrl = '"http://online.olleh.com/index.jsp?prdcID=E229E144-DE70-4E8B-B21E-080C55707F15"';	
		}
	}
	if($arrOrderList['dvKey'] === '746') { //아이폰7플러스 128G

		if($arrOrderList['paApplyType'] === '02'){ // 번이
			$applyLinkUrl = '"http://online.olleh.com/index.jsp?prdcID=7220F06A-5D1F-404B-A118-DD8F39AFF9C4"';	

		}else if($arrOrderList['paApplyType'] === '06'){ //기변
			$applyLinkUrl = '"http://online.olleh.com/index.jsp?prdcID=C6F15359-008E-4DF7-9DBB-BCEE1CB58BAE"';	
		}
	}
	if($arrOrderList['dvKey'] === '747') { //아이폰7플러스 256G

		if($arrOrderList['paApplyType'] === '02'){ // 번이
			$applyLinkUrl = '"http://online.olleh.com/index.jsp?prdcID=6CD80D63-50AE-41DA-8988-017F57DC41AB"';	

		}else if($arrOrderList['paApplyType'] === '06'){ //기변
			$applyLinkUrl = '"http://online.olleh.com/index.jsp?prdcID=2C746333-2A02-46D0-A587-41C760A19879"';	
		}
	}
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



$arrOrderList['paGift'] =  explode(',', $arrOrderList['paGift']);

$gift = array(
	'tablet' => '엠피지오 태블릿',
	'externalHard' => '외장SSD 128G',
	'skMirroring' => 'SK 미러링'
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
$currentState[$arrOrderList['paProcess']] = 'active';

$device = array(
	'741' => '아이폰7 32G',
	'742' => '아이폰7 128G',
	'743' => '아이폰7 256G',
	'745' => '아이폰7 플러스 32G',
	'746' => '아이폰7 플러스 128G',
	'747' => '아이폰7 플러스 256G',
	'0' => '아이폰'
);

$color = array(
	'jetBlack' => '제트블랙',
	'black' => '블랙',
	'silver' => '실버',
	'gold' => '골드',
	'roseGold' => '로즈골드'
);


require_once($cfg['path']."/head.inc.php");			// 헤더 부분 (스킨포함)

require_once("preorderState.skin.php");		


require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)