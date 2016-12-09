<?php 
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
include_once(PATH_LIB."/lib.snoopy.inc.php");
include_once(PATH_LIB."/lib.parsing.inc.php");
include_once(PATH_LIB.'/lib.PHPExcel.inc.php');
include_once(PATH_LIB.'/PHPExcel/IOFactory.php');
require_once($cfg['path']."/adminhead.php");			// 헤더 부분 (스킨포함)
// include_once("sk_margin_test.php");
// include_once("kt_margin_test.php");
// ECHO META_CHARSET;



if ($_POST['chk_info'] === "sk") {
	// echo "sk file";
	// echo "<br/>";
	// var_dump($_FILES);
	// echo "<br/>";
	$actionFile = "updateRewardPointsk.php";
} elseif ($_POST['chk_info'] === "kt") {
	// echo "kt file";
	// echo "<br/>";
	// var_dump($_FILES);
	// echo "<br/>";
	$actionFile = "updateRewardPointkt.php";
} else {
	exit;
}
include_once($actionFile);


?>




<script>
$(function(){
	var $json = <?php echo json_encode($arr) ?>;
	var $array = json2array($json);
	var $data = {data : $array};
	console.log($array);
	//echo $.parseJSON(<?php echo json_encode($arr) ?>);

	$('.js-doAJAX').click(function(){
		$.ajax({
			url:'/admin/updateRewardPointAjaxAction.php',
			type:'post',
			async:false,
			data:$data,
			success:function(data){
				console.log(data);
			}
		});
	});
});
</script>

<br/>
<button type="button" class="js-doAJAX">Upload</button>

<?php require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)


