<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

//실가입 채널로부터 무슨 통신사인지 불러옴

$arrCode = array(
	1 => $_POST['cdCode_01'],
	2 => $_POST['cdCode_02'],
	6 => $_POST['cdCode_06']
);

list($carrier, $chCode) = DB::queryFirstList("SELECT chCarrier, chCode FROM tmChannel WHERE chKey = %i", $_POST['chKey']);

$deviceList = DB::query("SELECT * FROM tmCode WHERE dvKey=%i AND  cdType=%i AND cdCarrier=%s", $_POST['dvKey'],$_POST['cdType'],$carrier);


if($carrier == 'sk'){
	$rexURL = '/https:\/\/tgate\.sktelecom\.com\/applform\/main\.do\?prod_seq=(\d*)&scrb_cl=0\d&mall_code='. $chCode .'/';
}else if($carrier == 'kt'){
	$rexURL = '/http:\/\/online\.olleh\.com\/index\.jsp\?prdcID=(.*)$/';			
}

$deviceInfo = new deviceInfo();

// =====================================================================

try
{
	foreach ($arrCode as $type => $val) {
		$codearr[$type] = getRexMatch($val, $rexURL);
		if($codearr[$type] === false) {
			$applyTypeName = $deviceInfo->getApplyTypeName('0'.$type);
			throw new Exception($applyTypeName.' URL이 현재 채널과 맞지 않거나 올바르지 않은 URL입니다.', 3);
		}
	}
}
catch(Exception $e){	

	alert($e->getMessage());	

}

// =====================================================================
$deviceInfo->setCarrier($carrier)->setMode($_POST['dvCate']);

$arrPlan = $deviceInfo->getArrPlan($_POST['dvKey']);

foreach ($arrPlan as $spPlan){
	foreach ($codearr as $dvCate => $cdCode) {		

		$deviceList = DB::queryFirstField("SELECT COUNT(*) FROM tmCode WHERE dvKey=%i AND  cdType=%i AND spPlan=%i AND cdCarrier=%s AND chKey=%i", $_POST['dvKey'], $dvCate, $spPlan, $carrier,$_POST['chKey']);

		if($deviceList === '1' && is_null($cdCode) === false){ // 이미 저장되어있는 기기 url이면 update			

			DB::update('tmCode', array(
				'cdCode' => $cdCode
			),"dvKey=%i AND cdType=%i AND spPlan=%i AND cdCarrier=%s AND chKey=%i", $_POST['dvKey'], $dvCate, $spPlan, $carrier,$_POST['chKey']); 		

		}else if(is_null($cdCode) === false){ // 새로 저장하는  기기 url이면 insert
			
			DB::insert('tmCode', array(
				'dvKey' => $_POST['dvKey'],		
				'chKey' => $_POST['chKey'],
			 	'cdType' => $dvCate,
			 	'cdCarrier' => $carrier,
			 	'spPlan' => $spPlan,
			 	'cdCode' => $cdCode
			 	)
			);	

		}
	}
}

alert('완료되었습니다.', "/admin/insertDeviceCode.php");

?>
