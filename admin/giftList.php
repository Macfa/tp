<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

$js_file .= '<script type="text/javascript" src="'.PATH_JS.'/input.js"></script>';

require_once($cfg['path']."/adminhead.php");			// 헤더 부분 (스킨포함)


$display = array(
	0 => "진열안함",
	1 => "진열"
);

$search = $_GET['search'];
$sql = "SELECT * FROM tmGift";
	
if( isExist($_GET['display']) === false)
	$sql  .= "";

if(isExist($_GET['display']) || isExist($search)){
	$sql  .= " WHERE";
}

if(isExist($search)){
	$sql  .= " (gfTit LIKE %ss_search OR gfSubTit LIKE %ss_search)";
	$array['search'] = $search;
}


if(isExist($_GET['display'])){	
	if(isExist($search))
	$sql  .= " and";
	$sql  .= " (gfDisplay=%i_display)";	
	$array['display'] = $_GET['display'];
	
	
}


$giftInfo = DB::query($sql.' ORDER BY gfKey', $array);

foreach ($giftInfo as $val){

	$thumbString[$val['gfKey']] = DB::queryFirstField("SELECT gfThumb FROM tmGift WHERE gfKey=%i", $val['gfKey']);

	$tmp = $thumbString[$val['gfKey']];	

	$result[$val['gfKey']] = substr($tmp, 0, 4);

	if($result[$val['gfKey']] === 'gift'){		
		$gfThumbPath[$val['gfKey']] = PATH_IMG."/";
	}else{
		$gfThumbPath[$val['gfKey']] = "/image.index.php?name=";
	}
	if(isExist($val['gfThumb']) === false){		
		$gfThumb[$val['gfKey']]	= PATH_IMG.'/noimage.jpg';
	}else{
		$gfThumb[$val['gfKey']]	= $gfThumbPath[$val['gfKey']].$val['gfThumb'];
	}
	
}

require_once("giftList.skin.php");		

require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)
?>