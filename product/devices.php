<?

// 검색엔진이 페이지를 잘 해석할 수 있게 html 마크업과 디자인을 리뉴얼한 버전

// 파일명.inc.php 는 다른 파일에 종속(include)되는 파일로 단독적으로 활용될수 없습니다.
// 파일명.skin.php 는 다른 파일의 html 부분을 담당하는 파일로 단독적으로 활용될수 없습니다.

require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)


if (getIndexInArr($_GET, 'carrier', 'key') < getIndexInArr($_GET, 'manuf', 'key')) $isGnbCarrier = true;
if (getIndexInArr($_GET, 'carrier', 'key') > getIndexInArr($_GET, 'manuf', 'key')) $isGnbManuf = true;

$add_css = '<link rel="stylesheet" href="'.PATH_CSS.'/deviceList.css" type="text/css">';
$js_file = '<script type="text/javascript" src="'.PATH_JS.'/deviceList.js"></script>';
$containerClass = 'device-list-wrap';
$isDeviceList = true;
$isShowManufSubNav = false;
$isShowDeviceNav = false;
$deviceListWhere = '';

if (($isGnbCarrier || $isGnbManuf) && $_GET['device'])
	alert('잘못된 접근입니다.');

//최상단메뉴에서 통신사가 선택되었고 
//서브메뉴에서 제조사가 선택되었으면
//서브메뉴가 애니메이션 없이 처음부터 보임
if ($isGnbCarrier && $_GET['manuf']) $isSubNavActive = 'active';

//최상단메뉴에서 통신사가 선택되었는데 
//서브메뉴에서 제조사가 선택되지 않았다면 
//서브메뉴에서 "전체"에 하이라이트
if ($isGnbCarrier && !$_GET['manuf']){
	$isSubAllActive = 'active';
}

switch($_GET['carrier']) {
	case 'all' :
	case 'kt' :
	case 'sk' :
		if ($isGnbCarrier)
			$isShowManufSubNav = true;
		$isShowDeviceNav = true;
		$deviceListWhere .= "and dv".strtoupper($_GET['carrier'])." = 1 ";
	case 'lguplus' :
		$deviceListWhere .= "and dvCate = 'phone'";
		if ($isGnbCarrier){
			${'isGnb'.ucfirst($_GET['carrier']).'Active'} = 'active';
			$subTitGnb = $_GET['carrier'].' 통신사';
		} else {
			${'isSub'.ucfirst($_GET['carrier']).'Active'} = 'active';
			$subTitSub = $_GET['carrier'].' 통신사';
		}
		break;
	case '' :
		break;
	default :
		alert('통신사 변수가 잘못됨');
		break;
}

switch($_GET['manuf']) {
	case 'samsung' :
	case 'apple' :
	case 'lg' :
	case 'etc' :
		$deviceListWhere .= "and dvCate = 'phone' and dvManuf = '".$_GET['manuf']."' ";
		$deviceNavManufId = $_GET['manuf'];
	case 'all' :
		if ($isGnbManuf){
			${'isGnb'.ucfirst($_GET['manuf']).'Active'} = 'active';
			$subTitGnb = $_GET['manuf'].' 기종';
		} else {
			${'isSub'.ucfirst($_GET['manuf']).'Active'} = 'active';
			$subTitSub = $_GET['manuf'].' 기종';
		}
		$isShowDeviceNav = true;
		break;
	case '' :
		break;
	default :
		alert('제조사 변수가 잘못됨');

		break;
}

switch($_GET['device']) {
	case 'pocketfi' :
		$deviceTit = '휴대용 와이파이';
	case 'watch' :
		if(!$deviceTit) $deviceTit = '스마트워치';
	case 'kids' :
		if(!$deviceTit) $deviceTit = '키즈폰';
		$deviceListWhere .= "and dvCate = '".$_GET['device']."' ";
		$deviceNavDeviceId = $_GET['device'];
		$isShowDeviceNav = true;
		${'isGnb'.ucfirst($_GET['device']).'Active'} = 'active';
		$subTitGnb = $deviceTit.' 기종';
		break;
	case '' :
		break;
	default :
		alert('기기 변수가 잘못됨');
		break;
}


if ($isGnbCarrier) {
	$containerClassPrefix = $_GET['carrier'].'-';
	if (isNullVal($_GET['manuf']) || $_GET['manuf'] == 'all')
		$bannerSuffix = ucfirst($_GET['carrier']);
	else if ($_GET['manuf'])
		$bannerSuffix = ucfirst($_GET['manuf']);
}

if ($isGnbManuf) {
	$containerClassPrefix = $_GET['manuf'].'-';
	if (isNullVal($_GET['carrier']) || $_GET['carrier'] == 'all')
		$bannerSuffix = ucfirst($_GET['manuf']);
	else if ($_GET['manuf'])
		$bannerSuffix = ucfirst($_GET['carrier']);
} 

if ($_GET['device']) {
	$containerClassPrefix = $_GET['device'].'-';
	$bannerSuffix = ucfirst($_GET['device']);
}

//---------------------------------------------------------------

$tmpSql = "SELECT d.* FROM tmDevice d LEFT JOIN tmSort o ON d.dvKey = o.soTargetKey WHERE d.dvDisplay=1 and d.dvParent = 0 ".$deviceListWhere."  GROUP BY d.dvKey ORDER BY o.soOrder is null ASC, o.soOrder ASC";
if($deviceNavManufId || $deviceNavDeviceId){
	$deviceNavResult = DB::query($tmpSql);
}else{
	$deviceNavResult = DB::query($tmpSql);
}

setSession('detailDeviceListSql', $tmpSql);
$incList['deviceResults'] = $deviceNavResult;


if ($subTitSub) {
	$subTitGnb = $subTitGnb.' 중 ';
	$cfg['subTitle'] = $subTitGnb.$subTitSub.' 리스트';
} else {
	$cfg['subTitle'] = $subTitGnb = $subTitGnb.' 리스트 ';
}

require_once($cfg['path']."/head.inc.php");			// 헤더 부분 (스킨포함)

if(file_exists("./".$includePrefix."devicesBanner".$bannerSuffix.".skin.php"))
	require_once("./".$includePrefix."devicesBanner".$bannerSuffix.".skin.php"); 

if($_GET['carrier'] === 'lguplus'){
	require_once("devicesKt.skin.php");
}else{
	
	require_once("deviceNews.php"); // 뉴스글	    
	require_once("deviceList.php"); // 최신기기   
}

require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)
?>