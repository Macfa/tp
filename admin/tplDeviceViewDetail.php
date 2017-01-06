<?php 
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

$import->addJS('tplDevice.js');
require_once($cfg['path']."/adminhead.php");			// 헤더 부분 (스킨포함)

/*$_GET 의 carrier 값이 skt kt lg 에 포함된다면... true / 그 외는 재고, 정보 테이블을 활용하여 해당 컬러, 제조사, 모델명에 맞는 시리얼번호를 받음 */
if(in_array($_GET['carrier'], array('skt', 'kt', 'lg')))
	$serial = DB::queryOneColumn('inSerialNumber', "SELECT * FROM tmInventoryInfo WHERE inModelCode=%s and inCarrier=%s and inColor=%s GROUP BY inSerialNumber", $_GET['model'], $_GET['carrier'
		], $_GET['color']);
else {
	$serial = DB::queryOneColumn('inSerialNumber', "SELECT * FROM tmInventoryIn as i LEFT JOIN tmInventoryInfo as f ON i.inSerialNumber = f.inSerialNumber WHERE f.inModelCode=%s AND f.inColor=%s AND i.ivGoodReceipt=%s GROUP BY i.inSerialNumber", $_GET['model'], $_GET['color'], $_GET['carrier']);

}
/*상단에 조건에도 함께 해당되는 경우라서 따로 뺌, etc 라면... 값 덮어씌우기*/
if(in_array($_GET['carrier'], array('etc'))) {
	$serial = DB::queryOneColumn('inSerialNumber', "SELECT * FROM tmInventoryInfo as f LEFT JOIN tmDevice as d ON f.inModelCode = d.dvModelCode WHERE f.inModelCode=%s AND f.inColor=%s AND (d.dvManuf=%s OR d.dvManuf=%s) GROUP BY f.inSerialNumber", $_GET['model'], $_GET['color'], $_GET['carrier'], '');
}
foreach($serial as $ex => $value) {
	$tmp['in'] = DB::query("SELECT * FROM tmInventoryIn WHERE inSerialNumber=%s ORDER BY ivInDate DESC", $value);

	$tmp['out'] = DB::query("SELECT * FROM tmInventoryOut WHERE inSerialNumber=%s ORDER BY ouOutDate DESC", $value);

	$date = (isExist($tmp['in']['ivInDate']))?$tmp['in']['ivInDate']:$tmp['out']['ouOutDate'];


	if(count($tmp['out']) > 0){
		foreach($tmp['out'] as $row) {
			$row['type'] = '출고';
			$date = $row['date'] = date_format(date_create($row['ouOutDate']), "Y-m-d");
			$row['doneDate'] = $row['ouOutTerm'];
			$result[$date][] = $row;
		}
	}

	if(count($tmp['in']) > 0){
		foreach($tmp['in'] as $row) {
			$row['type'] = '입고';
			$date = $row['date'] = date_format(date_create($row['ivInDate']), "Y-m-d");
			$row['doneDate'] = $row['ivInTerm'];
			$result[$date][] = $row;
		}
	}
}

krsort($result,SORT_STRING);
foreach($result as $key => $val) {
	$result[$key] = sortArray($val, 'doneDate', SORT_DESC);
}
// debugArray($result);

$returnName = (isExist($_POST['returnName']))?" / ".$_POST['returnName']:"";
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
				<th style="width:60">구분</th>
				<th style="width:220">일련번호</th>
				<th style="width:200">날짜</th>
				<th style="width:60">비고</th>
			</tr>
			<?php foreach($result as $date => $array) :?>
				<?php foreach($array as $row) :?>
					<tr>
						<td><?php echo $row['type'] ?></td>
						<td><?php echo $row['inSerialNumber'] ?></td>
						<td><?php echo $date ?></td>
						<td><?php echo $row['ouDelivery'] ?><?php echo $row['ivGoodReceipt'].$returnName ?></td>
					</tr>
				<?php endforeach?>
			<?php endforeach?>
		</table>
	</div>
</div>

<?php 
require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)
 ?>
