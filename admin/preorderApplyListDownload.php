<?php
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename=업로드목록.xls');
header('Cache-Control: max-age=0');

include_once('./_common.inc.php');
include_once(PATH_LIB.'/lib.parsing.inc.php');
include_once(PATH_LIB.'/lib.snoopy.inc.php');
include_once(PATH_LIB.'/lib.PHPExcel.inc.php');


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
	'749' => '비와이폰'
);




$preorder = DB::query("SELECT * FROM tmPreorder WHERE poDisplay=%i", '1');



if(isExist($_GET)){
	$sql = "SELECT * FROM tmPreorderApplyList";
		
	if(isExist($_GET['searchDevice']) === false)
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
}



if(isExist($_POST['chk'])){
	$list = DB::query("SELECT * FROM tmPreorderApplyList WHERE paKey IN %li", $_POST['chk']);
}


$obj_excel = new PHPExcel();
$row_array = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P','Q');

$obj_excel->setActiveSheetIndex(0)
				->setCellValueExplicit('A1', '타임스탬프', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('B1', '현재통신사', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('C1', '가입유형', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('D1', '신청한통신사', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('E1', '순 번', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('F1', '신청기기', PHPExcel_Cell_DataType::TYPE_STRING)					
				->setCellValueExplicit('G1', '색상', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('H1', '선택요금제', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('I1', '선택사은품', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('J1', '예약자명', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('K1', '생년월일', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('L1', '성별', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('M1', '전화번호', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('N1', '이메일', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('O1', '진행상황', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('P1', '취소상태', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('Q1', '연락가능시간', PHPExcel_Cell_DataType::TYPE_STRING);
$row = 2;
foreach ($list as $key => $val){

	if(isExist($plan[$val['paPlan']])){
		$val['paPlan'] = $plan[$val['paPlan']];
	}else{
		$val['paPlan'] = $val['paPlan'];
	}

	$val['paGift'] = explode(",", $val['paGift']);
	foreach($val['paGift'] as $giftVal){
		$tmp[] = $gift[$giftVal];		
	}
	$val['paGift'] = implode(",",$tmp);
	unset($tmp);
	

	$obj_excel->setActiveSheetIndex(0)
					->setCellValueExplicit('A'.$row, $val['paDatetime'], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('B'.$row, $val['paCurrentCarrier'], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('C'.$row, $type[$val['paApplyType']], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('D'.$row, $val['paChangeCarrier'], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('E'.$row, $val['paWatingNumber'], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('F'.$row, $deviceKey[$val['dvKey']], PHPExcel_Cell_DataType::TYPE_STRING)					
					->setCellValueExplicit('G'.$row, $val['paColorType'], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('H'.$row, $val['paPlan'], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('I'.$row, $val['paGift'], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('J'.$row, $val['paName'], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('K'.$row, $val['paBirth'], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('L'.$row, $sex [$val['paSexType']], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('M'.$row, $val['paPhone'], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('N'.$row, $val['paEmail'], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('O'.$row, $state[$val['paProcess']], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('P'.$row, $cancel[$val['paCancel']], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('Q'.$row, $val['paContactTime'], PHPExcel_Cell_DataType::TYPE_STRING);
	$row++;
}



$obj_writer = PHPExcel_IOFactory::createWriter($obj_excel, 'Excel5');
$obj_writer->save('php://output');