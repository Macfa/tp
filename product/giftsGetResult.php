<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

$isSearchStr = (isExist($_POST['searchStr']))?true:false;
$isSearchCategory = (isExist($_POST['searchCategory']))?true:false;
$sql = '';

if ($isSearchStr) {
	$_POST['searchStr'] = str_replace('  ',' ',$_POST['searchStr']);
	$arrSearchStr = explode(' ',$_POST['searchStr']);
	$sqlSearchStr = '';
	foreach ($arrSearchStr as $val) {
		if (isExist($sqlSearchStr)) $sqlSearchStr .= ' and ';
		$sqlSearchStr .= "(gfTit LIKE '%".$val."%' or gfSubTit LIKE '%".$val."%')";
	}
	$sql .= '('.$sqlSearchStr.')';
}


if ($isSearchCategory) {
	$arrSearchCategory = explode(',',$_POST['searchCategory']);
	$sqlSearchCategory = '';
	foreach ($arrSearchCategory as $val) {
		if (isExist($sqlSearchCategory)) $sqlSearchCategory .= ' or ';
		$sqlSearchCategory .= "gc.gcId = '".$val."'";
	}
	if (isExist($sql)) $sql .= ' and ';
	$sql .= '('.$sqlSearchCategory.')';
}

if (isExist($sql)) $sql = ' and '.$sql;

$giftResults = DB::query("SELECT g.* FROM tmGift as g LEFT JOIN tmGiftCategory as gc ON g.gfKey = gc.gfKey WHERE gfDisplay = 1".$sql." GROUP BY g.gfKey");

require_once("dev-giftList.skin.php");	
?>

