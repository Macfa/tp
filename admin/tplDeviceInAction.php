<?php 
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)


try {		/* 입고 출고의 form 값이 view 로 떨어지는데 그때 값을 검출하기 위함. */

	if(isNullVal($_POST['inDate']))
		throw new Exception("날짜를 입력해주세요", 3);

	$isReturn = FALSE;
	if($_POST['checkbox_return'] === 'media')
		$isReturn = true;

	if($isReturn === FALSE) {
		if(isNullVal($_POST['carrier']))
			throw new Exception("통신사를 선택해주세요", 3);

		if(isNullVal($_POST['goodReceipt']))
			throw new Exception("입고처를 선택해주세요", 3);

		if(isNullVal($_POST['modelCode']))
			throw new Exception("모델명을 선택해주세요", 3);

		if(isNullVal($_POST['color']))
			throw new Exception("색상을 선택해주세요", 3);

		/*정보테이블(tmInventoryInfo) 에서 중복기입을 막기 위함*/
		/*Ahull 테이블에서 입고처가 정의되어 있다면 에러 출력*/
		$chk_carrier = DB::queryOneField('chCarrier', "SELECT * FROM tmChannel WHERE chName=%s", $_POST['goodReceipt']);
		if(count($chk_carrier) != 0) {
			if(strcasecmp($_POST['carrier'], $chk_carrier) != 0) {
				throw new Exception($_POST['goodReceipt']."은\\n".$chk_carrier."로 설정되어 있습니다", 3);
			}
		}

		$check_key = DB::queryFirstField("SELECT dvKey FROM tmDevice WHERE dvModelCode=%s", $_POST['modelCode']);

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
	}

	if(isNullVal($_POST['serialNumber']))
		throw new Exception("일련번호를 재기입해주세요", 3);


	if($isReturn === true && isExist($_POST['returnName']) === false){
		throw new Exception("반품자명을 입력해주세요.", 3);
	}

	/*데이터베이스 내 검증하는 부분*/
	foreach($_POST['serialNumber'] as $key => $val) {	/*입고가 출고보다 많다면...*/
		if (isExist($val) === false) continue;

		$check_in = DB::queryFirstField("SELECT count(*) FROM tmInventoryIn WHERE inSerialNumber=%s", $val);
		$check_out = DB::queryFirstField("SELECT count(*) FROM tmInventoryOut WHERE inSerialNumber=%s", $val);
		$check_return = DB::queryFirstField("SELECT ivIsReturned FROM tmInventoryIn WHERE inSerialNumber=%s", $val);

		if($check_in > $check_out) {	/*기기가 있다면(더많다면..) 값을 담고 */
			$err_val .= $val.' ';
			$err = true;

			if($isReturn === true)	/*반품체크가 되어있지만 출고가 되지 않아 에러 (ex, 2 입고 1출고 일때 )*/
				throw new Exception($err_val."\\n위 기기는 출고가 되지 않아 반품할 수 없습니다", 3);

		} elseif($check_in == 0 && $check_out == 0) {	/*입고 출고가 둘 다 0일때 */
			if($isReturn === true)	/*반품체크가 되었다면 에러 (ex, 0, 0 ) / 반품 대상이 없으므로*/
				throw new Exception($err_val."\\n위 기기는 입고된적이 없는 일련번호이므로 반품이 불가능합니다.", 3);
		} else {
			if($isReturn === false) {	/*반품 체크를 하지않으면..*/
				$err_val .= $val.' ';
				$err = true;
			}
		}
	}

	if($err === true) {
		throw new Exception($err_val."\\n위는 이미 입고처리 된 SerialKey 입니다", 3);
	}
	$err = false;

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

	
	/*검증 종료*/
} catch (Exception $e) {
    alert($e->getMessage());
}

/*반품자가 체크되어있으면 입고처대신 반품자이름으로 대입*/
if($isReturn === true) {
	$goodReceipt = $_POST['returnName'];
}else{
	list($fromName, $fromCarrier) = DB::queryFirstList('SELECT chName, chCarrier FROM tmChannel WHERE chKey = %s', $_POST['goodReceipt']);
	$goodReceipt = $fromName .'('. $fromCarrier .')';
}

// 입고란에 인설트 하기 위한 배열저장
$where = new WhereClause('or');
foreach($_POST['serialNumber'] as $key => $value) {
	if (isExist($value) === false) continue;
	$input_in[] = array(
		'inSerialNumber' => $value,
		'ivGoodReceipt' => $goodReceipt,
		'ivInDate' => $_POST['inDate'],
		'ivInTerm' => $cfg['time_ymdhis']
	);
	if($isReturn === true)
		$input_in[0]['ivIsReturned'] = 1;
	echo "<pre>";
	var_dump($input_in);
	echo "</pre>";
	$count++;

	if($exist == false) {	/*고유값이라 중복되면 문제발생, 해결하기 위한 조건문*/
		$input_info[] = array(
			'inSerialNumber' => $value,
			'inModelCode' => $_POST['modelCode'],
			'inColor' => $_POST['color'],
			'chKey' => $_POST['goodReceipt'],
			'inCarrier' => $_POST['carrier']
		);
	}

	$where->add('inSerialNumber = %s', $value);
}	

DB::insert('tmInventoryIn', $input_in);

