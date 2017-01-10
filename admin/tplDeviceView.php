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

foreach ($carrier_ex as $carrier => $arrGoodreceipt) {	/*숫자인덱스 | 통신사*/
	foreach($arrGoodreceipt as $goodreceipt) {	/*숫자인덱스 | 대리점*/
		
		if($_GET['view'] == 'model') {
			$separator = $carrier;
		}else if($_GET['view'] == 'receipt') {
			$separator = $goodreceipt;
		}
		
		foreach($dvCategory as $thr => $category) {	/*카테고리종류인덱스 | 각 제조사 및 카테고리*/
			if($thr == 'manuf')
				$searchField = 'dvManuf';
			else
				$searchField = 'dvCate';
			foreach($category as $key => $value) {	/*각 제조사 및 카테고리의 값*/
				if($value == 'etc') {
					$arr[$separator][$value] = DB::query("SELECT dvModelCode, stColor, stEach FROM ".$table." as i LEFT JOIN tmDevice as d ON i.stModelCode = d.dvModelCode WHERE d.dvCate=%s AND (d.dvManuf=%s OR d.dvManuf=%s) AND i.".$separatorField."=%s AND i.stKey is not null", 'phone', '', $value, $separator);
				} elseif($value !== 'phone') {
					$arr[$separator][$value] = DB::query("SELECT dvModelCode, stColor, stEach FROM ".$table." as i LEFT JOIN tmDevice as d ON i.stModelCode = d.dvModelCode WHERE d.".$searchField."=%s AND i.".$separatorField."=%s AND i.stKey is not null", $value, $separator);
				}

			}
		}
	}
}


require_once("tplDeviceView.skin.php");
require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)


?>
