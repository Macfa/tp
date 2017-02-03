<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
include_once(PATH_LIB."/lib.snoopy.inc.php");
include_once(PATH_LIB."/lib.parsing.inc.php");
include_once(PATH_LIB."/lib.phone.inc.php");
require_once($cfg['path']."/headBlank.inc.php");


// 어드민에서 직접 신청서를 수정하는 경우
if(isExist($_POST['modifyEmail'])){
	$mb['mbEmail'] = $_POST['modifyEmail'];
	list($mb['mbKey'],$mb['mbPhone']) = DB::queryFirstList("SELECT mbKey, mbPhone FROM tmMember WHERE mbEmail = %s", $_POST['modifyEmail']);
}

//--------------------------------------------------------------------------------------------------------

//작성된 신청서 확인
$isExistApply = DB::queryFirstRow("SELECT * FROM tmApplyTmp WHERE mbEmail=%s AND dvKey=%i and apCancel = 0", $mb['mbEmail'],$_POST['dvKey']);
$countApply = DB::count();

//유입경로를 입력이 필요한지 아닌지 여부를 위해 자신이 했던 신청건의 갯수와 맨처음에 입력했던 유입경로를 가져옴
list($countApplyForReferrerChannel, $apReferrerChannelInitial) = DB::queryFirstList('SELECT COUNT(*), apReferrerChannel FROM tmApplyTmp WHERE mbEmail = %s ORDER BY apKey DESC', $mb['mbEmail']);
$countApplyForReferrerChannel = (int)$countApplyForReferrerChannel;

if($_POST['v'] === 'edit') 
	$isEdit = true;

$carrier = strtoupper($_POST['carrier']);
$dvChannel = 'dvChannel'.$carrier;

list($isExistDevice, $chKey) = DB::queryFirstList("SELECT COUNT(*), $dvChannel FROM tmDevice WHERE dvDisplay = 1 and dvKey = %s", $_POST['dvKey']);

//--------------------------------------------------------------------------------------------------------

try
{
	
	if($isLogged == false)
		throw new Exception('별 포인트 적립을 위해 로그인 해주세요!', 3);

	if($countApply > 0 AND isExist($_POST['v']) === false) //중복 신청 방지
		throw new Exception('이미 신청이 완료되었습니다', 4);

	if(isNullVal($_POST['applyType']))
		throw new Exception('가입유형을 선택해주세요 ', 3);

	if(isNullVal($_POST['discountType']))
		throw new Exception('할인유형을 선택해주세요 ', 3);

	if(isNullVal($_POST['plan']))
		throw new Exception('요금제를 선택해주세요 ', 3);

	if(isNullVal($_POST['apPhone']))
		throw new Exception('추가 전화번호를 적어주세요 ', 3);

	$apBirth = parsingNum($_POST['apBirth']);
	$apBirthLen = strlen($apBirth);
	if(isNullVal($apBirth) || isDate($apBirth) === false || $apBirthLen != '8' && $apBirthLen !='6') 
		throw new Exception('생년월일을 0000-00-00 형식으로 입력해주세요 ', 3);

	if(isNullVal($_POST['apColor']))
		throw new Exception('색상을 선택해주세요 ', 3);


	//(신청완료가 아닌 신청건이 0개거나) (수정중인데 신청완료가 아닌 신청건이 1개 이하일때) 유입경로 입력이 필요함
	// 수정시 신청완료가 아닌 신청건이 1개 이하로 한이유는 
	if($countApplyForReferrerChannel === 0 || ($countApplyForReferrerChannel === 1 && $isEdit === TRUE)) {
		$isNeedReferrerChannel = TRUE;
	}

	if($isNeedReferrerChannel === true && isNotExist($_POST['apReferrerChannel']) === true) {
		throw new Exception('유입경로를 선택해주세요! ', 3);
	}


	// V20 이벤트로 인해 추가된 코드
	if($_POST['dvId'] == 'v20') {
		if(isNullVal($_POST['apBenefits']))
			throw new Exception("혜택을 선택해주세요", 3);

		if(isNullVal($_POST['apBuyway']))
			throw new Exception("구매방법을 선택해주세요", 3);
	}
	// V20 이벤트로 인해 추가된 코드


	if(isNullVal($_POST['apCurrentCarrier']))
		throw new Exception('현재통신사를 선택해주세요 ', 3);
	
	
	if(isExist($isExistDevice) === FALSE)
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
catch(Exception $e){	

	if($e->getCode() === 4) { // 이미 신청서 작성되어있을때(중복신청 방지)

		if(isExist($_POST['modifyEmail']) === false){

			$URL = $cfg['url']."/user/applyState.php?apKey=".$isExistApply['apKey'];
		}else{

			$URL = $cfg['url']."/admin/productOrderList.php";
		}
		
    	alert($e->getMessage(), $URL);
	}else 
		alert($e->getMessage());	

}

//지급 포인트 가져오기

$getPlanInfo = getPlanInfo(
			array(
				'capacity' => $_POST['capacity'],				
				'plan' => $_POST['plan'],
				'carrier' => $_POST['carrier'],
				'applyType' => $_POST['applyType'],
				'discountType' => $_POST['discountType'],
				'id' => $_POST['dvId']
			)
		);

$rewardPoint = $getPlanInfo['rewardPoint']; 

$parentPoint = 0;
$grandPoint = 0;




//////////////////추천포인트 지급

if(isExist($_POST['recommedID'])){//추천포인트 지급

	// ID - parent 관계 인서트
	$isRelationExist = (int)$isRelationExist;
	if($isRelationExist === 0){
		DB::insert('tmPointRelationship', array(
		  'mbKey' => $myMbKey, 
		  'prParent' => $targetMbKey,
		  'prDate' => $cfg['time_ymdhis']
		));	
	}
	$parentPoint = $rewardPoint*0.05;

	//추천인 포인트 자동지급 삭제

	/*

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

	*/


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

		$grandPoint = $rewardPoint*0.05;
	
		//grand 추천인 포인트 자동지급 삭제
		/*
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
		*/
	}
}