//반품이 아닐때
if($isReturn === false) {

	if($exist == false)	DB::insert('tmInventoryInfo', $input_info);
	/*'재고' 란에서 모델의 수량을 센다*/
	$model = DB::queryFirstField("SELECT count(*) FROM tmInventoryStock WHERE stModelCode=%s and stCarrier=%s and stColor=%s", $_POST['modelCode'], $_POST['carrier'], $_POST['color']);
	$model_ware = DB::queryFirstField("SELECT count(*) FROM tmInventoryWare WHERE stModelCode=%s and stGoodReceipt=%s and stColor=%s", $_POST['modelCode'], $_POST['goodReceipt'], $_POST['color']);
	 /*일련번호 ( 즉 입고된 기기의 수량가 몇개나 들어왔는지 ? )*/


	if((int)$model === 0) {	/*모델의 수량이 없다면 ( 처음 인설트 하는 거라면 )*/
		$insert = array(
			'stModelCode' => $_POST['modelCode'],
			'stGoodReceipt' => $_POST['goodReceipt'],
			'stCarrier' => $_POST['carrier'],
			'stColor' => $_POST['color'],
			'stEach' => $count /* 입고된 기기의 총 수량을 대입한다 */
			);
		DB::insert('tmInventoryStock', $insert);
	} else {	/* 모델의 수량이 기존에 있다면 .. */
		$each = DB::queryOneField('stEach', "SELECT * FROM tmInventoryStock WHERE stModelCode=%s and stCarrier=%s and stColor=%s", $_POST['modelCode'], $_POST['carrier'], $_POST['color']);
		DB::update('tmInventoryStock', array(	/*일련번호 수에 따른 수량 조절*/
			'stEach' => $each+$count
		), 'stModelCode=%s and stCarrier=%s and stColor=%s', $_POST['modelCode'], $_POST['carrier'], $_POST['color']);
	}


	/*tmInventoryWare 용*/
	if($model_ware == 0) {
		$insert_ware = array(
			'stModelCode' => $_POST['modelCode'],
			'stColor' => $_POST['color'],
			'stGoodReceipt' => $_POST['goodReceipt'],
			'stEach' => $count /* 입고된 기기의 총 수량을 대입한다 */
			);
		DB::insert('tmInventoryWare', $insert_ware);
	} else {
		$each_ware = DB::queryOneField('stEach', "SELECT * FROM tmInventoryWare WHERE stModelCode=%s and stGoodReceipt=%s and stColor=%s", $_POST['modelCode'], $_POST['goodReceipt'], $_POST['color']);

		DB::update('tmInventoryWare', array(
			'stEach' => $each_ware+$count
			),	'stModelCode=%s and stColor=%s and stGoodReceipt=%s', $_POST['modelCode'], $_POST['color'], $_POST['goodReceipt']);
	}

}


//반품될때
if($isReturn === true) {

	// 각 일련번호의 정보를 가져옴
	foreach($_POST['serialNumber'] as $key => $value) {
		if (isExist($value) === false) continue;

		$model = DB::queryFirstField("SELECT inModelCode FROM tmInventoryInfo WHERE inSerialNumber=%s", $value);	// String ModelName
		$color = DB::queryFirstField("SELECT inColor FROM tmInventoryInfo WHERE inSerialNumber=%s", $value);	// String etc) Red
		$carrier = $carrier = DB::queryFirstField("SELECT inCarrier FROM tmInventoryInfo WHERE inSerialNumber=%s", $value);	// String etc) skt
		$goodreceipt = DB::queryFirstField("SELECT ivGoodReceipt FROM tmInventoryIn WHERE inSerialNumber=%s ORDER BY ivKey ASC", $value);
		$temp['carrier'][$carrier][$model][$color] += 1;
		$temp['goodreceipt'][$goodreceipt][$model][$color] += 1;
	}

	//DB로 보내는 QUERY를 최소화 하기위해 같은 수량이 반품되는 건들은 OR로 한번에 묶어서 쿼리를 보내기 위한 WHERE BUILD
	foreach($temp as $type => $arrType) {
		// $carrierReceipt : 타입에 따라 carrier 나 goodreceipt 전환됨 ()
		foreach($arrType as $carrierReceipt => $arrModel) {
			foreach($arrModel as $model => $arrColor) {
				foreach($arrColor as $color => $count) {
					if(isExist($whereForReturn[$type][$count]) === false)
						$whereForReturn[$type][$count] = new WhereClause('or');

					$subClause = $whereForReturn[$type][$count]->addClause('and');

					if($type === 'carrier')
						$subClause->add('stCarrier=%s', $carrierReceipt);
					else if($type === 'goodreceipt')
						$subClause->add('stGoodReceipt=%s', $carrierReceipt);

					$subClause->add('stModelCode=%s', $model);
					$subClause->add('stColor=%s', $color);
				}
			}
		}
	}


 // 이미 info테이블에 일련번호 정보가 있기때문에 inIsExist 값을 다시 1로 업데이트 시켜줌
	DB::update('tmInventoryInfo', array(
		'inIsExist' => 1
	),	'%l', $where);

	foreach($whereForReturn['carrier'] as $count => $val) {
		DB::query('UPDATE tmInventoryStock SET stEach = stEach+'.$count.' WHERE %l', $val);	/* tmInventoryStock 갯수 수정 */
	}

	foreach($whereForReturn['goodreceipt'] as $count => $val) {
		DB::query('UPDATE tmInventoryWare SET stEach = stEach+'.$count.' WHERE %l', $val);	/* tmInventoryStock 갯수 수정 */
	}

}


alert('인설트 되었습니다', 'tplDeviceView.php?view=model&carrier=sk');

 ?>
