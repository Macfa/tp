<?

require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

$js_file .= '<script type="text/javascript" src="'.PATH_JS.'/input.js"></script>';

require_once("./_adminhead.php");			// 헤더 부분 (스킨포함)



$newsInfo =  DB::queryFirstRow("SELECT * FROM tmNews WHERE neKey=%i", $_GET['neKey']);
$newsCategory =  DB::query("SELECT * FROM tmNewsCategory WHERE neKey=%i ORDER BY ncCategory", $_GET['neKey']);


try{

	if(isExist($newsInfo) === false)
		throw new Exception('존재하지 않는 정보글입니다', 3);
	
} catch (Exception $e) {	

	alert($e->getMessage(), "./addNewsList.php");
}

	$dvThumbPath = "/image.index.php?name=";

	if(isExist($newsInfo['neThumb']) === false){		
		$thumbImg = PATH_IMG.'/noimage.jpg';
	}else{
		$thumbImg = $dvThumbPath.$newsInfo['neThumb'];
	}



$display = array(
	0 => "진열안함",
	1 => "진열"
);


if(isExist($newsInfo['dvDetail']) === true){

	$arrdetailImage = explode("<img", $newsInfo['dvDetail']);

	foreach ($arrdetailImage as $key => $detailImage) {
		$arrfileNameTag = "<img".$detailImage;	

		preg_match('/data-original="(.*)"/', $arrfileNameTag, $file);				
		preg_replace("/\s+/","",$file[1]);
				
		$arrfileInfo[$key] = array(
			'tag' => $arrfileNameTag,
			'name' => $file[1]
			);		
		unset($arrfileInfo[0]);
	}
}else{ 

	$arrfileInfo[0] = array(
		0 => ""		
	);
}


foreach ($newsCategory as $category){
	$array[$category['ncKey']] = $category['ncCategory'];
}

if(isNullVal($array) === true){
	$array = array(
		0 => '선택된 카테고리 없음'
		);
}
$category = implode(",", $array);



$deviceDisplay = DB::query("SELECT * FROM tmDevice WHERE dvDisplay=1 AND dvParent = 0");

$arrDailyHit = DB::query("SELECT * FROM tmNewsHitsDaily d LEFT JOIN tmNews n ON d.neKey = n.neKey WHERE d.neKey=%i ORDER BY d.ndDay DESC",$newsInfo['neKey']);

require_once("addNewsListModify.skin.php");		

require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)

?>