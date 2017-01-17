<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
include_once(PATH_LIB.'/lib.upload.inc.php');

$allowedExtension = 'jpg,png,gif';
$img_dir = PATH_IMG_STORAGE;


//=============== 썸네일 이미지

$thumbFileName = $_POST['neThumb'];

if(isExist($_FILES['neThumbModify']['name']) === true){	


	$upload = Upload::setFile($_FILES['neThumbModify'])->setMaxsize(1024000)->setAllowedExtension($allowedExtension)->setDirectory($img_dir)->upload();

	try{
		
		if($upload === false)
			throw new Exception('업로드에 실패했습니다.', 1);

		if(isURL($_POST['neUrl']) === false)
			throw new Exception('유효한 URL이 아닙니다', 1);
		
	} catch (Exception $e) {	
		
		alert($e->getMessage(),"./addNewsListModify.php?neKey=".$_POST['neKey']);

	}

	$thumbFileName = $upload->fsId;
}




DB::update('tmNews', array(
  'neThumb' => $thumbFileName,
  'neTit' => $_POST['neTit'],
  'neUrl' => $_POST['neUrl'],
  'neDisplay' => $_POST['neDisplayModify'],
  'neDatetime' => $cfg['time_ymdhis']

  ), "neKey=%i", $_POST['neKey']);


//=============== 카테고리 수정

$deletedCategory = $_POST['deletedCategory'];
$deviceModify = $_POST['deviceModify'];
$categoryModify = $_POST['categoryModify'];


//삭제한 카테고리 DB 삭제
if(isExist($deletedCategory)){	
	foreach ($deletedCategory as $delete) {
		DB::delete('tmNewsCategory', "neKey=%i AND ncCategory=%s", $_POST['neKey'], $delete);
	}
}
//추가한 기기 DB 추가
if(isExist($deviceModify)){	
	foreach ($deviceModify as $device) {
		DB::insert('tmNewsCategory', 
				array(
					'neKey' => $_POST['neKey'],
					'ncCategory' => $device
				)
		);
	}
}
//추가한 카테고리 DB 추가
if(isExist($categoryModify)){	
	foreach ($categoryModify as $category) {
		DB::insert('tmNewsCategory', 
				array(
					'neKey' => $_POST['neKey'],
					'ncCategory' => $category
				)
		);
	}
}




alert('완료되었습니다.', "./addNewsListModify.php?neKey=".$_POST['neKey']);

?>