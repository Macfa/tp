<?php 
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
header("Content-Type: text/xml; charset=utf-8");
echo '<?xml version="1.0" encoding="UTF-8"?>';
$arrDevice = DB::query("SELECT * FROM tmDevice WHERE dvDisplay = 1");
$feedUpdated = date('Y-m-d\TH:i:s\+09:00', $cfg['server_time']);
?>
<feed xmlns="http://webmastertool.naver.com">
	<id><?php echo $cfg['url']?></id>
	<title>티플 : 하늘에서 내려온 호갱구세주</title>
	<author>
		<name>티플</name>
	</author>
	<updated><?php echo $feedUpdated?></updated>
	<link rel="site" href="http://tplanit.co.kr" title="티플 : 하늘에서 내려온 호갱구세주"/>
	<?php foreach($arrDevice as $row) :?>
	<?php
	switch($row['dvManuf']){
		case 'samsung':
			$row['dvManufKr'] = '삼성';
			break;
		case 'apple':
			$row['dvManufKr'] = '애플';
			break;
		case 'lg':
			$row['dvManufKr'] = 'LG';
			break;
		case '기타':
			$row['dvManufKr'] = '기타';
			break;
		default:
			break;
	}
	$defaultPlanKey = DB::queryFirstField("SELECT min(spPlan) FROM tmSupport WHERE dvKey = %i0 and spCarrier = 'sk'", $row['dvKey']);
	if ($defaultPlanKey == 9) $defaultPlanKey = 10;

	list($currentSupport, $currentAddSupport, $spDate) = DB::queryFirstList("SELECT spSupport,spAddSupport,spDate FROM tmSupport WHERE dvKey = %i0 and spPlan = %i1 and spCarrier = 'sk' ORDER BY spDate DESC LIMIT 1", $row['dvKey'], $defaultPlanKey);
	$currentSupport = number_format($currentSupport);
	$currentAddSupport = number_format($currentAddSupport);

	if($currentSupport == 0) continue;

	if($row['dvParent'] != 0) {
		$parentTit = DB::queryFirstField("SELECT dvTit FROM tmDevice WHERE dvKey = %i0", $row['dvParent']);
		$row['dvTit'] = $parentTit.' '.$row['dvTit'];
	}

	?>
	<entry>
		<id><?php echo $cfg['url']?>/device/<?php echo $row['dvId']?></id>
		<title><![CDATA[<?php echo $row['dvTit']?>]]></title>
		<author><name>티플 : 하늘에서 내려온 호갱구세주</name></author>
		<updated><?php echo $feedUpdated?></updated>
		<published><?php echo $feedUpdated?></published>
		<link rel="via" href="<?php echo $cfg['url']?>/<?php echo $row['dvManuf']?>" title="<?php echo $row['dvManufKr']?>기기 목록"/>
		<link rel="mobile" href="<?php echo $cfg['url']?>/device/<?php echo $row['dvId']?>" title="<?php echo $row['dvManufKr']?>기기 목록"/>
		<content type="html">
		<![CDATA[ 
		<h3><?php echo $row['dvTit']?> 현재 공시지원금 정보</h3>
		<ul><li>현재 공시지원금 : <?php echo $currentSupport?></li><li>현재 추가공시지원금 : <?php echo $currentAddSupport?></li><li>공시일자 : <?php echo $spDate?></li></ul><?php echo $row['dvTit']?> 살 땐 역시 "호갱구세주 티플"에서!</div>
		]]>
		</content>
		<summary type="text">
		<![CDATA[
		현재 공시지원금 정보 // 현재 공시지원금 : <?php echo $currentSupport?>, 현재 추가공시지원금 : <?php echo $currentAddSupport?>, 공시일자 : <?php echo $spDate?>, <?php echo $row['dvTit']?> 살 땐 역시 "호갱구세주 티플"에서!
		]]>
		</summary>
	</entry>
	<?php endforeach?>
	<deleted-entry ref="http://tplanit.co.kr/user/login.php" when="2016-06-26T20:10:45+09:00"/>
</feed>