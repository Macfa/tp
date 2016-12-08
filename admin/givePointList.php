<?

require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

$js_file .= '<script type="text/javascript" src="'.PATH_JS.'/input.js"></script>';

require_once($cfg['path']."/adminhead.php");			// 헤더 부분 (스킨포함)
$cutline = '2016-11-1 00:00:00';

$existList = DB::query("SELECT * FROM tmPointHistory WHERE phDate >= %s AND mbEmail !='admin@naver.com' ANd mbEmail !='kies13@naver.com'ANd mbEmail !='kizunamj@traum.asia' AND mbEmail != 'traumcorp@gmail.com' AND mbEmail !='hdhcoss1@naver.com' AND mbEmail !='terracanjeep@nate.com' AND mbEmail !='crepubic@naver.com' AND mbEmail != 'gpfusl84@naver.com'", $cutline);

foreach($existList as $key => $row){

	$existList[$key]['mbName'] = DB::queryFirstField("SELECT mbName FROM tmMember WHERE mbEmail = %s",$row['mbEmail']);
	$existList[$key]['mbPhone'] = DB::queryFirstField("SELECT mbPhone FROM tmMember WHERE mbEmail = %s",$row['mbEmail']);




}




$k = substr($a, -5, -2);


if(isExist($_GET['search'])){
$existList = DB::query("SELECT * FROM tmPointHistory WHERE mbEmail LIKE %ss_search OR phCont LIKE %ss_search", 
	array(
    'search' => $_GET['search']
	));
}

require_once("givePointList.skin.php");		

require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)
?>