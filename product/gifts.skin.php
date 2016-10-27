<div class="gifts-wrap">
	<form id="js-giftsForm">
	<label class="inp-wrap">
		<input type="text" class="inp-search" name="giftsSearch"/>
		<div class="inp-label">검색어 입력 후 엔터. <i></i></div>
	</label>
	<br/>
	<label class="inp-chk-dense">
		<input type="checkbox" class="js-category" value="it"/>
		<div class="inp-chk-box"></div>
		IT
	</label>
	<label class="inp-chk-dense">
		<input type="checkbox" class="js-category" value="living"/>
		<div class="inp-chk-box"></div>
		생활
	</label>
	<label class="inp-chk-dense">
		<input type="checkbox" class="js-category" value="health"/>
		<div class="inp-chk-box"></div>
		건강
	</label>
	<label class="inp-chk-dense">
		<input type="checkbox" class="js-category" value="sound"/>
		<div class="inp-chk-box"></div>
		음향
	</label>
	<label class="inp-chk-dense">
		<input type="checkbox"class="js-category" value="media"/>
		<div class="inp-chk-box"></div>
		영상
	</label>
	<label class="inp-chk-dense">
		<input type="checkbox"class="js-category" value="home"/>
		<div class="inp-chk-box"></div>
		가전
	</label>

	<br/><br/>
	<input type="submit" style="width:0;height:0;outline:0;border:0;background:transparent" onsubmit="return false;"/>
	</form>
	<div class="js-giftList">
		<?php 	require_once(PATH_PRD."/dev-giftList.inc.php");	?>
	</div>
</div>
<script>
<?php if($isShowGiftDetail === true) :?>
$(function(){
	require([ 
		'jquery.lazyload'
	], function (lazyload) {
		var $giftData = {id : <?php echo $_GET['giftId']?>};
		$.ajax({
			url:'/product/dev-giftDetail.php',
			type:'post',
			async:false,
			data:$giftData,
			success:function(data){
				setGiftDetail(data);
				$('.js-giftView img[data-original]').lazyload({ 
					effect: "fadeIn",
					container: $(".js-giftView")
				});
			}
		});
	});
});
<?php endif?>
</script>