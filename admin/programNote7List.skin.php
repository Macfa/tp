<div class="wrap applyList-wrap">	
	<h1 class="center tit">갤럭시노트7 구제 프로그램 리스트 </h1>	
	<h2 class="center sub">조회된 신청자 : <?echo $count?> 명 </h2>	

	<div class="center">	
		<form method="get">
		<!--
			<select name="serchProcess" data-default="<?echo $_GET['serchProcess']?>">
				<option value="">선택</option>
				<? foreach ($process as $key => $val) : ?>				
					<option value="<?echo $key?>"><?echo $val?></option>
				<?endforeach?>
			</select>
		-->
			<input type="text" name="search" value=<? echo $search ?>>
			<input type="submit" value="검색" >
		</form>			
	</div>

	<br/>

	<form method="post">
		<div class="center">			
		<!--
			선택된 행을
			<select name="changeProcess">
				<? foreach ($process as $key => $val) : ?>				
					<option value="<?echo $key?>"><?echo $val?></option>
				<?endforeach?>
			</select>
				상태로 	
		-->
		선택된 행을
			<input type="hidden" value="<?echo $searchDevice?>" name="hidden">
			<input type="submit" class="btn-filled-sub-dense" data-action="programNote7ListDelete.php" value="취소"/>
			<br/><br/>		
			<?if(isExist($_GET['search']) === True) :?>
				<button class="btn-filled-sub-dense" data-action="<?echo $downloadFullUrl ?>">조회된 신청자 엑셀다운로드</button>
			<?endif?>
			<button class="btn-filled-sub-dense" data-action="programNote7ListDownload.php">신청자 엑셀다운로드</button>
		</div>
		<br/>

		<table class="table">
			<thead>
				<tr class="">
					<td class="chk-wrap">
						<label class="inp-chk">
							<input type="checkbox" class="js-tableAllChk" value="<?php echo $row['tnKey']?>"/>
							<div class="inp-chk-box">
							</div>
						</label>
					</td>
					<td class="table-item-str preorder">타임스탬프</td>
					<td class="table-item-str">신청자명</td>
					<td class="table-item-str">전화번호</td>
					<td class="table-item-str">이메일</td>
					<td class="table-item-str">티플에서 구매여부</td>
					<td class="table-item-str">현재통신사</td>
					<td class="table-item-str">가입유형</td>
					<td class="table-item-str">취소여부</td>
				</tr>
			</thead>	
			<tbody>
				<? foreach($existList as $row) : ?>
					<tr class="js-cartRow<?php echo $row['tnKey']?>" <?php echo $row['processClass']?>>
						<td class="chk-wrap">
							<label class="inp-chk">
								<input type="checkbox" class="js-tableChk" value="<?php echo $row['tnKey']?>" name="chk[]" ?>
								<div class="inp-chk-box"></div>
							</label>
						</td>			
						<td class="table-item-str preorder"><?php echo $row['tnDateTime'] ?></td>
						<td class="table-item-str"><?php echo $row['mbName'] ?></td>
						<td class="table-item-str"><?php echo $row['mbPhone'] ?></td>
						<td class="table-item-str"><?php echo $row['tnEmail'] ?></td>
						<td class="table-item-str"><?php echo $buy[$row['isBuyTplanitNote7']] ?></td>
						<td class="table-item-str"><?php echo $row['tnCurrentCarrier'] ?></td>
						<td class="table-item-str"><?php echo $type[$row['tnApplyType']] ?></td>
						<td class="table-item-str"><?php echo $cancel[$row['tnCancel']]?></td>
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