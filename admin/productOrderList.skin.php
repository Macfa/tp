<div class="wrap applyList-wrap">
	<h1 class="center tit"><?echo $preorderTitle?> 일반신청 리스트 </h1>	
	<h2 class="center sub">조회된 구매자 : <?echo $count?> 명 </h2>	
	<div class="center">
		<form method="get">

			<select name="deviceFilter" class="deviceFilter">
				<option>신청기기</option>
			<? foreach($deviceFilter as $row) : ?>
				<option value="<?php echo $row ?>"><?echo $row?></option>
			<?endforeach?>
			</select>
			<input type="text" name="search" value=<? echo $search ?>>
				<input type="submit" value="검색" >
	 		<div data-default="<?php echo $_GET['apIsSpot'] ?>" class="center">
				<label class="inp-chk-dense">
					<input type="radio" class="apIsSpot_radio" name="apIsSpot" value=0>일반신청
					<div class="inp-chk-box"></div>
				</label>

				<label class="inp-chk-dense">
					<input type="radio" class="apIsSpot_radio" name="apIsSpot" value=1>스팟신청
					<div class="inp-chk-box"></div>
				</label>
				<label class="inp-chk"  data-default="<?php echo $_GET['chked'] ?>">
					<input type="checkbox" class="js-tableChk" value="canceled" name="chked">
					<div class="inp-chk-box" ></div>취소한 예약자
				</label>
			</div>
		</form>
	</div>
	<br/>
	<form method="post">
		<div class="center">
			선택된 행을
			<select name="changeProcess" class="js-stateSelect">
				<? foreach ($changeState as $key => $val) : ?>				
					<option value="<?echo $key?>"><?echo $val?></option>
				<?endforeach?>
			</select>
			상태로  <input type="submit" class="btn-filled-sub-dense" data-action="productOrderListAction.php" value="적용"/>
			<br/><br/>				
				<input type="submit" class="btn-filled-primary-dense" data-action="productOrderListDelete.php" value="취소"/>
				<input type="submit" class="btn-filled-primary-dense" data-action="productOrderListDeleteRestore.php" value="취소복구"/>
				<input type="submit" class="btn-filled-primary-dense" data-action="productOrderListModify.php" value="수정"/>
			<!--<br/>
			<input type="submit" class="btn-filled" data-action="preorderTrackingNum.php" value="송장번호입력"/>-->
			<!--
			<?if (isExist($downloadFullUrl)):?>
				<button class="btn-filled-sub-dense" data-action="<?echo $downloadFullUrl ?>">조회된 사전예약자 엑셀 다운로드</button>
			<?endif?>
			-->
			<button class="btn-filled-sub-dense" data-action="productOrderListDownload.php">체크된 사전예약자 엑셀다운로드</button>			
		</div>
		<br/>
		
		<table class="table-grid-dense" style="font-size:.85em">
			<thead>
				<tr class="">
					<td class="chk-wrap">
						<label class="inp-chk">
							<input type="checkbox" class="js-tableAllChk" value="<?php echo $row['apKey']?>"/>
							<div class="inp-chk-box">
							</div>
						</label>
					</td>
					<td class="table-item-str">진행상황</td>
					<td class="table-item-str">타임스탬프</td>
					<td class="table-item-str">신청기기</td>
					<td class="table-item-str">신청모델명</td>
					<td class="table-item-str">구매자명</td>
					<td class="table-item-str">연락처</td>
					<td class="table-item-str">신청한 통신사</td>
					<td class="table-item-str">가입유형</td>
					<td class="table-item-str">할인유형</td>
					<td class="table-item-str">현재통신사</td>
					<td class="table-item-str">대리점</td>
					<td class="table-item-str">요금제</td>
					<td class="table-item-str">색 상</td>
					<td class="table-item-str">지급포인트</td>
					<td class="table-item-str">지급사은품</td>
					<td class="table-item-str">구입방법</td>
					<td class="table-item-str">유입경로</td>
				</tr>
			</thead>
			<tbody>
				<? foreach($existList as $key => $row) : ?>
					<tr class="js-cartRow<?php echo $row['paKey']?>" <?php echo $row['cancelClass']?> <?php echo $row['apProcess']?>>					
						<td class="chk-wrap">
							<label class="inp-chk">
								<input type="checkbox" class="js-tableChk" value="<?php echo $row['apKey']?>" name="chk[]" ?>
								<div class="inp-chk-box"></div>
							</label>
						</td>
						<td class="table-item-str"><?php echo $changeState[$row['apProcess']] ?></td>
						<td class="table-item-str"><?php echo $row['apDatetime'] ?></td>
						<td class="table-item-str"><?php echo $dvTitList[$key] ?></td>
						<td class="table-item-str"><?php echo $dvModelCode[$key] ?></td>							
						<td class="table-item-str"><?php echo $mbName[$key] ?></td>
						<td class="table-item-str"><?php echo $mbPhone[$key] ?></td>
						

						<td class="table-item-str"><?php echo $deviceInfo->getCarrierName($row['apChangeCarrier']) ?></td>	
						<td class="table-item-str"><?php echo $deviceInfo->getApplyTypeName($row['apApplyType']) ?></td>
						<td class="table-item-str"><?php echo $deviceInfo->getDiscountTypeName($row['apDiscountType']) ?></td>				
						<td class="table-item-str"><?php echo $deviceInfo->getCarrierName($row['apCurrentCarrier']) ?></td>
						<td class="table-item-str"><?php echo $row['chName'] ?></td>
						<td class="table-item-str"><?php echo $deviceInfo->getPlanName($row['apPlan']) ?></td>

						<td class="table-item-str"><?php echo $row['apColor'] ?></td>
						<td class="table-item-str"><?php echo (isExist($row['apBenefits']))?'':number_format($row['apPoint']) ?></td>
						<td class="table-item-str"><?php echo $row['apBenefits'] ?></td>
						<td class="table-item-str"><?php echo $row['buyway'] ?></td>
						<td class="table-item-str"><?php echo $row['apReferrerChannel'] ?></td>
					</tr>
				<?php endforeach?>
			</tbody>
		</table>
		<br/><br/>
		<div class="center">
			<? if( $count > 15)  :?>
				선택된 행을
				<select name="changeProcess" class="js-stateSelect">
					<? foreach ($changeState as $key => $val) : ?>				
						<option value="<?echo $key?>"><?echo $val?></option>
					<?endforeach?>
				</select>
				상태로 
				<br/>		
				<input type="submit" class="btn-filled-sub-dense" data-action="productOrderListAction.php" value="적용"/>
				<input type="submit" class="btn-filled-primary-dense" data-action="productOrderListDelete.php" value="취소"/>
				<input type="submit" class="btn-filled-primary-dense" data-action="productOrderListDeleteRestore.php" value="취소복구"/>
				<br/><br/>					
				<button class="btn-filled-sub-dense" data-action="productOrderListDownload.php">체크된 사전예약자 엑셀다운로드</button>
			<?endif?>	
		</div>
	</form>
