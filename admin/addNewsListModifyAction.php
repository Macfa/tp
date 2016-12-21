<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
include_once(PATH_LIB.'/lib.upload.inc.php');



function ncCategory($input){
	if(isExist($input) === false){
		return array();
	} return $input;
}

$selectedCategory = ncCategory($_POST['selectedCategory']);
$ncDevice = ncCategory($_POST['ncDeviceList']);
$ncCategoryModify = ncCategory($_POST['ncCategoryModify']);

$result = array_merge($selectedCategory, $ncDevice, $ncCategoryModify);

$newsKeyList = array_unique($result);

DB::delete('tmNewsCategory', "neKey=%i", $_POST['neKey']);

foreach ($newsKeyList as $device) {
		DB::insert('tmNewsCategory', 
			array(
				'neKey' => $neKey,
				'ncCategory' => $device
			)
		);


	}

 /*
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
  'neSubTit' => $_POST['neSubTit'],
  'neUrl' => $_POST['neUrl'],
  'neDisplay' => $_POST['neDisplayModify'],
  'neDatetime' => $cfg['time_ymdhis']

  ), "neKey=%i", $_POST['neKey']);

DB::update('tmNewsCategory', array(

  'ncCategory' => $_POST['ncCategoryModify'],
  'ncManuf' => $_POST['ncManufModify'],
  'ncDevice' => $_POST['ncDeviceModify']
  ), "neKey=%i", $_POST['neKey']);



alert('완료되었습니다.', "./addNewsListModify.php?neKey=".$_POST['neKey']);
*/
?>