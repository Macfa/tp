<?php 
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

$import->addJS('tplDevice.js');
require_once($cfg['path']."/adminhead.php");			// 헤더 부분 (스킨포함)

/*
						object
색상, 통신사, 기기명을 GET 형식으로 받으면 재고정보 테이블에서 조건을 만족하는
serialnumber 를 받아온다 
*/
$serial = DB::queryOneColumn('inSerialNumber', "SELECT * FROM tmInventoryInfo WHERE inModelCode=%s and inCarrier=%s and inColor=%s GROUP BY inSerialNumber", $_GET['model'], $_GET['carrier'], $_GET['color']);

foreach($serial as $ex => $value) {

	$tmp['in'] = DB::query("SELECT inSerialNumber FROM tmInventoryIn WHERE inSerialNumber=%s ORDER BY ivInDate DESC", $value);
	$tmp['out'] = DB::query("SELECT inSerialNumber FROM tmInventoryOut WHERE inSerialNumber=%s ORDER BY ouOutDate DESC", $value);

	foreach($tmp as $type => $rows) {
		foreach($rows as $row) {
			foreach ($row as $val) {
				$result[] = $val;
			}
		}
	}
}

$result = array_unique($result);
krsort($result,SORT_STRING);

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
		<h1><?php echo strtoupper($_GET['carrier'])." ".$_GET['model']." ".strtoupper($_GET['color']). " 입출고기록" ?></h1>

		<table style="border: 1px skyblue solid">
			<tr>
				<th style="width:60">일련번호</th>
			</tr>
			<?php foreach($result as $row) :?>
				<tr>
					<td><?php echo $row ?></td>
				</tr>
			<?php endforeach?>
		</table>
	</div>
</div>

<?php 
require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)
 ?>
