<?
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

?>