<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)


$checked = $_POST['chk'];

try{
	
	if($isLogged == false)
		throw new Exception('로그인 해주세요!', 3);

	if(isExist($checked) === false)
		throw new Exception('적용할 행을 선택해주세요', 3);


	
} catch (Exception $e) {	

	alert($e->getMessage());
}

foreach($checked as $checkedList){	
	$cancelApply = DB::queryFirstRow("SELECT * FROM tmApplyTmp WHERE apKey=%i", $checkedList);	
	$cancelMember = DB::queryFirstRow("SELECT * FROM tmMember WHERE mbEmail=%s", $cancelApply['mbEmail']);
	$cancelDevice = DB::queryFirstField("SELECT dvModelCode FROM tmDevice WHERE dvKey=%i", $cancelApply['dvKey']);	

	//신청서에 취소복구
	DB::update('tmApplyTmp', array(
		'apCancel' => '0'
		), "apKey=%i", $checkedList);	
/*
	//취소자 포인트 복구
	DB::update('tmMember', array(
		'mbPoint' => $cancelMember['mbPoint']+$cancelApply['apPoint']
		),'mbEmail = %s', $cancelApply['mbEmail']);

	//취소자 포인트 히스토리
	DB::insert('tmPointHistory', array(
		'mbEmail' => $cancelApply['mbEmail'],
		'phCont' => $cfg['time_ymdhis'].' '.$cancelDevice.' 신청취소복구',
		'phAmount' => $cancelApply['apPoint'],
		'phResult' => $cancelMember['mbPoint']+$cancelApply['apPoint'],
		'phDate' => $cfg['time_ymdhis']
		));



	$relationship = DB::queryFirstRow("SELECT * FROM tmPointRelationship WHERE mbKey=%i", $cancelMember['mbKey']);
	
	
	if(isExist($relationship) === true){ // 추천인이 있을때만 취소포인트 적용

		//취소자의 부모단계 멤버
		$cancelParent = DB::queryFirstRow("SELECT * FROM tmMember WHERE mbKey=%i", $relationship['prParent']);	
		$cancelParentPoint = $cancelApply['apParentPoint'];

		//취소자의 부모 포인트 수정
		DB::update('tmMember', 
			array(
				'mbPoint' => DB::sqleval("mbPoint+($cancelParentPoint)")
			),	'mbKey = %i', $relationship['prParent']
		);

		//취소자의 부모 포인트 히스토리
		DB::insert('tmPointHistory', array(
			'mbEmail' => $cancelParent['mbEmail'],
			'phCont' => $cfg['time_ymdhis'].' 추천포인트취소복구',
			'phAmount' => $cancelApply['apParentPoint'],
			'phResult' => $cancelParent['mbPoint'] + ($cancelApply['apParentPoint']) ,
			'phDate' => $cfg['time_ymdhis']
		));


		if((int)$relationship['prGrand'] !== 0){ // 3단계 성립 되었을때

			$cancelGrand = DB::queryFirstRow("SELECT * FROM tmMember WHERE mbKey=%i", $relationship['prGrand']);	
			$cancelGrandPoint = $cancelApply['apGrandPoint'];

			//취소자의 grand 포인트 수정
			DB::update('tmMember', 
				array(
					'mbPoint' => DB::sqleval("mbPoint+($cancelGrandPoint)")
				),	'mbKey = %i', $relationship['prGrand']
			);

			//취소자의 grand 포인트 히스토리
			DB::insert('tmPointHistory', array(
				'mbEmail' => $cancelGrand['mbEmail'],
				'phCont' => $cfg['time_ymdhis'].' 3단계추천포인트취소복구',
				'phAmount' => $cancelApply['apGrandPoint'],
				'phResult' => $cancelGrand['mbPoint'] + ($cancelApply['apGrandPoint']) ,
				'phDate' => $cfg['time_ymdhis']
			));
		}
	}
*/

}




goURL($cfg['url']."/admin/productOrderList.php");




?>