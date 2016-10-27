#!/usr/local/php/bin/php 
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<?
if (preg_match("/ehgu09.tplanit.co.kr/", $_SERVER["HTTP_HOST"])) {
	$rootPrefix = '-dev';
}
$path= '/home/www/traumplanet'.$rootPrefix.'/lib';
include_once($path."/lib.common.inc.php");
include_once($path."/lib.sql.inc.php");
include_once($path."/lib.meekrodb.inc.php");
include_once($path."/lib.naverLogin.inc.php");
include_once($path."/lib.kakaoLogin.inc.php");
include_once($path."/lib.security.inc.php");
include_once($path."/lib.validate.inc.php");
include_once($path.'/lib.phone.inc.php');
include_once($path.'/lib.snoopy.inc.php');
include_once($path.'/lib.parsing.inc.php');
include_once($path.'/lib.planParsing.inc.php');

$parsePlan = new parseSupportPrice();

$parsePlan->setCarrier('sk')->setMode('phone')->setManuf('samsung')->getDataAndInsert();
$parsePlan->setCarrier('sk')->setMode('phone')->setManuf('apple')->getDataAndInsert();
$parsePlan->setCarrier('sk')->setMode('phone')->setManuf('lg')->getDataAndInsert();
$parsePlan->setCarrier('sk')->setMode('watch')->getDataAndInsert();
$parsePlan->setCarrier('sk')->setMode('pocketfi')->getDataAndInsert();
$parsePlan->setCarrier('sk')->setMode('kids')->getDataAndInsert();
/*
$parsePlan->setCarrier('lg')->setMode('phone')->setManuf('samsung')->getDataAndInsert();
//$parsePlan->setCarrier('lg')->setMode('phone')->setManuf('apple')->getDataAndInsert();
//$parsePlan->setCarrier('lg')->setMode('phone')->setManuf('lg')->getDataAndInsert();
//$parsePlan->setCarrier('lg')->setMode('watch')->getDataAndInsert();
//$parsePlan->setCarrier('lg')->setMode('pocketfi')->getDataAndInsert();
//$parsePlan->setCarrier('lg')->setMode('kids')->getDataAndInsert();
*/