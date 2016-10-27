<div class="mypage-wrap center ">
	<h1 class="tit center"></h1>
	<h2 class="tit-sub">갤럭시노트7 교환/환불 신청</h2>
	<div class="tit-sub">진행단계</div>
	<ul class="preorder-process-wrap">
		<?php $stateIndex = 1?>
		<?php foreach($state as $key => $val) :?>
		<li class="<?php echo $currentState[$key]?>">
			<div class="number"><?php echo $stateIndex?></div>
			<div class="name"><?php echo $val?></div>
			<?php $stateIndex++?>
		</li>
		<?php endforeach?>
	</ul>
	<section class="section-no-padding">
		<Br/>
		<div class="tit-sub"><?echo "갤럭시 노트7 ".$type[$arrExchangeRefundList['enApplyType']]?> 신청정보</div>
			<ul class="inlinelist">
				<li> 
					<span class="label"><i class="ico-person-small"></i> 신청자명</span><span class="cont"><?php echo $arrExchangeRefundList['mbName'] ?></span>	
				</li><li>
					<span class="label"><i class="ico-tel-small"></i> 전화번호</span><span class="cont"><?php echo $arrExchangeRefundList['enPhone'] ?></span>			
				</li><li>
					<span class="label"><i class="ico-gift-small"></i> 사은품 </span><span class="cont"><?php echo $gift[$arrExchangeRefundList['enReceivedGift']] ?></span>								
				</li><li>
					<span class="label"><i class="ico-apply-type-small"></i> 진행방법</span><span class="cont"><?php echo $way[$arrExchangeRefundList['enWay']] ?></span>								
				</li><li>
					<span class="label"><i class="ico-carrier-small"></i> 신청하신 통신사</span><span class="cont"><?php echo $arrExchangeRefundList['enApplyCarrier'] ?></span>								
				</li><? if($arrExchangeRefundList['enApplyType'] === 'exchange') : ?><li>
					<span class="label"><i class="ico-apply-type-small"></i> 교환하실 기기</span><span class="cont">
							<?php echo(isExist($device[$arrExchangeRefundList['enTargetDevice']]))?$device[$arrExchangeRefundList['enTargetDevice']]:$arrExchangeRefundList['enTargetDevice'] ?>
						</span>			
					</li>
				<?endif?>
				<? if(($arrExchangeRefundList['enApplyType'] === 'exchange') && isExist($device[$arrExchangeRefundList['enTargetDevice']])): ?>
					<li>
						<span class="label"><i class="ico-apply-type-small"></i> 용량</span><span class="cont"><?php echo $arrExchangeRefundList['enDeviceCapacity'] ?></span>		
					</li><li>
						<span class="label"><i class="ico-color-small"></i> 색상</span><span class="cont"><?php echo $color[$arrExchangeRefundList['enColorType']] ?></span>
					</li>
				<?endif?>
				<Br/>
			</ul>
		<? if($arrExchangeRefundList['enApplyType'] === 'exchange' && $arrExchangeRefundList['enWay'] === 'delivery') : ?>
			<div class="tit-sub">기기교환 받으실 주소</div>
			<ul class="inlinelist">
				<li>
					<span class="label">비상연락처</span><span class="cont"><?php echo $arrExchangeRefundList['enSubPhone'] ?></span>			
				</li><li>
					<span class="label">우편번호 </span><span class="cont"><?php echo $arrExchangeRefundList['enPostCode'] ?></span>								
				</li><li>
					<span class="label">받으실 주소</span><span class="cont"><?php echo $arrExchangeRefundList['enAddress']." ".$arrExchangeRefundList['enSubAddress'] ?></span>								
				</li>
				<Br/>
			</ul>
		<?endif?>
		<!--
		<? if($arrExchangeRefundList['enApplyType'] === 'refund' && $arrExchangeRefundList['enReceivedGift'] === '1') : ?>
			<div class="tit-sub">사은품비용 입금 안내</div>
			<ul class="inlinelist">
				<li>
					<span class="label">예금주명</span><span class="cont">ㄴㅁㅇㄴㅇㄴㅁ</span>			
				</li><li>
					<span class="label">입금은행 </span><span class="cont">ㅁㄴㅇㅁㄴㅇㅁ</span>								
				</li><li>
					<span class="label">입금계좌번호</span><span class="cont">ㅁㄴㅇㅁㄴㅇ</span>								
				</li>
				<Br/>
			</ul>
		<?endif?>
		-->
	</section>
	<br/>
</div>
