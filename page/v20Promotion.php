<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
require_once(PATH_LIB."/lib.calculator.inc.php");

$import->addCSS('V20Promotion.css')->addJS('calculator.js')->addJS('/promotion/v20Promotion.js');
$cfg['subTitle'] = 'V20 이벤트';
require_once($cfg['path']."/head.inc.php");			// 헤더 부분 (스킨포함)

$planCalculator = new planCalculator();
$planCalculator->setDevice('v20')->setCarrier('kt');

require_once("v20Promotion.skin.php");		

require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)
?>