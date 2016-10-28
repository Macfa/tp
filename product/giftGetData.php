<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
if(isNullVal($_GET['id'])) exit; 

$result = DB::queryFirstRow("SELECT * FROM tmGift WHERE gfKey = %i", $_GET['id']);
$result['gfCont'] = htmlspecialchars(removeBlank($result['gfCont']));
$result['quantity'] = 1;
$result['resultPoint'] = $result['gfPoint']*$result['quantity'];
$result['resultPointNumFormat'] = number_format($result['resultPoint']);
?>
<?=array2json($result)?>