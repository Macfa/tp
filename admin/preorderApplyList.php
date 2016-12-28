<?

require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

$js_file .= '<script type="text/javascript" src="'.PATH_JS.'/input.js"></script>';

require_once($cfg['path']."/adminhead.php");			// 헤더 부분 (스킨포함)

$search = $_GET['search'];
$searchState = $_GET['searchState'];


$sql = "SELECT * FROM tmPreorderV20";
$array = array(1=>1);

if(isExist($search) || isExist($searchState))
	$sql  .= " WHERE";

if(isExist($search)){
	$sql  .= " (pvName LIKE %ss_search OR pvPhone LIKE %ss_search OR pvEmail LIKE %ss_search)";
	$array['search'] = $search;
}
if($searchState === 'cancel'){
	if(isExist($search))
	$sql .= " and";
	$sql .= " pvCancel = %i_pvCancel";
	$array['pvCancel'] = '1';
}
else if(isExist($searchState)){	
	if(isExist($search))
	$sql  .= " and";
	$sql  .= " (pvProcess = %i_searchState and pvCancel = %i_pvCancel)";	
	$array['searchState'] = $searchState;
	$array['pvCancel'] = '0';
}


$existList = DB::query($sql.' ORDER BY pvDatetime DESC', $array);


//var_dump($existList['2']['pvPhone']);

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

foreach($existList as $key => $row) {			
	$existList[$key]['cancelClass'] = ($row['pvCancel']==='1')?'style=color:red':'1';
}

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




require_once("preorderApplyList.skin.php");		

require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)
?>