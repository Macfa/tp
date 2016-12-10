<?php
$finfo = new finfo();
$basefile_type = $finfo->open(FILEINFO_MIME_TYPE);
$basefile_type->file($value);
echo "<pre>basefile";
var_dump($basefile_type);
echo "</pre>";
 ?>
