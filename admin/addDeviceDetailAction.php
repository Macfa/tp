<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
include_once(PATH_LIB.'/lib.upload.inc.php');
var_dump($_POST);
/*
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


if (isExist($_FILES['dvDetail'])) {
    $file_ary = reArrayFiles($_FILES['dvDetail']);

    foreach ($file_ary as $val) {
    	    	
    	$arrUpload[] = Upload::setFile($val)->setMaxsize(1024000)->setAllowedExtension($allowedExtension)->setDirectory($img_dir)->upload();
		foreach ($arrUpload as $value) {


		} 
		$arrfileNewName[] = '<img data-original="'.$path_dir.'/image.index.php?name='.$value->fsId.'">';		
		$dvDetail = implode(" ", $arrfileNewName);
		
    }
}


$fileNewName = $upload->fsId;


DB::insert('tmDevice', 
			array(
				'dvDetail' => $dvDetail

			)
		);


if(isExist($upload) === true){

	alert('완료되었습니다.', "/admin/addGift.php");

}
*/
?>