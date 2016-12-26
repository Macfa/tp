<main role="main">
	<ul class="main-slider bxslider">
		<li class="slide-item banner-gears3">
			<a href="/device/gears3frontier"></a>
		</li>
		<li class="slide-item banner-note7program">
			<a href="/page/programNote7.php"></a>
		</li>
		<!--	
		<li class="slide-item banner-preorder-iphone7">
			<a href="/page/iphone7Event.php"></a>
		</li>		
		<li class="slide-item banner-v20">
			<a href="/page/preorderV20.php"></a>
		</li>
		-->
		<li class="slide-item banner-pointmall">
			<a href="/gifts"></a>
		</li>	
	</ul>
</main>
<div class="wrap">
	<section class="main-event">
		<ul class="main-event-wrap">
			<li class="main-event-item-wrap">
				<a href="/device/lteeggplusa" class="main-small-banner-pocketfi vert-wrap">
					<div class="vert-align">
						<span class="main-small-banner-sub">데이터를 현명하게 쓰는</span><br/>
						<span class="main-small-banner-tit">LTE egg + A</span>
					</div>
				</a>
			</li><li class="main-event-item-wrap">
				<a href="/page/programNote7.php" class="main-small-banner-note7program vert-wrap">
					<div class="vert-align"></div>
				</a>
			</li><li class="main-event-item-wrap">
				<a href="/device/iphone7" class="main-small-banner-iphone7 vert-wrap">
					<div class="vert-align">
					<img src="<?=PATH_IMG?>/main-small-banner-iphone7-tit.png" >				
					</div>
				</a>
			</li><li class="main-event-item-wrap">
				<a href="/device/galaxys7edge" class="main-small-banner-s7bluecoral vert-wrap">
				<div class="vert-align"></div>
				</a>
			</li>
		</ul>
	</section>
	<section>
		<h1>현재 티플 사은품</h1>
		<?php 
		$additialWhere = "WHERE gfDisplay = 1 LIMIT 15"; 
		require_once(PATH_PRD."/giftList.inc.php");	
		?>
	</section>
	<section>
		<h1>최신 기기</h1>
		<?php 
		$incList['deviceSql'] = "SELECT * FROM tmDevice d LEFT JOIN tmMainSort o ON d.dvKey = o.maTargetKey WHERE d.dvDisplay = 1 and (d.dvSK = 1 OR d.dvKT = 1 OR d.dvLG = 1) and d.dvParent = 0 ORDER BY o.maOrder is null ASC, o.maOrder ASC ";
		$incList['additialWhere'] = "LIMIT 15"; 
		require(PATH_PRD."/deviceList.inc.php");	
		?>
	</section>
</div>
<div class="layer-banner-wrap js-layerBanner">
	<div class="layer-banner center">
		<div class="tit-sub">갤럭시노트7 교환&환불 안내</div>
		<div class="tit-sub txt-highlight">(2016-11-29 업데이트)</div>
		갤럭시노트7 교환&환불 절차를 안내드립니다. 
		<br/>
		<i class="ico-caution-small"></i> <span class="txt-highlight">공지사항을 반드시 읽어주시길 바랍니다.</span>
		<BR/>
		<div class="layer-banner-btn">
			<label class="inp-chk">
				<input type="checkbox" name="isHide" value="1"/>
				<div class="inp-chk-box"></div>
				하루동안 안보기
			</label>
			<br/>
			<button class="btn-filled-sub-dense js-layerBannerClose">닫기</button>
			<a href="<?php echo $cfg['url']?>/page/note7ExchangeRefundNotice.php" class="btn-filled-sub-dense" target="_blank">공지사항</a>
			&nbsp;
			<a href="http://tplanit.co.kr/page/exchangeRefundNote7.php" class="btn-filled-primary-dense">신청</a>
			<br/><br/>
		</div>
	</div>
</div>
<script>
$(function(){
	require([ 
		'jquery.bxslider'
	], function (bxslider) {
		if ($isMobileTablet)
			$bxSliderOption = {auto:true};
		else
			$bxSliderOption = {mode:'fade',auto:true};

		$('.main-slider').bxSlider($bxSliderOption);
	});

	<?php if(isNotExist(get_cookie('isLayerBannerHide2016-11-29'))) :?>
	$('.js-layerBanner').show();
	<?php endif?>
});

$('.js-layerBannerClose').click(function(){
	if($('[name=isHide]:checked').val() == 1) {
		setCookie('isLayerBannerHide2016-11-29','yes',1);
	}
	
	$('.js-layerBanner').hide();
});
</script>	
