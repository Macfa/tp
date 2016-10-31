<div class="mypage-wrap center ">
	<h1 class="tit center"></h1>
	<h2 class="tit-sub">아이폰 신청 내역</h2>
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
			<span class="label"><i class="ico-person-small"></i> 신청자명</span><span class="cont"><?php echo $arrOrderList['paName'] ?></span>	
		</li><li>
			<span class="label"><i class="ico-email-small"></i> 이메일</span><span class="cont"><?php echo $arrOrderList['paEmail'] ?></span>				
		</li><li>
			<span class="label"><i class="ico-calendar-small"></i> 생년월일</span><span class="cont"><?php echo $arrOrderList['paBirth'] ?></span>		
		</li><li>
			<span class="label"><i class="ico-tel-small"></i> 전화번호</span><span class="cont"><?php echo $arrOrderList['paPhone'] ?></span>	
		</li>
		</ul>
		<Br/>
		<div class="tit-sub">디바이스 신청정보</div>
<<<<<<< HEAD
		<ul class="inlinelist">
			<li>
				<span class="label"><i class="ico-person-small"></i> 신청 디바이스 </span><span class="cont"><?php echo $device[$arrOrderList['dvKey']] ?></span>								
			</li><li>
				<span class="label"><i class="ico-person-small"></i> 순 번</span><span class="cont"><?php echo $arrOrderList['paWatingNumber'] ?></span>								
			</li><li>
				<span class="label"><i class="ico-carrier-small"></i> 신청할 통신사</span><span class="cont"><?php echo $arrOrderList['paChangeCarrier'] ?></span>			
			</li><li>
				<span class="label"><i class="ico-apply-type-small"></i> 가입유형</span><span class="cont"><?php echo $type[$arrOrderList['paApplyType']] ?></span>
			</li><li>
				<span class="label"><i class="ico-carrier-small"></i> 이용중인 통신사</span><span class="cont"><?php echo $arrOrderList['paCurrentCarrier'] ?></span>		
			</li><li>
				<span class="label"><i class="ico-plan-small"></i> 요금제</span><span class="cont"><?php echo (isExist($plan[$arrOrderList['paPlan']]))?$plan[$arrOrderList['paPlan']]:$arrOrderList['paPlan']; ?></span>
			</li><li>
				<span class="label"><i class="ico-color-small"></i> 색상</span><span class="cont"><?php echo $color[$arrOrderList['paColorType']] ?></span>	
			</li><li>
				<span class="label"><i class="ico-color-small"></i>2지망 색상</span><span class="cont"><?php echo $color[$arrOrderList['pa2ndColor']] ?></span>	
			</li><li>
				<span class="label"><i class="ico-gift-small"></i> 선택 사은품</span><span class="cont"><?php foreach($arrOrderList['paGift'] as $giftList){echo ($gift[$giftList])?$gift[$giftList]:$giftList."<Br/>";} ?></span>	
			</li><?php if(isExist($arrOrderList['paEtc2'])) :?><li>
				<span class="label"><i class="ico-gift-small"></i> 기타사항</span><span class="cont">에그신청</span>	
			</li><?php endif?>		
		<Br/>
=======

		<ul class="inlinelist">
		<li>
			<span class="label"><i class="ico-person-small"></i> 신청 디바이스 </span><span class="cont"><?php echo $device[$arrOrderList['dvKey']] ?></span>								
		</li><li>
			<span class="label"><i class="ico-person-small"></i> 순 번</span><span class="cont"><?php echo $arrOrderList['paWatingNumber'] ?></span>								
		</li><li>
			<span class="label"><i class="ico-carrier-small"></i> 신청할 통신사</span><span class="cont"><?php echo $arrOrderList['paChangeCarrier'] ?></span>			
		</li><li>
			<span class="label"><i class="ico-apply-type-small"></i> 가입유형</span><span class="cont"><?php echo $type[$arrOrderList['paApplyType']] ?></span>
		</li><li>
			<span class="label"><i class="ico-carrier-small"></i> 이용중인 통신사</span><span class="cont"><?php echo $arrOrderList['paCurrentCarrier'] ?></span>		
		</li><li>
			<span class="label"><i class="ico-plan-small"></i> 요금제</span><span class="cont"><?php echo (isExist($plan[$arrOrderList['paPlan']]))?$plan[$arrOrderList['paPlan']]:$arrOrderList['paPlan']; ?></span>
		</li><li>
			<span class="label"><i class="ico-color-small"></i> 색상</span><span class="cont"><?php echo $color[$arrOrderList['paColorType']] ?></span>	
		</li><li>
			<span class="label"><i class="ico-color-small"></i>2지망 색상</span><span class="cont"><?php echo $color[$arrOrderList['pa2ndColor']] ?></span>	
		</li><li>
			<span class="label"><i class="ico-gift-small"></i> 선택 사은품</span><span class="cont"><?php foreach($arrOrderList['paGift'] as $giftList){echo $gift[$giftList]."<Br/>";} ?></span>	
		</li><li>		
	<Br/>
>>>>>>> develop
		</ul>
	</section>
	
	<?php if($arrOrderList['paChangeCarrier'] === 'sk' && isNullVal($plan[$arrOrderList['paPlan']])) :?>
		<div class="center"><i class="ico-caution-small"></i> 기타 요금제 선택하신 고객님은 실가입 신청시 메모장에 원하시는 요금제를 써주세요.</div>
	<?php endif?>

