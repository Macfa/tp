<?php 
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

$import->addJS('tplDevice.js');
require_once($cfg['path']."/adminhead.php");			// 헤더 부분 (스킨포함)


/*$_GET 의 carrier 값이 skt kt lg 에 포함된다면... true / 그 외는 재고, 정보 테이블을 활용하여 해당 컬러, 제조사, 모델명에 맞는 시리얼번호를 받음 */
//입고되어 있는 일련번호의 목록을 불러옴
if(isExist($_GET['searchVal'])) {
	$serial = DB::queryOneColumn('inSerialNumber', "SELECT * FROM tmInventoryIn WHERE inSerialNumber = %s GROUP BY inSerialNumber", $_GET['searchVal']);
	$carrier = "해당";
	$model = "검색결과";
}else if(in_array($_GET['carrier'], array('skt', 'kt', 'lg'))) {
	$serial = DB::queryOneColumn('inSerialNumber', "SELECT * FROM tmInventoryInfo WHERE inModelCode=%s and inCarrier=%s and inColor=%s GROUP BY inSerialNumber", $_GET['model'], $_GET['carrier'], $_GET['color']);

}else if(in_array($_GET['carrier'], array('etc'))) {
	$serial = DB::queryOneColumn('inSerialNumber', "SELECT * FROM tmInventoryInfo as f LEFT JOIN tmDevice as d ON f.inModelCode = d.dvModelCode WHERE f.inModelCode=%s AND f.inColor=%s AND (d.dvManuf=%s OR d.dvManuf=%s) GROUP BY f.inSerialNumber", $_GET['model'], $_GET['color'], $_GET['carrier'], '');

}else {
	$serial = DB::queryOneColumn('inSerialNumber', "SELECT * FROM tmInventoryIn as i LEFT JOIN tmInventoryInfo as f ON i.inSerialNumber = f.inSerialNumber WHERE f.inModelCode=%s AND f.inColor=%s AND i.ivGoodReceipt=%s GROUP BY i.inSerialNumber", $_GET['model'], $_GET['color'], $_GET['carrier']);
}

$where = new WhereClause('or');
foreach($serial as $ex => $value) {

	$where->add('inSerialNumber = %s', $value);

	// 입고테이블에서 데이터를 마지막 날짜 순대로 불러옴\
	$tmp['in'] = DB::query("SELECT * FROM tmInventoryIn WHERE inSerialNumber=%s ORDER BY ivInDate DESC", $value);
	// 출고테이블에서 데이터를 마지막 날짜 순대로  불러옴
	$tmp['out'] = DB::query("SELECT * FROM tmInventoryOut WHERE inSerialNumber=%s ORDER BY ouOutDate DESC", $value);

	// 불러온 출고 데이터들의 각 행을 불러옴
	foreach($tmp as $type => $rows) {
		foreach($rows as $row) {

			if($type === 'out'){
				$tmpDate = 'ouOutDate';
				$tmpTerm = 'ouOutTerm';
				$tmpGood = 'ouDelivery';
			}
			if($type === 'in'){
				$tmpDate = 'ivInDate';
				$tmpTerm = 'ivInTerm';
				$tmpGood = 'ivGoodReceipt';
			}
 
			$row['type'] = ($type === 'out')?'출고':'입고';

			//입출고 날짜순대로 정렬하기 위해 변수 정의
			$row['date'] = date_format(date_create($row[$tmpDate]), "Y-m-d");

			// ivINDATE 와 ouOutDate는 시분초 차이가 없기때문에 뭐가 먼저 처리되었는지 몰라서 
			$row['doneDate'] = $row[$tmpTerm];
			$row['good'] = $row[$tmpGood];
			$result[] = $row;
			//$result[$date][] = $row;
			// $result['2017-01-09'] = arrau ($row)
		}
	}
}

$existSerial =  DB::queryOneColumn('inSerialNumber', "SELECT * FROM tmInventoryInfo WHERE (%l) and inIsExist = 1", $where);

// var_dump($result);
krsort($result,SORT_STRING);
$result = sortArray($result, 'doneDate', SORT_DESC);

$returnName = (isExist($_POST['returnName']))?" / ".$_POST['returnName']:"";

?>

<div class="wrap">
	<div class="wrap-dense">
		<h1>티플 단말기 현황</h1>
		<div class="wrap_option_button" style="display: inline;">
			<ul>
				<li><a href="tplDeviceIn.php" class="btn-filled-primary-dense">입고등록</a></li><br> <!-- inline, background-color, position -->
				<li><a href="tplDeviceOut.php" class="btn-filled-primary-dense">출고등록</a></li>
			</ul>
		</div>

		<div>
			<ul>
			<a href="http://chydev.tplanit.co.kr/admin/tplDeviceView.php?view=model&carrier=skt" class="btn-filled-sub-dense"><li>기종별</li></a>
			<a href="http://chydev.tplanit.co.kr/admin/tplDeviceView.php?view=receipt&carrier=미래대리점" class="btn-filled-sub-dense"><li>입고처별</li></a>
			</ul>
		</div>
		<div>
			<h1><?php echo strtoupper($carrier)." ".$model." ".strtoupper($color). " 입출고기록" ?></h1>

			<table class="table">
				<tr>
					<th class="table-item-str">구분</th>
					<th class="table-item-str">일련번호</th>
					<th class="table-item-str">날짜</th>
					<th class="table-item-str">비고</th>
				</tr>
				<?php foreach($result as $row) :?>
					<tr>
						<td class="table-item-str"><?php echo $row['type'] ?></td>
						<td class="table-item-str"><?php echo $row['inSerialNumber'] ?></td>
						<td class="table-item-str"><?php echo $row['date'] ?></td>
						<td class="table-item-str"><?php echo $row['good'] ?></td>
					</tr>
				<?php endforeach?>
			</table>
			<br>
			<h1>모든 일련번호</h1>
			<br>
			<table class="table">
				<tr>
					<th class="table-item-str">일련번호</th>
				</tr>
				<?php foreach($existSerial as $val) :?>
					<tr>
						<td class="table-item-str"><?php echo $val ?></td>
					</tr>
				<?php endforeach?>
			</table>
		</div>
	</div>
</div>

<?php 
require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)
 ?>
