<div class="wrap">
	<?php if(empty($news) === false ) :?>
		<section>
			<h2 class="tit-sec">꿀팁의 전당</h2>
			<ul class="grid-group js-devicelist newsList">
				<?php foreach ($news as $val) :?><li class="grid-item-wrap">
					<a class="grid-item js-telReserve js-ajax-news" href="<?php echo $val['neUrl']?>" target="layerView">
						<input type="hidden" class="js-ajax-neKey" value="<?echo $val['neKey']?>">
						<div class="grid-item-thumb-wrap">
							<div class="vert-wrap">
							<div class="vert-align">
								<img data-original="<?php echo $url.$val['neThumb']?>"/>
							</div>
							</div>
						</div>
						<div class="grid-item-tit">										
							<?php echo $val['neTit'] ?>
						</div>					
					</a>
				</li><?php endforeach?>
			</ul>		
		</section>
	<? endif?>
</div>
<script>
	$('.js-ajax-news').click(function(){
	$neKey = $(this).children('.js-ajax-neKey').val();
	
	$.ajax({
		url:'/product/deviceNewsUpdate.php',
		type:'post',
		async:false,
		data:{neKey : $neKey},
		success:function(data){		
			//console.log(data);			
		}
	});
});
</script>
