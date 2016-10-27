<div class="gift-panel-wrap">
	<div class="gift-panel js-giftPanel">
		<?php foreach ($category as $val) :?>
		<a class="gift-category-<?=strtolower($val['gcId'])?>" href="/gifts/<?=$val['gcId']?>"><i class="gift-view-ico"></i><?=strtoupper($val['gcId'])?></a>
		<?php endforeach ?>
		<div class="gift-view-info">
			<div class="gift-view-sub">
				<?php echo $gift['gfSubTit'];?>
			</div>
			<div class="gift-view-tit">
				<?php echo $gift['gfTit'];?>
			</div>
		</div>
		<div class="gift-view-price">
			<i class="gift-view-ico"></i><?php echo number_format($gift['gfPoint']);?>별
		</div>
		<button class="gift-btn-cart js-doCart" data-key="<?php echo $gift['gfKey'];?>">
			<i class="gift-view-ico"></i>장바구니 담기
			<div class="btn-success">
				<i class="gift-view-ico"></i>
				완료
			</div>
		</button>
		<button class="gift-btn-select js-doSelect" data-key="<?php echo $gift['gfKey'];?>">
			<i class="gift-view-ico"></i>선택
			<div class="btn-success">
				<i class="gift-view-ico"></i>
				완료
			</div>
		</button>
		<button class="gift-close-btn js-closeGiftDetail">
			X
		</button>
	</div>
</div><div class="gift-view">
	<?php echo $gift['gfCont'];?>
</div>