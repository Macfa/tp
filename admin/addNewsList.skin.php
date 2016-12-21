<div class="wrap">
	<h1 class="center tit">정보글리스트</h1>	
	<!--
	<form method="get" class="center">
		<select name="display" data-default="<?echo $_GET['display']?>">
			<option value="">핸드폰</option>
			<? foreach ($display as $key => $val) :?>		
				<option value="<? echo $key ?>"><? echo $val ?></option>
			<? endforeach?>
		</select>&nbsp;&nbsp;<input type="text" name="search" value=<? echo $search ?>>
			<input type="submit" value="검색" >
	</form>
	<Br/><Br/>	
	-->
	<form method="post">
		<input type="submit" class="btn-filled-primary-dense" data-action="addNewsListDisplay.php" value="진열함"/>
		<input type="submit" class="btn-filled-primary-dense" data-action="addNewsListHidden.php" value="진열안함"/>	
		<br/><br/>
		<table class="table deviceList">	
			<thead>
				<tr class="tit-sub">	
					<td class="chk-wrap">
						<label class="inp-chk">
							<input type="checkbox" class="js-tableAllChk" value="<?php echo $val['neKey']?>"/>
							<div class="inp-chk-box">
							</div>
						</label>
					</td>	
					<td></td>	
					<td>썸네일</td>
					<td>타이틀</td>
					<td>서브타이틀</td>
					<td>URL</td>					
					<td>진열상태</td>					
				</tr>
			</thead>
			<tbody>	
				<?php foreach ($result as $val) :?>								
						<tr>
							<td class="chk-wrap">
								<label class="inp-chk">
									<input type="checkbox" class="js-tableChk" value="<?php echo $val['neKey']?>" name="chk[]" ?>
									<div class="inp-chk-box"></div>
								</label>
							</td>
							<td ><?php echo $val['neKey'] ?></td>
							<td class="listThumb"><img src="<?php echo $neThumb[$val['neKey']]?>"/></td>			
							<td class="listTitLink"><a href="addNewsListModify.php?neKey=<?php echo $val['neKey']?>"><?php echo $val['neTit']?></a></td>
							<td ><?php echo $val['neSubTit']?></td>	
							<td ><?php echo $val['neUrl']?></td>
							<td ><?php echo $display[$val['neDisplay']]?></td>	
						</tr>					
				<?php endforeach?>
			</tbody>	
		</table>
		<br/><br/>
		<input type="submit" class="btn-filled-primary-dense" data-action="addNewsListDisplay.php" value="진열함"/>
		<input type="submit" class="btn-filled-primary-dense" data-action="addNewsListHidden.php" value="진열안함"/>
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

