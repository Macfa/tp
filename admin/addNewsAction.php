<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
include_once(PATH_LIB.'/lib.upload.inc.php');

$allowedExtension = 'jpg,png,gif';
$img_dir = PATH_IMG_STORAGE;


$upload = Upload::setFile($_FILES['neThumb'])->setMaxsize(1024000)->setAllowedExtension($allowedExtension)->setDirectory($img_dir)->upload();

try{
	
	if($upload == false)
		throw new Exception('업로드에 실패했습니다.', 1);

	if(isURL($_POST['neUrl']) === false)
		throw new Exception('유효한 URL이 아닙니다', 1);

	
} catch (Exception $e) {	
	
	alert($e->getMessage(),"/admin/addNews.php");

}

$fileNewName = $upload->fsId;





DB::insert('tmNews', 
			array(
				'neTit' => $_POST['neTit'],
				'neSubTit' => $_POST['neSubTit'],
				'neUrl' => $_POST['neUrl'], 
				'neThumb' => $fileNewName,
				'neDatetime' => $cfg['time_ymdhis']

			)
		);





if(isExist($upload) === true){
	$neKey = DB::queryFirstField("SELECT neKey FROM tmNews WHERE neThumb=%s", $fileNewName);

	$ncDeviceList = $_POST['ncDeviceList'];
	$ncCategory = $_POST['ncCategory'];

	foreach ($ncDeviceList as $device) {
		DB::insert('tmNewsCategory', 
			array(
				'neKey' => $neKey,
				'ncCategory' => $device
			)
		);


	}
	foreach ($ncCategory as $category) {
		DB::insert('tmNewsCategory', 
			array(
				'neKey' => $neKey,
				'ncCategory' => $category
			)
		);


	}
	
	alert('완료되었습니다.', "/admin/addNewsList.php");

}

?>