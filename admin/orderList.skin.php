<div class="wrap mypageList-wrap">
	<h1 class="center tit">구매목록</h1>	
	<table class="table mypageList">
	<thead>
		<tr>		
			<td>주문자</td>
			<td>전번</td>
			<td></td>
			<td>주문번호</td>
			<td>주문날짜</td>	
		</tr>
	</thead>
	<tbody>
	<?php foreach ($arrOrderList as $val) :?>
	<tr>
		<td><?php echo $val['mbName']?></td>
		<td><?php echo $val['mbPhone']?></td>
		<td><?php echo $val['mbEmail']?></td>
		<td><a href="/admin/orderView.php?id=<?php echo $val['orKey']?>" class="btn-flat-primary-dense js-layerViewToggle" target="layerView"><?php echo $val['orKey']?></a></td>
		<td><?php echo $val['orDate']?></td>	
	</tr>
	<?php endforeach?>
	</tbody>
	</table>
</div>

