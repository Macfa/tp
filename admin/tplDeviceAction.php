<?php 
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

echo "<pre>";
print_r($_POST);
echo "</pre>";

try {		/* 입고 출고의 form 값이 view 로 떨어지는데 그때 값을 검출하기 위함. */

	if(isNullVal($_POST['inDate']))
		throw new Exception("날짜를 입력해주세요", 3);

	if(isNullVal($_POST['newsAgency']))
		throw new Exception("통신사를 선택해주세요", 3);

	if(isNullVal($_POST['goodReceipt']))
		throw new Exception("입고처를 선택해주세요", 3);

	if(isNullVal($_POST['modelCode']))
		throw new Exception("모델명을 선택해주세요", 3);

	if(isNullVal($_POST['color']))
		throw new Exception("색상을 선택해주세요", 3);

	if(isNullVal($_POST['serialNumber']))
		throw new Exception("일련번호를 재기입해주세요", 3);

} catch (Exception $e) {
    alert($e->getMessage());
}

foreach($_POST['serialNumber'] as $key => $value) {
	$input[] = array(
		'ivSerialNumber' => $value,
		'ivModelCode' => $_POST['modelCode'],
		'ivColor' => $_POST['color'],
		'ivNewsAgency' => $_POST['newsAgency'],
		'ivGoodReceipt' => $_POST['goodReceipt'],
		'ivInDate' => $_POST['inDate']);
}
	

DB::insert('tmInventory', $input);

alert('인설트 되었습니다', 'tplDeviceView.php');
 ?>