<?
if ($additialWhere == '')
	$additialWhere = 'WHERE gfDisplay = 1 or gfKey = 137';
$giftResults = DB::query("SELECT * FROM tmGift ".$additialWhere);
$additialWhere = '';
if ($isBig == true)
	$bigSuffix = '-big';

if ($isCentering == true)
	$groupCenterSuffix = '-center';

if ($startIndex == false && $startIndex !== 0)
	$startIndex = 1;


foreach ($giftResults as $giftRow){

	$thumbString[$giftRow['gfKey']] = DB::queryFirstField("SELECT gfThumb FROM tmGift WHERE gfKey=%i", $giftRow['gfKey']);

	$tmp = $thumbString[$giftRow['gfKey']];	

	$result[$giftRow['gfKey']] = substr($tmp, 0, 4);

	if($result[$giftRow['gfKey']] === 'gift'){		
		$gfThumbPath[$giftRow['gfKey']] = PATH_IMG."/";
	}else{
		$gfThumbPath[$giftRow['gfKey']] = PATH."/image.index.php?name=";
	}
	
}

require("dev-giftList.skin.php");

$startIndex = 1;
$isBig = false;
$bigSuffix = '';
$isCentering = FALSE;
$groupCenterSuffix = '';
$selectionList = FALSE;
$giftResults = '';
$giftListCfg = array();



?>