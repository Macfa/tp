<div class="wrap">
	<h1 class="center tit">기기목록</h1>	
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
	<form method="post">
		<input type="submit" class="btn-filled-primary-dense" data-action="deviceListDisplay.php" value="진열함"/>
		<input type="submit" class="btn-filled-primary-dense" data-action="deviceListHidden.php" value="진열안함"/>	
		<br/><br/>
		<table class="table deviceList">	
			<thead>
				<tr class="tit-sub">	
					<td class="chk-wrap">
						<label class="inp-chk">
							<input type="checkbox" class="js-tableAllChk" value="<?php echo $val['dvKey']?>"/>
							<div class="inp-chk-box">
							</div>
						</label>
					</td>	
					<td></td>	
					<td>썸네일</td>
					<td>기기명</td>
					<td>dvID</td>
					<td>dvParent</td>					
					<td>모델코드</td>					
					<td>제조사</td>					
					<td>진열상태</td>					
				</tr>
			</thead>
			<tbody>	
				<?php foreach ($result as $key => $val) :?>	
					<?php if ($val['dvKey'] >= 636) :?>				
						<tr>
							<td class="chk-wrap">
								<label class="inp-chk">
									<input type="checkbox" class="js-tableChk" value="<?php echo $val['dvKey']?>" name="chk[]" ?>
									<div class="inp-chk-box"></div>
								</label>
							</td>
							<td ><?php echo $val['dvKey'] ?></td>
							<td class="dvThumb"><img src="<?php echo $dvThumb[$val['dvKey']]?>"/></td>			
							<td class="dvTit"><a href="deviceListModify.php?dvKey=<?php echo $val['dvKey']?>"><?php echo $val['dvTit']?></a></td>
							<td ><?php echo $val['dvId']?></td>	
							<td ><?php echo $val['dvParent']?></td>																						
							<td ><?php echo $val['dvModelCode']?></td>	
							<td ><?php echo $val['dvManuf']?></td>	
							<td ><?php echo $display[$val['dvDisplay']]?></td>	
						</tr>
					<?php endif?>
				<?php endforeach?>
			</tbody>	
		</table>
		<br/><br/>
		<input type="submit" class="btn-filled-primary-dense" data-action="deviceListDisplay.php" value="진열함"/>
		<input type="submit" class="btn-filled-primary-dense" data-action="deviceListHidden.php" value="진열안함"/>
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

