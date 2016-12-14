<?php 
// This file is read a excel and write date in mysql.
// header('Content-Type: application/vnd.ms-excel');
// header('Content-Disposition: attachment;filename=download.xls');
// header('Cache-Control: max-age=0');
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
include_once(PATH_LIB."/lib.snoopy.inc.php");
include_once(PATH_LIB."/lib.parsing.inc.php");
include_once(PATH_LIB.'/lib.PHPExcel.inc.php');
include_once(PATH_LIB.'/PHPExcel/IOFactory.php');
ECHO META_CHARSET;

$discountTypeRow = 3;
$planRow = 4;
$applyTypeRow = 6;

$baseCoulumnPlan = 'C';	// c 로 대입 f 로 대입
$baseCoulumnDis = 'C';


if(isExist($_FILES['selectfile']['tmp_name'])){
	$inputFileName = $_FILES['selectfile']['tmp_name'];
	$objReader =  $objReader = PHPExcel_IOFactory::createReaderForFile($inputFileName);
	$objPHPExcel = $objReader->load($inputFileName);
	$objPHPExcel->setActiveSheetIndex(2);
	// $objMarginExcel->setActiveSheetIndex(1);   // margin vlaue correct
	// 모델명 반복하면서 네이밍 수정
	$Cellend = 57;
	for ($i=7; $i <= $Cellend; $i++) { 
		// var_dump($objPHPExcel->getActiveSheet()->getCell('A'.$i)->getValue()); checked
		$model = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getValue();

		$_POST['carrier'] = 'sk';
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

		if (isContain('아이폰', $model) === true) {
			$model = str_replace('아이폰','iphone',$model);
			$model = trim(preg_replace('/(플러스|\+)/','plus',$model));
			$model = str_replace(' ', '_', $model);
		} else {
			$model = preg_replace('/'.$carrierPrefix.' /i', '_', $model); // SM-N920S 64G -> SM-N920_64G
			$model = preg_replace('/'.$carrierPrefix.'$/i', '', $model); // SM-N920S -> SM-N920
		}


		// if (isContain('아이폰', $model) === true) {
		// 	$model = str_replace('아이폰','iphone',$model);
		// 	$model = trim(preg_replace('/(플러스|\+)/','plus',$model));
		// 	$model = str_replace(' ', '_', $model);
		// }else{
		// 	$model = preg_replace('/'.$carrierPrefix.' /i', '_', $model); // SM-N920S 64G -> SM-N920_64G
		// 	$model = preg_replace('/'.$carrierPrefix.'$/i', '', $model); // SM-N920S -> SM-N920
		// }

		$model = strtoupper($dvKey);
		$dvKey = DB::queryFirstRow("SELECT dvKey FROM tmDevice WHERE dvModelCode=%s", $model);
		$dvKey = (int) $dvKey['dvKey'];   // array = dvKey['dvKey']  to int devKey  result : 649(int)

			for ($num ='C'; $num != 'AB'; $num++) { 

				if($num === 'I' || $num === 'J' || $num === 'K' || $num === 'O' || $num === 'V' || $num === 'W' || $num === 'X') {
			 		continue;
				}



				$discountType = $objPHPExcel->getActiveSheet()->getCell($num.$discountTypeRow)->getValue();					
				if (isExist($discountType) === true) {
					$baseCoulumnDis = $num;
				} else{
					$discountType = $objPHPExcel->getActiveSheet()->getCell($baseCoulumnDis.$discountTypeRow)->getValue();					
				}

				if (isContain('공시지원금', $discountType) === true) {
					$discountType = 'support';
				} else if (isContain('선택약정', $discountType) === true) {
					$discountType = 'selectPlan';
				}


				$planCategory = $objPHPExcel->getActiveSheet()->getCell($num.$planRow)->getValue();
				if (isExist($planCategory) === true) {
					$baseCoulumnPlan = $num;
				} else {
					$planCategory = $objPHPExcel->getActiveSheet()->getCell($baseCoulumnPlan.$planRow)->getValue();					
				}

				if (isContain('퍼펙트', $planCategory) === true) {
					$plan = array(0,1,2,3);
					$planCategory = '0,1,2,3';
				} else if (isContain('6\.5G', $planCategory) === true) {
					$plan = array(4);
					$planCategory = '4';
				} else if (isContain('세이브', $planCategory) === true) {
					$plan = array(5,6,7,8);
					$planCategory = '5,6,7,8';
				}	


				$applyType = $objPHPExcel->getActiveSheet()->getCell($num.$applyTypeRow)->getValue();
				if (isContain('010', $applyType) === true) {
					$applyType = '1';
				} else if (isContain('MNP', $applyType) === true) {
					$applyType = '2';
				} else if (isContain('보상', $applyType) === true) {
					$applyType = '6';
				}		

				$pointValue = round($objPHPExcel->getActiveSheet()->getCell($num.$i)->getCalculatedValue() * 10000);

				
				// foreach ( $plan as $value ) {
					
					$arr[$dvKey][$discountType][$planCategory][$applyType] = array(
						'dvKey' => $dvKey,
						'rpDiscountType' => $discountType,
						'rpPlan' => $planCategory,
						'rpApplyType' => $applyType,
						'rpPoint' => $pointValue
					);
			}	// for loof done

		}

	//$plan = DB::queryFirstRow("SELECT apPlan FROM tmApplyTmp WHERE dvKey=%d", $dvKey);
	 // echo $dvKey;
	 // var_dump($dvKey);
	}

