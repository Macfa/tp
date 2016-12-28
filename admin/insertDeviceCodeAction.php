<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

$plan = array(
	'sk'=>array(
		'phone'=>array(
			0,
			1,
			2,
			3,
			4,
			5,
			6,
			7,
			8
		),
		'kids'=>array(
			9
		),
		'watch'=>array(
			11,
			12
		),
		'pocketfi'=>array(
			13,
			14
		)
	),
	'kt'=>array(
		'phone'=>array(
			15,16,17,18,19,20,23,24
		),
		'pocketfi'=>array(
			21,22
		),
		'watch'=>array(
			25,26
		),
		'kids'=>array(
			27,28
		)
	),	
	'lguplus'=>array(
		'phone'=>array()
	)
);	





$deviceList = DB::query("SELECT * FROM tmCode WHERE dvKey=%i AND  cdType=%i AND cdCarrier=%s", $_POST['dvKey'],$_POST['cdType'],$_POST['cdCarrier']);
$deviceKey = count($deviceList);

if($_POST['cdCarrier'] == 'sk'){
	$arrCode = array($_POST['cdCode_01'],$_POST['cdCode_02'],$_POST['cdCode_06']);
	foreach ($arrCode as $val) {
		preg_match('/https:\/\/tgate\.sktelecom\.com\/applform\/main\.do\?prod_seq=(\d*)&scrb_cl=0\d&mall_code=00001/', $val, $code);
		$skCodearr[] = $code[1];
	}
}else if($_POST['cdCarrier'] == 'kt'){
	$arrCode = array($_POST['cdCode_01'],$_POST['cdCode_02'],$_POST['cdCode_06']);
	foreach ($arrCode as $key => $val) {
		preg_match('/http:\/\/online\.olleh\.com\/index\.jsp\?prdcID=(.*)$/', $val, $code);			
		$ktCodearr[] = $code[1];
	}	
}

$skCodearr = array(
	'1' => $skCodearr[0],
	'2' => $skCodearr[1],
	'6' => $skCodearr[2]
);
$ktCodearr = array(
	'1' => $ktCodearr[0],
	'2' => $ktCodearr[1],
	'6' => $ktCodearr[2]
);

if($_POST['cdCarrier'] == 'sk'){	
	$codearr = $skCodearr;
}else if($_POST['cdCarrier'] == 'kt'){
	$codearr = $ktCodearr;
}

$arrPlan = $plan[$_POST['cdCarrier']][$_POST['dvCate']];


foreach ($arrPlan as $spPlan){
	foreach ($codearr as $dvCate => $cdCode) {		

		$deviceList = DB::queryFirstField("SELECT COUNT(*) FROM tmCode WHERE dvKey=%i AND  cdType=%i AND spPlan=%i AND cdCarrier=%s", $_POST['dvKey'], $dvCate, $spPlan, $_POST['cdCarrier']);

		if($deviceList === '1' && is_null($cdCode) === false){
			DB::update('tmCode', array(
				'cdCode' => $cdCode
			),"dvKey=%i AND cdType=%i AND spPlan=%i AND cdCarrier=%s", $_POST['dvKey'], $dvCate, $spPlan, $_POST['cdCarrier']); 			
		}else if(is_null($cdCode) === false){
			DB::insert('tmCode', array(
				'dvKey' => $_POST['dvKey'],		
				'cdType' => $dvCate,
				'cdCarrier' => $_POST['cdCarrier'],
				'spPlan' => $spPlan,
				'cdCode' => $cdCode
				)
			);	
		}
	}
}



alert('완료되었습니다.', "/admin/insertDeviceCode.php");

?>
