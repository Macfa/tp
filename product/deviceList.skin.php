<ul class="grid-group js-devicelist">
	<?php 
	foreach ($incList['deviceResults'] as $deviceRow) : 
	?><li class="grid-item-wrap">
		<a class="grid-item" href="/device/<?php echo $deviceRow['dvId']?>"  id="link-deviceList-<?php echo $deviceRow['dvId']?>">
			<div class="grid-item-thumb-wrap">
				<div class="vert-wrap">
				<div class="vert-align">
					<img data-original="<?=PATH_IMG?>/<?php echo $deviceRow['dvThumb']?>"/>
				</div>
				</div>
			</div>
			<div class="grid-item-tit">
				<?php echo $deviceRow['dvTit']?>
			</div>
		</a>
	</li><?php endforeach?><li class="grid-item-wrap">
		<a class="grid-item" href="/page/preorderV20Apply.php" id="link-deviceList-galaxys7edge">
			<div class="grid-item-thumb-wrap">
				<div class="vert-wrap">
				<div class="vert-align">
					<img data-original=<?echo$cfg['path']."/img/device-thumb-v20.jpg"?> src=<?echo$cfg['path']."/img/device-thumb-v20.jpg"?>  style="display: block;">
				</div>
				</div>
			</div>
			<div class="grid-item-tit">
				V20			</div>
		</a>
	</li><li class="grid-item-wrap">
		<a class="grid-item" href="/page/preorderApply.php?device=아이폰7" id="link-deviceList-iphone7">
			<div class="grid-item-thumb-wrap">
				<div class="vert-wrap">
				<div class="vert-align">
					<img data-original=<?echo$cfg['path']."/img/device-thumb-iphone7.jpg"?> src=<?echo$cfg['path']."/img/device-thumb-iphone7.jpg"?>  style="display: block;">
				</div>
				</div>
			</div>
			<div class="grid-item-tit">
				iPhone7			</div>
		</a>
	</li><li class="grid-item-wrap">
		<a class="grid-item" href="/page/preorderApply.php?device=아이폰7" id="link-deviceList-iphone7">
			<div class="grid-item-thumb-wrap">
				<div class="vert-wrap">
				<div class="vert-align">
					<img data-original=<?echo$cfg['path']."/img/device-thumb-iphone7.jpg"?> src=<?echo$cfg['path']."/img/device-thumb-iphone7.jpg"?>  style="display: block;">
				</div>
				</div>
			</div>
			<div class="grid-item-tit">
				iPhone7	플러스		</div>
		</a>
	</li>	
</ul>