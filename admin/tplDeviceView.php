<?php 
// ini_set('memory_limit', '-1');
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
require_once($cfg['path']."/adminhead.php");			// 헤더 부분 (스킨포함)
$import->addJS('tplDevice.js');
$carrier_val = array('skt', 'kt', 'lg');
$carrier_ex = array(
	'skt' => array('미래대리점', 'PSN마케팅'),
	 'kt' => array("KT(본사)", 'Ktis'),
	 'lg' => array('엔트솔')
	 );
$category['manuf'] = array('samsung', 'apple', 'lg');
$category1['category'] = array('phone', 'kids', 'pocketfi');

$dvCategory = $category + $category1;

if($_GET['view'] === 'model') {
	foreach($carrier_val as $idx => $carrier) {
		foreach($dvCategory as $key => $val) {
			if($key == 'manuf')
				$searchField = 'dvManuf';
			else
				$searchField = 'dvCate';
			foreach($val as $keys => $value) {
				$arr[$carrier][$value] = DB::query("SELECT dvModelCode, stColor, stEach  FROM tmInventoryStock as i LEFT JOIN tmDevice as d ON i.stModelCode = d.dvModelCode WHERE d.".$searchField." = %s AND i.stCarrier = %s AND i.stKey is not null", $value, $carrier);
			}
		}
	}
} elseif ($_GET['view'] === 'receipt') {
	foreach ($carrier_ex as $one => $carrier) {
		foreach ($carrier as $two => $goodreceipt) {
			foreach($dvCategory as $key => $val) {
				if($key == 'manuf')
					$searchField = 'dvManuf';
				else
					$searchField = 'dvCate';
				foreach($val as $keys => $value) {
					$arr[$goodreceipt][$value] = DB::query("SELECT dvModelCode, stColor, stEach FROM tmInventoryWare as w LEFT JOIN tmDevice as d ON w.stModelCode = d.dvModelCode WHERE d.".$searchField."=%s AND w.stGoodReceipt=%s", $value, $goodreceipt);
				}
			}
		}
	}
}


require_once("tplDeviceView.skin.php");
require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)

?>
