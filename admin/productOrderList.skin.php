<div class="wrap applyList-wrap">
	<h1 class="center tit"><?echo $preorderTitle?> 일반신청 리스트 </h1>	
	<h2 class="center sub">조회된 구매자 : <?echo $count?> 명 </h2>	
	
	<div class="center">
		<form method="get">
			<input type="text" name="search" value=<? echo $search ?>>
				<input type="submit" value="검색" ><label class="inp-chk" >
				<input type="checkbox" class="js-tableChk" value="canceled" name="chked">
				<div class="inp-chk-box" ></div>취소한 예약자
			</label>	
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
			<!--<br/>
			<input type="submit" class="btn-filled" data-action="preorderTrackingNum.php" value="송장번호입력"/>-->
			<br/><br/>
			<!--
			<?if (isExist($downloadFullUrl)):?>
				<button class="btn-filled-sub-dense" data-action="<?echo $downloadFullUrl ?>">조회된 사전예약자 엑셀 다운로드</button>
			<?endif?>
			-->
			<button class="btn-filled-sub-dense" data-action="productOrderListDownload.php">체크된 사전예약자 엑셀다운로드</button>			
		</div>
		<br/>
		<table class="table">
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
					<td class="table-item-str">신청기기</td>
					<td class="table-item-str">신청모델명</td>						
					<td class="table-item-str">구매자명</td>
					<td class="table-item-str">연락처</td>						
					<td class="table-item-str">신청한 통신사</td>
					<td class="table-item-str">가입유형</td>
					<td class="table-item-str">할인유형</td>
					<td class="table-item-str">현재통신사</td>
					<td class="table-item-str">요금제</td>
					<td class="table-item-str">색 상</td>
					<td class="table-item-str">지급포인트</td>
					<td class="table-item-str">취소상태</td>
					<td class="table-item-str table-dense">타임스탬프</td>
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
						<input type="hidden" name="dvKey" value="<?echo $row['dvKey']?>">
						<input type="hidden" name="plan" value="<?echo $row['dvKey']?>">
						<input type="hidden" name="carrier" value="<?echo $row['dvKey']?>">
						<input type="hidden" name="applyType" value="<?echo $row['dvKey']?>">
						<input type="hidden" name="discountType" value="<?echo $row['dvKey']?>">
						<input type="hidden" name="apType" value="<?echo $row['dvKey']?>">
						<td class="table-item-str"><?php echo $changeState[$row['apProcess']] ?></td>
						<td class="table-item-str"><?php echo $dvTitList[$key] ?></td>
						<td class="table-item-str"><?php echo $dvModelCode[$key] ?></td>							
						<td class="table-item-str"><?php echo $mbName[$key] ?></td>
						<td class="table-item-str"><?php echo $mbPhone[$key] ?></td>
						

						<td class="table-item-str"><?php echo $row['apChangeCarrier'] ?></td>	
						<td class="table-item-str"><?php echo $type[$row['apApplyType']] ?></td>
						<td class="table-item-str"><?php echo $discount[$row['apDiscountType']] ?></td>					
						<td class="table-item-str"><?php echo $row['apCurrentCarrier'] ?></td>
						<td class="table-item-str"><?php echo $arrPlan[$key] ?></td>

						<td class="table-item-str"><?php echo $row['apColor'] ?></td>
						<td class="table-item-str"><?php echo number_format($row['apPoint']) ?></td>
						<td class="table-item-str"><?php echo $cancel[$row['apCancel']] ?></td>
						<td class="table-item-str"><?php echo $row['apDatetime'] ?></td>
						
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

$(function() {
	$('[data-default]').each(function(){		
		if($(this).find('input[type=checkbox]').size()>0){
			$(this).find('[value='+$(this).attr('data-default')+']').prop('checked', true);
		} else
			$(this).val($(this).attr('data-default'));
	});
});

$('.js-trackingNum').change(function(){
	$(this).parents('tr').find('.js-tableChk').prop('checked', true);
	$('.js-trackingNum').each(function(){
		var checkedParent = $('.js-tableChk:checked').parents('tr');
			checkedParent	.addClass('active');		
	});

   });
</script>