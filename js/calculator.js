setCalcHeight();
var $arrPlanData = [];
var $arrPad = [];
var $prevCarrier = $('[name=carrier]:checked').val();

$(window).resize(function(){
	setCalcHeight();
});

$('.js-calcPad input[type=radio], .js-calcPad select').change(function(){
	var $carrier = $('[name=carrier]:checked').val();

	var $data = {
		carrier : $carrier,
		id : $('.js-id').val(),
		token : $('.js-token').val()
	};

	if($arrPad[$carrier] == undefined) {
		console.log($data);
		$.ajax({
			url:'/product/getPlanCalculatorPad.php',
			type:'post',
			async:false,
			data:$data,
			success:function(data){
				//console.log(data);
				$arrPad[$carrier] = $.parseJSON(data);
			}
		});
	}

	if ($prevCarrier != $carrier) {
		$('.js-planCalcArg').html('');
		$.each($arrPad[$carrier]['plan'], function($plan, $value){
			var $templateData = [];
			$templateData['name'] = $value['name'];
			$templateData['info'] = $value['info'];
			$templateData['value'] = $plan;
			var $planOption = getResultTemplate($('#js-planSelectOptionTemplate').html(), $templateData);
			$('.js-planCalcArg').append($planOption);
		});
		$prevCarrier = $carrier;
	}

	var $applyType = $('[name=applyType]:checked').val();
	var $discountType = $('[name=discountType]:checked').val();
	var $plan = $('[name=plan]').val();
	if ($('[name=containVat]:checked').val()>0)
		var $isContainVAT = true;
	else
		var $isContainVAT = false;

	if ($('[name=capacity]').size() > 0) {
		var $capacity = $('[name=capacity]:checked').val();
	} else {
		var $capacity = undefined;
	}
	var $isSelectPlanDiscount = ($discountType == 'selectPlan')?true:false;

	var $isRequiredCarrier = ($('[name=carrier]').size()>=2)?true:false;
	var $isRequiredApplyType = ($('[name=applyType]').size()>=2)?true:false;
	var $isRequiredCapacity = ($('[name=capacity]').size()>=2)?true:false;
	var $isRequiredDisocuntType = ($('[name=discountType]').size()>=2)?true:false;

	var $isSelectedCarrier = ($carrier!=undefined)?true:false;
	var $isSelectedApplyType = ($applyType!=undefined)?true:false;
	var $isSelectedCapacity = ($capacity!=undefined)?true:false;
	var $isSelectedDisocuntType = ($discountType!=undefined)?true:false;

	if(
		($isSelectedCarrier == false && $isRequiredCarrier == true)
		||($isSelectedApplyType == false && $isRequiredApplyType == true)
		||($isSelectedCapacity == false && $isRequiredCapacity == true)
		||($isSelectedDisocuntType == false && $isRequiredDisocuntType == true)
	) return false;

	$data = {
		carrier : $carrier,
		capacity : $capacity,
		discountType : $discountType,
		applyType : $applyType,
		plan : $plan,
		id : $('.js-id').val(),
		token : $('.js-token').val()
	};

	//console.log($data);

	//ajax 통신으로 데이터를 받아옴
	var $key = $carrier+'-'+$plan+'-'+$applyType+'-'+$discountType;
	
	if($capacity != undefined)
		$key = $key+'-'+$capacity;

	if ($arrPlanData[$key] == undefined) {
		$.ajax({
			url:'/product/detailGetPlan.php',
			type:'post',
			async:false,
			data:$data,
			success:function(data){
				//console.log(data);
				$data = $.parseJSON(data);
				$arrPlanData[$key] = $data;
			}
		});
	}

	

	$targetData = $arrPlanData[$key];

	//console.log($targetData);

	var $retailPrice = parseInt($targetData['dvRetailPrice']);
	var $retailPricePerMonth = Math.round($retailPrice/24);

	var $supportAmount = parseInt($targetData['spSupport']);
	var $supportAmountPerMonth = Math.round($supportAmount/24);

	var $addSupportAmount = parseInt($targetData['spAddSupport']);
	var $addSupportAmountPerMonth = Math.round($addSupportAmount/24);

	var $resultDevicePrice = ($isSelectPlanDiscount)? $retailPrice : $retailPrice-($supportAmount + $addSupportAmount);
	var $resultDevicePricePerMonth = Math.round($resultDevicePrice/24);

	var $resultDevicePriceInterest= parseInt($targetData['repayment'])*24;
	var $resultDevicePricePerMonthInterest = $targetData['repayment'];

	var $interestRate = $targetData['interestRate'];

	$resultDevicePrice = ($isContainVAT)? $resultDevicePriceInterest: $resultDevicePrice;
	$resultDevicePricePerMonth = ($isContainVAT)? $resultDevicePricePerMonthInterest : $resultDevicePricePerMonth;

	var $planFeePerMonth = parseInt($targetData['planFee']);
	var $planFee = $planFeePerMonth*24;

	var $planFeePerMonthVAT = Math.round($planFeePerMonth * 1.1);
	var $planFeeVAT = $planFeePerMonthVAT*24;

	var $selectPlanDiscountPerMonth = ($isSelectPlanDiscount)?Math.round(parseInt($targetData['selectPlanDiscount'])):0;
	var $selectPlanDiscount = ($isSelectPlanDiscount)?$selectPlanDiscountPerMonth*24:0;

	var $planFeeResultPerMonth = (($isContainVAT)?$planFeePerMonthVAT : $planFeePerMonth)-$selectPlanDiscountPerMonth;

	var $result = $resultDevicePricePerMonth + $planFeeResultPerMonth;

	var $availablePoint = $targetData['rewardPoint'];

	var $mbPoint = parseInt($('.js-totalResultInp').attr('data-mb-point'));

	$mbPoint = ($mbPoint>0)?$mbPoint : 0;

	$('.js-retailPrice').text(setNumComma($retailPrice));
	//$('.js-retailPricePerMonth').text(setNumComma($retailPricePerMonth));
	$('.js-resultDevicePricePerMonth').text(setNumComma($resultDevicePricePerMonth));
	if($discountType == 'support') {
		$('.js-support').text(setNumComma($supportAmount));
		//$('.js-supportPerMonth').text(setNumComma($supportAmountPerMonth));
		$('.js-addSupport').text(setNumComma($addSupportAmount));
		//$('.js-addSupportPerMonth').text(setNumComma($addSupportAmountPerMonth));
	}else if($discountType == 'selectPlan') {
		$('.js-selectplan').text(setNumComma($selectPlanDiscountPerMonth));

	}

	if ($isContainVAT == true) {
		$('.js-VAT').text(setNumComma($planFeePerMonthVAT-$planFeePerMonth));
		$('.js-interestRate').text($interestRate);
		if($carrier == 'kt')
			$('.js-repaymentType').text('연이자율');
		else
			$('.js-repaymentType').text('복리');
	} else {
		$('.js-VATWrap, .js-interestWrap').removeClass('active');
	}

	$('.js-planFee').text(setNumComma($planFeePerMonth));
	$('.js-planFeeResult').text(setNumComma($planFeeResultPerMonth));
	
	//$('.js-selectPlanDiscount').text(setNumComma($selectPlanDiscount));
	//$('.js-selectPlanDiscountPerMonth').text(setNumComma($selectPlanDiscountPerMonth));

	$('.js-result').text(setNumComma($result));
	$('.js-point').text(setNumComma($availablePoint));
	$('.js-key').val($targetData['dvKey']);

	if ($isSelectPlanDiscount) {
		$('.js-selectplanWrap').addClass('active');
		$('.js-supportWrap').removeClass('active');
	} else {
		$('.js-supportWrap').addClass('active');
		$('.js-selectplanWrap').removeClass('active');
	}

	if ($isContainVAT == true) {
		$('.js-VATWrap, .js-interestWrap').addClass('active');
	} else {
		$('.js-VATWrap, .js-interestWrap').removeClass('active');
	}

	if($availablePoint > 0) {
		$('.js-availablePointRow').show();
		$('.js-availablePointCalc').text(setNumComma($availablePoint));
		$('.js-availablePoint').text(setNumComma($availablePoint+parseInt($mbPoint)));
		$('.js-totalResultInp').val($availablePoint + $mbPoint).attr('data-parsley-max', $availablePoint + $mbPoint);
	}

	//-------------------------------------------------
});

$('.js-calculatorDetailToggle').click(function(){
	$('.js-calculatorResult').toggleClass('active');
});


function setCalcHeight(){
	//console.log('document:'+ $(document).width());
	//console.log('window:'+ $(window).width());
	if ($(document).width() < 623) {
		$('.calc-result-wrap').css({height:'25%'});
	} else {
		$('.calc-result-inner').removeClass('active');
		$('.calc-result-wrap').height($('.js-calcPad').height());
	}
	$('.calc-result-wrap').addClass('active');
}