// $objNEWFile = new PHPExcel();
// $objNEWFile->setActiveSheetIndex(0);
// $objNEWFile->getActiveSheet()->setCellValue('A1', 'AFK');

// $obj_writer = PHPExcel_IOFactory::createWriter($objNEWFile, 'Excel5');
// $obj_writer->save('php://output');
echo "<pre>";
print_r($arr);
echo "</pre>";
?>

<?php $test = array(1,2,6); ?>
<?php if($arr): ?>
 	<table border="1" style="width:100%">
 		<tr>
 			<th></th>
		 	<th colspan="9">support</th>
		 	<th colspan="9">selectPlan</th>
	 	</tr>

 		<tr>
 			<th></th>
 			<th colspan="3">0,1,2,3</th>
 			<th colspan="3">4</th>
 			<th colspan="3">5678</th>
 			<th colspan="3">0,1,2,3</th>
 			<th colspan="3">4</th>
 			<th colspan="3">5678</th>
 		</tr>

 		<tr>
 			<th></th>
 			<?php foreach($test as $value) echo "<th>".$value."</th>" ?>
 			<?php foreach($test as $value) echo "<th>".$value."</th>" ?>
 			<?php foreach($test as $value) echo "<th>".$value."</th>" ?>
 			<?php foreach($test as $value) echo "<th>".$value."</th>" ?>
 			<?php foreach($test as $value) echo "<th>".$value."</th>" ?>
 			<?php foreach($test as $value) echo "<th>".$value."</th>" ?>

 		</tr>


		
 		<?php foreach($arr as $dvKey => $arrDiscountType) :?>
 			<tr>
 				<td><?php echo $dvKey?></td>
 				<?php foreach($arrDiscountType as $arrPlan) :?>
 					<?php foreach($arrPlan as $arrApplyType) :?>
 						<?php foreach($arrApplyType as $point) :?>
 						<td><?php echo $point['rpPoint']?></td>
 						<?php endforeach ?>
 					<?php endforeach ?>
 				<?php endforeach ?>
 			</tr>
 		<?php endforeach ?>
 	</table>
<?php endif; ?>


<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<form name="formName" method="post" enctype="multipart/form-data"">
<input type="file" name="selectfile">
<select name="carrier">
<option value="sk">sk</option>
<option value="kt">kt</option>
<option value="lg">lg</option>
</select>
<input type="submit" value="Submit">
</form>
<style>
table, tr, th {
border-collapse: collapse;
}
</style>
</body>
</html>
