<?

require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

require_once("./_adminhead.php");			// 헤더 부분 (스킨포함)


$deviceInfo =  DB::queryFirstRow("SELECT * FROM tmDevice WHERE dvKey=%i", $_GET['dvKey']);

try{

	if(isExist($deviceInfo) === false)
		throw new Exception('존재하지 않는 기기입니다', 3);
	
} catch (Exception $e) {	

	alert($e->getMessage(), "./deviceList.php");
}

function checkThumb($thumb){
	$result = substr($thumb, 0, 6);
	if($result === 'device'){		
		$dvThumbPath= PATH_IMG."/";
	}else{
		$dvThumbPath = "/image.index.php?name=";	
	}
	
	if(isExist($thumb) === false){		
		$val = PATH_IMG.'/noimage.jpg';
	}else{
		$val = $dvThumbPath.$thumb;
	}

	return $val;
}

$dvThumb = checkThumb($deviceInfo['dvThumb']);

$dvDetailThumb = checkThumb($deviceInfo['dvDetailThumb']);


$display = array(
	0 => "진열안함",
	1 => "진열"
);


if(isExist($deviceInfo['dvDetail']) === true){

	$arrdetailImage = explode("<img", $deviceInfo['dvDetail']);

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





require_once("deviceListModify.skin.php");		

require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)
?>