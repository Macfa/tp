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
		<img class="detail-intro-img" src="<?php echo PATH_IMG?>/<?php echo $device['dvDetailThumb']?>"/>
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
	<form class="js-plan-calc-arg" method="post" action="/apply/<?php echo $_GET['id']?>">
	<input type="hidden" class="js-token" value="<?php echo createToken()?>"/>
	<input type="hidden" class="js-id" name="id" value="<?php echo $_GET['id']?>"/>
	<?php if ($capacityCnt == 1) :?>
	<input type="hidden" class="js-capacity js-planCalcArg" value="<?php echo $selectedCapacity?>"/>
	<?php endif?>
	<?php if ($arrApplyTypeCnt == 1) :?>
	<input type="hidden" class="js-applyType js-planCalcArg" value="<?php echo $applyTypeDefaultKey?>"/>
	<?php endif?>
	<?php if ($isNotSupportSelPlanDc === true) :?>
	<input type="hidden" class="js-dcType js-planCalcArg" value="support"/>
	<?php endif?>
	<section class="plan-calc-wrap">
		<section class="plan-calc-arg">
			<div>
				<div class="row">
					<div class="col-txt txt-bold">
						원하는 조건을 선택하세요.
					</div>
				</div>
				<?php if ($defaultVal['dvCate'] == 'watch') :?>
				<div class="row">
					<div class="col-tit">
						기기종류
					</div><div class="col-cont-wrap">
						<div class="col-inp">3G 모델</div>
					</div>
				</div>
				<?php endif?>
				<div class="row">
					<div class="col-tit">
						할부개월
					</div><div class="col-cont-wrap">
						<div class="col-inp">24개월</div>
					</div>
				</div>
				<?php if ($capacityCnt >1) :?>
				<div class="row">
					<div class="col-tit">
						용량선택
					</div><div class="col-cont-wrap">
						<?php foreach($childDevice as $child) :?><div class="col-<?php echo $capacityCnt?> radio">
							<label class="inp-radio">
								<input class="js-planCalcArg" type="radio" name="capacity" value="<?php echo $child['dvTit']?>" <?php echo $child['isChecked']?>/>
								<div class="inp-radio-btn"></div>
								<span class="inp-radio-label"><?php echo $child['dvTit']?></span>
								<div class="inp-radio-chk"></div>
							</label>
						</div><?php endforeach?>
					</div>
				</div>
				<?php endif?>
				<div class="row">
					<div class="col-tit">
						지원형태
					</div><div class="col-cont-wrap">
						<?php if ($isNotSupportSelPlanDc === false) :?>
						<div class="col-2 radio">
							<label class="inp-radio">
								<input class="js-planCalcArg" type="radio" name="discountType" value="support"/>
								<div class="inp-radio-btn"></div>
								<span class="inp-radio-label">공시지원금할인</span>
								<div class="inp-radio-chk"></div>
							</label>
						</div><div class="col-2 radio">
							<label class="inp-radio">
								<input class="js-planCalcArg" type="radio" name="discountType" value="selectPlan"/>
								<div class="inp-radio-btn"></div>
								<span class="inp-radio-label">선택약정할인</span>
								<div class="inp-radio-chk"></div>
							</label>
						</div>
						<?php else :?>
						<div class="col-inp">공시지원금 할인</div>
						<?php endif?>
					</div>
				</div>
				<div class="row">
					<div class="col-tit multiple-line">
						부가세<br/>할부이자
					</div><div class="col-cont-wrap radio">
						<div class="col-2 radio">
							<label class="inp-radio">
								<input class="js-containVat" type="radio" name="containVat" value="1"/>
								<div class="inp-radio-btn"></div>
								<span class="inp-radio-label">포함 (실청구액)</span>
								<div class="inp-radio-chk"></div>
							</label>
						</div><div class="col-2 radio">
							<label class="inp-radio">
								<input class="js-containVat" type="radio" name="containVat" value="0"/>
								<div class="inp-radio-btn"></div>
								<span class="inp-radio-label">포함안된 요금</span>
								<div class="inp-radio-chk"></div>
							</label>
						</div>
					</div>
				</div>
				<?php if ($arrApplyTypeCnt > 1) :?>
				<div class="row">
					<div class="col-tit">
						가입유형
					</div><div class="col-cont-wrap">
						<?php foreach($arrApplyType as $key => $val) :?><div class="col-<?php echo count($arrApplyType)?> radio">
							<label class="inp-radio">
								<input class="js-planCalcArg" type="radio" name="applyType" value="<?php echo $key?>" />
								<div class="inp-radio-btn"></div>
								<span class="inp-radio-label"><?php echo $val?></span>
								<div class="inp-radio-chk"></div>
							</label>
						</div><?php endforeach?>
					</div>
				</div>
				<?php endif?>
				<div class="row">
					<div class="col-tit">
						요금제
					</div><div class="col-cont-wrap radio">
						<select class="inp-select js-planCalcArg" name="plan">
							<?php 
								$tmpSelected = "selected";
								foreach($arrSelectPlan as $val) :
								if($val['spPlan'] == 9) continue;
							?>
							<option value="<?php echo $val['spPlan']?>" <?=$tmpSelected?>><?php echo $deviceInfo->getPlanName($val['spPlan'])?> : <?php echo $deviceInfo->getPlanInfo($val['spPlan'])?></option>
							<?php 
								unset($tmpSelected);
								endforeach;
							?>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-tit">
						가용포인트
					</div><div class="col-cont-wrap radio">
						<div class="col-inp js-availablePoint">
							<?php echo $defAvailablePoint?>
						</div>
					</div>
				</div>

			</div>
			<button class="detail-apply-submit btn-filled js-trackLink" id="link-detail-plan-apply">
				<?php if ($device['dvId'] == 'iphonese') :?>
				<span>사전예약 신청하기</span>
				<?php else:?>
				<span class="detail-apply-active">가입 신청</span>
				<?php endif?>
			</button>
			<div class="detail-apply-mobile center">(모바일에서는 신용카드 본인인증만 됩니다)</div>
			<!--a class="detail-apply-submit js-layerViewToggle" href="https://docs.google.com/forms/d/1tQVeoJsQHxRLTOzIqPx2-ThbXsynCn8qs8dXq189azI/viewform" id="link-detail-plan-apply" target="layerView">
				<span style="font-size:.8em">(<?php echo getRelativeDate(strtotime('2016-06-15 10:00:00'))?> 오전 10시 개통시작!) 특별사은품 증정</span>
				<br/>
				<span>예약하기</span>
			</a-->
		</section>
		<section class="plan-calc-result">
			<div class="row">
				<div class="col-txt txt-bold">
					요금제계산기
				</div>
			</div><div class="row">
				<div class="col-tit">
				</div><div class="col-cont-wrap">
					<div class="col-txt-2">
						총 액
					</div><div class="col-txt-2">
						24개월
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-tit">
					출고가
				</div><div class="col-cont-wrap int">
					<div class="col-txt-2 js-retailPrice">
						<?php echo number_format($defaultVal['dvRetailPrice'])?>
					</div><div class="col-txt-2 js-retailPricePerMonth">
						<?php echo number_format(floor($defaultVal['dvRetailPrice']/24))?>
					</div>
				</div>
			</div>
			<div class="row-responsive js-supportRow <?php echo $supportRowActive?>">
				<div class="col-tit">
					공시지원금
				</div><div class="col-cont-wrap int">
					<div class="col-txt-2 minus js-support">
						<?php echo number_format($devicePlanGraph[$devicePlanLastKey]['spSupport'])?>
					</div><div class="col-txt-2 minus js-supportPerMonth">
						<?php echo number_format(floor($devicePlanGraph[$devicePlanLastKey]['spSupport']/24))?>
					</div>
				</div>
			</div>
			<div class="last-row row-responsive js-supportRow <?php echo $supportRowActive?>">
				<div class="col-tit">
					티플 지원금
				</div><div class="col-cont-wrap int">
					<div class="col-txt-2 minus js-addSupport">
						<?php echo number_format($devicePlanGraph[$devicePlanLastKey]['spAddSupport'])?>
					</div><div class="col-txt-2 minus js-addSupportPerMonth">
						<?php echo number_format(floor($devicePlanGraph[$devicePlanLastKey]['spAddSupport']/24))?>
					</div>
				</div>
			</div>
			<div class="row row-divide">
				<div class="col-tit">
					단말기할부
				</div><div class="col-cont-wrap int">
					<div class="col-txt-2 js-retailPriceOriginInstallation">
						<?php echo number_format($defaultVal['dvDeviceInstallation'])?>
					</div><div class="col-txt-2 js-retailPriceInstallation">
						<?php echo number_format(floor($defaultVal['dvDeviceInstallation']/24))?>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-tit">
					요금제기본료
				</div><div class="col-cont-wrap int">
					<div class="col-txt-2">
					</div><div class="col-txt-2 js-planFee">
						<?php echo number_format($defaultVal['defaultPlanFee'])?>
					</div>
				</div>
			</div>
			<div class="row-responsive js-selectPlanDcRow">
				<div class="col-tit">
					선택약정할인
				</div><div class="col-cont-wrap int">
					<div class="col-txt-2 minus js-selectPlanDc js-selectPlanDc">
						<?php echo $defaultPlan['selectPlanDiscount']?>
					</div><div class="col-txt-2 minus js-selectPlanDcPerMonth js-selectPlanDcPerMonth">
						<?php echo $defaultPlan['selectPlanDiscountPerMonth']?>
					</div>
				</div>
			</div>
			<!--div class="row-responsive last-row js-familyDiscountRow">
				<div class="col-tit multiple-line">
					온가족할인<br/>(30% 할인)
				</div><div class="col-cont-wrap int">
					<div class="col-txt-2 minus">
						65256
					</div><div class="col-txt-2 minus">
						4523
					</div>
				</div>
			</div-->
			<div class="row row-divide">
				<div class="col-tit">
					월청구액
				</div><div class="col-cont-wrap int">
					<div class="col-txt-2">
					</div><div class="col-txt-2 js-planResult">
						<?php echo number_format($defaultVal['defaultPlanFee'] + floor($defaultVal['dvDeviceInstallation']/24))?>
					</div>
				</div>
			</div>
		</section>
	</section>
	</form>

	<h2 class="tit center">		
		<div class="tit-affix">하늘에서 내려온 호갱구세주!</div>
		티플이 드리는 미친 사은품
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

	<?php
	include('./detailCaution.skin.php');
	?>
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
</script>