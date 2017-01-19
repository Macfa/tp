<?php 
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

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
	foreach($_POST['serialNumber'] as $key => $val) {	/*입고가 출고보다 많다면...*/
		$check_in = DB::queryFirstField("SELECT count(*) FROM tmInventoryIn WHERE inSerialNumber=%s", $val);
		$check_out = DB::queryFirstField("SELECT count(*) FROM tmInventoryOut WHERE inSerialNumber=%s", $val);
		$check_key = DB::queryFirstField("SELECT dvKey FROM tmDevice WHERE dvModelCode=%s", $_POST['modelCode']);

		if($check_in > $check_out) {	/*기기가 있다면(더많다면..) 값을 담고 */
			$err_val .= $val.' ';
			$err = true;

			if(count($_POST['returnName']) > 0 )	/*반품체크가 되어있지만 출고가 되지 않아 에러 (ex, 2 입고 1출고 일때 )*/
				throw new Exception($err_val."\\n위 기기는 반품할 수 없습니다", 3);

		} elseif($check_in == 0 && $check_out == 0) {	/*입고 출고가 둘 다 0일때 */
			if(count($_POST['returnName']) > 0 )	/*반품체크가 되었다면 에러 (ex, 0, 0 ) / 반품 대상이 없으므로*/
				throw new Exception($err_val."\\n위 기기는 반품할 수 없습니다", 3);
		} else {
			if(count($_POST['returnName']) <= 0) {	/*반품 체크를 하지않으면..*/
				$err_val .= $val.' ';
				$err = true;
			}
		}
		if($err === true) {
			throw new Exception($err_val."\\n위는 이미 입고처리 된 SerialKey 입니다", 3);
		}
	}

	/*
	배열의 원소의 갯수를 체크하고
	그걸 돌려서 2개라면
	에러 출력
	*/
	$countVal = array_count_values($_POST['serialNumber']);
	foreach ($countVal as $key => $value) {
		if($value > 1) {
			$dot .= $key;
			$err_chk = true;
		}
	}

	if($err_chk == true) 
		throw new Exception($dot."\\n일련번호는 중복될 수 없습니다 !", 3);

	/*정보테이블(tmInventoryInfo) 에서 중복기입을 막기 위함*/
	/*Ahull 테이블에서 입고처가 정의되어 있다면 에러 출력*/
	$chk_carrier = DB::queryOneField('chCarrier', "SELECT * FROM tmChannel WHERE chName=%s", $_POST['goodReceipt']);
	if(count($chk_carrier) != 0) {
		if(strcasecmp($_POST['carrier'], $chk_carrier) != 0) {
			throw new Exception($_POST['goodReceipt']."은\\n".$chk_carrier."로 설정되어 있습니다", 3);
		}
	}

	$check_color = DB::queryOneColumn('dcColor', "SELECT * FROM tmDeviceColor WHERE dvKey=%s", $check_key);	/* 디비키에 설정되어 있는 색상리스트*/
	if(isExist($check_color) == true) {	/* 값이 tmDeviceColor 에 있다면... */
		if(in_array($_POST['color'], $check_color) == false) {	/* 배열안에 컬러값이 없다면..*/
			foreach($check_color as $color) {	/* 색상리스트를 불러와 하나씩 넣는다 */
				$colors .= $color.", ";
			}
				throw new Exception($_POST['modelCode']."을 지원하는 색상리스트\\n".$colors, 3);	/* 에러내용에 사용 가능한 색상 리스트 출력 */
		}	/* 어떻게 막을 지 생각해볼것.*/
	} else {
		throw new Exception($_POST['modelCode']." 기기는 색상등록이 필요합니다 !", 3);
	}

	/* 해당 일련번호가 이미 들어와있다면.. info 에 값을 넣지 않을 것. */
	if($check_in > 0) {
		$exist = true;
	}
	/*검증 종료*/
} catch (Exception $e) {
    alert($e->getMessage());
}

/*반품자가 체크되어있으면 입고처대신 반품자이름으로 대입*/
if(isExist($_POST['returnName']) === true) {
	$goodReceipt = $_POST['returnName'];
	$isReturn = true;
}else
	$goodReceipt = $_POST['goodReceipt'];

