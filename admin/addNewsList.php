<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

$js_file .= '<script type="text/javascript" src="'.PATH_JS.'/input.js"></script>';

require_once($cfg['path']."/adminhead.php");			// 헤더 부분 (스킨포함)

$display = array(
	0 => "진열안함",
	1 => "진열"
);

/*
$search = $_GET['search'];
$sql = "SELECT * FROM tmDevice";
	
if( isExist($_GET['display']) === false)
	$sql  .= "";

if(isExist($_GET['display']) || isExist($search)){
	$sql  .= " WHERE";
}

if(isExist($search)){
	$sql  .= " (dvTit LIKE %ss_search OR dvId LIKE %ss_search OR dvParent LIKE %ss_search OR dvModelCode LIKE %ss_search)";
	$array['search'] = $search;
}


if(isExist($_GET['display'])){	
	if(isExist($search))
	$sql  .= " and";
	$sql  .= " (dvDisplay=%i_display)";	
	$array['display'] = $_GET['display'];
	
	
}

$result = DB::query($sql.' ORDER BY neKey', $array);
*/

$result = DB::query("SELECT * FROM tmNews ");

foreach ($result as $val){ // $val = 기사 하나의 정보

	$neThumbPath[$val['neKey']] = "/image.index.php?name=";
	
	if(isExist($val['neThumb']) === false){		
		$neThumb[$val['neKey']]	= PATH_IMG.'/noimage.jpg';
	}else{
		$neThumb[$val['neKey']]	= $neThumbPath[$val['neKey']].$val['neThumb'];
	}		
}

require_once("addNewsList.skin.php");		

require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)
?>