<div class="mypage-wrap center ">
	<h1 class="tit center"></h1>
	<h2 class="tit-sub">사전예약 신청 내역</h2>
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
			<span class="label"><i class="ico-person-small"></i> 예약자명</span><span class="cont"><?php echo $arrOrderList['paName'] ?></span>	
		</li><li>
			<span class="label"><i class="ico-email-small"></i> 이메일</span><span class="cont"><?php echo $arrOrderList['paEmail'] ?></span>				
		</li><li>
			<span class="label"><i class="ico-calendar-small"></i> 생년월일</span><span class="cont"><?php echo $arrOrderList['paBirth'] ?></span>		
		</li><li>
			<span class="label"><i class="ico-tel-small"></i> 전화번호</span><span class="cont"><?php echo $arrOrderList['paPhone'] ?></span>	
		</li>
		</ul>
		<Br/>
		<div class="tit-sub">사전예약 신청정보</div>

		<ul class="inlinelist">
		<li>
			<span class="label"><i class="ico-person-small"></i> 신청 디바이스 </span><span class="cont"><?php echo $deviceKey[$arrOrderList['dvKey']] ?></span>								
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
			<span class="label"><i class="ico-color-small"></i> 색상</span><span class="cont"><?php echo $arrOrderList['paColorType'] ?></span>	
		</li><li>
			<span class="label"><i class="ico-color-small"></i>2지망 색상</span><span class="cont"><?php echo $arrOrderList['pa2ndColor'] ?></span>	
		</li><li>
			<span class="label"><i class="ico-gift-small"></i> 선택 사은품</span><span class="cont"><?php foreach($arrOrderList['paGift'] as $giftList){echo $gift[$giftList]."<Br/>";} ?></span>	
		</li><li>		
	<Br/>
		</ul>
	</section>
	<div class="center"><i class="ico-caution-small"></i> 수정 & 취소는 진행단계가 예약접수일때만 가능합니다.</div>
	<?if($arrOrderList['paProcess'] == 0) :?>
				<span class="cont"><a href="/page/preorderApplyDelete.php" class="btn-flat-primary-dense">취소하기</a></span><span class="cont"><a href="/page/preorderApply.php?device=<?echo $preorderTitle['poDeviceName']?>&v=edit" class="btn-filled-primary-dense">수정하기</a></span></li>			
			<? endif ?>
			<?if($arrOrderList['paProcess'] >= 2) :?>
				<span class="label"></span><span class="cont"><a href=<? echo $applyLinkUrl ?> target="_blank" class="btn-filled-primary-dense js-applyBtn">실가입신청</a></span>
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
<?php if(isNullVal($plan[$arrOrderList['paPlan']])) :?>

$('.js-applyBtn').click(function(){
	if(!confirm('기타 요금제를 선택하신 고객님은 실가입신청시 메모장에 원하시는 요금제를 써주세요.'))
		return false;

});
<?php endif?>


</script>