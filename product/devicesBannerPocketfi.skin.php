<!--<main class="list-banner-pocketfi">
	<a href="/device/lteeggplusi" class="list-banner-inner-pocketfi js-ajax-banner" id="link-banner-pocketfi">
		<h1 class="list-banner-tit">
			데이터를 언제 어디든지<br/>꺼내쓰는 현명한 방법
			<br/>
			LTE egg + A
		</h1>
		<button class="btn">엄청한 사은품과 함께 구매하기</button>
	</a>
</main>
-->
<main role="main" class="list-banner-pocketfi">
	<ul class="main-slider bxslider">
		<li class="slide-item subEvent-egg">
			<a href="/device/lteeggplusi"></a>
		</li>
		<li class="slide-item subEvent-pocket">
			<a href="/device/tpocketfia"></a>
		</li>
	</ul>
</main>
<!--
<script>
$('.js-ajax-banner').click(function(){
	$eventMsg = "에그완판알림";
	$.ajax({
		url:'/product/alarmEvent.php',
		type:'post',
		async:false,
		data:{aeEvent : $eventMsg},
		success:function(data){		
			// console.log(data);	
			$data = $.parseJSON(data);

			if ($data['errorCode'] > 0) {
				alert($data['errorMsg']);
				if ($data['errorURL'])
					location.href = $data['errorURL'];
			}else if ($data['errorCode'] == 0)
				alert('신청이 완료되었습니다');		
		}
	});
});

</script>
-->		
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