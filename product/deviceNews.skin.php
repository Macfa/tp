<div class="wrap">
	<?php if(isExist($news) ===true AND isNullVal($news[$key]) ===false) :?>
		<section>
			<h2 class="tit-sec">리스트</h2>
			<ul class="grid-group js-devicelist">
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
							<span class="grid-item-sub"><?php echo $val['neSubTit'] ?></span>
							<br>			
							<?php echo $val['neTit'] ?>
						</div>					
					</a>
				</li><?php endforeach?>
			</ul>		
		</section>
	<? endif?>
</div>

