<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
include_once(PATH_LIB."/lib.snoopy.inc.php");
include_once(PATH_LIB."/lib.parsing.inc.php");

$rewardPoint = DB::queryFirstField("SELECT rpPoint FROM tmRewardPoint WHERE dvKey = %i_dvKey and rpPlan = %i_rpPlan and rpCarrier = %s_rpCarrier and rpApplyType = %i_rpApplyType and rpDiscountType = %s_rpDiscountType", 
		array(
			'dvKey' => $_POST['dvKey'],
			'rpPlan' => $_POST['plan'],
			'rpCarrier' => $_POST['carrier'],
			'rpApplyType' => $_POST['applyType'],
			'rpDiscountType' => $_POST['discountType']
		)
);

try
{


	if($isLogged == false)
		throw new Exception('별 포인트 적립을 위해 로그인 해주세요!', 3);

	if(isNullVal($_POST['applyType']))
		throw new Exception('가입유형을 선택해주세요 ', 3);

	if(isNullVal($_POST['discountType']))
		throw new Exception('할인유형을 선택해주세요 ', 3);

	if(isNullVal($_POST['plan']))
		throw new Exception('요금제를 선택해주세요 ', 3);

	if(isNullVal($_POST['apColor']))
		throw new Exception('색상을 선택해주세요 ', 3);

	$isExistDevice = DB::queryFirstField("SELECT dvKey FROM tmDevice WHERE dvDisplay = 1 and dvKey = %s", $_POST['dvKey']);

	if($isExistDevice === FALSE)
		throw new Exception('존재하지 않는 기기입니다.', 3);


}
catch(Exception $e)
{
    alert($e->getMessage());
}

///////////////// 신청서 DB insert

DB::insert('tmApplyTmp', array(
    'mbEmail' => $mb['mbEmail'],
    'dvKey' => $_POST['dvKey'],
    'apCurrentCarrier' => $_POST['apCurrentCarrier'],
    'apChangeCarrier' => $_POST['carrier'],
    'apColor' => $_POST['apColor'],
    'apPlan' => $_POST['plan'],
    'apApplyType' => $_POST['applyType'],
    'apDatetime' => $cfg['time_ymdhis']));


DB::insert('tmPointHistory', array(
	'mbEmail' => $mb['mbEmail'],
	'phCont' => $cfg['time_ymdhis'].' 리워드포인트',
	'phAmount' => $rewardPoint,
	'phResult' => $mb['mbPoint']+($rewardPoint),
	'phDate' => $cfg['time_ymdhis']
));

DB::update('tmMember', array(
	'mbPoint' => $mb['mbPoint']+($rewardPoint)
	),
	'mbEmail = %s', $mb['mbEmail']
);

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
