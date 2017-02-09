<?php 
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

try {		/* 입고 출고의 form 값이 view 로 떨어지는데 그때 값을 검출하기 위함. */

	if(isNullVal($_POST['outDate']))
		throw new Exception("출고일을 정해주세요", 3);

	if(isNullVal($_POST['serialNumber']))
		throw new Exception("일련번호를 재기입해주세요", 3);

	foreach($_POST['delivery'] as $key => $val) {	/*일련번호 입고테이블에서 존재하지않다면..*/
		if(isNullVal($val))
			throw new Exception("출고처를 기입해주세요", 3);
	}

	/*데이터베이스 내 검증하는 부분*/
	foreach($_POST['serialNumber'] as $key => $val) {	/*일련번호 입고테이블에서 존재하지않다면..*/
		if (isExist($value) === false) continue;

		if(DB::queryOneField('inSerialNumber', "SELECT * FROM tmInventoryIn WHERE inSerialNumber=%s", $val) === null) {
			$err_val .= $val.' ';
			$err = true;
		}

		$count++;
	}
	if($err === true) {
		throw new Exception($err_val."\\n위는 입고처리가 안 된 SerialKey 입니다", 3);
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
			$check .= $key;
			throw new Exception($check."\\n일련번호는 중복될 수 없습니다 !", 3);
		}
	}

	// $each = DB::queryOneField('stEach', "SELECT * FROM tmInventoryStock WHERE stModelCode=%s and stCarrier=%s", $model, $carrier);
	// if($each != null) {	/* 해당 기기의 수량을 가져왔다면.. */
	// 	if ($each == 0) {
	// 		throw new Exception("재고가 '0'개 이므로 출고가 안됩니다.", 3);	/* 수량이 0 이라면.. */
	// 	} else if($each - $count < 0) {	/* POST로 넘어온 값을 빼서 0 이하이면 경고와 함께 종료 */
	// 		// throw new Exception("수량을 다시 확인해주세요", 3);
	// 	} 
	// } else {
	// 	throw new Exception("모델을 찾지 못했습니다", 3);
	// }

		/*입고 출고테이블에서 각 일련번호로 검색하여 갯수를 가져온다*/
	

	foreach($_POST['serialNumber'] as $key => $val) {	/*출고란에 일련번호가 중복되어 있다면 경고와 함께 종료*/
		$check_in = DB::queryFirstField("SELECT count(*) FROM tmInventoryIn WHERE inSerialNumber=%s", $val);
		$check_out = DB::queryFirstField("SELECT count(*) FROM tmInventoryOut WHERE inSerialNumber=%s", $val);

		if (isExist($val) === false) continue;

		if($check_in <= $check_out) {
			$err_val .= $val.' ';
			$err = true;
		}	
	}
	if($err === true) {
		throw new Exception($err_val."\\n위는 이미 출고 된 SerialKey 입니다", 3);
	}
	$err = false;
	/*검증 종료*/

} catch (Exception $e) {
    alert($e->getMessage());
}

$serialWhere = new WhereClause('or');
foreach($_POST['serialNumber'] as $key => $value) {
	if (isExist($value) === false) continue;

	$model = DB::queryFirstField("SELECT inModelCode FROM tmInventoryInfo WHERE inSerialNumber=%s", $value);	// String ModelName
	$color = DB::queryFirstField("SELECT inColor FROM tmInventoryInfo WHERE inSerialNumber=%s", $value);	// String etc) Red
	$carrier = DB::queryFirstField("SELECT inCarrier FROM tmInventoryInfo WHERE inSerialNumber=%s", $value);	// String etc) skt
	$goodreceipt = DB::queryFirstField("SELECT chKey FROM tmInventoryInfo WHERE inSerialNumber=%s", $value);
	$temp['carrier'][$carrier][$model][$color] += 1;
	$temp['goodreceipt'][$goodreceipt][$model][$color] += 1;

	/*출고란에 인설트 하는 부분*/
	$input[] = array(
		'inSerialNumber' => $value,
		'ouDelivery' => $_POST['delivery'][$key],
		'ouOutDate' => $_POST['outDate'],
		'ouOutTerm' => $cfg['time_ymdhis']
	);

	$serialWhere->add('inSerialNumber = %s', $value);
}

DB::insert('tmInventoryOut', $input);
DB::update('tmInventoryInfo', array(
	'inIsExist' => 0
	),	'%l', $serialWhere
);


	/* 
	중요, 만약 대리점 수정시 여기 역시 수정필요... 
	일련번호로 대리점검색 후 아래 배열의 값에 포함되어 있지않다면 기존에 넣어놓은 대리점을 다시 입력
	이는 반품상황시 입고처란에 반품자명이 쓰이는 경우를 위한 코드
	*/




$serialCount = count($_POST['serialNumber']); /*일련번호 ( 즉 댓수가 몇개나 들어왔는지 ? )*/
$each = DB::queryOneField('stEach', "SELECT * FROM tmInventoryStock WHERE stModelCode=%s and stCarrier=%s", $model, $carrier);
$each_ware = DB::queryOneField('stEach', "SELECT * FROM tmInventoryWare WHERE stModelCode=%s and stGoodReceipt=%s", $model, $goodreceipt);

/*재고 란에 값 수정*/
foreach($temp as $type => $arrType) {
	// $carrierReceipt : 타입에 따라 carrier 나 goodreceipt 전환됨 ()
	foreach($arrType as $carrierReceipt => $arrModel) {
		foreach($arrModel as $model => $arrColor) {
			foreach($arrColor as $color => $count) {
				if(isExist($where[$type][$count]) === false)
					$where[$type][$count] = new WhereClause('or');

				$subClause = $where[$type][$count]->addClause('and');

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

foreach($where['carrier'] as $count => $val) {
	DB::query('UPDATE tmInventoryStock SET stEach = stEach-'.$count.' WHERE %l', $val);	/* tmInventoryStock 갯수 수정 */
}

foreach($where['goodreceipt'] as $count => $val) {
	DB::query('UPDATE tmInventoryWare SET stEach = stEach-'.$count.' WHERE %l', $val);	/* tmInventoryStock 갯수 수정 */
}

alert('업데이트 되었습니다', 'tplDeviceView.php?view=model&carrier=sk');

 ?>
