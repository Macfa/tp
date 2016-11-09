<?


$applyLinkUrl = '""';
if($arrOrderList['taChangeCarrier'] === 'sk'){
	$linkUrl1 = '"https://tgate.sktelecom.com/applform/main.do?prod_seq=';
	$linkUrl2 = '&scrb_cl='.$arrOrderList['taApplyType'].'&mall_code=00001"';
	$applyLinkUrl = $linkUrl1.$arrApplyCode.$linkUrl2;
	if($arrOrderList['dvKey'] === '0'){
		$applyLinkUrl = '""';
	}
}


if($isBuyNote7 === '0'){  // 노트7 비구매자 s7 엣지 블루 url

	if($arrOrderList['paChangeCarrier'] === 'kt'){
		if($arrOrderList['dvKey'] === '664') { 

			if($arrOrderList['paApplyType'] === '02'){ //번이
				$applyLinkUrl = '"http://online.olleh.com/index.jsp?prdcID=16FD6727-297F-4396-BB67-308623146D82"';	

			}else if($arrOrderList['paApplyType'] === '06'){ //기변
				$applyLinkUrl = '"http://online.olleh.com/index.jsp?prdcID=4F133DF0-861B-44ED-B2BF-5A26AF28D876"';	
			}
		}
	}
}


?>