<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
include_once(PATH_LIB."/lib.snoopy.inc.php");
include_once(PATH_LIB."/lib.parsing.inc.php");

try
{
	//배송지 값 검사
	if (isNullVal($_POST['arKey']) == false) {
		$isExistArKey = true;
		if (isNum($_POST['arKey']) == false) 
			throw new Exception('매개변수가 비정상적입니다.', 3);

		$isValidAddress = DB::queryFirstField('SELECT COUNT(*) FROM tmAddress WHERE arKey = %i and mbEmail = %s', $_POST['arKey'], $mb['mbEmail']);
		$isValidAddress = ($isValidAddress>0)?TRUE:FALSE;
		if ($isValidAddress == false) 
			throw new Exception('존재하지 않는 주소록 입니다.', 3);
	}

	if (isNullVal($_POST['arTit']) === false && is_contain_special($_POST['arTit']))
		throw new Exception('주소지 명은 한글,영어,숫자만 가능합니다.', 3);

	if (isNullVal($_POST['arName']))
		throw new Exception('수취인 명을 입력해주세요.', 3);

	if (isKorEng($_POST['arName']) === false)
		throw new Exception('수취인 명은 한글,영어만 가능합니다.', 3);

	if (isNullVal($_POST['arPhone']))
		throw new Exception('연락처를 입력해주세요.', 3);

	$_POST['arPhone'] = parsingNum($_POST['arPhone']);
	if (isPhoneNum($_POST['arPhone']) == false && isTelNum($_POST['arPhone']) == false)
		throw new Exception('연락처는 번호만 입력이 가능합니다.', 3);

	if (isNullVal($_POST['arTel']) === false) {
		$_POST['arTel'] = parsingNum($_POST['arTel']);
		if (isPhoneNum($_POST['arTel']) == false && isTelNum($_POST['arTel']) == false)
			throw new Exception('추가연락처는 번호만 입력이 가능합니다.', 3);
	}

	if (isNullVal($_POST['arPostcode'])) 
		throw new Exception('우편번호를 입력해주세요', 3);

	if (isEqualLength($_POST['arPostcode'], 5) === false)
		throw new Exception('우편번호는 5글자이어야 가능합니다.', 3);

	if (isNum($_POST['arPostcode']) == false)
		throw new Exception('우편번호는 숫자만 입력이 가능합니다.', 3);
	
	if (isNullVal($_POST['arAddress'])) 
		throw new Exception('주소를 입력해주세요', 3);

	if (isNullVal($_POST['arSubAddress'])) 
		throw new Exception('상세주소를 입력해주세요', 3);


	if($isLogged == false)
		throw new Exception('별 포인트 적립을 위해 로그인 해주세요!', 3);

	if(isNullVal($_POST['applyType']))
		throw new Exception('가입유형을 선택해주세요 ', 3);

	if(isNullVal($_POST['discountType']))
		throw new Exception('할인유형을 선택해주세요 ', 3);

	if(isNullVal($_POST['plan']))
		throw new Exception('요금제를 선택해주세요 ', 3);

	if(isNullVal($_POST['color']))
		throw new Exception('색상을 선택해주세요 ', 3);

	$dvKeyWhere = "SELECT COUNT(*) FROM tmDevice WHERE dvDisplay = 1 and dvKey = %s_dvKey";
	$dvKeyArray = array('dvKey' => $_POST['dvKey']);
	list($countDevice, $dvKey) = DB::queryFirstList($dvKeyWhere, $dvKeyArray);
	$isExistDevice = ($countDevice>0)?TRUE:FALSE;
	if($isExistDevice === FALSE)
		throw new Exception('존재하지 않는 기기입니다.', 3);

	//주문 값 검사

	if($_POST['oiQuantity'] || $_POST['gfKey']) {
		$isOrderGift = true;

		if (count($_POST['gfKey']) != count($_POST['oiQuantity']))
			throw new Exception('사은품 매개변수가 쌍이 맞지 않습니다.', 3);

		

		foreach($_POST['oiQuantity'] as $val) {
			if(isNum($val) == false)
				throw new Exception('사은품 갯수가 숫자가 아닙니다.', 3);
		}

		foreach($_POST['gfKey'] as $key => $val) {
			if(isNum($val) == false)
				throw new Exception('사은품 키가 숫자가 아닙니다.', 3);

			list($isValidGift,$arrGfPoint[$key]) = DB::queryFirstList('SELECT COUNT(*), gfPoint FROM tmGift WHERE gfKey = %i', $val);
			$isValidGift = ($isValidGift>0)?TRUE:FALSE;
			if($isValidGift == false)
				throw new Exception('사은품이 존재하지 않습니다.', 3);

			$totalPoint += $_POST['oiQuantity'][$key]*$arrGfPoint[$key];
		}

		$rewardPoint = DB::queryFirstField("SELECT rpPoint FROM tmRewardPoint WHERE dvKey = %i_dvKey and rpPlan = %i_rpPlan and rpCarrier = %s_rpCarrier and rpApplyType = %i_rpApplyType and rpDiscountType = %s_rpDiscountType", 
			array(
				'dvKey' => $_POST['dvKey'],
				'rpPlan' => $_POST['plan'],
				'rpCarrier' => 'sk',
				'rpApplyType' => $_POST['applyType'],
				'rpDiscountType' => $_POST['discountType']
			)
		);
		if ($totalPoint > ($mb['mbPoint'] + $rewardPoint))
			throw new Exception('총 결제 별이 사용가능한 별보다 많습니다.', 3);

		if ($totalPoint < 0)
			throw new Exception('총 결제 별이 0보다 작을 수 없습니다.', 3);	

	}

	

}
catch(Exception $e)
{
    alert($e->getMessage());
}


