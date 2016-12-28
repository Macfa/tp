<?include_once('./_common.inc.php');

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
	'01' => '신규',
	'02' => '번호이동',
	'06' => '기기변경'
);

$gift = array(
	'tablet' => '엠피지오 태블릿',
	'externalHard' => 'LG 외장하드 500G',
	'skMirroring' => 'SK 미러링'
);

$sex = array(
	'0' => '남자',
	'1' => '여자'	
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

$deviceKey = array(
	'741' => '아이폰7 32G',
	'742' => '아이폰7 128G',
	'743' => '아이폰7 256G',
	'745' => '아이폰7플러스 32G',
	'746' => '아이폰7플러스 128G',
	'747' => '아이폰7플러스 256G',
);




$preorder = DB::query("SELECT * FROM tmPreorder WHERE poDisplay=%i", '1');

if(isExist($_POST['chk'])){
	foreach ($_POST['chk'] as $key => $val){
		$list[$key] = DB::query("SELECT * FROM tmPreorderApplyList WHERE paKey=%i", $val);	


}
}
var_dump($list);

$sql = "SELECT * FROM tmPreorderApplyList";
	
if( isExist($_GET['searchDevice']) === false)
	$sql  .= " WHERE paCancel = 3";

if(isExist($_GET['chkedCancel']) || isExist($_GET['searchDevice']))
	$sql  .= " WHERE";

if(isExist($_GET['searchDevice'])){
	$sql  .= " poKey=%i_searchDevice AND paCancel=%i_paCancel";
	$array['searchDevice'] = $_GET['searchDevice'];
	$array['paCancel'] = '0';
	
	if($_GET['chked'] === 'canceled'){
		$array['paCancel'] = '1';
	}
}

$list = DB::query($sql.' ORDER BY paDatetime DESC', $array);

?>