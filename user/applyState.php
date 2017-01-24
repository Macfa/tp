<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
$import->addCSS('mypageList.css');

try{
	
	if($isLogged === false)
		throw new Exception('로그인 해주세요!', 1);

	if(isExist($_GET['apKey']) === false)
		throw new Exception("잘못된 접근입니다", 2);

	$arrApplyList = DB::queryFirstRow("SELECT * FROM tmApplyTmp AS apply LEFT JOIN tmDevice AS device ON apply.dvKey = device.dvKey WHERE apply.mbEmail=%s AND apply.apKey = %i", $mb['mbEmail'], $_GET['apKey']);
	
	if(COUNT($arrApplyList) === 0 )
		throw new Exception('구매하신 후 이용해주세요', 2);
	
	

} catch (Exception $e) {	

	if ($e->getCode() === 1)
		$errorURL = $cfg['login_url'];

	else if ($e->getCode() === 2)
		$errorURL = $cfg['url']."/user/mySpace.php";
	
	alert($e->getMessage(), $errorURL);
}


//===========  신청서 타이틀
if((int)$arrApplyList['dvParent'] === 0){ // 용량이 따로 없는 기기
	$applyDevice = $arrApplyList['dvTit'];
	$deviceId = $arrApplyList['dvId'];

}else{ // 용량이 따로 있는 기기
	list($applyDevice, $parentId) = DB::queryFirstList("SELECT dvTit, dvId FROM tmDevice WHERE dvKey=%i", $arrApplyList['dvParent']);
	$applyCapacity = $arrApplyList['dvTit'];
	$deviceId = $parentId;

}

//=========== 구매자명 전화번호
list($mbName, $mbPhone) = DB::queryFirstList("SELECT mbName, mbPhone FROM tmMember WHERE mbEmail=%s", $arrApplyList['mbEmail']);

//=========== 지급 포인트
if($arrApplyList['apPoint'] === "미정"){
	$apPoint = $arrApplyList['apPoint'];
}else{
	$apPoint = number_format($arrApplyList['apPoint']);
}


//===========device 클래스 사용

$deviceInfo = new deviceInfo();


//===========수정하기 페이지 url


$applyEditURL = "/apply/?apKey=".$_GET['apKey']."&v=edit";


//============일반구매 진행상황

$state = array(
	
	0 => '신청완료',
	1 => '연락두절',
	2 => '연락필요',
	3 => '신청수단없음',
	4 => '실가입확인',
	5 => '개통완료',
	6 => '이슈발생',
	7 => '신청중'	
);

$currentState[$arrApplyList['apProcess']] = 'active';

$way = array(
	'delivery' => '택배',
	'guest' => '내방',
	);




require_once($cfg['path']."/head.inc.php");			// 헤더 부분 (스킨포함)

require_once("applyState.skin.php");	

require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)

?>