if ($isOrderGift) {
	$countOrder = DB::queryFirstField("SELECT count(*) FROM tmOrder WHERE mbEmail = %s", $mb['mbEmail']);
	//첫 주문일시 무료 배송
	$isShippingFree = ($countOrder>0)?FALSE:TRUE;
	$shipping = ($isShippingFree===true)?0:2500;

	DB::insert('tmOrder', array(
		'mbEmail' => $mb['mbEmail'],
		'orName' => $mb['mbName'],
		'orPhone' => $mb['mbPhone'],
		'orTel' => $_POST['arTel'],
		'orPostcode' => $_POST['arPostcode'],
		'orAddress' => $_POST['arAddress'],
		'orSubAddress' => $_POST['arSubAddress'],
		'orShipping' => $shipping,
		'orDate' => $cfg['time_ymdhis']
	));
	$orKey = DB::insertId();

	foreach($_POST['gfKey'] as $key => $val) {
		DB::insert('tmOrderItem', array(
			'mbEmail' => $mb['mbEmail'],
			'orKey' => $orKey,
			'gfKey' => $val,
			'oiPoint' => $_POST['oiQuantity'][$key]*$arrGfPoint[$key],
			'oiQuantity' => $_POST['oiQuantity'][$key]
		));
	}
}




$isSetDefAddr = (isExist($_POST['setDefaultAddress']))?TRUE:FALSE;
if($isSetDefAddr) {
	$isAlreadyDef = DB::queryFirstField("SELECT count(*) FROM tmAddress WHERE arKey = %i and arIsDefault = 1", $_POST['arKey']);
	$isAlreadyDef = ($isAlreadyDef>0)?TRUE:FALSE;
}
$sqlSetAddr = array('arTit' => $_POST['arTit'],
		'arName' => $_POST['arName'],
		'arPhone' => $_POST['arPhone'],
		'arTel' => $_POST['arTel'],
		'arPostcode' => $_POST['arPostcode'],
		'arAddress' => $_POST['arAddress'],
		'arSubAddress' => $_POST['arSubAddress']);
if ($isSetDefAddr) {
	$sqlSetAddr['arIsDefault'] = 1;
}

$isEditAddr = (isExist($_POST['arKey']) && isExist($_POST['saveAddress']))?TRUE:FALSE;
$isNewAddr = (isExist($_POST['arKey']) === false && isExist($_POST['saveAddress']))?TRUE:FALSE;

$_POST['arTit'] = (isExist($_POST['arTit']))?$_POST['arTit']:$_POST['arName'];

if ($isAlreadyDef === false) {
	DB::update('tmAddress', array(
		'arIsDefault' => 0
	),'mbEmail = %s', $mb['mbEmail']);

	if ($isEditAddr) {
		DB::update('tmAddress', array(
			'arIsDefault' => 1
		),'arKey = %i and mbEmail = %s', $_POST['arKey'], $mb['mbEmail']);
	}
}

if ($isEditAddr) {
	DB::update('tmAddress', $sqlSetAddr, 'arKey = %i and mbEmail = %s', $_POST['arKey'], $mb['mbEmail']);
}

if ($isNewAddr){
	$sqlSetAddr['mbEmail'] = $mb['mbEmail'];
	DB::insert('tmAddress', $sqlSetAddr);
}


DB::insert('tmPointHistory', array(
	'mbEmail' => $mb['mbEmail'],
	'phCont' => $cfg['time_ymdhis'].' 사은품 결제',
	'phAmount' => $totalPoint*-1,
	'phResult' => $mb['mbPoint']+($rewardPoint-$totalPoint),
	'phDate' => $cfg['time_ymdhis']
));

DB::update('tmMember', array(
	'mbPoint' => $mb['mbPoint']+($rewardPoint-$totalPoint)
),'mbEmail = %s', $mb['mbEmail']);
$cdCode = DB::queryFirstField("SELECT cdCode FROM tmCode WHERE dvKey = %i_dvKey and spPlan = %i_spPlan and cdType = %i_cdType and cdCarrier = %s_cdCarrier", 
	array('dvKey'=> $_POST['dvKey'], 
			'spPlan' => $_POST['plan'], 
			'cdType' => str_replace('0','',$_POST['applyType']),
			'cdCarrier' => $_POST['carrier']
	)
);

$deviceInfo = new deviceInfo();
$deviceInfo->setCarrier($_POST['carrier']);
//consoleLog($cdCode);
goURL($deviceInfo->getApplyURL($cdCode, $_POST['applyType']));

?>