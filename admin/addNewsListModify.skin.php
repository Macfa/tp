<form method="post" action="addNewsListModifyAction.php" enctype="multipart/form-data">
	<h1 class="center tit"><?echo $newsInfo['neTit']?> </h1>		
	<div class="wrap">
		<input type="hidden" name="neKey" value="<?php echo $newsInfo['neKey']?>">
		<input type="hidden" name="neThumb" value="<?php echo $newsInfo['neThumb']?>">
		<table class="table newsListModify">	
			<tbody>
				<tr>
					<td><?php echo $newsInfo['neKey']?></td>
					<td class="thumbModify"><img src="<?php echo $thumbImg?>"/></td>
					<td class="center">썸네일 변경</td>
					<td><input type="file" name="neThumbModify"></td>								
				</tr>
				<tr>
					<td colspan="2" class="center">타이틀</td>
					<td colspan="2"><input type="text" name="neTit" value="<?php echo $newsInfo['neTit']?>" size="80"></td>								
				</tr>
				<tr>
					<td colspan="2" class="center">서브카피</td>
					<td colspan="2"><input type="text" name="neSubTit" value="<?php echo $newsInfo['neSubTit']?>" size="80"></td>		
				</tr>
				<tr>					
					<td colspan="2" class="center">정보URL</td>
					<td colspan="2"><input type="text" name="neUrl" value="<?php echo $newsInfo['neUrl']?>" size="80"></td>
											
				</tr>
				<tr>
					<td colspan="2" class="center">진열상태</td>	
					<td>
						<fieldset class="inp-group border-none" data-default="<?echo $newsInfo['neDisplay']?>">						
							<label class="inp-chk">
								<input type="radio" name="neDisplayModify" class="neDisplayModify" value="1" />
								<div class="inp-chk-box"></div>
								진열
							</label>
							<label class="inp-chk">
								<input type="radio" name="neDisplayModify" class="neDisplayModify" value="0"/>
								<div class="inp-chk-box"></div>
								진열안함
							</label>
						</fieldset>
					</td>													
				</tr>
				<tr>
					<td colspan="2" class="center">선택된 카테고리</td>	
					<td>
						<fieldset class="inp-group border-none" data-default="<?echo $category?>">	
							<?php foreach ($array as $key => $val) :?>												
								<label class="inp-chk" >
									<input type="checkbox" name="selectedCategory[]" class="selectedCategory" date-val=<?echo $key?> value="<?echo $val?>" />
									<div class="inp-chk-box"></div>
									<?echo $val?>
								</label>						
							<?php endforeach ?>
						</fieldset>
					</td>													
				</tr>
				<tr>
					<td colspan="4" class="center"><h2>추가 카테고리</h2></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td class="center">
						<select name="ncDevice" class="js-device">
							<option value="">기기선택</option>
							<? foreach ($deviceDisplay as $val) : ?>	
								<option value="<?echo $val['dvId']?>"><?echo $val['dvTit']?></option>
							<?endforeach?>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2" class="center">추가선택기기</td>
					<td colspan="2" class="col-cont-wrap js-deviceList" style="height:auto;">
					</td>
				</tr>				
				<tr>
					<td colspan="2" class="center">추가카테고리</td>	
					<td colspan="2">
						<fieldset class="inp-group border-none" data-default="<?echo $category?>">						
							<label class="inp-chk">
								<input type="checkbox" name="ncCategoryModify[]" class="ncCategoryModify" value="sk" />
								<div class="inp-chk-box"></div>
								SK
							</label>
							<label class="inp-chk">
								<input type="checkbox" name="ncCategoryModify[]" class="ncCategoryModify" value="kt"/>
								<div class="inp-chk-box"></div>
								KT
							</label>
							<label class="inp-chk">
								<input type="checkbox" name="ncCategoryModify[]" class="ncCategoryModify" value="lguplus"/>
								<div class="inp-chk-box"></div>
								LG
							</label>							
							<label class="inp-chk">
								<input type="checkbox" name="ncCategoryModify[]" class="ncCategoryModify" value="pocketfi" />
								<div class="inp-chk-box"></div>
								휴대용와이파이
							</label>
							<label class="inp-chk">
								<input type="checkbox" name="ncCategoryModify[]" class="ncCategoryModify" value="watch"/>
								<div class="inp-chk-box"></div>
								스마트워치
							</label>
							<label class="inp-chk">
								<input type="checkbox" name="ncCategoryModify[]" class="ncCategoryModify" value="kids"/>
								<div class="inp-chk-box"></div>
								키즈폰
							</label>
							<br/>
							<label class="inp-chk">
								<input type="checkbox" name="ncCategoryModify[]" class="ncCategoryModify" value="samsung" />
								<div class="inp-chk-box"></div>
								samsung
							</label>
							<label class="inp-chk">
								<input type="checkbox" name="ncCategoryModify[]" class="ncCategoryModify" value="apple"/>
								<div class="inp-chk-box"></div>
								apple
							</label>
							<label class="inp-chk">
								<input type="checkbox" name="ncCategoryModify[]" class="ncCategoryModify" value="lg"/>
								<div class="inp-chk-box"></div>
								lg
							</label>
							<label class="inp-chk">
								<input type="checkbox" name="ncCategoryModify[]" class="ncCategoryModify" value="etc"/>
								<div class="inp-chk-box"></div>
								기타
							</label>
						</fieldset>
					</td>			
				</tr>				
			</tbody>
		</table>
		<br/>
		<div class="center">
			<input type="submit" value="수정하기" class="btn-filled-primary-dense">
			<a href="addNewsList.php" class="btn-filled-primary-dense">목록으로</a>
		</div>
	</div>
</form>


<script>

$('.js-device').change(function(){

	$('.js-devicewrap').show();

	var $dvId = $(this).val();
	var $dvTit = $(this).children("option:selected").text();
	var $labelSize = $('.js-deviceList').find('label').size();
	

	if($('input[value='+$dvId+']').size() == 0 && $dvId != null){
		
		$('.js-deviceList').append('<label class="inp-chk"><input type="checkbox" name="ncDeviceList[]" value='+$dvId+' class="js-deviceInput"><div class="inp-chk-box"></div>'+$dvTit+'</label>');	
		$('.js-deviceInput').prop('checked',true);

		if(($labelSize % 5) === 0 ){
			$('.js-deviceList').append('<br/>');
		}
	}

	$('.js-reset').click(function(){
		$('.js-deviceInput').prop('checked',false);
		$('.js-deviceList').children('label').remove();
		$('.js-devicewrap').hide();			
	});

});

console.log($('input[date-val=5]'));

	

</script>