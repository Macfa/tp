<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

$neHit = DB::queryFirstField("SELECT neHit FROM tmNews WHERE neKey=%i", $_POST['neKey']);

DB::update('tmNews', array(
  'neHit' => $neHit+1
  ), "neKey=%i", $_POST['neKey']);
 

?>