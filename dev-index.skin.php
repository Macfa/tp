<main role="main">
	<ul class="main-slider bxslider">
		<li class="slide-item banner-note7-media">
			<a href="/page/note7.php"></a>
		</li>
		<li class="slide-item banner-pointmall">
			<a href="/gifts"></a>
		</li>	
		<li class="slide-item banner-iphone6">
			<a href="/device/iphone6">
				<div class="wrap banner-iphone6-wrap">					
					<div class="vert-wrap">
							<div class="banner-sub">지금 아이폰6 사면</div>
							<div class="banner-tit iphone6">다 준 다</div>
							<button class="btn">구매하러하기</button>						
					</div>
				</div>
			</a>
		</li>
		<li class="slide-item banner-vacance">
			<div class="wrap banner-vacance-wrap">
					<div class="vert-wrap txt_vacance">
						<div class="banner-tit vacance">핸드폰 구매하고 <br/><span class="setcolor">티플바캉스세트</span> 받자!</div>
						<div class="banner-sub vacance">티플에서 핸드폰을 구매하는 고객님 전원에게 
							티플 바캉스 세트를 드립니다. <br/>
							( 7월 23일 ~ 8월 25일 구매자 전원, 소진 시 마감)
						</div>						
					</div>
				<div class="vacance_gift">					
						<ul class="vacance_list">
						<a class="js-layerViewToggle" href="http://tplanit.co.kr/gift/30" target="layerView" id="link-giftList-26">
							<li class="vacance_gift_list">
								<span class="gift_list_name">루나폴리 방수팩</span>
								<img src="<?=PATH_IMG?>/gift_02.png">
							</li>							
						</a>
						<a class="js-layerViewToggle" href="http://tplanit.co.kr/gift/28" target="layerView">
							<li class="vacance_gift_list">
								<span class="gift_list_name">돌고래 손잡이튜브</span>
								<img src="<?=PATH_IMG?>/gift_01.png">
							</li>							
						</a>
						<a class="js-layerViewToggle" href="http://tplanit.co.kr/gift/29" target="layerView">
							<li class="vacance_gift_list">
								<span class="gift_list_name">자동 에어 펌프</span>
								<img src="<?=PATH_IMG?>/gift_03.png">
							</li>							
						</a>
					</ul>				
			</div>
		</li>		
		<li class="slide-item banner-galaxynote7">
			<a href="/page/note7.php">
				<div class="wrap banner-galaxynote7-wrap">
					<div class="banner-right-sec banner-iphone-se-cont">						
						<div class="banner-tit">
							삼성의 새로운 혁신<br/>
							갤럭시 노트7 사전예약
						</div>
						<button class="btn">사전예약하기</button>
					</div>
				</div>
			</a>
		</li>
		<li class="slide-item banner-membership">
			<a href="/page/membership.php">
				<div class="wrap banner-membership-wrap">					
					<div class="vert-wrap">
						<div class="vert-align">
							<div class="banner-tit">티플 멤버쉽</div>
							<div class="banner-sub">실제로 통신비를 낮출 수 있는 유일한 방법</div>
							<button class="btn">통신비낮추러 가기</button>
						</div>
					</div>
				</div>
			</a>
		</li>
	</ul>
</main>
<div class="wrap">
	<section class="main-event">
		<ul class="main-event-wrap">
			<li class="main-event-item-wrap">
				<a href="/device/tpocketfim" class="main-small-banner-pocketfi vert-wrap">
					<div class="vert-align">
						<span class="main-small-banner-sub">데이터를 현명하게 쓰는</span><br/>
						<span class="main-small-banner-tit">포켓파이 M</span>
					</div>
				</a>
			</li><li class="main-event-item-wrap">
				<a href="/gifts" class="main-small-banner-pointmall vert-wrap">
					<div class="vert-align">
					<img src="<?=PATH_IMG?>/main-small-banner-pointmall-tit.png" class="mobile_img">
						<span class="main-small-banner-tit pc_tit">
							확실히 다르다
						</span><br/>
						<span class="main-small-banner-tit color bold pc_tit">포인트몰 오픈</span>
					</div>
				</a>
			</li><li class="main-event-item-wrap">
				<a href="/device/galaxys7edge" class="main-small-banner-galaxys7 vert-wrap">
					<div class="vert-align">
						<span class="main-small-banner-tit">갤럭시S7 엣지</span>
						<br/>
							데이터51요금제<br/>
							할부원금 766,500원<br/>
							월 91,838원<br/>
							푸짐한 사은품
					</div>
				</a>
			</li><li class="main-event-item-wrap">
				<a href="http://traumshop.co.kr" target="_blank" class="main-small-banner-traumguard vert-wrap">
					<div class="vert-align">
						<span class="main-small-banner-sub">
							함께하면 더 빛나는
						</span><br/>
						<span class="main-small-banner-tit">트라움가드<br/>방탄필름</span>
					</div>
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
		$incList['deviceSql'] = "SELECT * FROM tmDevice d LEFT JOIN tmMainSort o ON d.dvKey = o.maTargetKey WHERE d.dvDisplay=1 and d.dvParent = 0 ORDER BY o.maOrder is null ASC, o.maOrder ASC ";
		$incList['additialWhere'] = "LIMIT 15"; 
		require(PATH_PRD."/deviceList.inc.php");	
		?>
	</section>
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
});
</script>	
