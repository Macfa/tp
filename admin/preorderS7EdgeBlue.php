<?php

$preorder = DB::query("SELECT * FROM tmPreorder WHERE poDisplay=%i", '1');

$search = $_GET['search'];
$sql = "SELECT * FROM tmApply";
	
if( isExist($_GET['searchDevice']) === false)
	$sql  .= " WHERE taCancel = 3";

if(isExist($_GET['chkedCancel']) || isExist($_GET['searchDevice']) || isExist($search)){
	$sql  .= " WHERE";
	$downloadUrl = $_SERVER['REQUEST_URI'];
	$downloadUrl = explode("?",$downloadUrl);
	$downloadFullUrl = "preorderS7EdgeBlueDownload.php?".$downloadUrl[1];
}

if(isExist($search)){
	$sql  .= " (mbName LIKE %ss_search OR mbPhone LIKE %ss_search OR mbEmail LIKE %ss_search)";
	$array['search'] = $search;
}


if(isExist($_GET['searchDevice'])){	
	if(isExist($search))
	$sql  .= " and";
	$sql  .= " (poKey=%i_searchDevice and taCancel = %i_taCancel)";	
	$array['searchDevice'] = $_GET['searchDevice'];
	$array['taCancel'] = '0';
	if($_GET['chked'] === 'canceled'){
		$array['taCancel'] = '1';
	}
}


$existList = DB::query($sql.' ORDER BY dateTime DESC', $array);
$count = DB::count();

$preorderTitle = DB::queryFirstField("SELECT poDeviceName FROM tmPreorder WHERE poKey=%i", $_GET['searchDevice']);

$date = date("Y-m-d", strtotime( $str_date ) );


$plan = array(
	0 => 'T시그니쳐 Master',
	1 => 'T시그니쳐 Classic',
	2 => 'band 데이터 퍼펙트S',
	3 => 'band 데이터 퍼펙트',
	4 => 'band 데이터 6.5G',
	5 => 'band 데이터 3.5G',
	6 => 'band 데이터 2.2G',
	7 => 'band 데이터 1.2G',
	8 => 'band 데이터 세이브',
	15 => 'LTE 데이터 선택 109',
	16 => 'LTE 데이터 선택 76.8',
	17 => 'LTE 데이터 선택 65.8',
	18 => 'LTE 데이터 선택 54.8',
	19 => 'LTE 데이터 선택 49.3',
	20 => 'LTE 데이터 선택 43.8',
	23 => 'LTE 데이터 선택 38.3',
	24 => 'LTE 데이터 선택 32.8'
);

$type = array(
	'02' => '번호이동',
	'06' => '기기변경'
);

foreach($existList as $key => $row) {			
	$existList[$key]['cancelClass'] = ($row['taCancel']==='1')?'style=color:red':'1';
}
$gift = array(
	'tablet' => '엠피지오 태블릿',
	'externalHard' => '외장SSD 128G',
	'skMirroring' => 'SK 미러링'
);


foreach($existList as $key => $row) {			
	$existList[$key]['paGift'] = explode(',',$row['paGift']);
}


$sex = array(
	'0' => '남자',
	'1' => '여자'	
);

$buy = array(
	'0' => '비구매',
	'1' => '구매'	
);

$cancel = array(
	'0' => '-',
	'1' => '취소'
);

$state = array(
	'' => '진행상태',
	'cancel' => '예약취소',
	0 => '예약접수',
	1 => '예약완료',
	2 => '실가입신청필요',
	3 => '실가입신청확인',
	4 => '기기발송',
	5 => '기기도착',
	6 => '개통대기',
	7 => '개통완료',
	8 => '사은품발송대기',
	9 => '사은품발송',
	10 => '완료'	
);

$changeState = $state;

/*$state = array(
	'' => '진행상태',
	'cancel' => '예약취소',
	0 => '예약접수',
	1 => '예약완료',
	2 => '실가입신청필요',
	3 => '실가입신청확인',
	4 => '서류업로드 필요',
	5 => '서류업로드 됨',
	6 => '서류업로드 반려',
	7 => '서류업로드 확인',
	8 => '기기발송',
	9 => '기기도착',
	10 => '개통대기',
	11 => '개통완료',
	12 => '사은품발송대기',
	13 => '사은품발송',
	14 => '완료'	
);*/



unset($changeState['']);
unset($changeState['cancel']);


$deviceKey = array(
	'664' => '갤럭시S7엣지 32G'
);


$color = array(
	'blue' => '코랄블루'
);

$carrier = array(
	'sk' => 'sk',
	'kt' => 'kt'
);


foreach($existList as $key => $row) {	
	
$preorderOrderNum = $row['taWatingNumber'] + 100; 
$preorderOrderNumString[$key] = "01 - ".$preorderOrderNum;
	if($row['taWatingNumber'] > 200){		
		$preorderOrderNum = $preorderOrderNum - 200;
		$preorderOrderNumString = "02 - ".$arrOrderNum[$key];
}
}



?>