<?

require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

require_once("./_adminhead.php");			// 헤더 부분 (스킨포함)


$giftInfo =  DB::queryFirstRow("SELECT * FROM tmGift WHERE gfKey=%i", $_GET['gfKey']);

try{

	if(isExist($giftInfo) === false)
		throw new Exception('존재하지 않는 사은품입니다', 3);
	
} catch (Exception $e) {	

	alert($e->getMessage(), "./giftList.php");
}


$tmp = $giftInfo['gfThumb'];	

$result = substr($tmp, 0, 4);

if($result === 'gift'){		
	$gfThumbPath= PATH_IMG."/";
}else{
	$gfThumbPath = PATH."/image.index.php?name=";	
}
if(isExist($giftInfo['gfThumb']) === false){		
		$gfThumb = PATH_IMG.'/noimage.jpg';
	}else{
		$gfThumb = $gfThumbPath.$giftInfo['gfThumb'];
	}

$display = array(
	0 => "진열안함",
	1 => "진열"
);


if(isExist($giftInfo['gfCont']) === true){

	$arrdetailImage = explode("<img", $giftInfo['gfCont']);

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









require_once("giftListModify.skin.php");		

require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)
?>