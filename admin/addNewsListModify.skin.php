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
					<td colspan="2">
						<fieldset class="inp-group border-none selectedWrap" data-default="<?echo $category?>">	
							<?php foreach ($array as $key => $val) :?>												
								<label class="inp-chk" data-key = "<?echo $k?>">
									<input type="checkbox" name="selectedCategory[]" class="selectedCategory js-category" data-key="<?echo $key?>" value="<?echo $val?>" />
									<div class="inp-chk-box"></div>
									<?echo $val?>
								</label>
								<?php $k++; if(($k % 5) === 0) : // 카테고리가 5개 단위로 가로정렬 ?> 
									<br/>						
								<?php endif?>
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
					<td colspan="2" class="center">추가카테고리</td>	
					<td colspan="2">
						<fieldset class="inp-group border-none" class="addCategoryWrap" >						
							<label class="inp-chk">
								<input type="checkbox" name="categoryModify[]" class="categoryModify js-addCategory" value="sk" />
								<div class="inp-chk-box"></div>
								SK
							</label>
							<label class="inp-chk">
								<input type="checkbox" name="categoryModify[]" class="categoryModify js-addCategory" value="kt"/>
								<div class="inp-chk-box"></div>
								KT
							</label>
							<label class="inp-chk">
								<input type="checkbox" name="categoryModify[]" class="categoryModify js-addCategory" value="lguplus"/>
								<div class="inp-chk-box"></div>
								LG
							</label>							
							<label class="inp-chk">
								<input type="checkbox" name="categoryModify[]" class="categoryModify js-addCategory" value="pocketfi" />
								<div class="inp-chk-box"></div>
								휴대용와이파이
							</label>
							<label class="inp-chk">
								<input type="checkbox" name="categoryModify[]" class="categoryModify js-addCategory" value="watch"/>
								<div class="inp-chk-box"></div>
								스마트워치
							</label>
							<label class="inp-chk">
								<input type="checkbox" name="categoryModify[]" class="categoryModify js-addCategory" value="kids"/>
								<div class="inp-chk-box"></div>
								키즈폰
							</label>
							<br/>
							<label class="inp-chk">
								<input type="checkbox" name="categoryModify[]" class="categoryModify js-addCategory" value="samsung" />
								<div class="inp-chk-box"></div>
								samsung
							</label>
							<label class="inp-chk">
								<input type="checkbox" name="categoryModify[]" class="categoryModify js-addCategory" value="apple"/>
								<div class="inp-chk-box"></div>
								apple
							</label>
							<label class="inp-chk">
								<input type="checkbox" name="categoryModify[]" class="categoryModify js-addCategory" value="lg"/>
								<div class="inp-chk-box"></div>
								lg
							</label>
							<label class="inp-chk">
								<input type="checkbox" name="categoryModify[]" class="categoryModify js-addCategory" value="etc"/>
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


////////////////// 선택된 카테고리 

$(document).on("change", '.js-category', function(){ // 선택된 카테고리 변경시
	var dataKey = $(this).attr('data-key');
	var value = $(this).val();
	var deletedDatakey = $('.deletedCategory[value='+value+']').attr('data-key');
	var deletedCategory = $('.deletedCategory[value='+value+']').size();

	//선택된 카테고리 제외했을때..
	if($(this).prop('checked') === false) {
		$(this).parent('.inp-chk').remove();
		$('.selectedWrap').append('<input type="hidden" class="deletedCategory" name="deletedCategory[]" data-key='+dataKey+' value='+value+'>');
		$('.js-addCategory[value='+value+']').prop('checked',false);
	}

});

function deleteCategory(dvId,deletedDatakey,dvTit){
	// 지운 input 정보 불러오기
	$('.selectedWrap').append('<label class="inp-chk"><input type="checkbox" name="selectedCategory[]" value='+dvId+' class="selectedCategory js-category" data-key='+deletedDatakey+'><div class="inp-chk-box"></div>'+dvTit+'</label>');
	// input 체크 true
	$('.js-category[value='+dvId+']').prop('checked',true);

	// 지운정보들 있는 input 지우기
	$('.deletedCategory[value='+dvId+']').remove();
}


//////////////////추가 선택기기 

// 추가된 기기는 제외하고 나머지 input 추가하기
$('.js-device').change(function(){ // select 선택기기 변경시	

	var dvId = $(this).val();
	var dvTit = $(this).children("option:selected").text();
	var labelSize = $('.selectedWrap').find('label').size();
	var deletedCategory = $('.deletedCategory[value='+dvId+']').size();	
	var deletedDatakey = $('.deletedCategory[value='+dvId+']').attr('data-key');
	
	// 중복된 기기가 없을때 기기추가
	if($('.js-category[value='+dvId+']').size() === 0 && deletedCategory === 0 ){ 

		$('.selectedWrap').append('<label class="inp-chk"><input type="checkbox" name="deviceModify[]" value='+dvId+' class="js-deviceInput js-category"><div class="inp-chk-box"></div>'+dvTit+'</label>');	
		$('.js-deviceInput').prop('checked',true);

		// 추가하면서 5개 정렬
		if((labelSize % 5) === 0 ){ 
			$('.selectedWrap').append('<br/>');			
		}


	// 삭제된 데이터가 있을때	
	}else if(deletedCategory > 0){ 

		deleteCategory(dvId,deletedDatakey,dvTit);
	}
});




//////////////////추가 카테고리

$(document).on("change", '.js-addCategory', function(){
	var value = $(this).val();
	var deletedDatakey = $('.deletedCategory[value='+value+']').attr('data-key');
	var deletedCategory = $('.deletedCategory[value='+value+']').size();
	var selectedCategory = $('.js-category[value='+value+']').size();

	//선택된 카테고리 중 삭제한 카테고리가 있을때
	if(deletedCategory > 0 ){ 
		deleteCategory(value,deletedDatakey,value);
		$('.js-addCategory[value='+value+']').prop('checked',false);		

	//선택된 카테고리에 추가 되어있을때
	}else if(selectedCategory === 1){
		$('.js-addCategory[value='+value+']').prop('checked',false);
				
	}

});
	
// 선택된 카테고리 없을때 체크박스 없앰
if($('.js-category').val() === '선택된 카테고리 없음'){ 
	$('.js-category').next().remove('.inp-chk-box');	
}
</script>