<<<<<<< HEAD
	<?if($arrOrderList['paChangeCarrier'] === 'kt') :?>
		<div class="center"><i class="ico-caution-small"></i> 원하시는 색상은 반드시 메모란에 적어주세요!</div>
	<? endif ?>

	<?if($arrOrderList['paProcess'] == 0) :?>
		<span class="cont"><a href="/page/preorderApplyDelete.php" class="btn-flat-primary-dense">취소하기</a></span>
	<? endif ?>
	<?if($arrOrderList['paProcess'] < 3) :?>
		<span class="cont"><a href="/page/preorderApply.php?device=<?echo $preorderTitle['poDeviceName']?>&v=edit" class="btn-filled-primary-dense">수정하기</a></span></li>		
	<? endif ?>
	
=======

	<?if($arrOrderList['paProcess'] == 0) :?>
		<span class="cont"><a href="/page/preorderApplyDelete.php" class="btn-flat-primary-dense">취소하기</a></span><span class="cont"><a href="/page/preorderApply.php?device=<?echo $preorderTitle['poDeviceName']?>&v=edit" class="btn-filled-primary-dense">수정하기</a></span></li>			
	<? endif ?>
	<?if($arrOrderList['paChangeCarrier'] === 'kt') :?>
		<div class="center"><i class="ico-caution-small"></i> 원하시는 색상은 반드시 메모란에 적어주세요!</div>
	<? endif ?>
>>>>>>> develop
	<?if($arrOrderList['paProcess'] == 2 ) :?>
		<span class="label"></span><span class="cont"><a href=<? echo $applyLinkUrl ?> target="_blank" class="btn-filled-primary-dense js-applyBtn">실가입신청</a></span>
	<? endif ?>
	<!--
	<?if($arrOrderList['paProcess'] == 2 && $arrOrderList['paChangeCarrier'] === 'kt' && isExist($arrOrderList['paContactTime']) === False) :?>
		<span class="label"></span><span class="cont"><a href="/page/ktApplyIphone7.php" target="_blank" class="btn-filled-primary-dense js-applyBtn">실가입신청</a></span>
	<? endif ?>
	-->
	<?if($arrOrderList['paChangeCarrier'] === 'kt' && isExist($arrOrderList['paContactTime']) === TRUE) :?>
		 <h3><i class="ico-tel-small"></i> <?echo $arrOrderList['paContactTime']?>내로 가입안내 전화 드리겠습니다 </h3>
	<? endif ?>
	

	<!--table class="table str">
	<tbody>
		<tr>
			<td class="tit-sub" colspan="4">예약자 정보</td>
		</tr>
		<tr>
			<td class="label"><i class="ico-person-small"></i> 예약자명</td>
			<td><?php echo $arrOrderList['pvName'] ?></td>	
			<td class="label"><i class="ico-email-small"></i> 이메일</td>
			<td><?php echo $arrOrderList['pvEmail'] ?></td>				
		</tr>
		<tr>
			<td class="label"><i class="ico-calendar-small"></i> 생년월일</td>
			<td><?php echo $arrOrderList['pvBirth'] ?></td>		
			<td class="label"><i class="ico-tel-small"></i> 전화번호</td>
			<td><?php echo $arrOrderList['pvPhone'] ?></td>		
		</tr>
		<tr>
			<td class="tit-sub" colspan="4">사전예약 정보</td>
		</tr>
		<tr>
			<td class="label"><i class="ico-carrier-small"></i> 이용중인 통신사</td>
			<td><?php echo $arrOrderList['pvCurrent'] ?></td>		
			<td class="label"><i class="ico-apply-type-small"></i> 가입유형</td>
			<td><?php echo $type[$arrOrderList['pvApplyType']] ?></td>
		</tr>
		<tr>
			<td class="label"><i class="ico-carrier-small"></i> 신청할 통신사</td>
			<td><?php echo $arrOrderList['pvChangeCarrier'] ?></td>			
			<td class="label"><i class="ico-plan-small"></i> 요금제</td>
			<td><?php echo (isExist($plan[$arrOrderList['pvPlan']]))?$plan[$arrOrderList['pvPlan']]:$arrOrderList['pvPlan']; ?></td>
		</tr>
		<tr>
			<td class="label"><i class="ico-color-small"></i> 색상</td>
			<td><?php echo $arrOrderList['pvColorType'] ?></td>		
			<?if($arrOrderList['pvProcess'] == 0) :?>
			<td><a href="/page/preorderV20ApplyDelete.php" class="btn-flat-primary-dense">취소하기</a></td>
			<td><a href="/page/preorderV20Apply.php?v=edit" class="btn-filled-primary-dense">수정하기</a></td>			
			<? endif ?>
			<?if($arrOrderList['pvProcess'] >= 2) :?>
				<td></td>
				<td><a href=<? echo $applyLinkUrl ?> target="_blank" class="btn-filled-primary-dense">가입신청</a></td>
			<? endif ?>
			
		</tr>
	</tbody>
	</table-->

	<br/>
</div>

<script>
$('.js-applyBtn').click(function(){
	<?php if($arrOrderList['paChangeCarrier'] === 'sk') :?>
	if(!confirm('선택약정은 개통 중에 수정 가능하니 공시지원금으로 신청 먼저 부탁드립니다.'))
		return false;
	<?php endif?>
});
</script>