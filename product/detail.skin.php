<div class="detail-calc-result-mobile js-calcResultMobile">
	<span class="detail-calc-result-label">
		월 청구액
	</span>
	<span class="js-planResult detail-calc-result-price">
		<?php echo number_format($defaultVal['defaultPlanFee'] + floor($defaultVal['dvDeviceInstallation']/24))?>
	</span>
</div>
<div class="wrap center <?php echo $_GET['id']?>-container">
		<a href="/product/deviceDetail.php?id=<?php echo $device['dvId']?>" target="layerView" class="js-telReserve detailSpce-link" onfocus='this.blur();'>
	<h1 class="detail-device-tit"><?php echo $device['dvTit']?></h1>
	<button class="btn-flat-primary-dense"><i class="detailSpec-ico"></i><span class="detailSpec-txt">상세</span></button>
	</a>
	<div class="detail-intro-img-wrap <?php echo $device['dvId']?>">
		<img class="detail-intro-img" src="<?php echo $imgPath.$device['dvDetailThumb']?>"/>
	</div>
	<section class="detail-intro">
		<!--div class="intro-device">
			<div class="intro-device-img">
				<img src="<?=PATH_IMG?>/device-big-iphone6.png"/>
			</div>
		</div--><div class="intro-graph">
			<canvas id="supportChart" width="100%" height="100%"></canvas>
			<div class="intro-graph-tit tit-inside">공시지원금 변경내역</div>
		</div>
	</section>
	<ul class="benefit-wrap">
	<li class="benefit-item">
		가입비
		<div class="benefit-item-tit">면제</div>
	</li><li class="benefit-item">
		유심비청구
		<div class="benefit-item-tit">익월</div>
	</li><li class="benefit-item">
		배송비
		<div class="benefit-item-tit">무료</div>
	</li><li class="benefit-item">
		부가서비스
		<div class="benefit-item-tit">없음</div>
	</li>
	</ul>
	<!--ul class="benefit-wrap">
	<li class="benefit-item">
		할부개월
		<i class="benefit-ico-installation">24개월</i>
	</li><li class="benefit-item">
		가입비
		<i class="benefit-ico-join">면제</i>
	</li><li class="benefit-item">
		유심비청구
		<i class="benefit-ico-usim">익월</i>
	</li><li class="benefit-item">
		배송비
		<i class="benefit-ico-delivery">무료</i>
	</li><li class="benefit-item">
		부가서비스
		<i class="benefit-ico-addService">없음</i>
	</li><li class="benefit-item">
		색상선택
		<i class="benefit-ico-color">가입시 선택</i>
	</li>
	</ul-->
	<form class="js-plan-calc-arg" method="GET" action="/apply/">
		<?php echo $planCalculator->create();?>
		
		<?php if(isContain('lteeggplus',$device['dvId']) === true) :?>
		<Br/><br/>
		<div class="detail-banner-egg"></div>
		
		<?php elseif(isContain('tpocketfi',$device['dvId']) === true) :?>
		<Br/><br/>
		<div class="detail-banner-tpocketfi"></div>

		<?php elseif($device['dvId'] === 'gears3frontier') :?>
		<Br/><br/>
		<div class="detail-banner-gear"><!--<a href="/gift/155" class="detail-banner-link js-layerViewToggle" target="layerView"></a>--></div>		

		<?php elseif(isContain('joon',$device['dvId']) === true || $device['dvId'] === 'linekidsphone') :?>
		<Br/><br/>
		<div class="detail-banner-kiz-pc"><img src="http://lmjdev.tplanit.co.kr/img/openmarket_kiz_mecard.jpg"></div>
		<div class="detail-banner-kiz-mobile"><img src="http://lmjdev.tplanit.co.kr/img/openmarket_kiz_mecard-mobile.jpg"></div>
		<?php endif?>
		
		<button class="detail-apply-submit btn-filled js-trackLink" id="link-detail-plan-apply">신청하기</button>
	</form>
	
	<h2 class="tit center">		
		<div class="tit-affix" >★포인트 : <span class="js-point">0</span> <span class="js-egg11gEvent txt-highlight" style="display:none">(추가지급이벤트)</span></div>
		선택할 수 있는 사은품
	</h2>
	<?php 	require_once(PATH_PRD."/gifts.inc.php");	?>
	<?php
	if($device['dvCate'] == 'pocketfi')
	require("./reviewpocketfi.php");	
	?>
	
