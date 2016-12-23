<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

$js_file .= '<script type="text/javascript" src="'.PATH_JS.'/input.js"></script>';

require_once($cfg['path']."/adminhead.php");			// 헤더 부분 (스킨포함)

$display = array(
	0 => "진열안함",
	1 => "진열"
);


$search = $_GET['search'];
$sql = "SELECT * FROM tmDevice ";
	
if( isExist($_GET['display']) === false and isExist($search) === false)
	$sql  .= " WHERE dvParent=0";

if(isExist($_GET['display']) || isExist($search)){
	$sql  .= " WHERE dvParent=0 AND";
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

$result = DB::query($sql.' ORDER BY dvKey', $array);

foreach ($result as $val){

	$thumbString[$val['dvKey']] = DB::queryFirstField("SELECT dvThumb FROM tmDevice WHERE dvKey=%i", $val['dvKey']);

	$tmp = $thumbString[$val['dvKey']];	

	$result[$val['dvKey']] = substr($tmp, 0, 6);

	if($result[$val['dvKey']] === 'device'){		
		$dvThumbPath[$val['dvKey']] = PATH_IMG."/";
	}else{
		$dvThumbPath[$val['dvKey']] = "/image.index.php?name=";
	}
	if(isExist($val['dvThumb']) === false){		
		$dvThumb[$val['dvKey']]	= PATH_IMG.'/noimage.jpg';
	}else{
		$dvThumb[$val['dvKey']]	= $dvThumbPath[$val['dvKey']].$val['dvThumb'];
	}	
	
}

require_once("deviceList.skin.php");		

require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)
?>