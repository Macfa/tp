<div class="wrap">
	<h1>티플 단말기 현황</h1>
	<div class="wrap_option_button" style="display: inline;">
		<ul>
			<li><button><a href="tplDeviceIn.php">입고등록</a></button></li> <!-- inline, background-color, position -->
			<li><button><a href="tplDeviceOut.php">출고등록</a></button></li>
		</ul>
	</div>

	<div>
	<ul>
		<a href="http://chydev.tplanit.co.kr/admin/tplDeviceView.php?view=model"><li>기종별</li></a>
		<a href="http://chydev.tplanit.co.kr/admin/tplDeviceView.php?view=receipt"><li>입고처별</li></a>
	</ul>
	</div>

<!-- tplDeviceView.php 에서 arr 불러와 출력 -->
	<div>
	<?php foreach($arr as $carrier => $value_manuf) :?>
		<b><h1><?php echo strtoupper($carrier) ?></h1><br/></b>
		<?php foreach($value_manuf as $manuf => $value_none) :?>
			<h2><?php echo strtoupper($manuf) ?></h2><br/>
			<!-- 데이터 정렬 부분 -->
			<table style="border: solid 1px black">
				<tr>
					<th style="width:130">기종</th>
					<th style="width:60">색상</th>
					<th style="width:40">수량</th>
				</tr>
				<?php foreach($value_none as $key => $value_info) :?> <!-- 4  -->
					<tr>
					<?php foreach($value_info as $keys => $value) :?>
 						<td><?php echo "<a href=tplDeviceViewDetail.php?model=".$value_info['dvModelCode']."&color=".$value_info['stColor']."&carrier=".$carrier.">".$value."</a>" ?></td>
					<?php endforeach ?>
					</tr>
				<?php endforeach ?>
			</table>
		<?php endforeach ?>
	<?php endforeach ?>
	</div>
</div>