// 입고란에 인설트 하기 위한 배열저장
$where = new WhereClause('or');
foreach($_POST['serialNumber'] as $key => $value) {
	$input_in[] = array(
		'inSerialNumber' => $value,
		'ivGoodReceipt' => $goodReceipt,
		'ivInDate' => $_POST['inDate'],
		'ivInTerm' => $cfg['time_ymdhis']
	);
	if($exist == false) {	/*고유값이라 중복되면 문제발생, 해결하기 위한 조건문*/
		$input_info[] = array(
			'inSerialNumber' => $value,
			'inModelCode' => $_POST['modelCode'],
			'inColor' => $_POST['color'],
			'inCarrier' => $_POST['carrier']
		);
	}

	$where->add('inSerialNumber = %s', $value);
}	
DB::insert('tmInventoryIn', $input_in);
	/*위에서 정의했던 중복기입 방지용 변수로 조건*/
if($exist == false) 
	DB::insert('tmInventoryInfo', $input_info);

/* 입고처를 테이블에서 검색하고 그 값이 null 이라면 인설트 아니라면 고정값(미래대리점 -> skt)이 있으니 패스*/
$chk_receipt = DB::queryOneField('chName', "SELECT * FROM tmChannel WHERE chName=%s", $_POST['goodReceipt']);
if($chk_receipt == null) {
	DB::insert('tmChannel', array(
		'chName' => $_POST['goodReceipt'],
		'chCarrier' => $_POST['carrier']
		));
}

/*'재고' 란에서 모델의 수량을 센다*/
$model = DB::queryFirstField("SELECT count(*) FROM tmInventoryStock WHERE stModelCode=%s and stCarrier=%s and stColor=%s", $_POST['modelCode'], $_POST['carrier'], $_POST['color']);
$model_ware = DB::queryFirstField("SELECT count(*) FROM tmInventoryWare WHERE stModelCode=%s and stGoodReceipt=%s and stColor=%s", $_POST['modelCode'], $_POST['goodReceipt'], $_POST['color']);
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
} else {	/* 모델의 수량이 기존에 있다면 .. */
	$each = DB::queryOneField('stEach', "SELECT * FROM tmInventoryStock WHERE stModelCode=%s and stCarrier=%s and stColor=%s", $_POST['modelCode'], $_POST['carrier'], $_POST['color']);
	DB::update('tmInventoryStock', array(	/*일련번호 수에 따른 수량 조절*/
		'stEach' => $each+$serial
	), 'stModelCode=%s and stCarrier=%s and stColor=%s', $_POST['modelCode'], $_POST['carrier'], $_POST['color']);
}

/*tmInventoryWare 용*/
if($model_ware == 0) {
	$insert_ware = array(
		'stModelCode' => $_POST['modelCode'],
		'stColor' => $_POST['color'],
		'stGoodReceipt' => $_POST['goodReceipt'],
		'stEach' => $serial /* 입고된 기기의 총 수량을 대입한다 */
		);
	DB::insert('tmInventoryWare', $insert_ware);
} else {
	$each_ware = DB::queryOneField('stEach', "SELECT * FROM tmInventoryWare WHERE stModelCode=%s and stGoodReceipt=%s and stColor=%s", $_POST['modelCode'], $_POST['goodReceipt'], $_POST['color']);

	DB::update('tmInventoryWare', array(
		'stEach' => $each_ware+$serial
		),	'stModelCode=%s and stColor=%s and stGoodReceipt=%s', $_POST['modelCode'], $_POST['color'], $_POST['goodReceipt']);
}


//반품될때 이미 info테이블에 일련번호 정보가 있기때문에 inIsExist 값을 다시 1로 업데이트 시켜줌
if($isReturn === true) {
	DB::update('tmInventoryInfo', array(
		'inIsExist' => 1
		),	'%l', $where);
}


alert('인설트 되었습니다', 'tplDeviceView.php?view=model&carrier=skt');
 ?>
