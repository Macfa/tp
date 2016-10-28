<?php
include_once('./_common.inc.php');
require_once(PATH_LIB."/lib.zip.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
include_once(PATH_LIB.'/lib.parsing.inc.php');
include_once(PATH_LIB.'/lib.snoopy.inc.php');
include_once(PATH_LIB.'/lib.PHPExcel.inc.php');
include_once(PATH_LIB.'/PHPExcel/IOFactory.php');

$inputFileName = $_FILES['fileToUpload']['tmp_name'];
$objReader =  $objReader = PHPExcel_IOFactory::createReaderForFile($inputFileName);
$objPHPExcel = $objReader->load($inputFileName);
$objPHPExcel->setActiveSheetIndex(0);

for($i=2; $i=$i; $i++){
	$tmp = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getValue();
	if(isExist($tmp) === false){		
		break;
	}
	list($serchId, $serchphone, $serchName) = DB::queryFirstList("SELECT mbEmail, paPhone, paName FROM tmPreorderApplyList WHERE mbEmail=%s", $tmp);
	if(isExist($serchId)){
		$arrayid[] = (string)$tmp;
		$tmpTrackingNum = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getValue();
		if(isExist($tmpTrackingNum) === false){
			break;
		}
		$arrayTrackingNum[] = (string)$tmpTrackingNum;		
		$arraySerchphone[] = $serchphone;
		$arraySerchName[] = $serchName;
	}
}


$SMS = new SMS();
foreach($arrayid as $key => $val){

	DB::update('tmPreorderApplyList', array(
		'paTrackingNum' => $arrayTrackingNum[$key],
		'paProcess' => 4
	), "mbEmail=%s", $val);

	$sendCont = "[티플 아이폰7] 신청하신 기기가 발송되었습니다. 우체국 송장번호 ".$arrayTrackingNum[$key]." 입니다.";
	$SMS->sendMode(0)->sendMemberPhone($arraySerchphone[$key])->sendMemberName($arraySerchName[$key])->sendCont($sendCont)->send();


}

alert('완료되었습니다.', "/admin/insertPreorderTrackingNum.php");

?>