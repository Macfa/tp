<div class="mypage-list-wrap">
	<h1 class="center tit order-tit"><div class="tit-box"></div>구매목록</h1>	
	<table class="table">
	<thead>
		<tr>	
			<td>주문번호</td>
			<td>주문날짜</td>	
			<td>배송추적</td>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($arrOrderList as $val) :?>
	<tr>
		<td><a href="/user/orderView.php?id=<?php echo $val['orOrderNumber']?>" class="btn-flat-primary-dense js-layerViewToggle" target="layerView"><?php echo $val['orOrderNumber']?></a></td>
		<td><?php echo $val['orDate']?></td>	
		<td><?php echo $val['deliveryTracking']?></td>
	</tr>
	<?php endforeach?>
	</tbody>
	</table>
</div>

