<div class="mypage-list-wrap">
	<h1 class="center tit order-tit"><div class="tit-box"></div>신청목록</h1>	
	<table class="table">
	<thead>
		<tr>	
			<td>신청기기</td>
			<td>신청날짜</td>	
			<td>진행상황</td>
			<td>취소현황</td>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($applyExist as $key => $value) :?>
	<tr>
		<td><a href="/user/applyState.php?apKey=<?echo $value['apKey']?>" class="btn-flat-primary-dense"><?echo $dvTitle[$key]?> 신청현황</a></td>
		<td><?php echo $value['apDatetime']?></td>	
		<td><?php echo $changeState[$value['apProcess']]?></td>
		<td><?php echo $cancel[$value['apCancel']]?></td>
	</tr>
	<?php endforeach?>
	</tbody>
	</table>
</div>

