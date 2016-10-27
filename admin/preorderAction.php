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
foreach($checked as $checkedList){
	$preorderMember = DB::queryFirstRow("SELECT * FROM tmPreorderApplyList WHERE paKey=%s", $checkedList);
	$SMS->sendMode(0)->sendMemberPhone($preorderMember['paPhone'])->sendMemberName($preorderMember['paName'])->sendCont($sendCont)->send();
}


goURL($cfg['url']."/admin/preorder.php".$searchDeviceUrl);



?>