<ul class="grid-group<?php echo $groupCenterSuffix?>">
	<?php 
	$i = $startIndex;
	foreach ($giftResults as $giftRow) : 
	$canView = '';
	$link = '';

	if($giftRow['gfCont'] !== NULL) {
		$canView = 'js-giftViewToggle';
		$link = 'href="/product/dev-giftDetail.php?id='.$giftRow['gfKey'].'" target="giftView"';
	}
	?><li class="grid-item-wrap<?php echo $bigSuffix?>">
		<div class="js-doSelect select-btn-tit" data-key="<?php echo $giftRow['gfKey']?>"><i class="gift-view-ico"></i></div>
		<a class="grid-item <?php echo $canView?>" data-key="<?php echo $giftRow['gfKey']?>" id="link-giftList-<?php echo $giftRow['gfKey']?>">
			<div class="grid-item-thumb-wrap">
			<img data-original="<?php echo $gfThumbPath[$giftRow['gfKey']]?><?php echo $giftRow['gfThumb']?>"/>
			</div>
			<div class="grid-item-tit">
				<span style="color:#FFA000;font-size:.9em">★ <?php echo number_format($giftRow['gfPoint'])?></span>
				<br/>
				<span class="grid-item-sub">	<?php echo $giftRow['gfSubTit']?></span>
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
