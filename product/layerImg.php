<?
if (!$_GET['q']) exit;
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
require_once($cfg['path']."/headBlank.inc.php");	
?>
<style>
	img{max-width:100%;}
</style>
<img src="<?=PATH_IMG?>/<?=$_GET['q']?>"/>
<?PHP
require_once($cfg['path']."/footBlank.inc.php");	