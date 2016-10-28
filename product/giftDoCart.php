<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

$isInCart = DB::queryFirstField('SELECT COUNT(*) FROM tmCart WHERE mbEmail = %s and gfKey = %i', $mb['mbEmail'], $_POST['gfKey']);
if($isInCart > 0) {
	DB::query('UPDATE tmCart SET caQuantity = caQuantity+1 WHERE mbEmail = %s and gfKey = %i', $mb['mbEmail'], $_POST['gfKey']);
} else {
	DB::insert('tmCart', 
		array(
			'mbEmail' => $mb['mbEmail'], 
			'gfKey' => $_POST['gfKey']
		)
	);
}

echo $isInCart;