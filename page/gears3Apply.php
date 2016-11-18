<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
require_once(PATH_LIB."/lib.calculator.inc.php");

$import->addJS('calculator.js')->addCSS('preorderV20.css');
$planCalculator = new planCalculator();
$planCalculator->setDevice('gears3frontier')->setCarrier('kt');
require_once($cfg['path']."/head.inc.php");			// 헤더 부분 (스킨포함)
require_once("gears3Apply.skin.php");	
require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)
?>