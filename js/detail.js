$(function(){

	$('[name=planType]').change(function(){
		if($(this).val() == 'support') {//공시지원금
			$('.js-supportRow').addClass('active');
			$('.js-planDiscountRow').removeClass('active');
		}else if($(this).val() == 'planDiscount') {//요금약정할인
			$('.js-planDiscountRow').addClass('active');
			$('.js-supportRow').removeClass('active');
		}
	});

	$('[name=familydc]').change(function(){
		if($(this).val() == '0') {//해당없음, 10년 미만
			$('.js-familyDiscountRow').removeClass('active');
		}else {//요금약정할인
			$('.js-familyDiscountRow').addClass('active');
		}
	});
	
	setInterval(function() {
		if (didScroll) {
			var $header = $('.nav-device-wrap');
			var st = $(this).scrollTop();
			var $isScrollDown = false;
			var $isHeaderOut = false;
			var $inHeader = false;
			var $isShow = false;
			
			// Make sure they scroll more than delta
			if(Math.abs(lastScrollTop - st) <= delta)
				return;

			if (st > lastScrollTop)
				$isScrollDown = true;

			if (st > 250)
				$isHeaderOut = true;

			if ($header.hasClass('active') == false)
				$isShow = true;

			if ($isHeaderOut && $isScrollDown)
				$header.removeClass('active');

			if (!$isHeaderOut || !$isScrollDown)
				$header.addClass('active');

			lastScrollTop = st;
		}
	}, 50);

	$(window).on('scroll, touchmove', function(){
		controlCalcResult();
	});

	$('.tab-btn').click(function(){
		$($(this).attr('data-target')).siblings('div').hide();
		$($(this).attr('data-target')).show();
	});

	require([ 
		'Chart.min'
	], function (chart) {
		 $('.js-planCalcArg, .js-containVat').change(function(){

			 //ajax 통신에 필요한 변수 정의
			 if ($('[name=capacity]').length > 0) 
				$selectedCapacity = $('[name=capacity]:checked').val();
			 else if ($('.js-capacity').length > 0) 
				$selectedCapacity = $('.js-capacity').val();
			 else
				$selectedCapacity = 'noCapacity';

			 if ($('[name=applyType]').length > 0) 
				$selectedApplyType = $('[name=applyType]:checked').val();
			 else 
				$selectedApplyType = $('.js-applyType').val();

			 if ($('[name=discountType]').length > 0) 
				$selectedDcType = $('[name=discountType]:checked').val();
			 else 
				$selectedDcType = $('.js-dcType').val();

			 $selectedPlan = $('[name=plan]').val();
			 $selectedContainVatInterest = $('[name=containVat]:checked').val();

			 if ($selectedCapacity && $selectedApplyType && $selectedPlan){
				 var $isShowApplyBtn = true;
			 }
			//console.log($selectedDcType);
			var $arrPlanData = [];
			var $planData = {
				dataCapacity : $selectedCapacity,
				discountType : $selectedDcType,
				plan : $selectedPlan,
				id : $('.js-id').val(),
				token : $('.js-token').val(),
			 };

			if ($arrPlanData[$selectedCapacity] === undefined)
				$arrPlanData[$selectedCapacity] = [];

			//ajax 통신으로 데이터를 받아옴
			if ($arrPlanData[$selectedCapacity][$selectedPlan] === undefined) {
				$.ajax({
					url:'/product/detailGetPlan.php',
					type:'post',
					async:false,
					data:$planData,
					success:function(data){
						//console.log(data);
						$arrPlanData[$selectedCapacity][$selectedPlan] = $.parseJSON(data);
						
					}
				});
			}

			// 받아온 데이터를 후처리한후 요금제 계산기에 기입
			var $resultDiscount = 0;
			var $feeDiscount = 0;
			var $selectPlanDiscountPerMonth = 0;

			$targetObj = $arrPlanData[$selectedCapacity][$selectedPlan];
	
			if ($selectedDcType == 'selectPlan') {
				$feeDiscount = parseInt($targetObj['selectPlanDiscount']);
				$selectPlanDiscountPerMonth = $targetObj['selectPlanDiscountPerMonth'];
			} else if ($selectedDcType == 'support') {
				$resultDiscount = parseInt($targetObj['spSupport']) + parseInt($targetObj['spAddSupport']);
			}

			if ($selectedContainVatInterest == 1) {
				var $originInstallation = $targetObj['repayment'] * 24;
				var $result =  parseInt($targetObj['repayment']) + Math.floor($targetObj['planFee'] * 1.1) - ($feeDiscount/24);
				var $planFee = Math.floor($targetObj['planFee'] * 1.1);
			}else{
				var $originInstallation = parseInt($targetObj['dvRetailPrice']) - $resultDiscount;
				var $result = Math.floor($originInstallation/24) - $selectPlanDiscountPerMonth + parseInt($targetObj['planFee']);
				var $planFee = $targetObj['planFee'];
			}

			$('.js-retailPrice').text(setPriceComma($targetObj['dvRetailPrice']));
			$('.js-retailPricePerMonth').text(setPriceComma(Math.floor($targetObj['dvRetailPrice']/24)));

			if ($selectedDcType == 'selectPlan') {
				$('.js-selectPlanDcRow').addClass('active');
				$('.js-supportRow').removeClass('active');

				$('.js-selectPlanDc').text(setPriceComma($selectPlanDiscountPerMonth*24));
				$('.js-selectPlanDcPerMonth').text(setPriceComma($selectPlanDiscountPerMonth));
			} else if ($selectedDcType == 'support') {
				$('.js-supportRow').addClass('active');
				$('.js-selectPlanDcRow').removeClass('active');

				$('.js-support').text(setPriceComma($targetObj['spSupport']));
				$('.js-supportPerMonth').text(setPriceComma(Math.floor($targetObj['spSupport']/24)));

				$('.js-addSupport').text(setPriceComma($targetObj['spAddSupport']));
				$('.js-addSupportPerMonth').text(setPriceComma(Math.floor($targetObj['spAddSupport']/24)));
			}

			if ($selectedContainVatInterest == 1) {
				$('.js-retailPriceOriginInstallation, .js-retailPriceInstallation, .js-planFee, .js-planResult').addClass('detail-contain');
			}else{
				$('.js-retailPriceOriginInstallation, .js-retailPriceInstallation, .js-planFee, .js-planResult').removeClass('detail-contain');
			}

			$('.js-retailPriceOriginInstallation').text(setPriceComma($originInstallation));
			$('.js-retailPriceInstallation').text(setPriceComma(Math.floor($originInstallation/24)));
			$('.js-planFee').text(setPriceComma($planFee));		
			$('.js-planResult').text(setPriceComma($result));
			var $availablePoint = $targetObj['rewardPoint'][$selectedDcType][$selectedApplyType];

			if($availablePoint > 0 && $availablePoint != undefined) {
				$('.js-availablePoint').text(setNumComma($availablePoint) + '별');
			}else{
				$('.js-availablePoint').text('선택사항을 모두 선택해주세요');
			}

			$('.detail-apply-submit').attr('href', $targetObj['applyUrl'][$selectedApplyType]);
			
			//console.log(JSON.stringify($targetObj));
			if ($('html').hasClass('lte-ie8')){
				var ctx = document.getElementById("supportChart").getContext("2d");
				var ctxWidth = ctx.width;
				var ctxHeight = ctx.Height;
				ctx.clearRect(0, 0, ctxWidth, ctxHeight);
				var data = {
					labels: $targetObj['supportGraph']['spDate'],
					datasets: [
						{
							label: "공시지원금",
							fillColor: "rgba(255,192,51,0.2)",
							strokeColor: "rgba(255,192,51,1)",
							pointColor: "rgba(255,192,51,1)",
							pointStrokeColor: "#fff",
							pointHighlightFill: "#fff",
							pointHighlightStroke: "rgba(255,192,51,1)",
							data: $targetObj['supportGraph']['spSupport']
						}
					]
				};
				var options = {
					responsive : true,
					scaleGridLineColor : "rgba(0,0,0,0)",
					scaleShowLabels: false,
					maintainAspectRatio: false,
					scaleShowGridLines : false,
					tooltipTemplate: "<%= setPriceComma(value) %>원",
					percentageInnerCutout : 70,
					tooltipCaretSize: 0,
					showTooltips: true,
					onAnimationComplete: function()	{   
						this.showTooltip(this.datasets[0].points, true);
					},
					tooltipEvents: []
				}
				if ($targetObj['isGraphChanged'] == true){
					options['scaleOverride'] = true;
					options['scaleSteps'] = $targetObj['graphStep'];
					options['scaleStepWidth'] = $targetObj['graphStepGap'];
					options['scaleStartValue'] = $targetObj['graphStartValue'];
				}
				supportChartIe = new Chart(ctx).Line(data, options);
			}else {
				var $arrTmpPoint = supportChart.datasets[0].points;
				for (var $key in $targetObj['supportGraph']['spSupport']) {
					if ($arrTmpPoint[$key] != undefined) {
						supportChart.datasets[0].points[$key] = $arrTmpPoint[$key];
						supportChart.datasets[0].points[$key].value = $targetObj['supportGraph']['spSupport'][$key];
					} else 
						supportChart.addData('['+$targetObj['supportGraph']['spSupport'][$key]+']', '['+$targetObj['supportGraph']['spDate'][$key]+']');
				}
				supportChart.scale.xLabels = $targetObj['supportGraph']['spDate'];
				supportChart.scale.valuesCount = $targetObj['supportGraph']['spSupport'].length;
				supportChart.scale.steps = $targetObj['graphStep'];
				supportChart.scale.stepValue = $targetObj['graphStepGap'];
				supportChart.scale.min = $targetObj['graphStartValue'];
				supportChart.scale.max = $targetObj['graphStartValue'] + $targetObj['graphStepGap']*$targetObj['graphStep'];
				supportChart.scale.yLabels = $targetObj['graphStepYLabels'];

				//console.log(JSON.stringify($targetObj));
				//console.log(JSON.stringify(supportChart));
				//console.log(JSON.stringify(supportChart));
				supportChart.update();

			}

			// .js-planCalcArg 가 모두 선택되어 있을때 가입하기 버튼이 나타남
			if ($isShowApplyBtn == true) {
				$('.detail-apply-submit').removeClass('disabled');
			}
		});
	});
});

function controlCalcResult(){
	if (250 < $(document).scrollTop() && $(document).scrollTop() < 970) {
		$('.js-calcResultMobile').addClass('active');
	}else{
		$('.js-calcResultMobile').removeClass('active');
	}
}