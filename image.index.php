<?
require_once("./common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

$fileExtension = explode(".", $_GET['name']);

header("Content-type: image/".$fileExtension[1]);


$fsFileName = DB::queryFirstField("SELECT fsFileName FROM tmFileStorage where fsId=%s_fsId",array(
	'fsId' => $_GET['name']
	));

$url = PATH_IMG_STORAGE.$fsFileName;

$fp = fopen($url,"r");
$img_data = fread($fp,filesize($url));
fclose($fp);

echo $img_data;



?>