<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

if($_POST['id'] == false)
	exit;

$gift = DB::queryFirstRow("SELECT * FROM tmGift WHERE gfKey = %i",$_POST['id']);
$category = DB::query("SELECT gcId FROM tmGiftCategory WHERE gfKey = %i",$_POST['id']);

require_once("dev-giftDetail.skin.php");	
