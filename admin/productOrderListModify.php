<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

//================== 신청서 수정페이지

$checked = $_POST['chk'];

try{
	
	if($isLogged == false)
		throw new Exception('로그인 해주세요!', 3);

	if(isExist($checked) === false)
		throw new Exception('적용할 행을 선택해주세요', 3);


	
} catch (Exception $e) {	

	alert($e->getMessage());
}

foreach($checked as $checkedList){	
	$modifyApply = DB::queryFirstRow("SELECT * FROM tmApplyTmp AS apply LEFT JOIN tmDevice AS device ON apply.dvKey = device.dvKey WHERE apKey=%i", $checkedList);	
}


//===========수정하기 페이지 url

if((int)$modifyApply['dvParent'] === 0){ // 용량이 따로 없는 기기	
	$deviceId = $modifyApply['dvId'];

}else{ // 용량이 따로 있는 기기
	list($applyDevice, $parentId) = DB::queryFirstList("SELECT dvTit, dvId FROM tmDevice WHERE dvKey=%i", $modifyApply['dvParent']);
	$applyCapacity = $modifyApply['dvTit'];
	$deviceId = $parentId;

}


goURL($cfg['url']."/apply/?apKey=".$modifyApply['apKey'].".&v=edit&mbEmail=".$modifyApply['mbEmail']);


?>