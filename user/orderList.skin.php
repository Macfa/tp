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
		<td><a href="/user/orderView.php?id=<?php echo $val['orKey']?>" class="btn-flat-primary-dense js-layerViewToggle" target="layerView"><?php echo $val['orKey']?></a></td>
		<td><?php echo $val['orDate']?></td>	
		<td><a href="https://service.epost.go.kr/trace.RetrieveDomRigiTraceList.comm?sid1=<?php echo $val['orTrackingNum']?>&displayHeader=N" class="epost js-layerViewToggle" target='layerView'>배송추적</a></td>
	</tr>
	<?php endforeach?>
	</tbody>
	</table>
</div>

