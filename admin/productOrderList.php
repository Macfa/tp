<?php
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

$js_file .= '<script type="text/javascript" src="'.PATH_JS.'/input.js"></script>';
require_once($cfg['path']."/adminhead.php");			// 헤더 부분 (스킨포함)


$search = $_GET['search'];

// 서치 조건에 맞는 이름과 폰번호 db에서 아이디 조회

if(isNum($search)){
	$sechField = 'mbPhone';
}else $sechField = 'mbName';

$searchEmailList = DB::query("SELECT mbEmail FROM tmMember WHERE $sechField LIKE %ss", $search);

//////////////////////////////


$sql = "SELECT * FROM tmApplyTmp";
	
if(isExist($search) === false AND $_GET['chked'] != 'canceled') // 초기 리스트
	$sql  .= " WHERE apCancel = 0";

if(isExist($_GET['chked']) || isExist($search)){ // 조건이 있을때 다운로드파일url
	$sql  .= " WHERE";
	$downloadUrl = $_SERVER['REQUEST_URI'];
	$downloadUrl = explode("?",$downloadUrl);
	$downloadFullUrl = "productOrderListDownload.php?".$downloadUrl[1];

}
if(isExist($search) === false AND $_GET['chked'] === 'canceled') // 초기 리스트
	$sql  .= " apCancel = 1";



if(isExist($search) === true){

	if(empty($searchEmailList) === false){ // 서치 조건이 일치하는 사람이 있을때 

		foreach ($searchEmailList as $k => $arr){ 	
			$arrayEmail[$k] = $arr['mbEmail'];
		}

		$arr = implode("','", $arrayEmail);
		$arr = "'".$arr."'";
		$sql .= " mbEmail IN ($arr)"; // 조건에 맞는 아이디를 조건에 포함

		$sql  .= " and (apCancel = %i_apCancel)";		
		$array['apCancel'] = 0;
		if($_GET['chked'] === 'canceled'){
			$array['apCancel'] = 1;
		}
	}else { // 서치 조건이 일치하는 사람이 없을때 
		$sql .= " apCancel = 3";
		if($_GET['chked'] === 'canceled'){
			$array['apCancel'] = 1;
		}
	}
}

$existList = DB::query($sql.' ORDER BY apDatetime DESC', $array);

$count = count($existList);


$phone = new deviceInfo();


foreach($existList as $key => $row){
	list($mbName[$key], $mbPhone[$key]) = DB::queryFirstList("SELECT mbName, mbPhone FROM tmMember WHERE mbEmail=%s", $row['mbEmail']);

	list($dvParent[$key], $dvTit[$key], $dvModelCode[$key]) = DB::queryFirstList("SELECT dvParent, dvTit, dvModelCode FROM tmDevice WHERE dvKey=%s", $row['dvKey']);

	$dvTitList[$key] = $dvTit[$key];
	
	if((int)$dvParent[$key] !== 0){
		$dvTitList[$key] = DB::queryFirstField("SELECT dvTit FROM tmDevice WHERE dvKey=%s", $dvParent[$key]);			

	}
	

	
	$arrPlan[] = $phone->getPlanName($row['apPlan']);


}


foreach($existList as $key => $row) {			
	$existList[$key]['cancelClass'] = ($row['apCancel']==='1')?'style=color:red':'1';	
}


$date = date("Y-m-d", strtotime( $str_date ) );

$type = array(
	'01' => '신규',
	'02' => '번호이동',
	'06' => '기기변경'
);

$cancel = array(
	'0' => '-',
	'1' => '취소'
);

$state = array(
	0 => '신청완료',
	1 => '실가입신청확인',
	2 => '기기발송',
	3 => '기기도착',
	4 => '개통대기',
	5 => '개통완료',
	6 => '사은품발송대기',
	7 => '사은품발송',
	8 => '완료'	
);

$changeState = $state;






require_once("productOrderList.skin.php");

require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)

?>