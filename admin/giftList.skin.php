<div class="wrap">
	<h1 class="center tit">사은품목록</h1>	
	<form method="get" class="center">
		<select name="display" data-default="<?echo $_GET['display']?>">
			<option value="">사은품</option>
			<? foreach ($display as $key => $val) :?>		
				<option value="<? echo $key ?>"><? echo $val ?></option>
			<? endforeach?>
		</select>&nbsp;&nbsp;<input type="text" name="search" value=<? echo $search ?>>
			<input type="submit" value="검색" >
	</form>
	<Br/><Br/>	
	<form method="post">
		<input type="submit" class="btn-filled-primary-dense" data-action="giftListDisplay.php" value="진열함"/>
		<input type="submit" class="btn-filled-primary-dense" data-action="giftListHidden.php" value="진열안함"/>	
		<input type="submit" class="btn-filled-primary-dense" data-action="giftListDelete.php" value="삭 제"/>
		<br/><br/>
		<table class="table giftList">	
			<thead>
				<tr class="tit-sub">	
					<td class="chk-wrap">
						<label class="inp-chk">
							<input type="checkbox" class="js-tableAllChk" value="<?php echo $val['gfKey']?>"/>
							<div class="inp-chk-box">
							</div>
						</label>
					</td>
					<td></td>
					<td>썸네일</td>		
					<td>제 목</td>
					<td>서브카피</td>
					<td>포인트</td>			
					<td>사은품 진열</td>	
				</tr>
			</thead>
			<tbody>	
			<?php foreach ($giftInfo as $val) :?>	
				<tr>
					<td class="chk-wrap">
						<label class="inp-chk">
							<input type="checkbox" class="js-tableChk" value="<?php echo $val['gfKey']?>" name="chk[]" ?>
							<div class="inp-chk-box"></div>
						</label>
					</td>
					<td><?php echo $val['gfKey']?></td>
					<td class="gfThumb"><img src="<?php echo $gfThumb[$val['gfKey']]?>"/></td>		
					<td class="gfKey"><a href="giftListModify.php?gfKey=<?php echo $val['gfKey']?>"><?php echo $val['gfTit']?></a></td>
					<td><?php echo $val['gfSubTit']?></td>
					<td><?php echo $val['gfPoint']?></td>		
					<td><?php echo $display[$val['gfDisplay']]?></td>	
				</tr>		
			</tbody>
		<?php endforeach?>
		</table>
		<br/><br/>
		<input type="submit" class="btn-filled-primary-dense" data-action="giftListDisplay.php" value="진열함"/>
		<input type="submit" class="btn-filled-primary-dense" data-action="giftListHidden.php" value="진열안함"/>
		<input type="submit" class="btn-filled-primary-dense" data-action="giftListDelete.php" value="삭 제"/>
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
</script>

