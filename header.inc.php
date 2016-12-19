<?
header("Content-Type: text/html; charset=uft-8");
$gmnow = gmdate("D, d M Y H:i:s") . " GMT";
header("Expires: 0"); // rfc2616 - Section 14.21
header("Last-Modified: " . $gmnow);
header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
header("Cache-Control: pre-check=0, post-check=0, max-age=0"); // HTTP/1.1
header("Pragma: no-cache"); // HTTP/1.0

if ($cfg['subTitle'])
	$cfg['subTitle'] = ' > '.$cfg['subTitle'];
if ($cfg['subDesc'])
	$cfg['subDesc'] = ' : '.$cfg['subDesc'];
?>
<!DOCTYPE html class="">
<!--[if lt IE 7]><html class="lte-ie9 lte-ie8 lte-ie7 lt-ie7"><![endif]-->
<!--[if IE 7]><html class="lte-ie9 lte-ie8 lte-ie7"><![endif]-->
<!--[if IE 8]><html class="lte-ie9 lte-ie8"><![endif]-->
<!--[if IE 9]><html class="lte-ie9"><![endif]-->
<html class="<?php echo $_useragent['class'].' '.$_useragent['platform'].' '.$_useragent['device']?>">
<head>
<title>티플 : 호갱구세주<?php echo $cfg['subTitle']?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, maximum-scale=1, user-scalable=0" />
<meta name="description" content="티플 : 노트7사전예약,갤S7,G5,아이폰,스마트워치,포켓파이,준2">
<meta name="google-site-verification" content="KFJq5d9FeHWP2VkwbIAdlpRMO3kb6ayo2l6vDQmqIgc" />
<meta property="og:type" content="website">
<meta property="og:title" content="티플 : 호갱구세주">
<meta property="og:description" content="티플 : 노트7사전예약,갤S7,G5,아이폰,스마트워치,포켓파이,준2">
<meta property="og:image" content="<?=PATH_IMG?>/og-img.jpg">
<meta property="og:url" content="http://tplanit.co.kr">
<script>
$isMobileTablet = false;
</script>
<?php 
$importHead = new import();
$importHead->addJS("jquery.js", "lib")
			->addJS("common.js")
			->addJS("webFontLoader.js", "lib")
			->importJS();
?>
<script>
if ($isMobileTablet == false) {
	WebFont.load({
    custom: {
        families: ['Noto Sans KR'],
        urls: ['<?=PATH_CSS?>/notoSansFontKR.css']
    }
  });
}

</script>
<!-- <link rel="stylesheet" href="<?=PATH_CSS?>/normalize.css" type="text/css"> -->
<?php $import->importCSS(); ?>
<?=$header?>
<?=$add_css?>
<!--[if lt IE 9]>
<script type="text/javascript" src="<?=PATH_JS_LIB?>/html5shiv.js"></script>
<script type="text/javascript" src="<?=PATH_JS_LIB?>/ie7/IE9.js"></script>
<script type="text/javascript" src="<?=PATH_JS_LIB?>/selectivizr-min.js"></script>
<script type="text/javascript" src="<?=PATH_JS_LIB?>/css3-mediaqueries.js"></script>
<link rel="stylesheet" href="<?=PATH_CSS?>/outdatedbrowser.css">
<script>
$(document).ready(function(){
	var $isOutdatedClose = false;
	var $isCloseCookie = getCookie('isClose');
	if($('html').hasClass('lte-ie7')) $isCloseCookie = undefined;
	if($isCloseCookie === undefined){		
		$('body').prepend('<section id="outdated"></section>');
		outdatedBrowser({
			bgColor: '#f25648',
			color: '#ffffff',
			lowerThan: 'transform',
			languagePath: '<?=PATH_JS_LIB?>/outdatedbrowser/lang/ko.html'
		});		
	}
});
</script>
<![endif]-->
</head>
<body class="<?php echo $disableBody?>">