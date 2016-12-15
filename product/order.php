<?
require_once("./_common.inc.php");	// °ø¿ëºÎºÐ (¸ðµç ÆäÀÌÁö¿¡ ¾²ÀÌ´Â php·ÎÁ÷)

//ë°”ë¡œêµ¬ë§¤í•˜ê¸° ë²„íŠ¼ìœ¼ë¡œ ë“¤ì–´ì˜¨ ê²½ìš°
if(isExist($_POST['gift-number'])){
	$_POST['chk'] = array(
		0 => $_POST['gift-key']
		);
}
/////////////////////
try
{
	if ($_POST['chk'] == array())
		throw new Exception('ÁÖ¹®ÇÒ »çÀºÇ° º¯¼ö°¡ ¾ø½À´Ï´Ù.', 3);

	foreach($_POST['chk'] as $val){
		if (isNum($val) === false) throw new Exception('ÁÖ¹®ÇÒ »çÀºÇ° º¯¼ö°¡ ºñÁ¤»óÀûÀÔ´Ï´Ù.', 3);
	}	

}
catch(Exception $e)
{
    alert($e->getMessage());
}

$import->addCSS('cart.css')->addJS('order.js')->addJS('gifts.js')->addJS('modifyInfo.js');
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
	if(isExist($_POST['gift-number'])){
		$caQuantity = $_POST['gift-number'];
	}else{	
		$caQuantity = $val['caQuantity'];
	}


	$totalPoint = $totalPoint + ($val['gfPoint'] * $caQuantity);
}

$defAddress = DB::queryFirstRow("SELECT * FROM tmAddress WHERE mbEmail = %s and arIsDefault = 1", $mb['mbEmail']);
$arrAddress = DB::query("SELECT * FROM tmAddress WHERE mbEmail = %s", $mb['mbEmail']);

$isShippingFree = DB::queryFirstField("SELECT count(*) FROM tmOrder WHERE mbEmail = %s", $mb['mbEmail']);
if ($isShippingFree > 0)
	$isShippingFree = false;
else
	$isShippingFree = true;

$isEucKr = true;
require_once($cfg['path']."/head.inc.php");			// Çì´õ ºÎºÐ (½ºÅ²Æ÷ÇÔ)
require_once("order.skin.php");		
require_once($cfg['path']."/foot.inc.php");			// foot ºÎºÐ (½ºÅ²Æ÷ÇÔ)
