<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
include_once(PATH_LIB."/lib.snoopy.inc.php");
include_once(PATH_LIB."/lib.parsing.inc.php");
include_once(PATH_LIB."/lib.calculator.inc.php");
require_once($cfg['path']."/headBlank.inc.php");			// 헤더 부분 (스킨포함)

$calculator = new calculator('galaxynote7');
$calculator->setCarrierSelect()->setDeviceTypeSelect()->setCapacitySelect()->setApplyTypeSelect()->setDiscountTypeSelect()->setVatContainSelect()->setPlanSelect();
?>


<?php echo $calculator->getCalculator();?>
<?php
require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)