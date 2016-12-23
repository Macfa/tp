<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

$orderNumber = '';
for($i=0;$i<9999;$i++){
	$orderNumber = 'G'.date("Ymd", $cfg['server_time']).'-'.date("His", $cfg['server_time']).get_random_num(6);
	$isExistOrderNumber = DB::queryFirstField('SELECT COUNT(*) FROM tmOrder WHERE orOrderNumber = %s', $orderNumber);
	$isExistOrderNumber = ((int)$isExistOrderNumber > 0)?true:false;
	if($isExistOrderNumber === false) break;
}

echo $orderNumber;