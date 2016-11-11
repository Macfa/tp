<div class="mypage-wrap center ">
	<h1 class="tit center"></h1>
	<h2 class="tit-sub"><? if(isExist($arrpreorderS7EdgeBlue)){echo "갤럭시 S7엣지 블루코랄 사전예약현황";}else echo "갤럭시 S7 / S7엣지 신청내역"?></h2>

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
			<span class="label"><i class="ico-person-small"></i> 신청자명</span><span class="cont"><?php echo $arrOrderList['mbName'] ?></span>	
		</li><li>
			<span class="label"><i class="ico-email-small"></i> 이메일</span><span class="cont"><?php echo $arrOrderList['mbEmail'] ?></span>				
		</li><li>
			<span class="label"><i class="ico-calendar-small"></i> 생년월일</span><span class="cont"><?php echo $arrOrderList['taBirth'] ?></span>		
		</li><li>
			<span class="label"><i class="ico-tel-small"></i> 전화번호</span><span class="cont"><?php echo $arrOrderList['mbPhone'] ?></span>	
		</li>
		</ul>
		<Br/>
		<div class="tit-sub">디바이스 신청정보</div>
		<ul class="inlinelist">
			<li>
				<span class="label"><i class="ico-person-small"></i> 신청 디바이스 </span><span class="cont"><?php echo $device[$arrOrderList['dvKey']] ?></span>								
			</li><?if($arrOrderList['taWatingNumber'] != '0') :?><li>
				<span class="label"><i class="ico-person-small"></i> 순 번</span><span class="cont"><?php echo $preorderOrderNumString ?></span>							
			</li><?endif?><li>
				<span class="label"><i class="ico-carrier-small"></i> 신청할 통신사</span><span class="cont"><?php echo $arrOrderList['taChangeCarrier'] ?></span>			
			</li><li>
				<span class="label"><i class="ico-apply-type-small"></i> 가입유형</span><span class="cont"><?php echo $type[$arrOrderList['taApplyType']] ?></span>
			</li><li>
				<span class="label"><i class="ico-carrier-small"></i> 이용중인 통신사</span><span class="cont"><?php echo $arrOrderList['taCurrentCarrier'] ?></span>		
			</li><li>
				<span class="label"><i class="ico-plan-small"></i> 요금제</span><span class="cont"><?php echo (isExist($plan[$arrOrderList['taPlan']]))?$plan[$arrOrderList['taPlan']]:$arrOrderList['taPlan']; ?></span>
			</li><li>
				<span class="label"><i class="ico-color-small"></i> 색상</span><span class="cont"><?php echo $color[$arrOrderList['taColor']] ?></span>	
			</li><!--<li>
				<span class="label"><i class="ico-color-small"></i>2지망 색상</span><span class="cont"><?php echo $color[$arrOrderList['pa2ndColor']] ?></span>	
			</li>
			<li>
				<span class="label"><i class="ico-gift-small"></i> 선택 사은품</span><span class="cont"><?php foreach($arrOrderList['paGift'] as $giftList){echo ($gift[$giftList])?$gift[$giftList]:$giftList."<Br/>";} ?></span>	
			</li><?php if(isExist($arrOrderList['paEtc2'])) :?><li>
				<span class="label"><i class="ico-gift-small"></i> 기타사항</span><span class="cont">에그신청</span>	
			</li><?php endif?>		-->
		<Br/>
		</ul>
	</section>

	<?require_once("./preorderStateInfo.php");?>  <!-- 실가입 전  유의사항 -->

	
	<?php if($arrOrderList['taChangeCarrier'] === 'sk' && isNullVal($plan[$arrOrderList['taPlan']])) :?>
		<div class="center"><i class="ico-caution-small"></i> 기타 요금제 선택하신 고객님은 실가입 신청시 메모장에 원하시는 요금제를 써주세요.</div>
	<?php endif?>
	<?if($arrOrderList['taProcess'] == 2 && $arrOrderList['isBuyNote7'] == '0'):?>
		<div class="center"><i class="ico-caution-small"></i> 원하시는 색상은 반드시 메모란에 적어주세요!</div>
	<? endif ?>
	<!--
	<?if($arrOrderList['taProcess'] == 0) :?> 
		<span class="cont"><a href="/page/galaxys7Delete.php" class="btn-flat-primary-dense">취소하기</a></span>
	<? endif ?>
	-->
	
	<?if($arrOrderList['taProcess'] <= 2 && $arrOrderList['poKey'] !== '4') :?> <!-- 실가입 필요 단계가지 확인 -->		
		<span class="cont"><a href="/page/galaxys7Apply.php?v=edit" class="btn-filled-primary-dense">수정하기</a></span>
	<? endif ?>
	<?if($arrOrderList['taProcess'] == 2 &&  ($arrOrderList['taChangeCarrier'] === 'sk' || ($arrOrderList['taChangeCarrier'] === 'kt' && $arrOrderList['isBuyNote7'] == '0'))) :?> <!-- 노트7비구매자 실가입신청 -->
		<span class="label"></span><span class="cont"><a href=<? echo $applyLinkUrl ?> target="_blank" class="btn-filled-primary-dense js-applyBtn">실가입신청</a></span>
	<? endif ?>
	<?if($arrOrderList['taProcess'] == 2 && ($arrOrderList['taChangeCarrier'] === 'kt' && $arrOrderList['isBuyNote7'] == '1')) :?>

		<div class="center"> <i class="ico-caution-small"></i>  노트7 구매자분들 중 KT를 신청하시는 분들은 담당자가 유선상으로 진행합니다!</div>
		
	<? endif ?>

	<!--
	<?if($arrOrderList['taProcess'] == 2 && $arrOrderList['taChangeCarrier'] === 'kt' && isExist($arrOrderList['paContactTime']) === False) :?>
		<span class="label"></span><span class="cont"><a href="/page/ktApplyIphone7.php" target="_blank" class="btn-filled-primary-dense js-applyBtn">실가입신청</a></span>
	<? endif ?>
	
	<?if($arrOrderList['taChangeCarrier'] === 'kt' && isExist($arrOrderList['paContactTime']) === TRUE) :?>
		 <h3><i class="ico-tel-small"></i> <?echo $arrOrderList['paContactTime']?>내로 가입안내 전화 드리겠습니다 </h3>
	<? endif ?>
	-->

	<br/>
</div>

<script>
$('.js-applyBtn').click(function(){
	<?php if($arrOrderList['taChangeCarrier'] === 'sk') :?>
	if(!confirm('선택약정은 개통 중에 수정 가능하니 공시지원금으로 신청 먼저 부탁드립니다.'))
		return false;
	<?php endif?>
});
</script>