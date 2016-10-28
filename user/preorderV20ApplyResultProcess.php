<?php

if($arrOrderList['pvCurrent'] === 'skt')
$pvCurrent = "SKT";
if($arrOrderList['pvCurrent'] === 'kt')
$pvCurrent = "KT olleh";
if($arrOrderList['pvCurrent'] === 'lg')
$pvCurrent = "LG U+";
if($arrOrderList['pvCurrent'] === 'etc')
$pvCurrent = "알뜰폰";

if($arrOrderList['pvApplyType'] === 'changeCarrier')
$SelectPlan = "번호이동";
if($arrOrderList['pvApplyType'] === 'changeDevice')
$SelectPlan = "기기변경";

if($arrOrderList['pvPlan'] === '15')
$Plan = "KT 데이터 599";
if($arrOrderList['pvPlan'] === '16')
$Plan = "KT 데이터 499";
if($arrOrderList['pvPlan'] === '17')
$Plan = "KT 데이터 399";
if($arrOrderList['pvPlan'] === '18')
$Plan = "KT 데이터 299";

if($arrOrderList['pvProcess'] === '1')
$pvProcess = "신청완료";


?>
