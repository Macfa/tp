<div class="wrap center"> 
	<h1>티플 단말기 현황</h1>
		<a href="tplDeviceIn.php" class="btn-filled-primary-dense">입고등록</a>
		<a href="tplDeviceOut.php" class="btn-filled-primary-dense">출고등록</a>
		<Br/><Br/>
		<a href="/admin/tplDeviceView.php?view=model&carrier=sk" class="btn-filled-sub-dense"><li>기종별</li></a>
		<a href="/admin/tplDeviceView.php?view=receipt&carrier=1" class="btn-filled-sub-dense"><li>입고처별</li></a>
		<Br/><Br/>
		<?php foreach($lists as $key => $val) :?>
			<a href="/admin/tplDeviceView.php?
			view=<?php echo ($_GET['view']=='model')?'model':'receipt'?>
			&carrier=<?php echo $key ?>" class="checkbox_carrier btn-filled-sub-dense" name="<?php echo $val ?>">
				<?php echo $val ?>
			</a>
		<?php endforeach ?>
		<Br/><Br/>
<!-- tplDeviceView.php 에서 arr 불러와 출력 -->
	<div>
	<form method="get" action="tplDeviceViewDetail.php">
		<input type="text" class="search_serialnumberVal" name="searchVal">
		<input type="submit" value="Search" class="search_serialnumber">
		<br>
		<span><i class="ico-caution-small"></i>일련번호 검색기능</span>
		<br><br>
	</form>
</div>
<div class="wrap-dense">
	<?php foreach($arr as $carrier => $value_manuf) :?>
		<div class="js-carrier" name=<?php echo $carrier; ?>>
			<h1 class="table-item-str"><?php echo strtoupper($lists[$_GET['carrier']]) ?></h1>
			<?php foreach($value_manuf as $manuf => $value_none) :?>
				<h2><?php echo strtoupper($manuf) ?></h2><br/>
				<!-- 데이터 정렬 부분 -->
				<table class=table>
					<tr>
						<th class="table-item-str">기종 / 색상</th>
						<th class="table-item-str">수량</th>
					</tr>
					<?php foreach($value_none as $key => $value_info) :?> <!-- 4  -->
						<tr>
							<td class="table-item-str"><?php echo "<a class=btn-flat-primary-dense href=tplDeviceViewDetail.php?model=".$value_info['dvModelCode']."&carrier=".$carrier."&color=".$value_info['stColor'].">".$value_info['dvModelCode'] ?>	/	<?php echo $lists[$_GET['carrier']] ?>	/	<?php echo $value_info['stColor']."</a>" ?></td>
								<td><?php echo $value_info['stEach'] ?></td>
						</tr>
					<?php endforeach ?>
				</table>
			<?php endforeach ?>
			</div>
		<?php endforeach ?>
	</div>
</div>
