<div class="wrap">	
	<h1 class="center tit">멤버 리스트</h1>	
	<form method="get">
	<div class="center">	
	<input type="text" name="search"><input type="submit" value="검색">
	</div>	
	<br/><br/>
	<table class="table">
	<thead>
		<tr>
			<td class="chk-wrap">
				<label class="inp-chk">
					<input type="checkbox" class="js-tableAllChk" value="<?php echo $row['mbKey']?>"/>
					<div class="inp-chk-box">
					</div>
				</label>
			</td>
			<td class="table-item-str">회원이메일</td>
			<td class="table-item-str">회원이름</td>
			<td class="table-item-str">전화번호</td>
			<td class="table-item-str">현재포인트</td>
		</tr>
	</thead>	
	<tbody>
		<? foreach($existList as $row) : ?>
		<tr class="js-cartRow<?php echo $row['mbKey']?>">
			<td class="chk-wrap">
				<label class="inp-chk">
					<input type="checkbox" class="js-tableChk" value="<?php echo $row['mbKey']?>" name="chk[]" ?>
					<div class="inp-chk-box"></div>
				</label>
			</td>			
			<td class="table-item-str"><?php echo $row['mbEmail'] ?></td>
			<td class="table-item-str"><?php echo $row['mbName'] ?></td>
			<td class="table-item-str"><?php echo $row['mbPhone'] ?></td>
			<td class="table-item-str"><?php echo number_format($row['mbPoint']) ?></td>		</tr>
	<?php endforeach?>
	
	</tbody>
	</table>
	

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