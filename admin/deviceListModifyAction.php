<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
include_once(PATH_LIB.'/lib.upload.inc.php');

$detailImage = $_POST['detailImage']; 

$allowedExtension = 'jpg,png,gif';
$img_dir = PATH_IMG_STORAGE;



//=============== 썸네일 이미지

$thumbFileName = $_POST['dvThumb'];

if(isExist($_FILES['dvThumbModify']['name']) === true){
	
	$allowedExtension = 'jpg,png,gif';
	$img_dir = PATH_IMG_STORAGE;

	$upload = Upload::setFile($_FILES['dvThumbModify'])->setMaxsize(1024000)->setAllowedExtension($allowedExtension)->setDirectory($img_dir)->upload();

	try{
		
		if($upload === false)
			throw new Exception('썸네일 업로드에 실패했습니다.', 1);
		
	} catch (Exception $e) {	
		
		alert($e->getMessage(),"./deviceListModify.php?dvKey=".$_POST['dvKey']);

	}

	$thumbFileName = $upload->fsId;
}

//=============== 디테일썸네일

$detailThumbFileName = $_POST['dvDetailThumb'];

if(isExist($_FILES['dvDetailThumbModify']['name']) === true){
	
	$allowedExtension = 'jpg,png,gif';
	$img_dir = PATH_IMG_STORAGE;

	$upload = Upload::setFile($_FILES['dvDetailThumbModify'])->setMaxsize(1024000)->setAllowedExtension($allowedExtension)->setDirectory($img_dir)->upload();

	try{
		
		if($upload === false)
			throw new Exception('디테일썸네일 업로드에 실패했습니다.', 1);
		
	} catch (Exception $e) {	
		
		alert($e->getMessage(),"./deviceListModify.php?dvKey=".$_POST['dvKey']);

	}

	$detailThumbFileName = $upload->fsId;
}

//=============== 기기 상세페이지

function reArrayFiles($file_post) {

    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);

    for ($i=0; $i<$file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }

    return $file_ary;
}

$file_ary = reArrayFiles($_FILES['detailAddImg']);

$k = 0;
foreach ($detailImage as $key => $fileName) {	

	if(isExist($fileName) === false){

		$arrUpload = Upload::setFile($file_ary[$k])->setMaxsize(1024000)->setAllowedExtension($allowedExtension)->setDirectory($img_dir)->upload();
		$arrfileNewName[$key] = '<img data-original="/image.index.php?name='.$arrUpload->fsId.'">';		
		
		$k++;

	}else{
		$arrfileNewName[$key] ='<img data-original="'.$fileName.'">';
	}
	
	$dvDetailModify = implode(" ", $arrfileNewName);

}


DB::update('tmDevice', array(
  'dvThumb' => $thumbFileName,
  'dvDetailThumb' => $detailThumbFileName,
  'dvDisplay' => $_POST['dvDisplayModify'],
  'dvDetail' => $dvDetailModify,
  'dvChannelSK' => $_POST['sktmChannel'],
  'dvChannelKT' => $_POST['kttmChannel'],

  ), "dvKey=%i", $_POST['dvKey']);




//=============== DB에 색상 추가

$cnt = count($_POST['dvKeyChild']);
$arrKey = $_POST['dvKeyChild'];
$arrColor = $_POST['dcColor'];
$arrOrginColor = $_POST['dcOriginColor'];

for($i=0; $i<$cnt; $i++){
$newArr[] = array(
	$arrKey[$i] => $arrColor[$i]

	);
$originArr[] = array(
	$arrKey[$i] => $arrOrginColor[$i]

	);
}
if(isExist($_POST['dvKeyChild']) === false){
	$newArr[] = array(
		$_POST['dvKey'] => $arrColor

	);
	$originArr[] = array(
		$_POST['dvKey'] => $arrOrginColor

		);
}

//키값 value 재정렬하는 함수
function makerArr ($input){
	foreach ($input as $val) {
		foreach ($val as $key => $value) {
			$output[$key] = explode(',', $value);
		}		
	}		
	return $output;	
}

$colorList = makerArr($newArr);
$originColorList = makerArr($originArr);

if(isExist($_POST['dvKeyChild']) === false){
	$arrKey = array(
		0 => $_POST['dvKey']
		);

}


//array_diff 결과 배열 key값 재정렬하는 함수
function orderKey ($input){
	$i = 0; 
	foreach($input as $key=>$val){  
	    unset($array1[$key]);  	  
	    $new_key = $i;  
	    $array1[$new_key] = $val;  	  
	    $i++;  
	}  	
	return $array1;	
}




foreach ($arrKey as $value) {
	$a1=$originColorList[$value]; // 원래색상
	$a2=$colorList[$value]; // 바뀐색상

	// 삭제된 색상
	$delete[$value] = orderKey(array_unique(array_diff($a1,$a2)));  
	$deleteCount = count($delete[$value]);
	for ($i=0; $i < $deleteCount ; $i++) { 
		DB::delete("tmDeviceColor", " dvKey = %i and dcColor = %s", $value, trim($delete[$value][$i]));	
	}


	// 추가한 색상
	$insert[$value] = orderKey(array_unique(array_diff($a2,$a1)));  
	$insertCount = count($insert[$value]);
	var_dump($insert[$value]);
	for ($j=0; $j < $insertCount ; $j++) {
		if(isExist($insert[$value][$j]) === true){			
			DB::insert('tmDeviceColor', 
				array(
					'dvKey' => $value,
					'dcColor' => trim($insert[$value][$j])
				)
			);							
		}			
	}
}
						


alert('완료되었습니다.', "./deviceListModify.php?dvKey=".$_POST['dvKey']);

?>
