<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

$arrDeviceTracking = explode('\r\n',$_POST['pvDeviceTracking']);
$isError = false;



foreach($arrDeviceTracking as $key => $val) {	
	$val = explode('||', $val);	
	/*
	if(isNullVal($val[0]))
		alert($key.'번줄(행)에 이름없습니다.');

	if(isNullVal($val[1]))
		alert($key.'번줄(행)의 '.$val[0].'님 폰번이 없습니다.');

	if(isNullVal($val[2]))
		alert($key.'번줄(행)의 '.$val[0].'님 송장번호가 없습니다.');
*/
	list($mbEmail, $isExist) = DB::queryFirstList("SELECT mbEmail, count(*) from tmMember WHERE mbName = %s_mbName and (mbPhone = %s_mbPhone or mbPhone = %s_mbPhone2)", array('mbName' => $val[0], 'mbPhone' => $val[1], 'mbPhone2' => str_replace('-', '', $val[1])));

	if($isExist === 0){
		$errorMsg .= $key.'번줄(행)의 '.$val[0].'님 이름과 폰번과 매치되는 사용자가 없습니다.\r\n';
		$isError = true;
	}

	if($isExist > 1){
		$errorMsg .= $key.'번줄(행)의 '.$val[0].'님 이름과 폰번과 매치되는 사용자가 2명 이상입니다. \r\n';
		$isError = true;
	}

	$isPreorderExist = DB::queryFirstField("SELECT count(*) from tmPreorderV20 WHERE mbEmail = %s", $mbEmail);

	if($isPreorderExist === 0){
		$errorMsg .= $key.'번줄(행)의 '.$val[0].'님은 사전예약신청자 DB에 없는 사용자입니다. \r\n';
		$isError = true;
	}

	$arrDeviceTracking[$key] = $val;		
	$arrDeviceTracking[$key]['mbEmail'] = $mbEmail;

}

if($isError == false) {

	foreach($arrDeviceTracking as $key => $val) {					
		DB::update('tmPreorderV20', array(
			'pvDeviceTracking' => $val[2],
			'pvProcess' => '4',
			), "mbEmail = %s",  $val['mbEmail']);
	}
	
	alert('송장번호가 입력되었습니다', 'insertDeviceTracking.php');
} else {
	echo alert('송장번호가 입력되지 않았습니다. 오류는 다음과 같습니다.', false);
	echo $errorMsg;	
}
?>

