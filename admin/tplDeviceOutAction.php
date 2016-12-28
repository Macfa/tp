<?php 
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

echo "<pre>";
print_r($_POST);
echo "</pre>";

try {		/* 입고 출고의 form 값이 view 로 떨어지는데 그때 값을 검출하기 위함. */

	if(isNullVal($_POST['outDate']))
		throw new Exception("출고일을 정해주세요", 3);

	if(isNullVal($_POST['carrier']))
		throw new Exception("통신사를 선택해주세요", 3);

	if(isNullVal($_POST['modelCode']))
		throw new Exception("모델명을 선택해주세요", 3);

	if(isNullVal($_POST['color']))
		throw new Exception("색상을 선택해주세요", 3);

	if(isNullVal($_POST['serialNumber']))
		throw new Exception("일련번호를 재기입해주세요", 3);

	if(isNullVal($_POST['delivery']))
		throw new Exception("출고처를 기입해주세요", 3);

	/*데이터베이스 내 검증하는 부분*/
	foreach($_POST['serialNumber'] as $key => $val) {	/*입고란에 일련번호가 없다면 종료*/
		if(DB::queryOneField('ivSerialNumber', "SELECT * FROM tmInventoryIn WHERE ivSerialNumber=%s", $val) === null) {
			$err_val .= $val.' ';
			$err = true;
		}
	}
	if($err === true) {
		throw new Exception($err_val."\\n위는 입고처리가 안 된 SerialKey 입니다", 3);
	}

	$each = DB::queryOneField('stEach', "SELECT * FROM tmInventoryStock WHERE stModelCode=%s and stCarrier=%s and stColor=%s", $_POST['modelCode'], $_POST['carrier'], $_POST['color']);
	if($each != null) {	/* 해당 기기의 수량을 가져왔다면.. */
		if ($each == 0) {
			throw new Exception("모델이 갯수가 '0'개 입니다", 3);	/* 수량이 0 이라면.. */
		} else if($each - (int)count($_POST['serialNumber']) < 0) {	/* POST로 넘어온 값을 빼서 0 이하이면 경고와 함께 종료 */
			throw new Exception("수량을 다시 확인해주세요", 3);
		} 
	} else {
		throw new Exception("모델을 찾지 못했습니다", 3);
	}

	foreach($_POST['serialNumber'] as $key => $val) {	/*출고란에 일련번호가 중복되어 있다면 경고와 함께 종료*/
		if(DB::queryOneField('ouSerialNumber', "SELECT * FROM tmInventoryOut WHERE ouSerialNumber=%s", $val) != null) {
			$err_val .= $val.' ';
			$err = true;
		}
	}
	if($err === true) {
		throw new Exception($err_val."\\n위는 이미 출고 된 SerialKey 입니다", 3);
	}
	/*검증 종료*/

} catch (Exception $e) {
    alert($e->getMessage());
}

$serial = count($_POST['serialNumber']); /*일련번호 ( 즉 댓수가 몇개나 들어왔는지 ? )*/
$each = DB::queryOneField('stEach', "SELECT * FROM tmInventoryStock WHERE stModelCode=%s and stCarrier=%s and stColor=%s", $_POST['modelCode'], $_POST['carrier'], $_POST['color']);	/*해당 모델의 수량*/

/*출고란에 인설트 하는 부분*/
foreach($_POST['serialNumber'] as $key => $value) {
	$input[] = array(
		'ouSerialNumber' => $value,
		'ouDelivery' => $_POST['delivery'],
		'ouOutDate' => $_POST['outDate']
		);
}
DB::insert('tmInventoryOut', $input);

/* 확인 부분 */
echo "<pre>";
print_r($check);
echo "</pre>";

/*재고 란에 값 수정*/
DB::update('tmInventoryStock', array(
	'stEach' => $each-$serial
), 'stModelCode=%s and stCarrier=%s and stColor=%s', $_POST['modelCode'], $_POST['carrier'], $_POST['color']);	/* tmInventoryStock 갯수 수정 */


alert('업데이트 되었습니다', 'tplDeviceView.php?check=checkbox_model');
 ?>