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


//=============== 썸네일 경로 설정
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


//=============== 상세페에지 설정

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



//=============== DB에서 색상 가져오기


//해당 기기를 부모로 가진 기기
$deviceCapacityList = DB::query("SELECT * FROM tmDevice WHERE dvParent=%i", $_GET['dvKey']);
$isExistCapacity = (count($deviceCapacityList)>0)?true:false;

if($isExistCapacity === true){ // 용량이 나누어져 있는 경우
	foreach ($deviceCapacityList as $val) {

		$arr = DB::query("SELECT dcColor FROM tmDeviceColor WHERE dvKey=%i", $val['dvKey']);
		foreach ($arr as $key => $v) {		
			$array[$val['dvKey']][] = $v['dcColor'];
		}
	}

	if(empty($array) === false){ // color DB에 추가 되었을때만..
		foreach ($array as $key => $value) {
			foreach ($value as $val) {
				$color[$key][] = $val;
				$str = implode(',', $color[$key]);	
			}

			$strList[$key] = $str;
		}
	}
}else{ // 용량이 나누어져 있지 않은 경우
	$arr = DB::query("SELECT dcColor FROM tmDeviceColor WHERE dvKey=%i", $_GET['dvKey']);
	
	if(empty($arr) === false){ // DB에 color가 존재하면..
		foreach ($arr as $key => $value) {			
			$arrVal[] = $value['dcColor'];
			$str = implode(',', $arrVal);	
		}
	}
}


$display = array(
	0 => "진열안함",
	1 => "진열"
);

$SKtmChannel = DB::query("SELECT * FROM tmChannel WHERE chCarrier = %s", 'sk');
$KTtmChannel = DB::query("SELECT * FROM tmChannel WHERE chCarrier = %s", 'kt');
$LGmChannel = DB::query("SELECT * FROM tmChannel WHERE chCarrier = %s", 'lg');

require_once("deviceListModify.skin.php");		

require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)
?>