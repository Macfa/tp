</div>
<footer>
	(주) 스타티지디 | 대표 : 김무규 | 서울 영등포구 당산동2가 하나비즈타워 304호 | 사업자등록번호 : 598-88-00320 | 통신판매업신고 : 2016-서울영등포-0329호
</footer>
<?php if (!$noContact) :?>
<div class="contact-pc-wrap">
	<a href="https://docs.google.com/forms/d/14hlR5OtjqfDXIkwz52_vDh_9yNWbCi4G3-boCf0PCpQ/viewform" class="btn-contact js-telReserve" target="layerView">
	<i class="contact-ico-consult"></i>
	<div class="btn-contact-tit">상담예약</div>
	</a>
	<a href="tel:070-7775-2981" class="btn-contact">
	<i class="contact-ico-tel"></i>
	<div class="btn-contact-tit" style="margin-top:-9px;line-height:20px;">070-7775-2981<br/>02-6357-0313</div>
	</a>
	<a href="http://plus.kakao.com/home/lzsdhrk5" class="btn-contact-kakao" target="_blank">
	<i class="contact-ico-kakao"></i>
	<div class="btn-contact-tit">@트라움플랜잇</div>
	</a>
</div>
<div class="contact-mobile-wrap">
	<div class="contact-mobile-inner">
		<a href="https://docs.google.com/forms/d/14hlR5OtjqfDXIkwz52_vDh_9yNWbCi4G3-boCf0PCpQ/viewform" class="contact-consult-mobile js-telReserve" target="layerView">	
			<div class="mobile-contact-tit">상담예약</div>
			<div class="mobile-ico-consult"><i class="contact-mobile-ico-consult"></i></div>
		</a>
		<a href="tel:070-7775-2981" class="contact-tel-mobile">	
			<div class="mobile-contact-tit">전화상담</div>
			<div class="mobile-ico-tel"><i class="contact-mobile-ico-tel"></i></div>
		</a>
		<a href="http://plus.kakao.com/home/lzsdhrk5" class="contact-kakao-mobile">
			<div class="mobile-contact-tit">카톡상담</div>
			<div class="mobile-ico-kakao"><i class="contact-mobile-ico-kakao"></i></div>
		</a>
		<button href="#" class="contact-toggle-btn">상담</button>
	</div>
</div>
<?php endif?>
<div class="layer-view-wrap js-layerView blur-exc">
	<div class="layer-btn-wrap">
	<button class="layer-view-btn js-layerViewClose">X 닫기</button>
	</div>
	<div class="layer-view">
		<iframe src="" class="js-layerViewIframe layer-view-iframe" name="layerView" scrolling="yes"></iframe>
	</div>
</div>

<div class="js-giftView gift-view-wrap blur-exc <?php echo $showGift?>">
	<div class="gift-view-inner-wrap js-giftDetail">
	</div>
</div>
<svg version="1.1" xmlns="http://www.w3.org/2000/svg" style="display:none">
   <filter id="blur">
       <feGaussianBlur stdDeviation="5"></feGaussianBlur>
   </filter>
</svg>
<iframe name="common-action" style="position:absolute;width:0;height:0;border:0;margin-left:-99999px;overflow:hidden"></iframe>