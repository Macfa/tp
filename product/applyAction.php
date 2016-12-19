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

	if(isNullVal($_POST['apPhone']))
		throw new Exception('추가 전화번호를 적어주세요 ', 3);

	if(isNullVal($_POST['apBirth']))
		throw new Exception('생년월일을 적어주세요 ', 3);

	if(isNullVal($_POST['apColor']))
		throw new Exception('색상을 선택해주세요 ', 3);

	if(isNullVal($_POST['apCurrentCarrier']))
		throw new Exception('현재통신사를 선택해주세요 ', 3);

	$dvKeyWhere = "SELECT COUNT(*) FROM tmDevice WHERE dvDisplay = 1 and dvKey = %s_dvKey";
	$dvKeyArray = array('dvKey' => $_POST['dvKey']);
	list($countDevice, $dvKey) = DB::queryFirstList($dvKeyWhere, $dvKeyArray);
	$isExistDevice = ($countDevice>0)?TRUE:FALSE;
	if($isExistDevice === FALSE)
		throw new Exception('존재하지 않는 기기입니다.', 3);

	if(isExist($_POST['recommedID'])){

		$myMbKey = $mb['mbKey'];

		// 추천인 정보 조회
		list($isMemberExist, $targetMbKey, $targetMbEmail, $targetMbPoint) = DB::queryFirstList("SELECT COUNT(*), mbKey, mbEmail, mbPoint FROM tmMember WHERE mbEmail=%s", $_POST['recommedID']);	
		$isMemberExist = (int)$isMemberExist;

		if($isMemberExist === 0)
			throw new Exception("멤버가 존재하지 않습니다");	
		if($targetMbKey === $myMbKey)
			throw new Exception("본인추천은 불가능합니다");

		//본인이 mbkey 일때 parent,grand 정보
		//$isRelationExist : 본인이 mbkey 일때의 행이 존재하는 count
		list($isRelationExist, $isMyKey, $prParent,  $prGrand )= DB::queryFirstList("SELECT COUNT(*), mbKey, prParent, prGrand FROM tmPointRelationship WHERE mbKey=%i",$myMbKey);	

		//본인이 parent 일때 mbkey,grand 정보
		// $isExistRowWhenParent : 내가 부모인 행이 존재하는 행의 count
		// $prGrandWhenParent : 내가 부모인 행에서 prGrand 값		
		list($isExistRowWhenParent, $prGrandWhenParent, $childKey)= DB::queryFirstList("SELECT COUNT(*), prGrand, mbKey FROM tmPointRelationship WHERE prParent=%i",$myMbKey);

		if($prParent === $targetMbKey) $targetIsAlreadyParents = true;
		if($targetIsAlreadyParents === false && $isRelationExist >= 1)  
			throw new Exception("이미 다른 추천인이 등록되어있습니다"); 

		if($myMbKey === $isMyKey && $prParent !== $targetMbKey) // 다른 추천인을 넣었을때
			throw new Exception("이미 다른 추천인이 등록되어있습니다"); 

		if($childKey === $targetMbKey)
			throw new Exception("추천해준 사람을 추천할 수 없습니다");

	}

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
    'apDatetime' => $cfg['time_ymdhis'],
    'apDiscountType' => $_POST['discountType'],
    'rpPoint' => $rewardPoint
    ));



DB::insert('tmPointHistory', array(
	'mbEmail' => $mb['mbEmail'],
	'phCont' => $cfg['time_ymdhis'].' 리워드포인트',
	'phAmount' => $rewardPoint,
	'phResult' => $mb['mbPoint']+($rewardPoint),
	'phDate' => $cfg['time_ymdhis']
));


DB::update('tmMember', array(
	'mbPoint' => $mb['mbPoint']+($rewardPoint)
),'mbEmail = %s', $mb['mbEmail']);




//////////////////추천포인트 지급

if(isExist($_POST['recommedID'])){//추천포인트 지급

	// ID - parent 관계 인서트 - 포인트지급
	$isRelationExist = (int)$isRelationExist;
	if($isRelationExist === 0){
		DB::insert('tmPointRelationship', array(
		  'mbKey' => $myMbKey, 
		  'prParent' => $targetMbKey,
		  'prDate' => $cfg['time_ymdhis']
		));	
	}

	DB::update('tmMember', 
		array(
			'mbPoint' => DB::sqleval("mbPoint+($rewardPoint * 0.05)")
		),	'mbKey = %i', $targetMbKey
	);

	DB::insert('tmPointHistory', array(
		'mbEmail' => $targetMbEmail,
		'phCont' => $cfg['time_ymdhis'].' 추천포인트지급',
		'phAmount' => $rewardPoint*0.05,
		'phResult' => $targetMbPoint + ($rewardPoint*0.05) ,
		'phDate' => $cfg['time_ymdhis']
	));


	// B | A | 0 에서
	// A 가 C를 추천인으로 임명했을때

	// B | A | C
	// A | C | 0
	// 이 구조가 되게 해주는 코드
	// parent - grand 관계 인서트
	$prGrandWhenParent = (int)$prGrandWhenParent;
	if($isExistRowWhenParent >= 1){
		if($prGrandWhenParent === 0){		
			DB::update('tmPointRelationship', array(
			  'prGrand' => $targetMbKey 
			), "prParent=%i", $myMbKey);
		}
	}else if ($isRelationExist === 1 && isExist($prGrand) === true ) { // 3단계 관계가 성립할때 3단계 포인트 지급 

		list($grandMbEmail, $grandMbPoint) = DB::queryFirstList("SELECT mbEmail, mbPoint FROM tmMember WHERE mbKey=%i", $prGrand); //grand 추천인 정보

		DB::update('tmMember', 
			array(
				'mbPoint' => DB::sqleval("mbPoint+($rewardPoint*0.05)")
			),	'mbKey = %i', $prGrand
		);

		DB::insert('tmPointHistory', array(
			'mbEmail' => $grandMbEmail,
			'phCont' => $cfg['time_ymdhis'].' 3단계추천포인트지급',
			'phAmount' => $rewardPoint*0.05,
			'phResult' => $grandMbPoint + ($rewardPoint*0.05) ,
			'phDate' => $cfg['time_ymdhis']
		));

	}
}

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
// goURL($deviceInfo->getApplyURL($cdCode, $_POST['applyType']));


if((int)$_POST['good_mny'] === 0) {
	require_once("./orderResult.php");  	// 결재 결과를 처리하는 과정 
}
?>
