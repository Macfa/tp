<?php 
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

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
	foreach($_POST['serialNumber'] as $key => $val) {	/*일련번호 입고테이블에서 존재하지않다면..*/
		if(DB::queryOneField('inSerialNumber', "SELECT * FROM tmInventoryIn WHERE inSerialNumber=%s", $val) === null) {
			$err_val .= $val.' ';
			$err = true;
		}
	}
	if($err === true) {
		throw new Exception($err_val."\\n위는 입고처리가 안 된 SerialKey 입니다", 3);
	}
	
	/*
	배열의 원소의 갯수를 체크하고
	그걸 돌려서 2개라면
	에러 출력
	*/
	$countVal = array_count_values($_POST['serialNumber']);
	foreach ($countVal as $key => $value) {
		if($value > 1) {
			$check .= $key;
			throw new Exception($check."\\n일련번호는 중복될 수 없습니다 !", 3);
		}
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

		/*입고 출고테이블에서 각 일련번호로 검색하여 갯수를 가져온다*/
	$check_in = DB::queryFirstField("SELECT count(*) FROM tmInventoryIn WHERE inSerialNumber=%s", $val);
	$check_out = DB::queryFirstField("SELECT count(*) FROM tmInventoryOut WHERE inSerialNumber=%s", $val);

	foreach($_POST['serialNumber'] as $key => $val) {	/*출고란에 일련번호가 중복되어 있다면 경고와 함께 종료*/
		if($check_in <= $check_out) {
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

	/* 
	중요, 만약 대리점 수정시 여기 역시 수정필요... 
	일련번호로 대리점검색 후 아래 배열의 값에 포함되어 있지않다면 기존에 넣어놓은 대리점을 다시 입력
	이는 반품상황시 입고처란에 반품자명이 쓰이는 경우를 위한 코드
	*/

foreach($_POST['serialNumber'] as $key => $value) {
	$goodreceipt = DB::queryFirstField("SELECT ivGoodReceipt FROM tmInventoryIn WHERE inSerialNumber=%s ORDER BY ivKey ASC", $value); //string
}

$serialCount = count($_POST['serialNumber']); /*일련번호 ( 즉 댓수가 몇개나 들어왔는지 ? )*/
$each = DB::queryOneField('stEach', "SELECT * FROM tmInventoryStock WHERE stModelCode=%s and stCarrier=%s and stColor=%s", $_POST['modelCode'], $_POST['carrier'], $_POST['color']);
$each_ware = DB::queryOneField('stEach', "SELECT * FROM tmInventoryWare WHERE stModelCode=%s and stGoodReceipt=%s and stColor=%s", $_POST['modelCode'], $goodreceipt, $_POST['color']);

/*출고란에 인설트 하는 부분*/
foreach($_POST['serialNumber'] as $key => $value) {
	$input[] = array(
		'inSerialNumber' => $value,
		'ouDelivery' => $_POST['delivery'][$key],
		'ouOutDate' => $_POST['outDate'],
		'ouOutTerm' => $cfg['time_ymdhis']
	);
}
DB::insert('tmInventoryOut', $input);

/*재고 란에 값 수정*/
DB::update('tmInventoryStock', array(
	'stEach' => $each-$serialCount
), 'stModelCode=%s and stCarrier=%s and stColor=%s', $_POST['modelCode'], $_POST['carrier'], $_POST['color']);	/* tmInventoryStock 갯수 수정 */

DB::update('tmInventoryWare', array(
	'stEach' => $each_ware-$serialCount
), 'stModelCode=%s and stGoodReceipt=%s and stColor=%s', $_POST['modelCode'], $goodreceipt, $_POST['color']);	/* tmInventoryWare 갯수 수정 */

alert('업데이트 되었습니다', 'tplDeviceView.php?view=model');

 ?>