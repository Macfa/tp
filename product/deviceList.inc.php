<?
if ($incList['deviceSql'] == false)
	$incList['deviceSql'] = "SELECT * FROM tmDevice WHERE dvParent = 0 and dvDisplay = 1 ";

if ($incList['deviceResults'] == false) 
	$incList['deviceResults'] = DB::query($incList['deviceSql'].$incList['additialWhere']);

require("deviceList.skin.php");		
$incList = array();
?>