<ul class="grid-group js-devicelist">
	<?php foreach ($incList['deviceResults'] as $deviceRow) : ?><li class="grid-item-wrap">
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
	</li><?php endforeach?>
</ul>