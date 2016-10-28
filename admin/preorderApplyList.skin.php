<div class="wrap applyList-wrap">	
	<h1 class="center tit">V20 사전예약 리스트</h1>	
	<form method="get">
	<div class="center">
	<select name="searchState">
		<? foreach ($state as $key => $val) :?>
		<option value="<? echo $key?>"><? echo $val ?></option>
		<? endforeach?>
	</select>
	<input type="text" name="search" value=<? echo $search ?>><input type="submit" value="검색">
	</div>
	</form>
	<br/><br/>
	<form method="post">
	<table class="table">
	<thead>
		<tr>
			<td class="chk-wrap">
				<label class="inp-chk">
					<input type="checkbox" class="js-tableAllChk" value="<?php echo $row['pvKey']?>"/>
					<div class="inp-chk-box">
					</div>
				</label>
			</td>
			<td class="table-item-str preorder">타임스탬프</td>
			<td class="table-item-str">현재통신사</td>
			<td class="table-item-str">가입유형</td>
			<td class="table-item-str">신청한 통신사</td>
			<td class="table-item-str">색 상</td>
			<td class="table-item-str">선택요금제</td>
			<td class="table-item-str">예약자명</td>
			<td class="table-item-str">생년월일</td>
			<td class="table-item-str">성별</td>
			<td class="table-item-str">전화번호</td>
			<td class="table-item-str">이메일</td>
			<td class="table-item-str">진행상황</td>
			<td class="table-item-str">취소상태</td>
		</tr>
	</thead>	
	<tbody>
		<? foreach($existList as $row) : ?>
		<tr class="js-cartRow<?php echo $row['pvKey']?>" <?php echo $row['cancelClass']?>>
			<td class="chk-wrap">
				<label class="inp-chk">
					<input type="checkbox" class="js-tableChk" value="<?php echo $row['pvKey']?>" name="chk[]" ?>
					<div class="inp-chk-box"></div>
				</label>
			</td>			
			<td class="table-item-str"><?php echo $row['pvDatetime'] ?></td>
			<td class="table-item-str"><?php echo $row['pvCurrent'] ?></td>
			<td class="table-item-str"><?php echo $type[$row['pvApplyType']] ?></td>
			<td class="table-item-str"><?php echo $row['pvChangeCarrier'] ?></td>
			<td class="table-item-str"><?php echo $row['pvColorType'] ?></td>
			<td class="table-item-str"><?php echo (isExist($plan[$row['pvPlan']]))?$plan[$row['pvPlan']]:$row['pvPlan'] ?></td>
			<td class="table-item-str"><?php echo $row['pvName'] ?></td>
			<td class="table-item-str"><?php echo $row['pvBirth'] ?></td>
			<td class="table-item-str"><?php echo $sex [$row['pvSexType']] ?></td>
			<td class="table-item-str"><?php echo $row['pvPhone'] ?></td>
			<td class="table-item-str"><?php echo $row['pvEmail'] ?></td>
			<td class="table-item-str"><?php echo $state[$row['pvProcess']] ?></td>
			<td class="table-item-str"><?php echo $cancel[$row['pvCancel']] ?></td>
		</tr>
	<?php endforeach?>
	
	</tbody>
	</table>
	
	
		<div class="center">
		선택된 행을
			<select name="changeProcess">
				<? foreach ($changeState as $key => $val) : ?>				
				<option value="<?echo $key?>"><?echo $val?></option>
				<?endforeach?>
			</select>
		상태로 
		<br/>
		<input type="submit" class="btn-filled" data-action="preorderApplyListAction.php" value="적용"/>
		<input type="submit" class="btn-filled" data-action="preorderApplyListDelete.php" value="취소"/>
		<input type="submit" class="btn-filled" data-action="preorderApplyListDeleteRestore.php" value="취소복구"/>
		
	</form>
	</div>
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
</script>