<div class="applyUrl-view">
	<div class="skt-head-wrap">
		<div id="header"><!-- 신청서 Header Logo Html -->
		<p class="logo"><img src="<?=PATH_IMG?>/txt_logo.png" title="SK telecom" alt="에스케이 텔레콤"></p>					
		<h1><img src="<?=PATH_IMG?>/h1_online_store.png" title="온라인 공식대리점" alt="온라인 공식 대리점"></h1>
		
		<div class="store_info">
			<dl>
				<dt>대리점명 : </dt>
				<dd>엠케이트라음</dd>
				<dt class="phone_num">전화번호 : </dt>
				<dd>02-6357-0313</dd>
			</dl>
			<dl class="address_info">
				<dt>주소 : </dt>
				<dd>서울 영등포구 영등포로 103 하나비즈타워 304호 (당산동)</dd>
			</dl>
		</div>
	</div>
	</div>
	<div class="kt-head-wrap">
	<!--
		<div class="text-wrap">
			<span class="kt-text">kt 공식 온라인 대리점 엠케이트라움에 오신것을 환영합니다. <br/>
			고객님은 강북모바일_강북15 에서 kt 본사가 보증하는 공식 대리점을 통해 핸드폰 구입 및 olleh mobile 서비스에 가입됩니다.</span>
		</div>
	-->
	</div>
	<iframe src="<?echo $getPlanInfo['applyUrl']?>" name="applyUrlView" class="applyUrlIframe"></iframe>
</div>

<script>
	var carrier = '<?php echo $_POST['carrier']; ?>';
	if(carrier === 'kt'){
		$('.skt-head-wrap').hide();
		$('.kt-head-wrap').show();
		$('.applyUrl-view').css({width:"100%", height:"100%"});
		$('.applyUrlIframe').css({width:"100%", height:"100%"});
		/*
		$('.applyUrl-view').css('height','690px');
		$('.applyUrlIframe').css({width:"100%", height:"725px"});
		*/
	}else if(carrier ==='sk'){
		$('.skt-head-wrap').show();
		$('.kt-head-wrap').hide();
	}


</script>