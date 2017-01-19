<ul class="grid-group<?php echo $groupCenterSuffix?>">
	<?php 
	$i = $startIndex;
	foreach ($giftResults as $giftRow) : 
	$canView = '';
	$link = '';
	if($giftRow['gfCont'] !== NULL) {
		$canView = 'js-layerViewToggle';
		$link = 'href="'.$cfg['url'].'/gift/'.$giftRow['gfKey'].$giftListCfg['isDev'].'" target="layerView"';
	}
	?><li class="grid-item-wrap<?php echo $bigSuffix?>">
		<a class="grid-item <?php echo $canView?>" <?php echo $link?> id="link-giftList-<?php echo $giftRow['gfKey']?>">
			<div class="grid-item-thumb-wrap">
			<img data-original="<?=PATH_IMG?>/<?php echo $giftRow['gfThumb']?>"/>
			</div>
			<div class="grid-item-tit">
				<span class="grid-item-sub"><?php echo $giftRow['gfSubTit']?></span>
				<br/>
				<?php echo $giftRow['gfTit']?>
			</div>
			<?php if($selectionList) :?>
			<div class="grid-item-select">
				선택
				<?php echo $i?>
			</div>
			<?php endif?>
		</a>
	</li><?php $i++; endforeach?>
</ul>