</div>
<script>

$(function(){
	<?php if($_GET['deviceFilter'] != '신청기기'): ?>
		$(".deviceFilter>option[value="+"<?php echo $_GET['deviceFilter'] ?>"+"]").prop('selected', true);
	<?php endif ?>
});

$('.js-tableChk').change(function(){
	if (this.checked == true)
		$(this).parents('tr').addClass('active');
	else
		$(this).parents('tr').removeClass('active');

});

$('.js-tableAllChk').change(function(){
	$('.js-tableChk').prop("checked", this.checked);
	$('.js-tableChk').trigger('change');
	if (this.checked == true)
		$('.js-tableChk').parents('tr').addClass('active');
	else
		$('.js-tableChk').parents('tr').removeClass('active');

});

$('.js-stateSelect').change(function(){
	$('.js-stateSelect').val($(this).val());

});

$('.js-trackingNum').change(function(){
	$(this).parents('tr').find('.js-tableChk').prop('checked', true);
	$('.js-trackingNum').each(function(){
		var checkedParent = $('.js-tableChk:checked').parents('tr');
			checkedParent	.addClass('active');		
	});

   });

$('.apIsSpot_radio').change(function(){
	var $val = $(this).val();
	$(this).removeAttr('checked');
	$('.inp-chk-dense input[value='+$val+']').prop('checked', true);
});

$('form[method=get]').change(function(){
	$('form[method=get]').submit();
})

</script>