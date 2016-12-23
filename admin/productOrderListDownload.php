<?php
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename=일반구매목록.xls');
header('Cache-Control: max-age=0');

include_once('./_common.inc.php');
include_once(PATH_LIB.'/lib.parsing.inc.php');
include_once(PATH_LIB.'/lib.snoopy.inc.php');
include_once(PATH_LIB.'/lib.PHPExcel.inc.php');


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

$discount = array(
	'selectPlan' => '선택약정',
	'support' => '공시지원'
	);

/*
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
*/
$phone = new deviceInfo();

if(isExist($_POST['chk'])){
	$list = DB::query("SELECT * FROM tmApplyTmp WHERE apKey IN %li", $_POST['chk']);
}


$obj_excel = new PHPExcel();
$row_array = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N');

$obj_excel->setActiveSheetIndex(0)
				->setCellValueExplicit('A1', '진행상황', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('B1', '신청기기', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('C1', '신청모델명', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('D1', '구매자명', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('E1', '연락처', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('F1', '신청한통신사', PHPExcel_Cell_DataType::TYPE_STRING)					
				->setCellValueExplicit('G1', '가입유형', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('H1', '할인유형', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('I1', '현재통신사', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('J1', '요금제', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('K1', '색상', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('L1', '지급포인트', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('M1', '취소상태', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('N1', '타임스탬프', PHPExcel_Cell_DataType::TYPE_STRING);
$row = 2;
foreach ($list as $key => $val){
	list($mbName[$key], $mbPhone[$key]) = DB::queryFirstList("SELECT mbName, mbPhone FROM tmMember WHERE mbEmail=%s", $val['mbEmail']);

	list($dvParent[$key], $dvTit[$key], $dvModelCode[$key]) = DB::queryFirstList("SELECT dvParent, dvTit, dvModelCode FROM tmDevice WHERE dvKey=%s", $val['dvKey']);

	$dvTitList[$key] = $dvTit[$key];
	
	if((int)$dvParent[$key] !== 0){
		$dvTitList[$key] = DB::queryFirstField("SELECT dvTit FROM tmDevice WHERE dvKey=%s", $dvParent[$key]);			

	}
	
	$arrPlan[] = $phone->getPlanName($val['apPlan']);
	
	$obj_excel->setActiveSheetIndex(0)
					->setCellValueExplicit('A'.$row, $state[$val['apProcess']], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('B'.$row, $dvTitList[$key], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('C'.$row, $dvModelCode[$key], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('D'.$row, $mbName[$key], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('E'.$row, $mbPhone[$key], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('F'.$row, $val['apChangeCarrier'], PHPExcel_Cell_DataType::TYPE_STRING)					
					->setCellValueExplicit('G'.$row, $type[$val['apApplyType']], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('H'.$row, $discount[$val['apDiscountType']], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('I'.$row, $val['apCurrentCarrier'], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('J'.$row, $arrPlan[$key], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('K'.$row, $val['apColor'], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('L'.$row, $val['apPoint'], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('M'.$row, $cancel[$val['apCancel']], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('N'.$row, $val['apDatetime'], PHPExcel_Cell_DataType::TYPE_STRING);
	$row++;
}



$obj_writer = PHPExcel_IOFactory::createWriter($obj_excel, 'Excel5');
$obj_writer->save('php://output');