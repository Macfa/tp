<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
require_once($cfg['path']."/headBlank.inc.php");	
?>
<style>
	img{max-width:100%;}
	*{font-size:0;}
</style>
<?
if($_GET['id'] == false)
	exit;

$giftDetail = DB::queryFirstField("SELECT gfCont FROM tmGift WHERE gfKey = %i",$_GET['id']);

echo $giftDetail;

require_once($cfg['path']."/footBlank.inc.php");	