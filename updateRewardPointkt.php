<?php 
// header('Content-Type: application/vnd.ms-excel');
// header('Content-Disposition: attachment;filename=download.xls');
// header('Cache-Control: max-age=0');
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
include_once(PATH_LIB."/lib.snoopy.inc.php");
include_once(PATH_LIB."/lib.parsing.inc.php");
include_once(PATH_LIB.'/lib.PHPExcel.inc.php');
include_once(PATH_LIB.'/PHPExcel/IOFactory.php');
ini_set('memory_limit', '-1');

//var_dump($_POST);
$discountTypeRow = 6;
$planRow = 7;
$applyTypeRow = 9;

$baseColumnPlan = 'H';
$baseColumnDis = 'H';
$baseColumnApply = 'H';
// $_FILES['selectfile']['tmp_name'] = './kt_margin.xlsx';
$arrPlanCategoryKt = array(
    'kt'=> array(
	    'phone'=>array(15,16,17,18,19,20,23,24),
	    'pocketfi'=>array(21,22),
	    'watch'=>array(25,26),
	    'kids'=>array(27,28)
	    )
);

// echo $_FILES['selectfile']['tmp_name'];


//if(isExist($_FILES['selectfile']['tmp_name'])) {
	$inputFileName = $_FILES['selectfile']['tmp_name'];
	$objReader =  $objReader = PHPExcel_IOFactory::createReaderForFile($inputFileName);
	$objPHPExcel = $objReader->load($inputFileName);
	$objPHPExcel->setActiveSheetIndex(0);
	// $objMarginExcel->setActiveSheetIndex(1);   // margin vlaue correct
	// 모델명 반복하면서 네이밍 수정

	$Cellend = 62;
	for ($i=10; $i <= $Cellend; $i++) { 
		// var_dump($objPHPExcel->getActiveSheet()->getCell('A'.$i)->getValue()); checked
		$model = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getValue();
		$getByte = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getValue();

		if(isContain('H791', $model)) {
			continue;
		}


		$_POST['carrier'] = 'kt';
		switch($_POST['carrier']) {
			case 'sk':
				$carrierPrefix = 'S';
				break;
			case 'kt':
				$carrierPrefix = 'K';
				break;
			case 'lg':
				$carrierPrefix = 'L';
				break;
		}

		$rexCapacity = '/(16|32|64|128|256)/i';
		$tmpByte = explode('-', $getByte); // tmp[0] => S7 [1] => 32
		$model = trim($model);

		// var_dump($tmpByte);
		if (isContain('AIP', $model) === true) {
			$model = str_replace('AIP','iphone',$model);
			$model = preg_replace('/(P)/','plus',$model);
			$tmpByte = (isExist($tmpByte[1])===true)?'_'.$tmpByte[1].'G':$tmpByte[0]='';
			$model = $model.$tmpByte;
		// } elseif(isContain('IM', $model) ===true) {
		// 	$model = preg_replace('/'.$carrierPrefix.'$/i', '', $model); // SM-N920S 64G -> SM-N920_64G
		} else {
			$model = preg_replace('/'.$carrierPrefix.'$/i', '', $model); // SM-N920S 64G -> SM-N920_64G
			$tmpByte = (isExist($tmpByte[1])===true)?'_'.$tmpByte[1].'G':$tmpByte[0]='';

			if(isContain('IM', $model) === false) {

				if (isContain('-', $model) === true) {
					$tmpModel = $model;
					$model = $model.$tmpByte;
					
				} else {

					if(isContain('-', $tmpModel) === true) {
						$model = $tmpModel.$tmpByte;
					}				
				}
			}

				if(isContain('SM-J320', $model) === true) {
					$model ='SM-J320N0';
				}



			// $model = preg_replace('/'.$carrierPrefix.'$/i', '', $model); // SM-N920S 64G -> SM-N920_64G
			// if(isContain('-', $model) === true) {
			// 	$tmpCommonModel['model'] = $model;  // array(0=>SM, 1=>G930)
			// } else {

			// 	if(mb_strlen($model) > mb_strlen($tmpCommonModel['model']) && preg_match($rexCapacity, $getByte)) {
			// 		preg_match($rexCapacity, $getByte, $tmpByte);
			// 		$model = $tmpCommonModel['model'].'_'.$tmpByte[0].'G';

			// 	}
			// }

			//$CAPACITY = array( 0=>'/(16|32|64|128|256)g/i', 1=> array (0=>$1 1=> $2 2=> $3) 

			/*
			if(isContain('SM', $model) === true) {
				if(isContain('(32|64|128)G') === false) {
					$model = preg_replace('/(SM-.*)K$/i', '$1_32G', $model);
				}
			} else if(isContain('_', $model) === false) {
				$model = preg_replace('/([a-zA-Z]\d+[a-zA-Z]+)/i', '', $model);
				$getPreValue = preg_replace('/(_|32|64|128)+G/i', '', $model);
				$model = $getPreValue.$model;
			}
			*/
		}

		$model = strtoupper($model);
		//var_dump($model);echo "<br/>";
		$result = DB::queryFirstRow("SELECT dvKey FROM tmDevice WHERE dvModelCode=%s", $model);
		$dvKey = (int)$result['dvKey'];   // array = dvKey['dvKey']  to in
		

		if($dvKey === 0) {
			var_dump($model);
			echo $dvKey;
			echo "<br/>";
			continue;
		}



		for ($j = 'H'; $j != 'AA'; $j++) { 
			

			if($j === 'X' || $j === 'Y' || $j === 'Z' || $j === 'K' || $j === 'O' || $j === 'S' || $j === 'W') {
		 		continue;
			}

			if(isExist($objPHPExcel->getActiveSheet()->getCell($j.$discountTypeRow)->getValue()) === true) {
				$basecolumnDis = $j;
			}

			//$discountType = $objPHPExcel->getActiveSheet()->getCell($baseColumnDis.$discountTypeRow)->getValue();

			//if(isContain('공시지원금', $discountType) === true ) {
				$discountType = array('support', 'selectPlan');
			//}



			
			if(isExist($objPHPExcel->getActiveSheet()->getCell($j.$planRow)->getValue()) === true) {
				$baseColumnPlan = $j;
			}

			$planCategory = $objPHPExcel->getActiveSheet()->getCell($baseColumnPlan.$planRow)->getValue();


			if(isContain('65', $planCategory) === true ) {
				// $planCategory = '0,1,2';
				$planCategory1 = array(15,16,17);
			} else if (isContain('54', $planCategory) === true ) {
				// $planCategory = '3,4';
				$planCategory1 = array(18);
			} else if (isContain('38', $planCategory) === true ) {
				// $planCategory = '5,6';
				$planCategory1 = array(19,20,20,23);
			} else if (isContain('32\.8이상', $planCategory) === true ) {
				// $planCategory = '7,8';
				$planCategory1 = array(24);
			} else if (isContain('32\.8미만', $planCategory) === true ) {
				continue;
			}


			if(isExist($objPHPExcel->getActiveSheet()->getCell($j.$applyTypeRow)->getValue()) === true) {
				$baseColumnApply = $j;
			}

			$applyType = $objPHPExcel->getActiveSheet()->getCell($baseColumnApply.$applyTypeRow)->getValue();

			if(isContain('010', $applyType) === true ) {
				$applyType = '1';
			} else if (isContain('MNP', $applyType) === true ) {
				$applyType = '2';
			} else if (isContain('기변', $applyType) === true ) {
				$applyType = '6';
			}



			$pointValue = round($objPHPExcel->getActiveSheet()->getCell($j.$i)->getValue() / 2 * 1.2 * 10000);

			// KT 마진 구하여 DB 넣는 소스가 되는 변수  현재 데이터 검증을 위해 주석처리 하여 
			// 엑셀비교를 위하여 엑셀에 맞는 형식의 변수로 재정의

			foreach($planCategory1 as $plan) {
				foreach($discountType as $discount){
				// foreach($plan as $value) {

					$arr[] = array(
						'dvKey' => $dvKey,
						'rpDiscountType' => $discount,
						'rpPlan' => $plan,
						'rpCarrier' => $_POST['carrier'],
						'rpApplyType' => $applyType,
						'rpPoint' => $pointValue,
						'rpDate' => $cfg['time_ymdhis']
					);			
				}
			}


			foreach($discountType as $discount) {
				$ex_arr[$dvKey][$discount][$planCategory][$applyType] = array(		// #1 이 부분은 foreach #1 과 호환. 엑셀형식으로 진행이 되어 데이터를 비교하기 위함
					'dvKey' => $dvKey,
					'rpDiscountType' => $discount,
					'rpPlan' => $planCategory,
					'rpApplyType' => $applyType,
					'rpPoint' => $pointValue
				);	
			}
		

		}	// H 시작하는 for stament

    //foreach($arr as $arrVal) {  //key = string(phone, watch etc...), value = array()

    //}   //for $subarr stament
	}	// first for stament
	

// echo "<pre>";
// var_dump($arr);
// echo "</pre>";

// echo "<pre>";
// print_r($arr);
// echo "</pre>";



		// foreach ($ex_arr as $dvKey => $discountType) {			// #1 , $arr #1 과 호환
		// 	echo "<br/>";
		// 	echo $dvKey.'&#9;';
		// 	foreach ($discountType as $planCategory ) {
		// 		foreach ($planCategory as $applyType ) {
		// 			foreach ($applyType as $pointValue) {
		// 						// echo "<pre>pointValue";
		// 						// var_dump($pointValue);
		// 						// echo "</pre>";
		// 				echo $pointValue['rpPoint'].'&#9;';
		// 			}						
		// 		}
		// 	}
		// }


echo "<pre>";
var_dump($arr);
echo "</pre>";



// } if statment

?>