<?
if($preorderList['poKey'] == '5'){ // 비와이폰 실가입주소
	/*
	if($arrOrderList['paChangeCarrier'] === 'sk'){
		$linkUrl1 = '"https://tgate.sktelecom.com/applform/main.do?prod_seq=';
		$linkUrl2 = '&scrb_cl='.$arrOrderList['paApplyType'].'&mall_code=00001"';
		$applyLinkUrl = $linkUrl1.$arrApplyCode.$linkUrl2;
		if($arrOrderList['dvKey'] === '0'){
			$applyLinkUrl = '""';
		}
	}
	*/
	if($arrOrderList['paChangeCarrier'] === 'kt'){
		if($arrOrderList['dvKey'] === '749') { //비와이폰

			if($arrOrderList['paApplyType'] === '02'){ //번이
				$applyLinkUrl = '"http://online.olleh.com/index.jsp?prdcID=1A279AC7-BD7B-4FCA-B33D-F4346AFEBCAE"';	

			}else if($arrOrderList['paApplyType'] === '06'){ //기변
				$applyLinkUrl = '"http://online.olleh.com/index.jsp?prdcID=7F2C0678-C959-44A2-9032-BEC084E9337E"';	
			}
		}
		
	}

}
?>