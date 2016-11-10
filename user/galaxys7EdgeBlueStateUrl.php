<?
list($isExistApplyCode, $arrApplyCode)  = DB::queryFirstList("SELECT COUNT(*), cdCode FROM tmCode WHERE dvKey = %i0 and cdType = %i1 and cdCarrier = %s2 AND ISNULL(spPlan)", 
$arrOrderList['dvKey'], str_replace("0","",$arrOrderList['taApplyType']), $arrOrderList['taChangeCarrier']);

$applyLinkUrl = '""';
if($arrOrderList['taChangeCarrier'] === 'sk'){
	$linkUrl1 = '"https://tgate.sktelecom.com/applform/main.do?prod_seq=';
	$linkUrl2 = '&scrb_cl='.$arrOrderList['taApplyType'].'&mall_code=00001"';
	$applyLinkUrl = $linkUrl1.$arrApplyCode.$linkUrl2;
	if($arrOrderList['dvKey'] === '0'){
		$applyLinkUrl = '""';
	}
}


else if($arrOrderList['taChangeCarrier'] === 'kt' && $arrOrderList['isBuyNote7'] === '0'){  // 노트7 비구매자 s7 엣지 url

		if($arrOrderList['dvKey'] === '664') { 

			if($arrOrderList['taApplyType'] === '02'){ //번이
				$applyLinkUrl = '"http://online.olleh.com/index.jsp?prdcID=9D63071D-9DC7-42A4-80AB-B539C7D5C545"';	

			}else if($arrOrderList['taApplyType'] === '06'){ //기변
				$applyLinkUrl = '"http://online.olleh.com/index.jsp?prdcID=FE81142F-AE9B-4F47-B258-43F8AEE9E0F7"';	
			}

}
}


?>