if($apBirthLen == '8')
$date = date("Y-m-d", strtotime($apBirth));
if($apBirthLen == '6')
$date = date("y-m-d", strtotime("00".$apBirth));



///////////////// 신청서 DB insert

$arrApplyInfo = array(
    'mbEmail' => $mb['mbEmail'],
    'dvKey' => $_POST['dvKey'],
    'chKey' => $chKey,
    'apCurrentCarrier' => $_POST['apCurrentCarrier'],
    'apChangeCarrier' => $_POST['carrier'],
    'apColor' => $_POST['apColor'],
    'apBirth' => $date,
    'apPlan' => $_POST['plan'],
    'apApplyType' => $_POST['applyType'],
    'apDatetime' => $cfg['time_ymdhis'],
    'apDiscountType' => $_POST['discountType'],
    'apBuyway' => $_POST['apBuyway'],
    'apPoint' => $rewardPoint,
    'apParentPoint' =>$parentPoint,
    'apGrandPoint' =>$grandPoint
);


// V20 이벤트로 인해 추가된 코드
if($_POST['apBenefits'] == 'gifts') {
	$arrApplyInfo['apBenefits'] = $getPlanInfo['gift'];
} else {
	$arrApplyInfo['apBenefits'] = '포인트';
}
// V20 이벤트로 인해 추가된 코드


if($isNeedReferrerChannel === true) {
	$arrApplyInfo['apReferrerChannel'] = $_POST['apReferrerChannel'];
} else {
	$arrApplyInfo['apReferrerChannel'] = $apReferrerChannelInitial;
}

if(isExist($_POST['v']) === true){ // 고객이 직접 수정 & 어드민 수정 둘다 해당

	DB::update('tmApplyTmp', $arrApplyInfo,		
		"mbEmail=%s AND apKey=%i AND apCancel = 0", $mb['mbEmail'],$_POST['modifyApkey']);

}else if (isExist($_POST['v']) === false AND $countApply === 0){ // 새롭게 신청하는 상태

	DB::insert('tmApplyTmp', $arrApplyInfo);

}



// 포인트 자동지급 삭제
/*
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
*/			


$deviceInfo = new deviceInfo();

if(isExist($_POST['v']) === true AND isExist($_POST['modifyEmail']) === false){ // 고객이 직접 수정하는 상태이면 신청현황 페이지로 가게끔 설정

	goURL($cfg['url']."/user/applyState.php?apKey=".$_POST['modifyApkey']);

}else if(isExist($_POST['modifyEmail']) === true){ // 어드민에서 수정하는 상태이면 어드민 페이지로 가게끔 설정

	goURL($cfg['url']."/admin/productOrderList.php");	

}else{ // 새롭게 신청서 작성시 문자 설정 & 실가입 주소로 가게끔 설정

	$SMS = new SMS();

	$sendCont = "[티플] ".$_POST['applyTitle']." 가입신청 완료.\n마이페이지나 화면 안내에 따라 실가입을 진행해주세요";
	$SMS->sendMode('SMS')->sendMemberPhone($_POST['apPhone'])->sendMemberName($mb['mbName'])->sendCont($sendCont)->send();	

}

?>
<!-- // submit페이지로 이동해서 실가입 url로 이동 -->
<form action="submit.php" method="post" class="goApplyUrl">
	<input type="hidden" name="capacity" value="<?echo $_POST['capacity']?>">
	<input type="hidden" name="plan" value="<?echo $_POST['plan']?>">
	<input type="hidden" name="carrier" value="<?echo $_POST['carrier']?>">
	<input type="hidden" name="applyType" value="<?echo $_POST['applyType']?>">
	<input type="hidden" name="discountType" value="<?echo $_POST['discountType']?>">
	<input type="hidden" name="dvId" value="<?echo $_POST['dvId']?>">
</form>
<script>
	$(window).load(function(){
	    $('.goApplyUrl').submit();
	});
	
</script>
