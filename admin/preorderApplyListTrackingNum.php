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
	DB::update('tmPreorderV20', array(
  'pvCancel' => '0'
  ), "pvKey=%s", $checkedList);	

}

goURL($cfg['url']."/admin/preorderApplyList.php");






?>