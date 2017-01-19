<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

try
{
	if ($_POST['chk'] == array())
		throw new Exception('주문할 사은품 변수가 없습니다.', 3);

	foreach($_POST['chk'] as $val){
		if (isNum($val) === false) throw new Exception('주문할 사은품 변수가 비정상적입니다.', 3);
	}	

}
catch(Exception $e)
{
    alert($e->getMessage());
}

$add_css = '<link rel="stylesheet" href="'.PATH_CSS.'/cart.css" type="text/css">';
$js_file = '<script type="text/javascript" src="'.PATH_JS.'/order.js"></script>';
$js_file .= '<script type="text/javascript" src="'.PATH_JS.'/gifts.js"></script>';
$js_file .= '<script type="text/javascript" src="'.PATH_JS.'/modifyInfo.js"></script>';
$totalPoint = 0;
$sqlGiftWhere = '';

foreach($_POST['chk'] as $val){
	if (isNullVal($sqlGiftWhere) === false) 
		$sqlGiftWhere .= " or ";
	$sqlGiftWhere .= "g.gfKey = '".$val."'";
}

if(count($_POST['chk']) > 1)
	$sqlGiftWhere = '('.$sqlGiftWhere.')';

$arrOrder = DB::query("SELECT * FROM tmCart c LEFT JOIN tmGift g ON c.gfKey = g.gfKey WHERE ".$sqlGiftWhere." and mbEmail = %s", $mb['mbEmail']);

foreach($arrOrder as $val){
	$totalPoint = $totalPoint + ($val['gfPoint'] * $val['caQuantity']);
}

$defAddress = DB::queryFirstRow("SELECT * FROM tmAddress WHERE mbEmail = %s and arIsDefault = 1", $mb['mbEmail']);
$arrAddress = DB::query("SELECT * FROM tmAddress WHERE mbEmail = %s", $mb['mbEmail']);

$isShippingFree = DB::queryFirstField("SELECT count(*) FROM tmOrder WHERE mbEmail = %s", $mb['mbEmail']);
if ($isShippingFree > 0)
	$isShippingFree = false;
else
	$isShippingFree = true;

$isEucKr = true;
require_once($cfg['path']."/head.inc.php");			// 헤더 부분 (스킨포함)
require_once("order.skin.php");		
require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)