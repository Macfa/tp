<div class="mypage-wrap center ">
	<h1 class="tit center"></h1>
	<h2 class="tit-sub"><?echo $applyDevice?> 신청내역</h2>
	<div class="tit-sub">진행단계</div>
	<ul class="preorder-process-wrap">
		<?php foreach($state as $key => $val) :?>
		<li class="<?php echo $currentState[$key]?>">
			<div class="number"><?php echo $key+1?></div>
			<div class="name"><?php echo $val?></div>
			
		</li>
		<?php endforeach?>
	</ul>
	<section class="section-no-padding">
		<Br/>
		<div class="tit-sub">신청자 정보</div>
		<ul class="inlinelist">
		<li> 
			<span class="label"><i class="ico-person-small"></i> 구매자명</span><span class="cont"><?php echo $mbName ?></span>
		</li><?php if(isExist($arrApplyList['apBirth'])):?><li>
			<span class="label"><i class="ico-calendar-small"></i> 생년월일</span><span class="cont"><?php echo $arrApplyList['apBirth'] ?></span>		
		</li><?endif?><li>
			<span class="label"><i class="ico-tel-small"></i> 전화번호</span><span class="cont"><?php echo $mbPhone ?></span>	
		</li><li>
			<span class="label"><i class="ico-apply-type-small"></i> 디바이스</span><span class="cont"><?php echo $applyDevice.$applyCapacity ?></span>	
		</li>
		</ul>
		<Br/>
		<div class="tit-sub">디바이스 신청정보</div>

		<ul class="inlinelist">
			<li>
				<span class="label"><i class="ico-carrier-small"></i> 이용중인 통신사</span><span class="cont">
				<?php echo $deviceInfo->getCarrierName($arrApplyList['apCurrentCarrier']) ?></span>	
			</li><li>
				<span class="label"><i class="ico-apply-type-small"></i> 가입유형</span><span class="cont">
				<?php echo $deviceInfo->getApplyTypeName($arrApplyList['apApplyType'])?></span>
			</li><li>
				<span class="label"><i class="ico-carrier-small"></i> 신청할 통신사</span><span class="cont">
				<?php echo $deviceInfo->getCarrierName($arrApplyList['apChangeCarrier']) ?></span>
			</li><?if(isExist($arrApplyList['apDiscountType'])):?><li>
				<span class="label"><i class="ico-sale-small"></i> 할인유형</span><span class="cont">
				<?php echo $deviceInfo->getDiscountTypeName($arrApplyList['apDiscountType']) ?></span>
			</li><?endif?><li>
				<span class="label"><i class="ico-plan-small"></i> 요금제</span><span class="cont">
				<?php echo $deviceInfo->getPlanName($arrApplyList['apPlan']); ?></span>
			</li><li>
				<span class="label"><i class="ico-color-small"></i> 색상</span><span class="cont">
				<?php echo $arrApplyList['apColor'] ?></span>	
			</li><?if($applyDevice === 'V20') :?><li>
				<span class="label"><i class="ico-color-small"></i> 혜택</span><span class="cont">
				<?php echo $arrApplyList['apBenefits'] ?></span>	
			</li><li>
				<span class="label"><i class="ico-color-small"></i> 구매방법</span><span class="cont">
				<?php echo $way[$arrApplyList['apBuyway']] ?></span>	
			</li><?endif?><?if(isExist($arrApplyList['apPoint']) && $applyDevice != 'V20') :?><li>
				<span class="label"><i class="ico-plan-small"></i> 지급포인트</span><span class="cont">
				<?php echo $apPoint ?></span>
			</li><?endif?>
		</ul>		
	</section>
	<?php if ($arrApplyList['apProcess'] != 4 and $arrApplyList['apProcess'] != 5  and $arrApplyList['apCancel'] != '1' ) :?>
		
		<form method="post" action="applyStateDelete.php" style="display: inline-block;"><input type="hidden" value="<? echo $arrApplyList['dvKey']?>" name="dvKey"><span><input type="submit" value="취소하기" class="btn-filled-sub-dense"></span></form> &nbsp;<span><a href="<?echo $applyEditURL?>" class="btn-filled-sub-dense">수정하기</a></span> &nbsp;<span class="btn-filled-primary-dense js-applyBtn">실가입신청</span>

	<?php elseif ($arrApplyList['apCancel'] === '1' ):?>
		<span class="cont">신청이 취소되었습니다</span>
	<?endif?>
	<!--
	<?if($applyDevice === 'V20' && $arrApplyList['apCancel'] === '0' ) :?>	
		<Br><Br>
		<span class="cont">실가입은 1월 24일 화요일 중에 별도로 안내드립니다.</span>
	<?endif?>
	-->
	<Br><Br><Br>
	<?require_once("./preorderStateInfo.php");?>
	
</div>
<form action="/product/submit.php" method="post" class="goApplyUrl">
	<input type="hidden" name="capacity" value="<?echo $applyCapacity?>">
	<input type="hidden" name="plan" value="<?echo $arrApplyList['apPlan']?>">
	<input type="hidden" name="carrier" value="<?echo $arrApplyList['apChangeCarrier']?>">
	<input type="hidden" name="applyType" value="<?echo $arrApplyList['apApplyType']?>">
	<input type="hidden" name="discountType" value="<?echo $arrApplyList['apDiscountType']?>">
	<input type="hidden" name="dvId" value="<?echo $deviceId?>">	
</form>
<script>
	$('.js-applyBtn').click(function(){
	    $('.goApplyUrl').submit();
	});
</script>