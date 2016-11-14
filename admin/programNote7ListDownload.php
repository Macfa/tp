<?php
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename=업로드목록.xls');
header('Cache-Control: max-age=0');

include_once('./_common.inc.php');
include_once(PATH_LIB.'/lib.parsing.inc.php');
include_once(PATH_LIB.'/lib.snoopy.inc.php');
include_once(PATH_LIB.'/lib.PHPExcel.inc.php');




$buy = array(
	'0' => '비구매',
	'1' => '구매'
);

$type = array(
	'02' => '번호이동',
	'06' => '기기변경'
);

$cancel = array(
	'0' => '-',
	'1' => '취소'
);



$search = $_GET['search'];
$sql = "SELECT * FROM tmNote7Program";

if(isExist($search) || isExist($_GET['serchProcess'])){
	$sql  .= " WHERE";
	$downloadUrl = $_SERVER['REQUEST_URI'];
	$downloadUrl = explode("?",$downloadUrl);
	$downloadFullUrl = "programNote7ListDownload.php?".$downloadUrl[1];
}

if(isExist($search)){
	$sql .= " (mbName LIKE %ss_search OR mbPhone LIKE %ss_search)";
	$array['search'] = $search;	
}


$existList = DB::query($sql, $array);


if(isExist($_POST['chk'])){
	$existList = DB::query("SELECT * FROM tmNote7Program WHERE tnKey IN %li", $_POST['chk']);
}


$obj_excel = new PHPExcel();
$row_array = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H');

$obj_excel->setActiveSheetIndex(0)
				->setCellValueExplicit('A1', '타임스탬프', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('B1', '신청자명', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('C1', '전화번호', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('D1', '이메일', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('E1', '티플에서 구매여부', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('F1', '현재통신사', PHPExcel_Cell_DataType::TYPE_STRING)					
				->setCellValueExplicit('G1', '가입유형', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('H1', '취소여부', PHPExcel_Cell_DataType::TYPE_STRING);
$row = 2;
foreach ($existList as $key => $val){

	$obj_excel->setActiveSheetIndex(0)
					->setCellValueExplicit('A'.$row, $val['tnDateTime'], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('B'.$row, $val['mbName'], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('C'.$row, $val['mbPhone'], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('D'.$row, $val['tnEmail'], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('E'.$row, $buy[$val['isBuyTplanitNote7']], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('F'.$row, $val['tnCurrentCarrier'], PHPExcel_Cell_DataType::TYPE_STRING)					
					->setCellValueExplicit('G'.$row, $type[$val['tnApplyType']], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('H'.$row, $cancel[$val['tnCancel']], PHPExcel_Cell_DataType::TYPE_STRING);
	$row++;
}



$obj_writer = PHPExcel_IOFactory::createWriter($obj_excel, 'Excel5');
$obj_writer->save('php://output');