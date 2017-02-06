<?php
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
$import->addJS('input.js');
require_once($cfg['path']."/adminhead.php");			// 헤더 부분 (스킨포함)

$search = $_GET['search'];

// 서치 조건에 맞는 이름과 폰번호 db에서 아이디 조회

if(isNum($search)){
	$sechField = 'mbPhone';
}else $sechField = 'mbName';

$searchEmailList = DB::query("SELECT mbEmail FROM tmMember WHERE $sechField LIKE %ss", $search);

//////////////////////////////

$sql = "SELECT * FROM tmApplyTmp as t LEFT JOIN tmDevice as d ON t.dvKey = d.dvKey";
	
if(isExist($search) === false AND $_GET['chked'] != 'canceled') {	// 초기 리스트
	if(isExist($_GET['apIsSpot']))
		$sql  .= " WHERE t.apCancel = 0 AND t.apIsSpot=".$_GET['apIsSpot'];
	else
		$sql  .= " WHERE t.apCancel = 0";
}

if(isExist($_GET['chked']) || isExist($search)){ // 조건이 있을때 다운로드파일url
	$sql  .= " WHERE ";
	$downloadUrl = $_SERVER['REQUEST_URI'];
	$downloadUrl = explode("?",$downloadUrl);
	$downloadFullUrl = "productOrderListDownload.php?".$downloadUrl[1];

}

if(isExist($search) === false AND $_GET['chked'] === 'canceled') { // 초기 리스트
	if(isExist($_GET['apIsSpot']))
		$sql .= "t.apIsSpot=".$_GET['apIsSpot']." AND t.apCancel = 1";
	else
		$sql .= "t.apCancel = 1";
}

if($_GET['deviceFilter'] != '신청기기' && isExist($_GET['deviceFilter'])) 
	if(isExist($_GET['search']))
		$sql .= " d.dvModelCode='".$_GET[deviceFilter]."' AND ";
	else
		$sql .= " AND d.dvModelCode='".$_GET[deviceFilter]."' ";

if(isExist($search) === true){

	if(empty($searchEmailList) === false){ // 서치 조건이 일치하는 사람이 있을때 

		foreach ($searchEmailList as $k => $arr){ 	
			$arrayEmail[$k] = $arr['mbEmail'];
		}

		$arr = implode("','", $arrayEmail);
		$arr = "'".$arr."'";
		$sql .= " t.mbEmail IN ($arr)"; // 조건에 맞는 아이디를 조건에 포함

		$sql  .= " and (t.apCancel = %i_apCancel)";		
		$array['apCancel'] = 0;
		if($_GET['chked'] === 'canceled'){
			$array['apCancel'] = 1;
		}
	}else { // 서치 조건이 일치하는 사람이 없을때 
		$sql .= " t.apCancel = 3";
		if($_GET['chked'] === 'canceled'){
			$array['apCancel'] = 1;
		}
	}
	if(isExist($_GET['apIsSpot']))
		$sql .= " AND t.apIsSpot=".$_GET['apIsSpot'];
}

$existList = DB::query($sql.' ORDER BY apDatetime DESC', $array);

foreach ($existList as $key => $row) {
	if($row['apBuyway'] == 'delivery')
		$existList[$key]['buyway'] = '택배';
	elseif($row['apBuyway'] == 'guest')
		$existList[$key]['buyway'] = '내방';

}

foreach ($existList as $key => $arr) {
	$existList[$key]['chName'] = DB::queryFirstField("SELECT chName FROM tmChannel WHERE chKey=%i", $arr['chKey']);
}

$count = count($existList);


$deviceInfo = new deviceInfo();


foreach($existList as $key => $row){
	list($mbName[$key], $mbPhone[$key]) = DB::queryFirstList("SELECT mbName, mbPhone FROM tmMember WHERE mbEmail=%s", $row['mbEmail']);

	list($dvParent[$key], $dvTit[$key], $dvModelCode[$key]) = DB::queryFirstList("SELECT dvParent, dvTit, dvModelCode FROM tmDevice WHERE dvKey=%s", $row['dvKey']);

	$dvTitList[$key] = $dvTit[$key];
	
	if((int)$dvParent[$key] !== 0){
		$dvTitList[$key] = DB::queryFirstField("SELECT dvTit FROM tmDevice WHERE dvKey=%s", $dvParent[$key]);
	}	
}



foreach($existList as $key => $row) {			
	$existList[$key]['cancelClass'] = ($row['apCancel']==='1')?'style=color:red':'1';	
}


$date = date("Y-m-d", strtotime( $str_date ) );


$cancel = array(
	'0' => '-',
	'1' => '취소'
);

$changeState = array(
	
	0 => '신청완료',
	1 => '연락두절',
	2 => '연락필요',
	3 => '신청수단없음',
	4 => '실가입확인',
	5 => '개통완료',
	6 => '이슈발생',
	7 => '신청중'
);

//========================신청기기 select 부분

$arrdeviceFilter = DB::query("SELECT * FROM tmApplyTmp WHERE apCancel=0");

foreach ($arrdeviceFilter as $k => $r) {
	$dvModel[] = DB::queryFirstField("SELECT dvModelCode FROM tmDevice WHERE dvKey=%s", $r['dvKey']);		
}

$deviceFilter = array_unique($dvModel);
sort($deviceFilter);


//========================신청기기 select 부분

require_once("productOrderList.skin.php");


require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)

?>