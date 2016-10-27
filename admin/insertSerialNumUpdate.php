<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

$arrInput = explode('\r\n', $_POST['input']);

foreach($arrInput as $val) {
	if(isExist($val))
		DB::insert('tmSerialNum', array('snSerial' => $val));
}

alert('일련번호가 입력되었습니다', 'insertSerialNum.php');