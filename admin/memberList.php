<?

require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
$add_css = '<link rel="stylesheet" href="'.PATH_CSS.'/mypageList.css" type="text/css">';
$js_file .= '<script type="text/javascript" src="'.PATH_JS.'/input.js"></script>';

require_once($cfg['path']."/head.inc.php");		// 헤더 부분 (스킨포함)

$existList = DB::query("SELECT * FROM tmMember WHERE mbName",'1');

if(isExist($_GET['search'])){
$existList = DB::query("SELECT * FROM tmMember WHERE mbName LIKE %ss_search OR mbPhone LIKE %ss_search OR mbEmail LIKE %ss_search", 
	array(
    'search' => $_GET['search']
	));
}

require_once("memberList.skin.php");		

require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)
?>