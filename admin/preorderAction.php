<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)


$checked = $_POST['chk'];
$changeProcess = $_POST['changeProcess'];

try{
	
	if($isLogged == false)
		throw new Exception('로그인 해주세요!', 3);

	if(isExist($checked) === false)
		throw new Exception('적용할 행을 선택해주세요', 3);

	if(isExist($changeProcess) === false)
		throw new Exception('진행상황을 선택해주세요', 3);


	
} catch (Exception $e) {	

	alert($e->getMessage());
}




function changePreorderProcess($checked,$changeProcess,$preorderTable) {
	if($preorderTable === 'tmPreorderV20'){
			$process = 'pvProcess';
			$key = 'pvKey';
			$phone = 'pvPhone';
		}

	if($preorderTable === 'tmPreorderApplyList'){
			$process = 'paProcess';
			$key = 'paKey';
			$phone = 'paPhone';
		}

	foreach($checked as $checkedList){

		
		DB::update($preorderTable, 
			array(
				$process => $changeProcess
			), "$key=%s", $checkedList
		);

		$preorderPhone = DB::queryFirstField("SELECT $phone FROM $preorderTable WHERE $key=%s", $checkedList);

		DB::insert('tmSmsProcess', 
			array(
				'spProcess' => $changeProcess,
				'spPhone' => $preorderPhone				
			)
		);		
	}

}

changePreorderProcess($checked,$changeProcess,'tmPreorderApplyList');

if(isExist($_POST['hidden'])){
	$searchDeviceUrl = "?searchDevice=".$_POST['hidden'];
}


$SMS = new SMS();
if($_POST['hidden'] === '3')
	$title = '아이폰7';
if($_POST['hidden'] === '5')
	$title = '비와이폰';

	switch($changeProcess) {	
		case '0' :
			$sendCont = "[티플 ".$title."] 사전예약 신청이 접수되었습니다. 감사합니다.";
			break;
		case '1' :
			$sendCont = "[티플 ".$title."] 신청이 확인되었습니다. 감사합니다.";
			break;
		case '2' :
			$sendCont =  "[티플 ".$title."] 로그인 후 마이페이지에서 실가입을 신청해주세요.";
			break;
		case '3' :
			$sendCont =  "[티플 ".$title."] 실가입신청이 확인 되었습니다.";
			break;
		case '4' :
			$sendCont =  "[티플 ".$title."] 신청하신 기기가 발송되었습니다.";
			break;
		case '5' :
			$sendCont =  "[티플 ".$title."] 기기도착이 확인 되었습니다.";
			break;
		case '6' :
			$sendCont =  "[티플 ".$title."] 개통대기 상태로 변경되었습니다.";
			break;	
		case '7' :
			$sendCont =  "[티플 ".$title."] 기기 개통이 완료되었습니다.";
			break;
		case '8' :
			$sendCont =  "[티플 ".$title."] 사은품 발송대기 상태로 변경되었습니다.";
			break;
		case '9' :
			$sendCont =  "[티플 ".$title."] 사은품이 발송 되었습니다 감사합니다";
			break;
		case '10' :
			$sendCont =  "[티플 ".$title."] 티플에서 신청해주셔서 감사합니다";
			break;
	}
foreach($checked as $checkedList){
	$preorderMember = DB::queryFirstRow("SELECT * FROM tmPreorderApplyList WHERE paKey=%s", $checkedList);
	$SMS->sendMode('SMS')->sendMemberPhone($preorderMember['paPhone'])->sendMemberName($preorderMember['paName'])->sendCont($sendCont)->send();
}


goURL($cfg['url']."/admin/preorder.php".$searchDeviceUrl);



?>