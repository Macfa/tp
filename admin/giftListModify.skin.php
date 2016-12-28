<form method="post" action="giftListModifyAction.php" enctype="multipart/form-data">
	<h1 class="center tit"><?echo $giftInfo['gfTit']?> </h1>		
	<div class="wrap center">
		<input type="hidden" name="gfKey" value="<?php echo $giftInfo['gfKey']?>">
		<input type="hidden" name="gfThumb" value="<?php echo $giftInfo['gfThumb']?>">		
		<table class="table giftListModify">	
			<tbody>
				<tr>
					<td><?php echo $giftInfo['gfKey']?></td>
					<td class="gfThumb"><img src="<?php echo $gfThumb?>"/></td>
					<td>썸네일 변경</td>
					<td><input type="file" name="gfThumbModify"></td>								
				</tr>
				<tr>
					<td><?php echo $display[$giftInfo['gfDisplay']]?></td>	
					<td><input type="text" name="gfTit" value="<?php echo $giftInfo['gfTit']?>"></td>
					<td><input type="text" name="gfSubTit" value="<?php echo $giftInfo['gfSubTit']?>"></td>
					<td><input type="text" name="gfPoint" value="<?php echo $giftInfo['gfPoint']?>"></td>					
				</tr>
				<tr>					
					<td>
						<fieldset class="inp-group" data-default="<?echo $giftInfo['gfDisplay']?>">						
							<label class="inp-chk">
								<input type="radio" name="gfDisplayModify" class="gfDisplayModify" value="1" />
								<div class="inp-chk-box"></div>
								진열
							</label>
							<label class="inp-chk">
								<input type="radio" name="gfDisplayModify" class="gfDisplayModify" value="0"/>
								<div class="inp-chk-box"></div>
								진열안함
							</label>
						</fieldset>
					</td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</tbody>
		</table>
		<br><Br/>
		<section class="detailImageArea">
			<div class="tit center">상세페이지	</div>
			<ul class="sortable-grid sortable-main">								
				<?php $i = 1; foreach($arrfileInfo as $fileInfo) :?>					
					<?php if(isExist($fileInfo['tag']) === true) : ?>
						<li class="ui-state-default">							
							<span class="img-delete js-delete">삭제</span>
							<span class="img-wrap">
							<?php echo "<span class='tit-sub'>".$i."</span>" ?>
							<?php echo $fileInfo['tag']?></span>
							<input type="hidden" value="<?php echo $fileInfo['name']?>" name="detailImage[]"/>
						</li>						
					<?php endif ?>
				<?php  $i++; endforeach; ?>
				
			</ul>
			<br/>					
			<span class="img-delete js-addImg">추가</span>
		</section>
		<br><Br/>
		<input type="submit" value="수정하기" class="btn-filled-primary-dense">
		<a href="giftList.php" class="btn-filled-primary-dense">목록으로</a>
	</div>

    
</form>




<script>
$(function() {
	require([ 
		'jquery-ui.min'
	], function (jqueryui) {
		$(".sortable-grid").sortable();
		$(".sortable-grid").disableSelesction();
	});
});

$('.js-delete').click(function(){

	var $parentList = $(this).parent('li');	

	$parentList.hide();
	$parentList.find('.img-wrap').hide();
	$parentList.find('input').attr('disabled', 'disabled');

});

$(function() {
	$('[data-default]').each(function(){		
		//console.log($(this).attr('data-default'));		
		if($(this).find('input[type=radio]').size() > 0){
			var $mutipleValue = $(this).attr('data-default').split(',');
			var $target = $(this);
			$.each($mutipleValue, function(index, value){
				console.log();
				$target.find('[value='+value+']').prop('checked', true);				
			});
		} else 
			$(this).val($(this).attr('data-default'));
		
	});
	
});

$('.js-addImg').click(function(){

	$('.sortable-grid').append( '<li class="ui-state-default"><input type="file" name="detailAddImg[]" onchange="readURL(this);"/><img id="blah" src="#" /><input type="hidden" value="" name="detailImage[]"/></li>');


});

  function readURL(input) {
            if (input.files && input.files[0]) {            	
                var reader = new FileReader();
                reader.onload = function (e) {                	

                	$(input).next('#blah').attr('src', e.target.result);                    
                }
                reader.readAsDataURL(input.files[0]);
            }
        }


/*


*/
</script>