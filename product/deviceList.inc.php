<?
if ($incList['deviceSql'] == false)
	$incList['deviceSql'] = "SELECT * FROM tmDevice WHERE dvParent = 0 and dvDisplay = 1";

if ($incList['deviceResults'] == false) 
	$incList['deviceResults'] = DB::query($incList['deviceSql'].$incList['additialWhere']);

foreach ($incList['deviceResults'] as $key => $deviceRow){

	$tmp = $deviceRow['dvThumb'];
	$strTmp = substr($tmp, 0, 6);

	if($strTmp === 'device'){		
		$imgPath[$key] = PATH_IMG.'/';
	}else{
		$imgPath[$key] = "/image.index.php?name=";
	}

}
require("deviceList.skin.php");		
$incList = array();
?>