<?php 
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
include_once(PATH_LIB."/lib.snoopy.inc.php");
include_once(PATH_LIB."/lib.parsing.inc.php");
include_once(PATH_LIB.'/lib.PHPExcel.inc.php');
include_once(PATH_LIB.'/PHPExcel/IOFactory.php');
// include_once("sk_margin_test.php");
// include_once("kt_margin_test.php");
ECHO META_CHARSET;



if ($_POST['chk_info'] === "sk") {
	// echo "sk file";
	// echo "<br/>";
	// var_dump($_FILES);
	// echo "<br/>";
	include_once("sk_margin_test.php");
} elseif ($_POST['chk_info'] === "kt") {
	// echo "kt file";
	// echo "<br/>";
	// var_dump($_FILES);
	// echo "<br/>";
	include_once("kt_margin_test.php");
} else {
	exit;
}

?>
