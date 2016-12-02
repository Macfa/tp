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

		$fileNameCheck = substr_count($file_ary[$k]['name'],"_");
		if($fileNameCheck > 0){
			alert("파일명을 변경해주세요","./giftListModify.php?gfKey=".$_POST['gfKey']);
		}
		$arrUpload = Upload::setFile($file_ary[$k])->setMaxsize(1024000)->setAllowedExtension($allowedExtension)->setDirectory($img_dir)->upload();
		$arrfileNewName[$key] = '<img data-original="/image.index.php?name='.$arrUpload->fsId.'">';		
		
		$k++;

	}else{
		$arrfileNewName[$key] ='<img data-original="'.$fileName.'">';
	}
	
	$gfContModify = implode(" ", $arrfileNewName);

}

//=============== 썸네일 수정

try{
		if($fileNameCheck > 0)
			throw new Exception("파일명을 변경해주세요", 1);
		
		if(isExist($_POST['gfDisplayModify']) === false)
			throw new Exception("진열상태를 선택해주세요", 1);
		
} catch (Exception $e) {	
		
		alert($e->getMessage(),"./giftListModify.php?gfKey=".$_POST['gfKey']);

}

//=============== 썸네일 기존

$fileName = $_POST['gfThumb'];

if(isExist($_FILES['gfThumbModify']['name']) === true){
	
	$allowedExtension = 'jpg,png,gif';
	$img_dir = PATH_IMG_STORAGE;

	$upload = Upload::setFile($_FILES['gfThumbModify'])->setMaxsize(1024000)->setAllowedExtension($allowedExtension)->setDirectory($img_dir)->upload();

	try{
		
		if($upload === false)
			throw new Exception('업로드에 실패했습니다.', 1);
		
	} catch (Exception $e) {	
		
		alert($e->getMessage(),"./giftListModify.php?gfKey=".$_POST['gfKey']);

	}

	$fileName = $upload->fsId."_".$upload->arrfile['name'];
}



DB::update('tmGift', array(
  'gfTit' => $_POST['gfTit'],
  'gfSubTit' => $_POST['gfSubTit'],
  'gfPoint' => $_POST['gfPoint'],
  'gfThumb' => $fileName,
  'gfDisplay' => $_POST['gfDisplayModify'],
  'gfCont' => $gfContModify

  ), "gfKey=%i", $_POST['gfKey']);



alert('완료되었습니다.', "./giftListModify.php?gfKey=".$_POST['gfKey']);

?>
