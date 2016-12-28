<?php 
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

echo "<pre>";
print_r($_POST);
echo "</pre>";

try {		/* 입고 출고의 form 값이 view 로 떨어지는데 그때 값을 검출하기 위함. */

	if(isNullVal($_POST['inDate']))
		throw new Exception("날짜를 입력해주세요", 3);

	if(isNullVal($_POST['carrier']))
		throw new Exception("통신사를 선택해주세요", 3);

	if(isNullVal($_POST['goodReceipt']))
		throw new Exception("입고처를 선택해주세요", 3);

	if(isNullVal($_POST['modelCode']))
		throw new Exception("모델명을 선택해주세요", 3);

	if(isNullVal($_POST['color']))
		throw new Exception("색상을 선택해주세요", 3);

	if(isNullVal($_POST['serialNumber']))
		throw new Exception("일련번호를 재기입해주세요", 3);

	/*데이터베이스 내 검증하는 부분*/
	foreach($_POST['serialNumber'] as $key => $val) {	/*만약 입고 란에 일련번호가 중복되어 있다면 경고와 함께 종료*/
		if(DB::queryOneField('ivSerialNumber', "SELECT * FROM tmInventoryIn WHERE ivSerialNumber=%s", $val) != null) {
			$err_val .= $val.' ';
			$err = true;
		}
	}
	if($err === true) {
		throw new Exception($err_val."\\n위는 이미 입고처리 된 SerialKey 입니다", 3);
	}
	/*검증 종료*/

} catch (Exception $e) {
    alert($e->getMessage());
}

// 입고란에 인설트 하기 위한 배열저장
foreach($_POST['serialNumber'] as $key => $value) {
	$input_in[] = array(
		'ivSerialNumber' => $value,
		'ivGoodReceipt' => $_POST['goodReceipt'],
		'ivInDate' => $_POST['inDate']
		);

	$input_info[] = array(
		'inSerialNumber' => $value,
		'inModelCode' => $_POST['modelCode'],
		'inColor' => $_POST['color'],
		'inCarrier' => $_POST['carrier']
		);
}	
DB::insert('tmInventoryIn', $input_in);
DB::insert('tmInventoryInfo', $input_info);
DB::insert('tmInventoryAhull', array(
	'ahGoodReceipt' => $_POST['goodReceipt'],
	'ahCarrier' => $_POST['carrier']
	));
// 정보 테이블에 인설트 하기 위한 배열 저장

/*'재고' 란에서 모델의 수량을 센다*/
$model = count(DB::query("SELECT stModelCode FROM tmInventoryStock WHERE stModelCode=%s and stCarrier=%s and stColor=%s", $_POST['modelCode'], $_POST['carrier'], $_POST['color']));
$serial = count($_POST['serialNumber']); /*일련번호 ( 즉 입고된 기기의 수량가 몇개나 들어왔는지 ? )*/

if($model == 0) {	/*모델의 수량이 없다면 ( 처음 인설트 하는 거라면 )*/
	$insert = array(
		'stModelCode' => $_POST['modelCode'],
		'stGoodReceipt' => $_POST['goodReceipt'],
		'stCarrier' => $_POST['carrier'],
		'stColor' => $_POST['color'],
		'stEach' => $serial /* 입고된 기기의 총 수량을 대입한다 */
		);
	DB::insert('tmInventoryStock', $insert);
	$insert_ware = array(
		'iwModelCode' => $_POST['modelCode'],
		'iwColor' => $_POST['color'],
		'iwGoodReceipt' => $_POST['goodReceipt'],
		'iwEach' => $serial /* 입고된 기기의 총 수량을 대입한다 */
		);
	DB::insert('tmInventoryWare', $insert_ware);	
} else {	/* 모델의 수량이 기존에 있다면 .. */
	$each = DB::queryOneField('stEach', "SELECT * FROM tmInventoryStock WHERE stModelCode=%s and stCarrier=%s and stColor=%s", $_POST['modelCode'], $_POST['carrier'], $_POST['color']);
	DB::update('tmInventoryStock', array(	/*일련번호 수에 따른 수량 조절*/
		'stEach' => $each+$serial
	), 'stModelCode=%s and stCarrier=%s and stColor=%s', $_POST['modelCode'], $_POST['carrier'], $_POST['color']);

	DB::update('tmInventoryWare', array(
		'iwEach' => $each+$serial
		),	'iwModelCode=%s and iwColor=%s and iwGoodReceipt', $_POST['modelCode'], $_POST['color'], $_POST['goodReceipt']);
}

alert('인설트 되었습니다', 'tplDeviceView.php?check=checkbox_model');
 ?>
