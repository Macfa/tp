<?php 
// This file is read a excel and write date in mysql.
// header('Content-Type: application/vnd.ms-excel');
// header('Content-Disposition: attachment;filename=download.xls');
// header('Cache-Control: max-age=0');
$discountTypeRow = 3;
$planRow = 4;
$applyTypeRow = 6;
$arrPlanCategorySk = array(
    'sk' => array(
        'phone' => array(0,1,2,3,4,5,6,7,8),
        'kids'=>array(9),
        'watch'=>array(11,12,29,30),
        'pocketfi'=>array(13,14)
    ),
    'kt'=> array(
        'phone'=>array(15,16,17,18,19,20,23,24),
        'pocketfi'=>array(21,22),
        'watch'=>array(25,26),
        'kids'=>array(27,28)
    ),  
    'lguplus'=>array(
        'phone'=>array()
    )
);

$baseCoulumnPlan = 'C';   // c 로 대입 f 로 대입
$baseCoulumnDis = 'C';
// $_FILES['selectfile']['tmp_name'] = './sk_margin.xlsx';

// echo $_FILES['selectfile']['tmp_name'];

if(isExist($_FILES['selectfile']['tmp_name'])) {
    $inputFileName = $_FILES['selectfile']['tmp_name'];
    $objReader =  $objReader = PHPExcel_IOFactory::createReaderForFile($inputFileName);
    $objPHPExcel = $objReader->load($inputFileName);
    $objPHPExcel->setActiveSheetIndex(0);
  // $objMarginExcel->setActiveSheetIndex(1);   // margin vlaue correct
  // 모델명 반복하면서 네이밍 수정
    $Cellend = 58;

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

    for ($i=7; $i != $Cellend; $i++) { 

        $model = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getValue();


        if (isContain('아이폰', $model) === true) {
            $model = str_replace('아이폰','iphone',$model);
            $model = trim(preg_replace('/(플러스|\+)/','plus',$model));
            $model = str_replace(' ', '_', $model);
        } else {
            $model = preg_replace('/'.$carrierPrefix.' /i', '_', $model); // SM-N920S 64G -> SM-N920_64G
            $model = preg_replace('/'.$carrierPrefix.'$/i', '', $model); // SM-N920S -> SM-N920
        }

        $model = strtoupper($model);
        $dvKey = DB::queryFirstRow("SELECT dvKey FROM tmDevice WHERE dvModelCode=%s", $model);
        $dvKey = (int) $dvKey['dvKey'];   // array = dvKey['dvKey']  to int devKey  result : 649(int)

        if ( $dvKey === 0 ) {
        	$dvKey = DB::queryFirstRow("SELECT dvKey FROM tmDevice WHERE dvModelCode LIKE '%$model%'");
       		$dvKey = (int) $dvKey['dvKey'];   // array = dvKey['dvKey']  to int devKey  result : 649(int)

       		if ( $dvKey === 0 ) {
           	var_dump($model);
    	     	echo $dvKey;
    	     	echo "<br/>";
    	     	echo "------------------------";echo "<br/>";
    	     	continue;
	       }
        }

   //  echo $model;
   //  echo "<br/>";
   //  echo $dvKey;
  	// echo "<br/>";


        for ($num ='C'; $num != 'AB'; $num++) { 

            if($num === 'I' || $num === 'J' || $num === 'K' || $num === 'O' || $num === 'V' || $num === 'W' || $num === 'X') {
                continue;
            }



            $discountType = $objPHPExcel->getActiveSheet()->getCell($num.$discountTypeRow)->getValue();               
            if (isExist($discountType) === true) {
                $baseCoulumnDis = $num;
            } else {
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

            $pointValue = round($objPHPExcel->getActiveSheet()->getCell($num.$i)->getCalculatedValue() / 2 * 1.2 * 10000);

            
            foreach ( $plan as $planType ) {
               
                $arr[] = array(
                    'dvKey' => $dvKey,
                    'rpPlan' => $planType,
                    'rpCarrier' => $_POST['carrier'],
                    'rpPoint' => $pointValue,
                    'rpApplyType' => $applyType,
                    'rpDiscountType' => $discountType,
                    'rpDate' => $cfg['time_ymdhis']
                );


         	}

            $ex_arr[$dvKey][$discountType][$planCategory][$applyType] = array(        // #2 | $subarr 하단에 있는 foteach 문과 호환
                    'dvKey' => $dvKey,
                    'rpDiscountType' => $discountType,
                    'rpPlan' => $planCategory,
                    'rpApplyType' => $applyType,
                    'rpPoint' => $pointValue
                );



        }   // column for stament

    }   // i for stament




    // Kid, Gear, T-Pet Model
    for ( $i = 59; $i < 61;$i++ ) {

    // echo "for start";
        $chkStart = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getValue();
        // echo $chkStart;

        if ( isContain('모델명', $chkStart) === true) {

            $DiscountRow = $i; // Discount, Plan, Apply Row 설정
            $PlanRow = $DiscountRow+1;
            $ApplyRow = $DiscountRow+2;

            $DiscountColumn = 'C'; //Discount, Plan Column 설정
            $PlanColumn = 'C';


            $start = $DiscountRow+3;    // 모델명 행으로 이동
            $end = 73;

            // var_dump($subModel);

            for (;$start <= $end; $start++ ) {

                $Model = $objPHPExcel->getActiveSheet()->getCell('A'.$start)->getValue(); // 모델명 가져옴

                if(isset($Model) === false) {
                    continue;
                }

                if(isContain('\(', $Model) === true) {
                    $Model = preg_replace('/[(].+\)/','', $Model);
                }

                $Model = preg_replace('/'.$carrierPrefix.'$/', '', $Model); // 맨 뒤 S ( 통신사 키값 ) 제거 
                $dvKey = DB::queryFirstRow("SELECT dvKey FROM tmDevice WHERE dvModelCode=%s", $Model);
                $dvKey = (int) $dvKey['dvKey'];
                $dvcate = DB::queryFirstRow("SELECT dvCate FROM tmDevice WHERE dvModelCode=%s", $Model);
                $dvcate = $dvcate['dvCate'];

                // echo $dvcate;    // which whatch pocketfi phone

                // echo "subdvKey Check :".$subdvKey;
                // echo "<br/>";

                if ( $dvKey === 0 ) {
                    $dvKey = DB::queryFirstRow("SELECT dvKey FROM tmDevice WHERE dvModelCode LIKE '%$Model%'");
                    $dvKey = (int) $dvKey['dvKey'];   // array = dvKey['dvKey']  to int devKey  result : 649(int)
                    $dvcate = DB::queryFirstRow("SELECT dvCate FROM tmDevice WHERE dvModelCode LIKE '%$Model%'");
                    if ( $dvKey === 0 ) {
                        continue;
                    }
                }

                // echo $subdvKey;

                for ($j='C'; $j != 'F'; $j++) {
                    if(isExist($objPHPExcel->getActiveSheet()->getCell($j.$DiscountRow)->getValue()) === true) {
                        $DiscountColumn = $j;
                    }
                    $DiscountValue = $objPHPExcel->getActiveSheet()->getCell($DiscountColumn.$DiscountRow)->getValue();
                    if(isContain('키즈폰', $DiscountValue) === true) {
                        $DiscountValue = "support";
                    }            


                    if(isExist($objPHPExcel->getActiveSheet()->getCell($j.$PlanRow)->getValue()) === true) {
                        $PlanColumn = $j;
                    }
                    $PlanValue = $objPHPExcel->getActiveSheet()->getCell($PlanColumn.$PlanRow)->getValue();
                    if(isContain('공유요금제', $PlanValue) === true) {
                        $PlanValue = $arrPlanCategorySk['sk'];   //array = "phone" => array(), "poketfi" => array(), "kids" => array(), "watch" => array()
                        // var_dump($subPlanValue);
                        // echo "<br/>";
                        unset($PlanValue['phone']);
                    }


                    $ApplyValue = $objPHPExcel->getActiveSheet()->getCell($j.$ApplyRow)->getValue();
                    if(isContain('010', $ApplyValue) === true) {
                        $ApplyValue = 1;
                    }
                    if(isContain('MNP', $ApplyValue) === true) {
                        $ApplyValue = 2;
                    }            
                    if(isContain('기변', $ApplyValue) === true) {
                        $ApplyValue = 6;
                    }

                    $Point = round($objPHPExcel->getActiveSheet()->getCell($j.$start)->getCalculatedValue() / 2 * 1.2 * 10000);
                    // key is String , plan is array ( Value)

                    foreach($PlanValue as $key => $value) {  //key = string(phone, watch etc...), value = array()
                        foreach($value as $keys => $plans) {        // 엑셀 형식의 데이터로 출력하여 데이터를 비교하기 위해 이는 주석처리
                            $arr[] = array(
                                'dvKey' => $dvKey,
                                'rpPlan' => $plans,
                                'rpCarrier' => $_POST['carrier'],
                                'rpPoint' => $Point,
                                'rpApplyType' => $ApplyValue,
                                'rpDiscountType' => $DiscountValue,
                                'rpDate' => $cfg['time_ymdhis']
                            );
                        }
                    }

                    foreach ($PlanValue as $key => $list) {
                        foreach ($list as $keys => $value) {
                            $ex_arr[$dvKey][$DiscountValue][$value][$ApplyValue] = array(  // #1, 엑셀의 데이터와 비교하기 위해 출력 형식을 바꿈.
                                'dvKey' => $dvKey,
                                'rpDiscountType' => $DiscountValue,
                                'rpPlan' => $value,
                                'rpApplyType' => $ApplyValue,
                                'rpPoint' => $Point
                            );
                        }
                    }

                }
            }   // for stament
        }   // if stament
    }   // for stament
}   // first if stament

    
//$result = array_merge($arr, $subarr);
//$ex_result = array_merge($ex_arr, $ex_subarr);

echo "<pre>";
var_dump($ex_arr);
echo "</pre>";


      foreach ($ex_arr as $dvKey => $discount) {         // #? 
            echo "<br/>";
            echo $dvKey.'&#9;';

            foreach ($discount as $apply) {
                foreach ($apply as $key) {
                    foreach ($key as $list => $value) {
                    echo $value['rpPoint'].'&#9;';
                    }
                }

            }
        }

// echo "<br/>----------------------------------------------------<br/>";

      // foreach ($ex_result as $key) {         // #2 , $arr #2 과 호환
      //       // echo $dvKey.'&#9;';
      //       foreach ($key as $what) {
      //           foreach ($what as $key => $apply) {
      //               foreach ($apply as $keys => $value) {
      //                   // foreach ($value as $last) {
      //                   echo "<br/>";
      //                   echo $value['dvKey'].'&#9;';
      //                   echo $value['Point'].'&#9;';
      //                   // }
      //               }
      //           }
      //       }


            // foreach ($discountType as $planCategory) {
            //     foreach ($planCategory as $applyType ) {
            //         foreach ($applyType as $pointValue) {
            //                     // echo "<pre>pointValue";
            //                     // var_dump($pointValue);
            //                     // echo "</pre>";

            //             echo $pointValue['rpPoint'].'&#9;';
            //         }                       
            //     }
            // }
        // }




      // foreach ($ex_arr as $dvKey => $discountType) {         // #2 , $arr #2 과 호환
      //       echo "<br/>";
      //       echo $dvKey.'&#9;';
      //       foreach ($discountType as $planCategory) {
      //           foreach ($planCategory as $applyType ) {
      //               foreach ($applyType as $pointValue) {
      //                           // echo "<pre>pointValue";
      //                           // var_dump($pointValue);
      //                           // echo "</pre>";

      //                   echo $pointValue['rpPoint'].'&#9;';
      //               }                       
      //           }
      //       }
      //   }



      // foreach ($ex_subarr as $subdvKey => $subDiscountValue) {         // #1 , $subarr #1 과 호환
      //       echo "<br/>";
      //       echo $subdvKey.'&#9;';
      //       foreach ($subDiscountValue as $plans ) {
      //           foreach ($plans as $subApplyValue ) {
      //               foreach ($subApplyValue as $subPoint) {
      //                           // echo "<pre>pointValue";
      //                           // var_dump($pointValue);
      //                           // echo "</pre>";
      //                   echo $subPoint['rpPoint'].'&#9;';
      //               }                       
      //           }
      //       }
      //   }






?>



<!-- <br/>
<br/>

<?php $subApplyValue = array(1,2,6); ?>
<?php if($subarr): ?>
    <table border="1" style="width:100%">
       <tr>
          <th></th>
          <th colspan="1"><?php echo $subDiscountValue ?></th>
       </tr>

       <tr>
          <th></th>
          <th colspan="3"><?php echo $subPlanValue ?></th>
       </tr>

       <tr> 
          <th></th>
          <?php foreach($subApplyValue as $value) echo "<th>".$value."</th>" ?>
          <?php foreach($subApplyValue as $value) echo "<th>".$value."</th>" ?>
          <?php foreach($subApplyValue as $value) echo "<th>".$value."</th>" ?>
       </tr>


      
       <?php foreach($subarr as $subdvKey => $subDiscountValue) :?>
          <tr>
             <td><?php echo $subdvKey?></td>
             <?php foreach($subDiscountValue as $subPlanValue) :?>
                <?php foreach($subPlanValue as $subApplyValue) :?>
                   <?php foreach($subApplyValue as $point) :?>
                   <td><?php echo $point['subgetValue']?></td>
                   <?php endforeach ?>
                <?php endforeach ?>
             <?php endforeach ?>
          </tr>
       <?php endforeach ?>
    </table>
<?php endif; ?>

<br/>
<br/>


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
</html> -->