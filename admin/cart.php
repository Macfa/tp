<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
 
try{

	if($isLogged == false)
		throw new Exception('로그인 해주세요!', 1);

} catch (Exception $e) {	

	if ($e->getCode() === 1)
		$errorURL = $cfg['login_url'];
	alert($e->getMessage(), $errorURL);
}

$add_css = '<link rel="stylesheet" href="'.PATH_CSS.'/cart.css" type="text/css">';
$js_file = '<script type="text/javascript" src="'.PATH_JS.'/cart.js"></script>';
$js_file .= '<script type="text/javascript" src="'.PATH_JS.'/gifts.js"></script>';
$totalPoint = 0;

$arrCart = DB::query("SELECT * FROM tmCart c LEFT JOIN tmGift g ON c.gfKey = g.gfKey WHERE mbEmail = %s", $mb['mbEmail']);

foreach($arrCart as $val){
	$totalPoint = $totalPoint + ($val['gfPoint'] * $val['caQuantity']);
}

require_once($cfg['path']."/head.inc.php");			// 헤더 부분 (스킨포함)
require_once("cart.skin.php");		
require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)