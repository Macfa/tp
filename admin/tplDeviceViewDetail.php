<?php 
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

$import->addJS('tplDevice.js');
require_once($cfg['path']."/adminhead.php");			// 헤더 부분 (스킨포함)

/*$_GET 의 carrier 값이 skt kt lg 에 포함된다면... true / 그 외는 재고, 정보 테이블을 활용하여 해당 컬러, 제조사, 모델명에 맞는 시리얼번호를 받음 */
if(in_array($_GET['carrier'], array('skt', 'kt', 'lg')))
	$serial = DB::queryOneColumn('inSerialNumber', "SELECT * FROM tmInventoryInfo WHERE inModelCode=%s and inCarrier=%s and inColor=%s", $_GET['model'], $carrier, $_GET['color']);
else
	$serial = DB::queryOneColumn('ivSerialNumber', "SELECT * FROM tmInventoryIn as i LEFT JOIN tmInventoryInfo as f ON i.ivSerialNumber = f.inSerialNumber WHERE f.inModelCode=%s AND f.inColor=%s AND i.ivGoodReceipt=%s", $_GET['model'], $_GET['color'], $_GET['carrier']);

?>

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
	<div>
		<h1><?php echo strtoupper($_GET['carrier'])." - ".$_GET['model']." - ".strtoupper($_GET['color']). " - 입출고기록" ?></h1>

		<table style="border: 1px skyblue solid">
			<tr>
			<th style="width:220">일련번호</th>
			<th style="width:200">입고일</th>
			<th style="width:60">출고일</th>
			<th style="width:60">입고처</th>
			<th >출고처</th>
			</tr>
			<?php foreach($serial as $key => $value) :?>
			<tr>
				<td><?php echo $value ?></td>
				<td><?php echo $indate = DB::queryOneField('ivInDate', "SELECT * FROM tmInventoryIn WHERE ivSerialNumber=%s", $value) ?></td>
				<td><?php echo $outdate = DB::queryOneField('ouOutDate', "SELECT * FROM tmInventoryOut WHERE ouSerialNumber=%s", $value) ?></td>
				<td><?php echo DB::queryOneField('ivGoodReceipt', "SELECT * FROM tmInventoryIn WHERE ivSerialNumber=%s", $value) ?></td>
			</tr>
		<?php endforeach ?>
		</table>
	</div>
</div>

<?php 
require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)
 ?>