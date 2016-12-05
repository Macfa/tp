<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
include_once(PATH_LIB.'/lib.upload.inc.php');

$detailImage = $_POST['detailImage']; 

$allowedExtension = 'jpg,png,gif';
$img_dir = PATH_IMG_STORAGE;

//=============== 상세페이지

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

//=============== 썸네일 이미지

$thumbFileName = $_POST['dvThumb'];

if(isExist($_FILES['dvThumbModify']['name']) === true){
	
	$allowedExtension = 'jpg,png,gif';
	$img_dir = PATH_IMG_STORAGE;

	$upload = Upload::setFile($_FILES['dvThumbModify'])->setMaxsize(1024000)->setAllowedExtension($allowedExtension)->setDirectory($img_dir)->upload();

	try{
		
		if($upload === false)
			throw new Exception('업로드에 실패했습니다.', 1);
		
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
			throw new Exception('업로드에 실패했습니다.', 1);
		
	} catch (Exception $e) {	
		
		alert($e->getMessage(),"./deviceListModify.php?dvKey=".$_POST['dvKey']);

	}

	$detailThumbFileName = $upload->fsId;
}




DB::update('tmDevice', array(
  'dvThumb' => $thumbFileName,
  'dvDetailThumb' => $detailThumbFileName,
  'dvDisplay' => $_POST['dvDisplayModify'],
  'dvDetail' => $dvDetailModify

  ), "dvKey=%i", $_POST['dvKey']);



alert('완료되었습니다.', "./deviceListModify.php?dvKey=".$_POST['dvKey']);

?>
