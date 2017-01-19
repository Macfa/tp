<?
if ($additialWhere == '')
	$additialWhere = 'WHERE gfDisplay = 1';
$giftResults = DB::query("SELECT * FROM tmGift ".$additialWhere);
$additialWhere = '';
if ($isBig == true)
	$bigSuffix = '-big';

if ($isCentering == true)
	$groupCenterSuffix = '-center';

if ($startIndex == false && $startIndex !== 0)
	$startIndex = 1;


require("giftList.skin.php");		
$startIndex = 1;
$isBig = false;
$bigSuffix = '';
$isCentering = FALSE;
$groupCenterSuffix = '';
$selectionList = FALSE;
$giftResults = '';
$giftListCfg = array();
?>