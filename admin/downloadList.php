<?php
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename=업로드목록.xls');
header('Cache-Control: max-age=0');

include_once('./_common.inc.php');
include_once(PATH_LIB.'/lib.parsing.inc.php');
include_once(PATH_LIB.'/lib.snoopy.inc.php');
include_once(PATH_LIB.'/lib.PHPExcel.inc.php');

$list = DB::query("SELECT * FROM tmPreorderNote7 as a LEFT JOIN tmMember as b ON a.mbEmail = b.mbEmail");
$obj_excel = new PHPExcel();
$row_array = array('A', 'B', 'C');

$row = 1;
foreach ($list as $key => $val){
	$obj_excel->setActiveSheetIndex(0)
					->setCellValueExplicit('A'.$row, $val['mbEmail'], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('B'.$row, $val['mbName'], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('C'.$row, addTelHyphen($val['mbPhone']), PHPExcel_Cell_DataType::TYPE_STRING);
	$row++;
}



$obj_writer = PHPExcel_IOFactory::createWriter($obj_excel, 'Excel5');
$obj_writer->save('php://output');