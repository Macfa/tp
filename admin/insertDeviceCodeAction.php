<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)



$deviceList = DB::query("SELECT * FROM tmCode WHERE dvKey=%i AND  cdType=%i AND cdCarrier=%s", $_POST['dvKey'],$_POST['cdType'],$_POST['cdCarrier']);
$deviceKey = count($deviceList);

preg_match('/https:\/\/tgate\.sktelecom\.com\/applform\/main\.do\?prod_seq=(\d*)&scrb_cl=0\d&mall_code=00001/', $_POST['cdCode'], $code);

try{
	if(isNullVal($_POST['dvKey']))
		throw new Exception('기기선택해주세요', 3);
	
} catch (Exception $e) {	

	alert($e->getMessage());
}


if($deviceKey === 0){
	DB::insert('tmCode', array(
		'dvKey' => $_POST['dvKey'],		
		'cdType' => $_POST['cdType'],
		'cdCarrier' => $_POST['cdCarrier'],
		'cdCode' => $code['1']

	));	
 
}else if($deviceKey === 1){
	DB::update('tmCode', array(
		'cdCode' => $code['1']
  ),"dvKey=%i AND cdType=%i AND cdCarrier=%s", $_POST['dvKey'],$_POST['spPlan'],$_POST['cdType'],$_POST['cdCarrier']); 
}

alert('완료되었습니다.', "/admin/insertDeviceCode.php");

?>