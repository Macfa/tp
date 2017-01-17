<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

//================== 진행상황 변경

$checked = $_POST['chk'];
$changeProcess = $_POST['changeProcess'];

try{
	
	if($isLogged == false)
		throw new Exception('로그인 해주세요!', 3);

	if(isExist($checked) === false)
		throw new Exception('적용할 행을 선택해주세요', 3);

	if(isExist($changeProcess) === false)
		throw new Exception('진행상황을 선택해주세요', 3);


	
} catch (Exception $e) {	

	alert($e->getMessage());
}


foreach($checked as $checkedList){
	DB::update('tmApplyTmp', 
			array(
				'apProcess' => $changeProcess
			), "apKey=%i", $checkedList
		);

	$productOrderMember = DB::queryFirstRow("SELECT * FROM  tmApplyTmp WHERE apKey=%s", $checkedList);	

}


goURL($cfg['url']."/admin/productOrderList.php");

?>