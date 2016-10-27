<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)


$checked = $_POST['chk'];

try{
	
	if($isLogged == false)
		throw new Exception('로그인 해주세요!', 3);

	if(isExist($checked) === false)
		throw new Exception('적용할 행을 선택해주세요', 3);

	if(isExist($_POST['changeProcess']) === false)
		throw new Exception('진행상황을 선택해주세요', 3);


	
} catch (Exception $e) {	

	alert($e->getMessage());
}



foreach($checked as $checkedList){
	DB::update('tmExchangeRefundNote7', array(
		 'enProcess' =>$_POST['changeProcess']
	  ), "enKey=%i", $checkedList);
}



/*
$SMS = new SMS();
foreach($checked as $checkedList){
	$preorderMember = DB::queryFirstRow("SELECT * FROM tmPreorderApplyList WHERE paKey=%s", $checkedList);
	$SMS->sendMode(0)->sendMemberPhone($preorderMember['paPhone'])->sendMemberName($preorderMember['paName'])->sendCont($sendCont)->send();
}
*/

goURL($cfg['url']."/admin/exchangeRefundNote7List.php");



?>