<!--
	<div class="wrap">
		<section class="gift-notice">
			<div class="gift-notice-wrap">
				<i class="ico-gift-notice"></i>
				<span class="gift-notice-txt">사은품은 해피콜 시 말씀해주세요!</span>
			</div>
		</section>
	</div>
-->
	<div class="wrap">
	<section class="way">
		<h2 class="tit center">
			구매방법
		</h2>
		<ul class="detail-progress-wrap">
			<li class="detail-progress-item-wrap">
				<div class="detail-progress-item">
					<span>1.</span>
					<i class="detail-progress-ico-search"></i>
					<div class="detail-progress-cont">
						원하시는 상품을 선택 후, 가입형태를 선택합니다.(신규, 기변, 번호이동)
					</div>
				</div>
			</li>
			
			<li class="detail-progress-item-wrap">
				<div class="detail-progress-item">
					<span>2.</span>
					<i class="detail-progress-ico-apply"></i>
					<div class="detail-progress-cont">
						원하시는 요금제를 선택해 신청서를 작성합니다.
					</div>
				</div>
			</li>
			<li class="detail-progress-item-wrap">
				<div class="detail-progress-item">
					<span>3.</span>
					<i class="detail-progress-ico-tel"></i>
					<div class="detail-progress-cont">
						개통 실시 이전, 해피콜을 통해 가입정보 확인을 합니다.
					</div>
				</div>
			</li>
			<li class="detail-progress-item-wrap">
				<div class="detail-progress-item">
					<span>4.</span>
					<i class="detail-progress-ico-delivery"></i>
					<div class="detail-progress-cont">
						개통 후, 기기와 사은품을 함께 배송해드립니다.(당일 퀵/택배 발송)
					</div>
				</div>
			</li>
		</ul>
	</section>	
	<section class="detail-guide-wrap">
		<h2 class="tit center">		
			<i class="detail-ico-caution"></i>
			유의사항		
		</h2>
		<?php
		include('./detailCaution.skin.php');
		?>
	</section>
	</div>
</div>


<script>
$(function(){
	require([ 
		'Chart.min'
	], function (chart) {
		var ctx = document.getElementById("supportChart").getContext("2d");
		var data = {
			labels: 
				[
					<?php
						foreach($devicePlanGraph as $val) {
							if($graphComma)
								echo $graphComma;
							$graphComma = ',';
							echo "'".$val[spDate]."'";
						}
					?>
				],
			datasets: [
				{
					label: "공시지원금",
					fillColor: "rgba(255,192,51,0.2)",
					strokeColor: "rgba(255,192,51,1)",
					pointColor: "rgba(255,192,51,1)",
					pointStrokeColor: "#fff",
					pointHighlightFill: "#fff",
					pointHighlightStroke: "rgba(255,192,51,1)",
					data: 
						[
							<?php
								$graphComma = '';
								foreach($devicePlanGraph as $val) {
									if($graphComma)
										echo $graphComma;
									$graphComma = ',';
									echo $val[spSupport];
								}
							?>
						]
				}
			]
		};
		var options = {
			responsive : true,
			scaleGridLineColor : "rgba(0,0,0,0)",
			scaleShowLabels: false,
			maintainAspectRatio: false,
			scaleShowGridLines : false,
			<?php if($isGraphChanged == true) :?>
			scaleOverride : true,
			scaleSteps : <?php echo $graphStep?>,
			scaleStepWidth :<?php echo $graphStepGap?>,
			scaleStartValue : <?php echo $graphStartValue?>,
			<?php endif?>
			tooltipTemplate: "<%= setPriceComma(value) %>원",
			percentageInnerCutout : 70,
			tooltipCaretSize: 0,
			showTooltips: true,
			onAnimationComplete: function()
			{   
				this.showTooltip(this.datasets[0].points, true);
			},
			tooltipEvents: []
		}
		
		supportChart = new Chart(ctx).Line(data, options);
	});
});
/*  알림이벤트 코드
$('.js-applyAlarmEggEvent').click(function(){
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
*/
</script>