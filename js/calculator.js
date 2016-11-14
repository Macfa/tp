setCalcHeight();
var $arrPlanData = [];
var $isLoadedData = [];

$(window).resize(function(){
	setCalcHeight();
});

$('.js-calcPad input[type=radio], .js-calcPad select').change(function(){
	var $applyType = $('[name=applyType]:checked').val();
	var $discountType = $('[name=discountType]:checked').val();
	var $plan = $('[name=plan]').val();
	if ($('[name=containVat]:checked').val()>0)
		var $isContainVAT = true;
	else
		var $isContainVAT = false;

	if ($('[name=capacity]').size() > 0) {
		var $capacity = $('[name=capacity]:checked').val();
		var $affixCapacityKey = '-'+$capacity;
	} else {
		var $capacity = undefined;
		var $affixCapacityKey = '';
	}
	var $isSelectPlanDiscount = ($discountType == 'selectPlan')?true:false;

	if($('.js-id').val() == 'galaxys7edge' && $capacity == '64G') {
		alert('갤럭시S7엣지 64G는 현재 판매하지 않습니다.');
		$('[name=capacity][value=32G]').prop('checked', true);
	}

	var $data = {
		capacity : $capacity,
		discountType : $discountType,
		applyType : $applyType,
		plan : $plan,
		id : $('.js-id').val(),
		token : $('.js-token').val()
	 };

	//ajax 통신으로 데이터를 받아옴

	if ($isLoadedData[$plan+'-'+$applyType+'-'+$discountType+$affixCapacityKey] == undefined) {
		$.ajax({
			url:'/product/detailGetPlan.php',
			type:'post',
			async:false,
			data:$data,
			success:function(data){
				console.log(data);
				$isLoadedData[$affixCapacityKey+$plan] = true;
				if ($arrPlanData[$capacity] == undefined) $arrPlanData[$capacity] = [];
				$arrPlanData[$capacity][$plan] = $.parseJSON(data);
			}
		});
	}
	

	$targetData = $arrPlanData[$capacity][$plan];

	//console.log($targetData);

	var $retailPrice = parseInt($targetData['dvRetailPrice']);
	var $retailPricePerMonth = Math.round($retailPrice/24);

	var $supportAmount = parseInt($targetData['spSupport']);
	var $supportAmountPerMonth = Math.round($supportAmount/24);

	var $addSupportAmount = parseInt($targetData['spAddSupport']);
	var $addSupportAmountPerMonth = Math.round($addSupportAmount/24);

	var $resultDevicePrice = ($isSelectPlanDiscount)? $retailPrice : $retailPrice-($supportAmount + $addSupportAmount);
	var $resultDevicePricePerMonth = Math.round($resultDevicePrice/24);

	var $resultDevicePriceVAT = parseInt($targetData['repayment'])*24;
	var $resultDevicePricePerMonthVAT = $targetData['repayment'];

	$resultDevicePrice = ($isContainVAT)? $resultDevicePriceVAT : $resultDevicePrice;
	$resultDevicePricePerMonth = ($isContainVAT)? $resultDevicePricePerMonthVAT : $resultDevicePricePerMonth;

	var $planFeePerMonth = parseInt($targetData['planFee']);
	var $planFee = $planFeePerMonth*24;

	var $planFeePerMonthVAT = Math.round($planFeePerMonth * 1.1);
	var $planFeeVAT = $planFeePerMonthVAT*24;

	$planFeePerMonth = ($isContainVAT)?$planFeePerMonthVAT : $planFeePerMonth;

	var $selectPlanDiscountPerMonth = ($isSelectPlanDiscount)?Math.round(parseInt($targetData['selectPlanDiscount']/24)):0;
	var $selectPlanDiscount = ($isSelectPlanDiscount)?$selectPlanDiscountPerMonth*24:0;

	var $result = $resultDevicePricePerMonth + $planFeePerMonth - $selectPlanDiscountPerMonth;

	var $availablePoint = parseInt($targetData['rewardPoint'][$discountType][$applyType]);

	var $mbPoint = parseInt($('.js-totalResultInp').attr('data-mb-point'));

	$mbPoint = ($mbPoint>0)?$mbPoint : 0;

	$('.js-retailPrice').text(setNumComma($retailPrice));
	$('.js-retailPricePerMonth').text(setNumComma($retailPricePerMonth));

	$('.js-support').text(setNumComma($supportAmount));
	$('.js-supportPerMonth').text(setNumComma($supportAmountPerMonth));

	$('.js-addSupport').text(setNumComma($addSupportAmount));
	$('.js-addSupportPerMonth').text(setNumComma($addSupportAmountPerMonth));

	$('.js-planFeePerMonth').text(setNumComma($planFeePerMonth));

	$('.js-selectPlanDiscount').text(setNumComma($selectPlanDiscount));
	$('.js-selectPlanDiscountPerMonth').text(setNumComma($selectPlanDiscountPerMonth));

	$('.js-result').text(setNumComma($result));

	if ($isSelectPlanDiscount) {
		$('.calc-select-plan').addClass('active');
		$('.calc-support-discount').removeClass('active');
	}else {
		$('.calc-support-discount').addClass('active');
		$('.calc-select-plan').removeClass('active');
	}

	if($availablePoint > 0) {
		$('.js-availablePointRow').show();
		$('.js-availablePointCalc').text(setNumComma($availablePoint));
		$('.js-availablePoint').text(setNumComma($availablePoint+parseInt($mbPoint)));
		$('.js-totalResultInp').val($availablePoint + $mbPoint).attr('data-parsley-max', $availablePoint + $mbPoint);
	}
	
});

function setCalcHeight(){
	if ($(document).width() < 640) {
		$('.calc-result-wrap').css({height:'35%'});
		return false;
	}
	$('.calc-result-wrap').height($('.calc-wrap').height()).addClass('active');
}


