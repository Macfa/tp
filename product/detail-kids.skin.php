<div class="wrap">
	<div class="tit center">프리미엄 사은품 (택1)</div>
	<?php
		$additialWhere = "WHERE (gfKey = 4 or gfkey = 24)"; 
		$selectionList = TRUE;
		include("./giftList.inc.php");
	?>

	<h2 class="tit center">기본 제공 사은품 (택1)</h2>
	<?php
		$additialWhere = "WHERE (gfKey = 17 or gfKey = 18 or gfKey = 19 or gfKey = 20)"; 
		$selectionList = TRUE;
		include("./giftList.inc.php");
	?>

	<h2 class="tit center">지인 소개 이벤트</h2>
	<div class="tit-sub-detail">친구와 함께 개통 하시면<br/>터닝카 점보로 업그레이드 혹은 1+1 으로 하나더 드립니다!</div>
	<p class="center">랜덤발송이며 소개 이후 두분 모두 개통이 완료된 경우에만 한합니다.</p>
	<div class="center">
		<img src="<?php echo PATH_IMG?>/gift-mecard-jumbo.jpg"/>
		<p class="tit-sub-detail">(업그레이드 후 터닝메카드 터닝카 점보)</p>
		<img src="<?php echo PATH_IMG?>/gift-mecard-default.jpg"/>
		<p class="center">(업그레이드 전 일반 터닝카)</p>
	</div>
	<div class="tit center">친구와 함께 준2를 신청하세요!</div>

	<div class="tit-sub-detail">티플에는 키즈폰 전문가가 항상 대기하고 있습니다.<Br/>(구. 트라움모바일)</div>

	<img src="<?php echo PATH_IMG?>/detail-kids-1.jpg"/>
	<div class="tit-sub-detail">월간 best baby 키즈폰 관련기사 자문/협찬 (2016 2월호 258 페이지)</div>
	<br/>
	<img src="<?php echo PATH_IMG?>/detail-kids-2.jpg"/>
	<div class="tit-sub-detail">월간 babee 키즈폰 관련기사 자문/협찬 (2016 4월호 134 페이지)</div>
</div>