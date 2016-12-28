<div class="wrap">	
	<h1 class="center tit">포인트 히스토리 리스트</h1>	
	<form method="get">
	<div class="center">	
	<!--<input type="text" name="search"><input type="submit" value="검색">-->
	</div>	
	<br/><br/>
	</form>
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
			<td class="table-item-str">회원이름</td>
			<td class="table-item-str">전화번호</td>
			<td class="table-item-str">컨텐츠</td>
			<td class="table-item-str">포인트지급</td>
			<td class="table-item-str">포인트결과</td>
			<td class="table-item-str">날짜</td>
		</tr>
	</thead>	
	<tbody>
		<? foreach($existList as $row) : ?>
		<?php if(isExist($row['mbEmail']) === true AND $row['phAmount'] != 0) :?>
		<tr class="js-cartRow<?php echo $row['mbKey']?>">
			<td class="chk-wrap">
				<label class="inp-chk">
					<input type="checkbox" class="js-tableChk" value="<?php echo $row['mbKey']?>" name="chk[]" ?>
					<div class="inp-chk-box"></div>
				</label>
			</td>			
			<td class="table-item-str"><?php echo $row['mbName'] ?></td>
			<td class="table-item-str"><?php echo $row['mbPhone'] ?></td>
			<td class="table-item-str"><?php echo $row['phCont'] ?></td>
			<td class="table-item-str"><?php echo $row['phAmount'] ?></td>
			<td class="table-item-str"><?php echo number_format($row['phResult']) ?></td>		
			<td class="table-item-str"><?php echo $row['phDate']?></td>
		</tr>

		<?endif?>


	<?php endforeach?>
	
	</tbody>
	</table>
	

	</div>
</div>


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