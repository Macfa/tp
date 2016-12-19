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

	list($cancelPoint, $cancelEmail) = DB::queryFirstList("SELECT rpPoint, mbEmail FROM tmApplyTmp WHERE apKey=%i", $checkedList);
	$cancelMember = DB::queryFirstRow("SELECT * FROM tmMember WHERE mbEmail=%s", $cancelEmail);

	//신청서에 취소 표시
	DB::update('tmApplyTmp', array(
  'apCancel' => '1'
  ), "apKey=%i", $checkedList);	

	//취소자 포인트 제거
	DB::update('tmMember', array(
	'mbPoint' => $cancelMember['mbPoint']-$cancelPoint
	),'mbEmail = %s', $cancelEmail);

	//취소자 포인트 히스토리
	DB::insert('tmPointHistory', array(
	'mbEmail' => $cancelEmail,
	'phCont' => $cfg['time_ymdhis'].' 신청취소',
	'phAmount' => -($cancelPoint),
	'phResult' => $cancelMember['mbPoint']-$cancelPoint,
	'phDate' => $cfg['time_ymdhis']
	));



	$relationship = DB::queryFirstRow("SELECT * FROM tmPointRelationship WHERE mbKey=%i", $cancelMember['mbKey']);
	
	if(isExist($relationship) === true){ // 추천인이 있을때만 취소포인트 적용

		//취소자의 부모단계 멤버
		$cancelParent = DB::queryFirstRow("SELECT * FROM tmMember WHERE mbKey=%i", $relationship['prParent']);	

		//취소자의 부모 포인트 수정
		DB::update('tmMember', 
			array(
				'mbPoint' => DB::sqleval("mbPoint-($cancelPoint * 0.05)")
			),	'mbKey = %i', $relationship['prParent']
		);

		//취소자의 부모 포인트 히스토리
		DB::insert('tmPointHistory', array(
			'mbEmail' => $cancelParent['mbEmail'],
			'phCont' => $cfg['time_ymdhis'].' 추천포인트취소',
			'phAmount' => -($cancelPoint*0.05),
			'phResult' => $cancelParent['mbPoint'] - ($cancelPoint*0.05) ,
			'phDate' => $cfg['time_ymdhis']
		));


		if($relationship['prGrand'] !== '0'){ // 3단계 성립 되었을때

			$cancelGrand = DB::queryFirstRow("SELECT * FROM tmMember WHERE mbKey=%i", $relationship['prGrand']);	

			//취소자의 grand 포인트 수정
			DB::update('tmMember', 
				array(
					'mbPoint' => DB::sqleval("mbPoint-($cancelPoint * 0.05)")
				),	'mbKey = %i', $relationship['prGrand']
			);

			//취소자의 grand 포인트 히스토리
			DB::insert('tmPointHistory', array(
				'mbEmail' => $cancelGrand['mbEmail'],
				'phCont' => $cfg['time_ymdhis'].' 3단계추천포인트취소',
				'phAmount' => -($cancelPoint*0.05),
				'phResult' => $cancelGrand['mbPoint'] - ($cancelPoint*0.05) ,
				'phDate' => $cfg['time_ymdhis']
			));
		}
	}

}




goURL($cfg['url']."/admin/productOrderList.php");




?>