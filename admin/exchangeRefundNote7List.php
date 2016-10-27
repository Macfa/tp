<?php
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
$add_css = '<link rel="stylesheet" href="'.PATH_CSS.'/mypageList.css" type="text/css">';
$js_file .= '<script type="text/javascript" src="'.PATH_JS.'/input.js"></script>';
require_once($cfg['path']."/headBlank.inc.php");			// 헤더 부분 (스킨포함)


$search = $_GET['search'];
$sql = "SELECT * FROM tmExchangeRefundNote7";

if(isExist($search) || isExist($_GET['serchProcess'])){
	$sql  .= " WHERE";
	$downloadUrl = $_SERVER['REQUEST_URI'];
	$downloadUrl = explode("?",$downloadUrl);
	$downloadFullUrl = "exchangeRefundNote7ListDownload.php?".$downloadUrl[1];
}

if(isExist($search)){
	$sql .= " (mbName LIKE %ss_search OR enPhone LIKE %ss_search)";
	$array['search'] = $search;

	
	}

if(isExist($_GET['serchProcess'])){		
	if(isExist($search))
	$sql  .= " and";
	$sql  .= " (enProcess=%i_serchProcess)";	
	$array['serchProcess'] = $_GET['serchProcess'];
}

$existList = DB::query($sql, $array);
$count = DB::count();




$gift = array(
	0 => '미수령',
	1 => '수령'
);

$way = array(
	'delivery' => '택배로 진행',
	'offline' => '방문하여 진행'
);

$type = array(
	'exchange' => '교환',
	'refund' => '환불'
);

$device = array(
	'galaxys7' => '갤럭시 S7',
	'galaxys7edge' => '갤럭시 S7 엣지',
	'galaxynote5' => '갤럭시 노트5',
	'v20' => 'LG V20',
	'iphone7' => '아이폰7',
	'iphone7Plus' => '아이폰7 플러스'
	
);


$color = array(
	'jetBlack' => '제트블랙',
	'black' => '블랙',
	'silver' => '실버',
	'gold' => '골드',
	'roseGold' => '로즈골드',
	'pink' => '핑크',
	'white' => '화이트',
	'pinkgold' => '핑크골드'
);

foreach($existList as $key => $row) {			
	$existList[$key]['processClass'] = ($row['enProcess']==='1')?'style=background-color:#e6ffe8':'1';
}

$process = array(
	0 => '미처리',
	1 => '처리'
);

require_once("exchangeRefundNote7List.skin.php");
require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)

?>