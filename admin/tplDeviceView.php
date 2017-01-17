<?php 
// ini_set('memory_limit', '-1');
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
require_once($cfg['path']."/adminhead.php");			// 헤더 부분 (스킨포함)
$import->addJS('tplDevice.js');

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
	$lists = array('미래대리점', 'PSN마케팅', 'Ktis', '엔트솔', "KT본사");
}

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


require_once("tplDeviceView.skin.php");
require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)


?>
