<div class="wrap mypageList-wrap">
	<h1 class="center tit">포인트 적립내용</h1>	
	<table class="table mypageList">
	<thead>
		<tr>		
			<td>포인트 상세내용</td>
			<td>포인트</td>			
			<td>남은포인트</td>			
			<td>날짜</td>			
		</tr>
	</thead>
	<tbody>
	<?php foreach($arrPointList as $val) :?>
	<tr style="text-align:right">
		<td><?php echo $val['phCont']?></td>
		<td><?php echo $val['phAmount']?></td>			
		<td><?php echo $val['phResult']?></td>			
		<td><?php echo $val['phDate']?></td>		
	</tr>
	<?php endforeach?>
	</tbody>
	</table>
</div>

<script>
</script>