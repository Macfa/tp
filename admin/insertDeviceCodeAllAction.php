<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)


try{

	if(isNullVal($_POST['dvKey']))
		throw new Exception('기기값을 선택해주세요 ', 3);

	if(isNullVal($_POST['cdType']))		
		throw new Exception('가입유형을 선택해주세요 ', 3);

	if(isNullVal($_POST['cdCarrier']))
		throw new Exception('통신사를 입력해주세요.', 3);
	
} catch (Exception $e) {	
	alert($e->getMessage(), $errorURL);

}

$arrCode = explode('\r\n',$_POST['cdCodeAll']);

foreach($arrCode as $key => $code){
	preg_match('/https:\/\/tgate\.sktelecom\.com\/applform\/main\.do\?prod_seq=(\d*)&scrb_cl=0\d&mall_code=00001/', $code, $code);
	if(isNullVal(trim($code[1]))) continue;
	DB::insert('tmCode', array(
		'dvKey' => $_POST['dvKey'],
		'spPlan' => $key,
		'cdType' => $_POST['cdType'],
		'cdCarrier' => $_POST['cdCarrier'],
		'cdCode' => $code['1']
	));
}
?>

