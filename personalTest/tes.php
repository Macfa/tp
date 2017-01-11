<?php 
// ini_set('memory_limit', '-1');
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
require_once($cfg['path']."/adminhead.php");			// 헤더 부분 (스킨포함)
$import->addJS('tplDevice.js');
$carrier_val = array('skt', 'kt', 'lg');
$carrier_ex = array(
	'skt' => array('미래대리점', 'PSN마케팅'),
	 'kt' => array("KT본사", 'Ktis'),
	 'lg' => array('엔트솔')
);

$category['manuf'] = array('samsung', 'apple', 'lg', 'etc');
$category1['category'] = array('phone', 'kids', 'pocketfi', 'watch');
$dvCategory = $category + $category1;

if($_GET['view'] == 'model') {
	$table = 'tmInventoryStock';
	$separatorField = 'stCarrier';
	$lists = array('skt', 'kt', 'lg');
}else if($_GET['view'] == 'receipt') {
	$table = 'tmInventoryWare';
	$separatorField = 'stGoodReceipt';
	$lists = array('미래대리점', 'PSN마케팅', 'Ktis', '엔트솔', "KT\(본사\)");
}

// foreach ($carrier_ex as $carrier => $arrGoodreceipt) {	/*숫자인덱스 | 통신사*/
// 	foreach($arrGoodreceipt as $goodreceipt) {	/*숫자인덱스 | 대리점*/
		
// 		if($_GET['view'] == 'model') {
// 			$separator = $carrier;
// 		}else if($_GET['view'] == 'receipt') {
// 			$separator = $goodreceipt;
// 		}
		
// 		foreach($dvCategory as $thr => $category) {	/*카테고리종류인덱스 | 각 제조사 및 카테고리*/
// 			if($thr == 'manuf')
// 				$searchField = 'dvManuf';
// 			else
// 				$searchField = 'dvCate';
// 			foreach($category as $key => $value) {	/*각 제조사 및 카테고리의 값*/
// 				if($value == 'etc') {
// 					$arr[$separator][$value] = DB::query("SELECT dvModelCode, stColor, stEach FROM ".$table." as i LEFT JOIN tmDevice as d ON i.stModelCode = d.dvModelCode WHERE d.dvCate=%s AND (d.dvManuf=%s OR d.dvManuf=%s) AND i.".$separatorField."=%s AND i.stKey is not null", 'phone', '', $value, $separator);
// 				} elseif($value !== 'phone') {
// 					$arr[$separator][$value] = DB::query("SELECT dvModelCode, stColor, stEach FROM ".$table." as i LEFT JOIN tmDevice as d ON i.stModelCode = d.dvModelCode WHERE d.".$searchField."=%s AND i.".$separatorField."=%s AND i.stKey is not null", $value, $separator);
// 				}

// 			}
// 		}
// 	}
// }

$carrier = $_GET['carrier'];

foreach($dvCategory as $list => $category) {	/*카테고리종류인덱스 | 각 제조사 및 카테고리*/
	if($list == 'manuf')
		$searchField = 'dvManuf';
	else
		$searchField = 'dvCate';
	foreach($category as $key => $value) {	/*각 제조사 및 카테고리의 값*/
		if($value == 'etc') {
			$arr[$carrier][$value] = DB::query("SELECT dvModelCode, stColor, stEach FROM ".$table." as i LEFT JOIN tmDevice as d ON i.stModelCode = d.dvModelCode WHERE d.dvCate=%s AND (d.dvManuf=%s OR d.dvManuf=%s) AND i.".$separatorField."=%s AND i.stKey is not null", 'phone', '', $value, $carrier);
		} elseif($value !== 'phone') {
			$arr[$carrier][$value] = DB::query("SELECT dvModelCode, stColor, stEach FROM ".$table." as i LEFT JOIN tmDevice as d ON i.stModelCode = d.dvModelCode WHERE d.".$searchField."=%s AND i.".$separatorField."=%s AND i.stKey is not null", $value, $carrier);
		}

	}
}


echo "<pre>";
print_r($arr);
echo "</pre>";

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

<!-- tplDeviceView.php 에서 arr 불러와 출력 -->
	<div>
	<form method="get" action="tplDeviceViewDetail.php">
		<input type="text" class="search_serialnumberVal" name="searchVal">
		<input type="submit" value="Search" class="search_serialnumber">
	</form>
	<?php foreach($lists as $list_carrier) :?>
		<a href="http://chydev.tplanit.co.kr/personalTest/tes.php?view=<?php echo ($_GET['view']=='model')?'model':'receipt'?>&carrier=<?php echo $list_carrier ?>" class=checkbox_carrier name=<?php echo $list_carrier ?>><li><?php echo $list_carrier ?></li></a>
	<?php endforeach ?>
	<?php foreach($arr as $carrier => $value_manuf) :?>
		<div class="js-carrier" name=<?php echo $carrier; ?>>
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
			</div>
		<?php endforeach ?>
	</div>
</div>
