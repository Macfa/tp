<?php
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename=업로드목록.xls');
header('Cache-Control: max-age=0');

include_once('./_common.inc.php');
include_once(PATH_LIB.'/lib.parsing.inc.php');
include_once(PATH_LIB.'/lib.snoopy.inc.php');
include_once(PATH_LIB.'/lib.PHPExcel.inc.php');


$gift = array(
	0 => '미수령',
	1 => '수령'
);

$way = array(
	'delivery' => '택배로 진행',
	'offline' => '방문하여 진행'
);

$type = array(
	'exchange' => '교환',
	'refund' => '환불'
);

$device = array(
	'galaxys7' => '갤럭시 S7',
	'galaxys7edge' => '갤럭시 S7 엣지',
	'galaxynote5' => '갤럭시 노트5',
	'v20' => 'LG V20',
	'iphone7' => '아이폰7',
	'iphone7Plus' => '아이폰7 플러스'
	
);


$color = array(
	'jetBlack' => '제트블랙',
	'black' => '블랙',
	'silver' => '실버',
	'gold' => '골드',
	'roseGold' => '로즈골드',
	'pink' => '핑크',
	'white' => '화이트',
	'pinkgold' => '핑크골드'
);


$process = array(
	0 => '미처리',
	1 => '처리'
);



$search = $_GET['search'];
$sql = "SELECT * FROM tmExchangeRefundNote7";

if(isExist($search) || isExist($_GET['serchProcess'])){
	$sql  .= " WHERE";
	$downloadUrl = $_SERVER['REQUEST_URI'];
	$downloadUrl = explode("?",$downloadUrl);
	$downloadFullUrl = "exchangeRefundNote7ListDownload.php?".$downloadUrl[1];
}

if(isExist($search)){
	$sql .= " (mbName LIKE %ss_search OR enPhone LIKE %ss_search)";
	$array['search'] = $search;

	
	}

if(isExist($_GET['serchProcess'])){		
	if(isExist($search))
	$sql  .= " and";
	$sql  .= " (enProcess=%i_serchProcess)";	
	$array['serchProcess'] = $_GET['serchProcess'];
}

$existList = DB::query($sql, $array);

$obj_excel = new PHPExcel();
$row_array = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N');

$obj_excel->setActiveSheetIndex(0)				
				->setCellValueExplicit('A1', '신청자명', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('B1', '전화번호', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('C1', '교환/환불', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('D1', '진행방법', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('E1', '사은품수령', PHPExcel_Cell_DataType::TYPE_STRING)					
				->setCellValueExplicit('F1', '신청하신통신사', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('G1', '교환하실기기', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('H1', '용량', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('I1', '색상', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('J1', '비상연락처', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('K1', '우편번호', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('L1', '받으실주소', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('M1', '진행상황', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit('N1', '타임스탬프', PHPExcel_Cell_DataType::TYPE_STRING);
$row = 2;
foreach ($existList as $key => $val){

	

	$obj_excel->setActiveSheetIndex(0)					
					->setCellValueExplicit('A'.$row, $val['mbName'], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('B'.$row, $val['enPhone'], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('C'.$row, $type[$val['enApplyType']], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('D'.$row, $way[$val['enWay']], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('E'.$row, $gift[$val['enReceivedGift']], PHPExcel_Cell_DataType::TYPE_STRING)					
					->setCellValueExplicit('F'.$row, $val['enApplyCarrier'], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('G'.$row, $val['enTargetDevice'], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('H'.$row, $val['enDeviceCapacity'], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('I'.$row, $color[$val['enColorType']], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('J'.$row, $val['enSubPhone'], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('K'.$row, $val['enPostCode'], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('L'.$row, $val['enAddress']." ".$val['enSubAddress'], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('M'.$row, $process[$val['enProcess']], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('N'.$row, $val['enDatetime'], PHPExcel_Cell_DataType::TYPE_STRING);
	$row++;
}



$obj_writer = PHPExcel_IOFactory::createWriter($obj_excel, 'Excel5');
$obj_writer->save('php://output');