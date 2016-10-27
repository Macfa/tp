<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
require_once($cfg['path']."/headBlank.inc.php");	
?>
<style>
	img{max-width:100%;display:block;}
	*{font-size:0;}
	body{padding-top:30px;}
</style>
<?
if($_GET['id'] == false)
	exit;

$deviceDetail = DB::queryFirstField("SELECT dvDetail FROM tmDevice WHERE dvId= %s",$_GET['id']);

echo "<br/><br/><br/>".$deviceDetail;

require_once($cfg['path']."/footBlank.inc.php");	