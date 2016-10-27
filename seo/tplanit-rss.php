<?php
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
header("Content-Type: application/rss+xml");
header("Content-Type: text/xml");

$arrDevice = DB::query("SELECT * FROM tmDevice WHERE dvDisplay = 1 and dvParent = 0");
?>
<rss xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:taxo="http://purl.org/rss/1.0/modules/taxonomy/" 
xmlns:activity="http://activitystrea.ms/spec/1.0/" version="2.0" encoding="utf-8">
<channel>
	<title><![CDATA[티플 : 하늘에서 내려온 호갱구세주 ]]></title>
	<link><?php echo $cfg['url']?></link>
	<image>
	<url><?php echo PATH_IMG?>/og-img.jpg</url>
	<title>
	<![CDATA[티플 : 하늘에서 내려온 호갱구세주 ]]>
	</title>
	<link><?php echo $cfg['url']?></link>
	</image>
	<description>
	<![CDATA[ 현명한 소비자들의 새로운 선택 '티플' ]]>
	</description>
	<item>
		<title><![CDATA[티플 SK]]></title>
		<link><?php echo $cfg['url']?>/sk</link>
		<guid><?php echo $cfg['url']?>/sk</guid>
		<description><![CDATA[sk 통신사]]></description>
		<tag><![CDATA[티플,sk]]></tag>
	</item>
	<item>
		<title><![CDATA[티플 KT]]></title>
		<link><?php echo $cfg['url']?>/kt</link>
		<guid><?php echo $cfg['url']?>/kt</guid>
		<description><![CDATA[kt 통신사]]></description>
		<tag><![CDATA[티플,kt]]></tag>
	</item>
	<item>
		<title><![CDATA[티플 LG 기기]]></title>
		<link><?php echo $cfg['url']?>/lg</link>
		<guid><?php echo $cfg['url']?>/lg</guid>
		<description><![CDATA[lg기기]]></description>
		<tag><![CDATA[티플,lg]]></tag>
	</item>
	<item>
		<title><![CDATA[티플 삼성 기기]]></title>
		<link><?php echo $cfg['url']?>/samsung</link>
		<guid><?php echo $cfg['url']?>/samsung</guid>
		<description><![CDATA[삼성 기기]]></description>
		<tag><![CDATA[티플,삼성]]></tag>
	</item>
	<item>
		<title><![CDATA[티플 애플 기기]]></title>
		<link><?php echo $cfg['url']?>/apple</link>
		<guid><?php echo $cfg['url']?>/apple</guid>
		<description><![CDATA[애플기기]]></description>
		<tag><![CDATA[티플,애플,apple]]></tag>
	</item>
	<item>
		<title><![CDATA[티플 스마트워치]]></title>
		<link><?php echo $cfg['url']?>/watch</link>
		<guid><?php echo $cfg['url']?>/watch</guid>
		<description><![CDATA[스마트워치 기기]]></description>
		<tag><![CDATA[티플,스마트워치,스마트와치,루나워치,기어S,기어S2,기어S2클래식]]></tag>
	</item>
	<item>
		<title><![CDATA[티플 포켓파이]]></title>
		<link><?php echo $cfg['url']?>/pocketfi</link>
		<guid><?php echo $cfg['url']?>/pocketfi</guid>
		<description><![CDATA[포켓파이 기기, 휴대용 와이파이]]></description>
		<tag><![CDATA[티플,포켓파이,휴대용와이파이,에그,egg,T포켓파이M,T포켓파이Y,T포켓파이,KT에그]]></tag>
	</item>
	<item>
		<title><![CDATA[티플 <?php echo $row['dvTit']?>]]></title>
		<link><?php echo $cfg['url']?>/device/<?php echo $row['dvId']?></link>
		<guid><?php echo $cfg['url']?>/device/<?php echo $row['dvId']?></guid>
		<description><![CDATA[<?php echo $row['dvTit']?>]]></description>
		<tag><![CDATA[티플,<?php echo str_replace(' ','',$row['dvTit'])?>]]></tag>
	</item>
	<?php foreach($arrDevice as $row) :?>
	<item>
		<title><![CDATA[티플 <?php echo $row['dvTit']?>]]></title>
		<link><?php echo $cfg['url']?>/device/<?php echo $row['dvId']?></link>
		<guid><?php echo $cfg['url']?>/device/<?php echo $row['dvId']?></guid>
		<description><![CDATA[<?php echo $row['dvTit']?>]]></description>
		<tag><![CDATA[티플,<?php echo str_replace(' ','',$row['dvTit'])?>]]></tag>
	</item>
	<?php endforeach?>
</channel>
</rss>