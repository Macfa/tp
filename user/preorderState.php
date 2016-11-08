<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

$add_css = '<link rel="stylesheet" href="'.PATH_CSS.'/mypageList.css" type="text/css">';

$preorderList = DB::queryFirstRow("SELECT * FROM tmPreorder WHERE poDeviceName=%s", $_GET['device']);

$arrOrderList = DB::queryFirstRow("SELECT * FROM tmPreorderApplyList WHERE mbEmail = %s and paCancel = 0 and poKey = %s", $mb['mbEmail'], $preorderList['poKey']);






try{
	
	if($isLogged == false)
		throw new Exception('로그인 해주세요!', 1);
	
	$isExist = (int)count($arrOrderList);
	if($isExist === 0)
		throw new Exception('구매신청 후 이용해주세요!', 3);	

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
$applyLinkUrl = '"#"';

if($preorderList['poKey'] == '3'){ // 아이폰7 실가입주소
	
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
				$applyLinkUrl = '"http://online.olleh.com/index.jsp?prdcID=16FD6727-297F-4396-BB67-308623146D82"';	

			}else if($arrOrderList['paApplyType'] === '06'){ //기변
				$applyLinkUrl = '"http://online.olleh.com/index.jsp?prdcID=4F133DF0-861B-44ED-B2BF-5A26AF28D876"';	
			}
		}

		if($arrOrderList['dvKey'] === '742') { //아이폰7 128G

			if($arrOrderList['paApplyType'] === '02'){ // 번이
				$applyLinkUrl = '"http://online.olleh.com/index.jsp?prdcID=C55ECAF0-10FD-4A56-9797-562D8CB39E1D"';	

			}else if($arrOrderList['paApplyType'] === '06'){ //기변
				$applyLinkUrl = '"http://online.olleh.com/index.jsp?prdcID=54F14F9B-DE1D-4E72-84C2-C25B13680CE7"';	
			}
		}
		if($arrOrderList['dvKey'] === '743') { //아이폰7 256G

			if($arrOrderList['paApplyType'] === '02'){ // 번이
				$applyLinkUrl = '"http://online.olleh.com/index.jsp?prdcID=ADA7EF9D-7031-4657-A871-CD0308185748"';	

			}else if($arrOrderList['paApplyType'] === '06'){ //기변
				$applyLinkUrl = '"http://online.olleh.com/index.jsp?prdcID=2FA76C8F-F4E4-4319-9BF9-9325C1E1E5C4"';	
			}
		}


		if($arrOrderList['dvKey'] === '745') { //아이폰7플러스 32G

			if($arrOrderList['paApplyType'] === '02'){ // 번이
				$applyLinkUrl = '"http://online.olleh.com/index.jsp?prdcID=B2C194C8-956E-40A6-BC55-499A46FCE540"';	

			}else if($arrOrderList['paApplyType'] === '06'){ //기변
				$applyLinkUrl = '"http://online.olleh.com/index.jsp?prdcID=A5D238C8-373A-4AA2-A015-143CB5AFA329"';	
			}
		}
		if($arrOrderList['dvKey'] === '746') { //아이폰7플러스 128G

			if($arrOrderList['paApplyType'] === '02'){ // 번이
				$applyLinkUrl = '"http://online.olleh.com/index.jsp?prdcID=CD9A7BD6-D6AF-4DE2-ABDC-63F0B2F78EAC"';	

			}else if($arrOrderList['paApplyType'] === '06'){ //기변
				$applyLinkUrl = '"http://online.olleh.com/index.jsp?prdcID=D5093E84-6D1F-4E9E-98CB-714B87E27A5C"';	
			}
		}
		if($arrOrderList['dvKey'] === '747') { //아이폰7플러스 256G

			if($arrOrderList['paApplyType'] === '02'){ // 번이
				$applyLinkUrl = '"http://online.olleh.com/index.jsp?prdcID=BFDF0477-054C-4192-906C-2E9AD1A50891"';	

			}else if($arrOrderList['paApplyType'] === '06'){ //기변
				$applyLinkUrl = '"http://online.olleh.com/index.jsp?prdcID=66BC34C8-A9CE-41D5-845F-4A6A2C4026F2"';	
			}
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
	'749' => '비와이폰',
	'0' => '아이폰'
);

$color = array(
	'jetBlack' => '제트블랙',
	'black' => '블랙',
	'silver' => '실버',
	'gold' => '골드',
	'roseGold' => '로즈골드',
	'white' => '화이트'

);


require_once($cfg['path']."/head.inc.php");			// 헤더 부분 (스킨포함)

require_once("preorderState.skin.php");		


require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)