<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
require_once($cfg['path']."/headBlank.inc.php");	
?>
<style>
	*{font-size:0;}
</style>
<?
if($_GET['id'] == false)
	exit;
?>
<iframe src="" class="layer-view-iframe" name="tgate" scrolling="yes"></iframe>
<?
require_once($cfg['path']."/footBlank.inc.php");	