<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

$poLandingPage = preg_replace('/http:\/\/(ehgu09\.)*tplanit\.co\.kr/', '', $_POST['poLandingPage']);
$poApplyPage = preg_replace('/http:\/\/(ehgu09\.)*tplanit\.co\.kr/', '', $_POST['poApplyPage']);

$preorderList = DB::query("SELECT * FROM tmPreorder WHERE poDeviceName=%s0 OR (poLandingPage = %s1 AND poApplyPage = %s2)", $_POST['poDeviceName'],$poLandingPage,$poApplyPage);
$preorderList = count($preorderList);



try{
	if(isNullVal($_POST['poDeviceName']))
		throw new Exception('기기명을 넣어주세요', 3);

	if(isNullVal($_POST['poLandingPage']))
		throw new Exception('랜딩페이지를 넣어주세요', 3);
	
	if(isNullVal($_POST['poApplyPage']))
		throw new Exception('신청페이지를 넣어주세요', 3);
	
} catch (Exception $e) {	

	alert($e->getMessage());
}


if($preorderList === 0){
	DB::insert('tmPreorder', array(
		'poDeviceName' => $_POST['poDeviceName'],
		'poLandingPage' => $poLandingPage,
		'poApplyPage' => $poApplyPage,
		'poDisplay' => $_POST['poDisplay'],
		'poDatetime' =>$cfg['time_ymdhis']
  ));
 
}else if($preorderList === 1){
	DB::update('tmPreorder', array(
		'poDeviceName' => $_POST['poDeviceName'],
		'poLandingPage' => $poLandingPage,
		'poApplyPage' => $poApplyPage,
		'poDisplay' => $_POST['poDisplay'],
		'poDatetime' =>$cfg['time_ymdhis']
	  ),"poLandingPage = %s AND poApplyPage = %s", $poLandingPage, $poApplyPage);

}

alert('완료되었습니다.', "/admin/preorderCreate.php");

?>