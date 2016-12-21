<div class="wrap">
	<h1 class="center tit">구매목록</h1>	
	<table class="table mypageList">
	<thead>
		<tr>		
			<td class="table-item-str">주문번호</td>
			<td class="table-item-str">주문자</td>
			<td class="table-item-str">전번</td>
			<td>사용한 별</td>
			<td>결제한 금액</td>
			<td class="table-item-str">주문날짜</td>	
		</tr>
	</thead>
	<tbody>
	<?php foreach ($arrOrderList as $val) :?>
	<tr>
		<td class="table-item-str"><a href="/admin/orderView.php?id=<?php echo $val['orOrderNumber']?>" class="btn-flat-primary-dense js-layerViewToggle" target="layerView"><?php echo $val['orOrderNumber']?></a></td>
		<td class="table-item-str"><?php echo $val['mbName']?></td>
		<td class="table-item-str"><?php echo $val['mbPhone']?></td>
		<td><?php echo number_format($val['orPoint'])?></td>
		<td><?php echo number_format($val['orCash'])?></td>
		<!-- <td><?php echo $val['mbEmail']?></td> -->
		<td class="table-item-str"><?php echo $val['orDate']?></td>	
	</tr>
	<?php endforeach?>
	</tbody>
	</table>
</div>

