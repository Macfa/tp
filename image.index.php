<?
require_once("./common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

$fileExtension = explode(".", $_GET['name']);

header("Content-type: image/".$fileExtension[1]);

$fileName = explode("_", $_GET['name']);

$fsFileName = DB::queryFirstField("SELECT fsFileName FROM tmFileStorage where fsId=%s_fsId AND fsOriginalName=%s_fsOriginalName",array(
	'fsId' => $fileName[0],
	'fsOriginalName' => $fileName[1]
	));

$url = PATH_IMG_STORAGE.$fsFileName;

$fp = fopen($url,"r");
$img_data = fread($fp,filesize($url));
fclose($fp);

echo $img_data;



?>