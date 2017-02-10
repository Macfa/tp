#!/usr/local/php/bin/php 
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<?
$cfg['path'] = $_SERVER['DOCUMENT_ROOT'];
include_once($cfg['path']."/lib/config.inc.php");
include_once(PATH_LIB."/lib.inc.php");
include_once(PATH_LIB.'/lib.planParsing.inc.php');

planParsing::setCarrier('kt')->setMode('phone')->setManuf('apple')->getDataAndInsert();
planParsing::setCarrier('kt')->setMode('phone')->setManuf('samsung')->getDataAndInsert();
planParsing::setCarrier('kt')->setMode('phone')->setManuf('lg')->getDataAndInsert();
planParsing::setCarrier('kt')->setMode('watch')->getDataAndInsert();
planParsing::setCarrier('kt')->setMode('pocketfi')->getDataAndInsert();
planParsing::setCarrier('kt')->setMode('kids')->getDataAndInsert();

planParsing::setCarrier('sk')->setMode('phone')->setManuf('apple')->getDataAndInsert();
planParsing::setCarrier('sk')->setMode('phone')->setManuf('samsung')->getDataAndInsert();
planParsing::setCarrier('sk')->setMode('phone')->setManuf('lg')->getDataAndInsert();
planParsing::setCarrier('sk')->setMode('watch')->getDataAndInsert();
planParsing::setCarrier('sk')->setMode('pocketfi')->getDataAndInsert();
planParsing::setCarrier('sk')->setMode('kids')->getDataAndInsert();
