<?php
include_once("../lib/lib.upload.inc.php");

// echo "<pre>FILE";
// var_dump($_FILES);
// echo "</pre>";

$upload = new Upload();
$upload->addFILE($_FILES['uploadfile']['name']);
$upload->checkFILE();
echo "sdasdasdasdasdasd";
// echo "<pre>upload";
// var_dump($upload);
// echo "</pre>";

// $filename = '/Users/chy/site/file/'.$_FILES["uploadfile"]["name"];
// echo $filename;
// $upload->addFILE($filename);
// $upload->upload();
 ?>
