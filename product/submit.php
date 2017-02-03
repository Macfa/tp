<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

$import->addCSS('layerIframe.css');


$deviceInfo = new deviceInfo();

$getPlanInfo = getPlanInfo(
			array(
				'capacity' => $_POST['capacity'],				
				'plan' => $_POST['plan'],
				'carrier' => $_POST['carrier'],
				'applyType' => $_POST['applyType'],
				'discountType' => $_POST['discountType'],
				'id' => $_POST['dvId']
			)
		);
try
{
	if(isExist($getPlanInfo) === false) // 버튼눌러서 들어온게 아니라 그냥 페이지 링크연결시
		throw new Exception('잘못된 접근입니다');

}
catch(Exception $e)
{
    alert($e->getMessage());
}

require_once($cfg['path']."/headBlank.inc.php");
require_once("submit.skin.php");  
require_once($cfg['path']."/footBlank.inc.php"); 

?>
