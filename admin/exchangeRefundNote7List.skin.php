<div class="wrap applyList-wrap">	
	<h1 class="center tit">갤럭시노트7 교환/환불 리스트 </h1>	
	<h2 class="center sub">조회된 신청자 : <?echo $count?> 명 </h2>	
	<div class="center">
		<form method="get">
			<select name="serchProcess" data-default="<?echo $_GET['serchProcess']?>">
				<option value="">선택</option>
				<? foreach ($process as $key => $val) : ?>				
					<option value="<?echo $key?>"><?echo $val?></option>
				<?endforeach?>
			</select>
			<input type="text" name="search" value=<? echo $search ?>>
			<input type="submit" value="검색" >
		</form>			
	</div>
	<br/>
	<form method="post">
		<div class="center">			
			선택된 행을
			<select name="changeProcess">
				<? foreach ($process as $key => $val) : ?>				
					<option value="<?echo $key?>"><?echo $val?></option>
				<?endforeach?>
			</select>
				상태로 	
				<input type="hidden" value="<?echo $searchDevice?>" name="hidden">
				<input type="submit" class="btn-filled-sub-dense" data-action="exchangeRefundNote7ListAction.php" value="적용"/>
			<br/><br/>				
				<button class="btn-filled-sub-dense" data-action="<?echo $downloadFullUrl ?>">조회된 사전예약자 엑셀 다운로드</button>
				<button class="btn-filled-sub-dense" data-action="exchangeRefundNote7ListDownload.php">체크된 사전예약자 엑셀다운로드</button>
		</div>
		<br/>
		<table class="table">
			<thead>
				<tr class="">
					<td class="chk-wrap">
						<label class="inp-chk">
							<input type="checkbox" class="js-tableAllChk" value="<?php echo $row['enKey']?>"/>
							<div class="inp-chk-box">
							</div>
						</label>
					</td>
					<td class="table-item-str preorder">타임스탬프</td>
					<td class="table-item-str">신청자명</td>
					<td class="table-item-str">전화번호</td>
					<td class="table-item-str">교환/환불</td>
					<td class="table-item-str">진행방법</td>
					<td class="table-item-str">사은품수령</td>
					<td class="table-item-str">신청하신통신사</td>
					<td class="table-item-str">교환하실기기</td>
					<td class="table-item-str">용량</td>
					<td class="table-item-str">색상</td>
					<td class="table-item-str">비상연락처</td>
					<td class="table-item-str">우편번호</td>
					<td class="table-item-str">받으실주소</td>
					<td class="table-item-str">진행상황</td>
				</tr>
			</thead>	
			<tbody>
				<? foreach($existList as $row) : ?>
					<tr class="js-cartRow<?php echo $row['enKey']?>" <?php echo $row['processClass']?>>
						<td class="chk-wrap">
							<label class="inp-chk">
								<input type="checkbox" class="js-tableChk" value="<?php echo $row['enKey']?>" name="chk[]" ?>
								<div class="inp-chk-box"></div>
							</label>
						</td>			
						<td class="table-item-str"><?php echo $row['enDatetime'] ?></td>
						<td class="table-item-str"><?php echo $row['mbName'] ?></td>
						<td class="table-item-str"><?php echo $row['enPhone'] ?></td>
						<td class="table-item-str"><?php echo $type[$row['enApplyType']] ?></td>
						<td class="table-item-str"><?php echo $way[$row['enWay']] ?></td>
						<td class="table-item-str"><?php echo $gift[$row['enReceivedGift']] ?></td>
						<td class="table-item-str"><?php echo $row['enApplyCarrier'] ?></td>
						<td class="table-item-str"><?php echo (isExist($device[$row['enTargetDevice']]))?$device[$row['enTargetDevice']]:$row['enTargetDevice'] ?></td>
						<td class="table-item-str"><?php echo $row['enDeviceCapacity'] ?></td>
						<td class="table-item-str"><?php echo $color[$row['enColorType']] ?></td>
						<td class="table-item-str"><?php echo $row['enSubPhone'] ?></td>
						<td class="table-item-str"><?php echo $row['enPostCode'] ?></td>
						<td class="table-item-str"><?php echo $row['enAddress']." ".$row['enSubAddress'] ?></td>
						<td class="table-item-str"><?php echo $process[$row['enProcess']] ?></td>
					</tr>
				<?php endforeach?>
			</tbody>
		</table>
		<br/><br/>		
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
		if($(this).has(':checkbox').size() > 0){
			$(this).find('[value='+$(this).attr('data-default')+']').prop('checked', true);
		} else
			$(this).val($(this).attr('data-default'));
	});
});
</script>