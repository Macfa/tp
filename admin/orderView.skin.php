<div class="wrap mypageList-wrap">
	<h1 class="center tit">주문사은품</h1>	
	<table class="table mypageList">
	<thead>
		<tr>
			<td class="table-item-str">사은품 명</td>
			<td>	수량</td>
			<td></td>
			<td>개당 별</td>
			<td></td>
			<td>구매 별</td>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($arrOrderItemList as $val) :?>
	<tr>
		<td class="table-item-str gift-tit"><a href="" class="btn-flat-primary-dense js-giftViewToggle" data-key="<?php echo $val['gfKey']?>"><?php echo $val['gfTit']?></a></td>
		<td class="no-padding"><?php echo $val['oiQuantity']?>개</td>
		<td class="table-separator">x</td>
		<td><?php echo number_format($val['oiPoint'])?></td>
		<td class="table-separator">=</td>
		<td class="table-value" ><?php echo number_format($val['oiPoint']*$val['oiQuantity'])?></td>	
	</tr>
	<?php endforeach?>
	</tbody>
	</table>
</div>
