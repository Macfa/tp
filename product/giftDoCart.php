<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

list($isInCart, $caQuantityDB) = DB::queryFirstList('SELECT COUNT(*), caQuantity FROM tmCart WHERE mbEmail = %s and gfKey = %i', $mb['mbEmail'], $_POST['gfKey']);

if($isInCart > 0) {

	if(isExist($_POST['caQuantity']))
		$caQuantity = $caQuantityDB + $_POST['caQuantity'];
	else
		$caQuantity = $caQuantityDB + 1;

	DB::query('UPDATE tmCart SET caQuantity = %i WHERE mbEmail = %s and gfKey = %i', $caQuantity, $mb['mbEmail'], $_POST['gfKey']);

} else {
	if($_POST['caQuantity'] >0)
		$caQuantity = $_POST['caQuantity'];
	else
		$caQuantity = 1;
	
	DB::insert('tmCart', 
		array(
			'mbEmail' => $mb['mbEmail'], 
			'gfKey' => $_POST['gfKey'],
			'caQuantity' => $caQuantity,
			'caDate' => $cfg['time_ymdhis']
		)
	);
}



echo $isInCart;