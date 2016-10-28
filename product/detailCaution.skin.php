<section class="detail-guide-wrap">
	<h2 class="tit center">		
		<i class="detail-ico-caution"></i>
		유의사항		
	</h2>
	<?php if($device['dvCate'] == 'watch') :?>
	<!--<h3 class="tit-sub">T아웃도어 요금제 설명</h3>-->
	<span class="tit-sub">T아웃도어(공유) 요금제란?</span>
	<ul class="detail-check-list price">
		<li>-기본 음성 통화량 소진 시 모폰의 음성통화량을 공유할 수 있는 혜택</li>
		<li>-착신전환 서비스 270분 무료제공 혜택</li>
		<li>-SK 통신사 이용 고객</li>
		<?php if($device['dvIcon'] == 'gear' && $device['dvManuf'] == 'samsung') :?> 
		<li>-삼성전자에서 출시한 스마트폰 이용자</li>
		<li>-운영체제 안드로이드 4.3이상, 1.5G 이상의 RAM</li>
		<?php endif?>
	</ul>
	<br/>
	<span class="tit-sub">T아웃도어(단독) 요금제란? </span>
	<ul class="detail-check-list price">
		<li>-기본 음성통화량만 가능 (사용량 초과시, 1초당 1.8원씩 과금)</li>
		<li>-착신전환 서비스 별도신청</li>
		<li>-타 통신사 이용 고객</li>
	</ul>
	<h3 class="tit-sub-detail center">
		<i class="detail-ico-device-support"></i>
		해당 기기는 사용중인 스마트폰과의 "호환성 여부" 확인이 필요합니다.
	</h3>
	<div class="center">
		아래의 링크를 통해 반드시 호환가능 모델을 확인하세요.
		<Br/>
		호환모델에 대한 궁금증은 고객센터를 통해 해결해주세요!
		<br/>
		<?php if($device['dvId'] == 'tgw500s'){?>
		<a class="btn-filled js-layerViewToggle" target="layerView" href="/product/layerImg.php?q=LUNA_Watch_compatibility.jpg">
			호환모델 확인하기
		</a>
		<?php }else if($device['dvIcon'] == 'gear'){?>
				<a class="btn-filled js-layerViewToggle" target="layerView" href="/product/layerImg.php?q=Gears_compatibility.jpg">
			호환모델 확인하기
		</a>

		<?php }?>
		<br/>
		<br/>
		<hr>
	</div>
	<?php endif?>
	<Br/>
	<h2 class="tit center vacancetit <?php echo $detailNone ?>">바캉스세트 유의사항</h2>
	<ul class="detail-check-list <?php echo $detailNone ?>">
		<li><i class="detail-ico-mark"></i>상품을 받자마자 불량테스트를 해주세요.</li>
		<li><i class="detail-ico-mark"></i>방수팩은 반드시 휴지를 넣고 테스트를 진행해주시기 바랍니다.</li>
		<li><i class="detail-ico-mark"></i>교환은 최대 7일 이내 가능합니다.</li>
		<li><i class="detail-ico-mark"></i>교환하실 때 박스 등 구성품이 그대로 있어야 교환 가능합니다.</li>
		<li><i class="detail-ico-mark"></i>183일 이전 개통철회 시 바캉스세트 비용 또한 지불해주셔야합니다.</li>
		<li><i class="detail-ico-mark"></i>돌고래튜브는 포장 박스 그대로 갖고 계시면 전국 홈플러스에서 교환 가능합니다.</li>
	</ul>
	<Br/>
	<h2 class="tit center">구매하시기전 확인사항</h2>
	<ul class="detail-check-list">
		<li><i class="detail-ico-mark"></i>구매 시 유심비는 익월 8,800원 청구됩니다.</li>
		<li><i class="detail-ico-mark"></i>기본 약정개월은 24개월입니다.</li>
		<?php if($device['dvCate'] == 'watch') :?>
		<li><i class="detail-ico-mark"></i>아쉽게도 아이폰 시리즈와 호환되지 않습니다.</li>
		<?php endif?>
		<?php if($device['dvCate'] == 'pocketfi') :?> 
		<li><i class="detail-ico-mark"></i>포켓파이의 커버리지는 전국망LTE와 동일하며, 포켓파이를 사용중인 장소의 LTE 신호 강도에 따라 통신품질의 차이가 발생할 수 있습니다.</li>
		<?php endif?>
		<li><i class="detail-ico-mark"></i>회선유지기간 182일 전에 해지 시 사은품 비용을 일체 지불하셔야 합니다.</li>
		<li><i class="detail-ico-mark"></i>확인사항에 없는 궁긍한 점은 고객센터로 문의주세요!</li>
	</ul>
	<h2 class="tit center">구매 후 확인사항</h2>
	<ul class="detail-check-list">
		<li><i class="detail-ico-mark"></i>상품을 받으시고 상품이 정상적으로 도착했는지 확인합니다. <div class="check-list-sub">상품이 정상적으로 오지 않았다면 02-6358-0312로 문의주세요.</div> </li>
		<li><i class="detail-ico-mark"></i>첨부된 설명서를 잘 읽어보면서 USIM 다운로드를 진행합니다.<div class="check-list-sub">USIM다운로드를 했는데 작동이 안되면 인근의 이용중인 통신사 대리점을 방문하여 해결합니다.</div> </li>
		<li><i class="detail-ico-mark"></i>
			불량인 것 같아요!
			<?php if($device['dvManuf'] == 'samsung') :?> 
			<div class="check-list-sub"> 고장이 나면 바로 가까운 삼성 서비스센터를 방문해 진단을 받아보세요.<Br/>
			삼성 서비스센터에서 교환증을 받으셔야 저희가 교환 해드릴 수 있습니다.<Br/>
			상품 받은 후 14일 이내 저희에게 도착해야 원할한 교품이 진행될 수 있습니다.<Br/>
			불량인 경우 빨리 서둘러 주세요!
			</div> 
			<?php else :?>
			<div class="check-list-sub">각 제조사에 맞는 서비스센터를 방문해 진단을 받아보세요.</div> 
			<?php endif?>
		</li>
		<?php if($device['dvCate'] == 'pocketfi') :?>
		<li><i class="detail-ico-mark"></i>
			포켓파이M 속도가 잘 나오질 않네요!
			<div class="check-list-sub">
				1. 스마트폰에 포켓파이가 올바르게 연결되어 있는지 확인해주세요.
				<br/>
				2. 고객님이 계신 장소의 LTE 신호강도를 확인해주세요.
				<BR/>
				3. 그래도 문제가 있으시면 통신사로 문의바랍니다.
			</div> 
		</li>
		<?php endif?>
		<li><i class="detail-ico-mark"></i>
			교환/반품이 하고 싶어요!
			<div class="check-list-sub">
				1. 티플에서 구매하신 모든 전자기기의 교환 및 반품은 계약일(구매일) 이후, 10일 이내에만 가능합니다.
				<br/>
				2. 포장이 훼손되어 상품 가치가 상실된 경우에는 교환 및 반품이 불가능합니다. 
				<BR/>
				3. 제품의 구성품이 누락된 경우에는 교환 및 반품이 불가능합니다. 
				<BR/>
				4. 제조사의 서비스센터에서 불량파정 및 교품판정을 받고 관련 서류를 함께 동봉해주셔야만 합니다.
				<BR/>
				5. 사은품은 초기 불량을 제외하고 반품이 되지 않습니다. 기계 해지 시 사은품 비용을 지불하셔야합니다.
			</div> 
		</li>
		
		<li><i class="detail-ico-mark"></i>확인사항에 없는 궁긍한 점은 고객센터로 문의주세요!</li>
	</ul>
</section>