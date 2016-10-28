<?php
include_once('./_common.inc.php');
?>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<style>
	html,body{width:100%:height:100%;padding:0;margin:0;}
	*{margin:0;padding:0}
</style>
<?
if(isNotExist($_GET['img'])) {
	echo "<script>alert('이미지 주소가 필요합니다.');";
	exit;
}
?>

<iframe width="100%" height="100%" allowfullscreen frameborder="0" src="//storage.googleapis.com/vrview/index.html?image=http://crossorigin.me/http://traum.co.kr/images/<?php echo $_GET['img']?>"></iframe>