<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

try
{
	if (isNullVal($_GET['id']) || isNum($_GET['id']) === false)
		throw new Exception('매개변수가 숫자가 아니거나 빈 값입니다.', 3);
	
	$isValidAddressKey = DB::queryFirstField("SELECT COUNT(*) FROM tmAddress WHERE arKey = %i and mbEmail = %s", $_GET['id'], $mb['mbEmail']);
	if($isValidAddressKey === 0)
		throw new Exception('잘못된 요청입니다 (code 110)', 3);
}
catch(Exception $e)
{
    alert($e->getMessage());
}

DB::delete("tmAddress", " arKey = %i and mbEmail = %s", $_GET['id'], $mb['mbEmail']);
echo true;
?>