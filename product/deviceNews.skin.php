<div class="wrap">
	<?php if(empty($news) === false ) :?>
		<section>
			<h2 class="tit-sec">리스트</h2>
			<ul class="grid-group js-devicelist newsList">
				<?php foreach ($news as $val) :?><li class="grid-item-wrap">
					<a class="grid-item js-telReserve" href="<?php echo $val['neUrl']?>" target="layerView">
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

