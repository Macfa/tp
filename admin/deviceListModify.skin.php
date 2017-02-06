<form method="post" action="deviceListModifyAction.php" enctype="multipart/form-data">
	<h1 class="center tit"><?echo $deviceInfo['dvTit']?> </h1>		
	<div class="wrap center">
		<input type="hidden" name="dvKey" value="<?php echo $deviceInfo['dvKey']?>">
		<input type="hidden" name="dvThumb" value="<?php echo $deviceInfo['dvThumb']?>">	
		<input type="hidden" name="dvDetailThumb" value="<?php echo $deviceInfo['dvDetailThumb']?>">		
		<table class="table deviceListModify">	
			<tbody>
				<tr>
					<td><?php echo $deviceInfo['dvKey']?></td>
					<td class="dvThumb"><img src="<?php echo $dvThumb?>"/></td>
					<td>썸네일 변경</td>
					<td><input type="file" name="dvThumbModify"></td>								
				</tr>
				<tr>
					<td></td>
					<td class="dvDetailThumb"><img src="<?php echo $dvDetailThumb?>"/></td>
					<td>디테일썸네일 변경</td>
					<td><input type="file" name="dvDetailThumbModify"></td>								
				</tr>
				<tr>
					<td><?php echo $display[$deviceInfo['dvDisplay']]?></td>		
					<td>
						<fieldset class="inp-group" data-default="<?echo $deviceInfo['dvDisplay']?>">						
							<label class="inp-chk">
								<input type="radio" name="dvDisplayModify" class="dvDisplayModify" value="1" />
								<div class="inp-chk-box"></div>
								진열
							</label>
							<label class="inp-chk">
								<input type="radio" name="dvDisplayModify" class="dvDisplayModify" value="0"/>
								<div class="inp-chk-box"></div>
								진열안함
							</label>
						</fieldset>
					</td>
					<td></td>
					<td></td>								
				</tr>		
				<tr>
					<td>색상</td>
					<fieldset class="inp-group">
						<?php foreach ($deviceCapacityList as $val) : // 기종에 용량이 없을때 ?>
							<td>
								<?echo $val['dvTit'];?>
								<input type="hidden" name="dvKeyChild[]" value="<?echo $val['dvKey']?>">								
								<input type="hidden" name="dcOriginColor[]" value="<?echo $strList[$val['dvKey']]?>">					
								<input type="text" name="dcColor[]" value="<?echo $strList[$val['dvKey']]?>">								
							</td>
						<?endforeach?>
					</fieldset>
					<?php if(empty($deviceCapacityList) === true): // 기종에 용량이 없을때 ?>
						<td>
							<input type="hidden" name="dcOriginColor" value="<?echo $str?>">					
							<input type="text" name="dcColor" value="<?echo $str ?>">
						</td>
					<?endif?>
					<td></td>															
				</tr>
				<tr>
					<td>SK특수채널</td>		
					<td colspan="3">
						<fieldset class="inp-group" data-default="<?echo $deviceInfo['dvChannelSK']?>">
							<?foreach ($SKtmChannel as $value) :?>
								<label class="inp-chk">
									<input type="radio" name="sktmChannel" class="sktmChannel" value="<?php echo $value['chKey']?>" />
									<div class="inp-chk-box"></div>
									<?php echo $value['chName'];?>
								</label>
							<?endforeach?>
						</fieldset>
					</td>								
				</tr>
				<tr>
					<td>KT특수채널</td>		
					<td colspan="3">
						<fieldset class="inp-group" data-default="<?echo $deviceInfo['dvChannelKT']?>">
							<?foreach ($KTtmChannel as $value) :?>
								<label class="inp-chk">
									<input type="radio" name="kttmChannel" class="kttmChannel" value="<?php echo $value['chKey']?>" />
									<div class="inp-chk-box"></div>
									<?php echo $value['chName'];?>
								</label>
							<?endforeach?>
						</fieldset>
					</td>								
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
		<a href="deviceList.php" class="btn-filled-primary-dense">목록으로</a>
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


</script>