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
		<form method="post" action="/order">
			<div class="gift-view-info">
				수량(클릭하여수정가능)
				<input type="number" name="gift-number" class="gift-number" value="1" data-type="price">
				<input type="hidden" name="gift-key" value="<?php echo $gift['gfKey'];?>">
			</div>
			<button type="submit" class="gift-btn-cart js-buyCart" data-key="<?php echo $gift['gfKey'];?>">
				<i class="gift-view-ico"></i>바로구매하기
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
		</form>
		<button class="gift-close-btn js-closeGiftDetail">
			X
		</button>
	</div>
</div><div class="gift-view">
	<?php echo $gift['gfCont'];?>
</div>