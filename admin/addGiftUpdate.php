<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
include_once(PATH_LIB.'/lib.upload.inc.php');

$allowedExtension = 'jpg,png,gif';
$img_dir = PATH_IMG_STORAGE;

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


if (isExist($_FILES['gfCont'])) {
    $file_ary = reArrayFiles($_FILES['gfCont']);

    foreach ($file_ary as $val) {
    	    	
    	$arrUpload[] = Upload::setFile($val)->setMaxsize(1024000)->setAllowedExtension($allowedExtension)->setDirectory($img_dir)->upload();
		foreach ($arrUpload as $value) {


		} 
		$arrfileNewName[] = '<img data-original="'.$path_dir.'/image.index.php?name='.$value->fsId.'">';		
		$gfCont = implode(" ", $arrfileNewName);
		
    }
}


$upload = Upload::setFile($_FILES['gfThumb'])->setMaxsize(1024000)->setAllowedExtension($allowedExtension)->setDirectory($img_dir)->upload();

try{
	
	if($upload == false)
		throw new Exception('업로드에 실패했습니다.', 1);

	
} catch (Exception $e) {	
	
	alert($e->getMessage(),"/admin/addGift.php");

}

$fileNewName = $upload->fsId;


DB::insert('tmGift', 
			array(
				'gfTit' => $_POST['gfTit'],
				'gfSubTit' => $_POST['gfSubtit'],
				'gfPoint' => (int)$_POST['gfPoint'], 
				'gfThumb' => $fileNewName,
				'gfCont' => $gfCont

			)
		);


if(isExist($upload) === true){

	alert('완료되었습니다.', "/admin/addGift.php");

}

?>