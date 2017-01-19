<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

//바로구매하기 버튼으로 들어온 경우
if(isExist($_POST['gift-number'])){

	$_POST['chk'] = array(
		0 => $_POST['gift-key']
		);
}
/////////////////////

try
{
	if($isLogged == false)
		throw new Exception('로그인 해주세요!', 1);

	if ($_POST['chk'] == array())
		throw new Exception('주문할 사은품 변수가 없습니다.', 2);

	foreach($_POST['chk'] as $val){
		if (isNum($val) === false) throw new Exception('주문할 사은품 변수가 비정상적입니다.', 3);
	}	

}
catch(Exception $e)
{
	if ($e->getCode() === 1)
		$errorURL = $cfg['login_url'];

	if ($e->getCode() === 2)
		$errorURL = '/cart';

    alert($e->getMessage(), $errorURL);
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

//=========================================

$isShippingFree = DB::queryFirstField("SELECT count(*) FROM tmOrder WHERE mbEmail = %s", $mb['mbEmail']);
if ($isShippingFree > 0) {
	$isShippingFree = false;
	$shipping = 2500;
}else{
	$isShippingFree = true;
	$shipping = 0;
}

//==========================================

$arrOrder = DB::query("SELECT * FROM tmCart c LEFT JOIN tmGift g ON c.gfKey = g.gfKey WHERE ".$sqlGiftWhere." and mbEmail = %s", $mb['mbEmail']);

foreach($arrOrder as $val){
	if(isExist($_POST['gift-number'])){
		$caQuantity = $_POST['gift-number'];
	}else{	
		$caQuantity = $val['caQuantity'];
	}


	$totalPoint = $totalPoint + ($val['gfPoint'] * $caQuantity);
}

$totalPoint += $shipping;

$defAddress = DB::queryFirstRow("SELECT * FROM tmAddress WHERE mbEmail = %s and arIsDefault = 1", $mb['mbEmail']);
$arrAddress = DB::query("SELECT * FROM tmAddress WHERE mbEmail = %s", $mb['mbEmail']);

require_once($cfg['path']."/head.inc.php");			// 헤더 부분 (스킨포함)
require_once("order.skin.php");		
require_once($cfg['path']."/foot.inc.php");			// foot �κ� (��Ų����)

