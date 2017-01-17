$(function(){
	require([ 
		'validate'
	], function (chart) {
		$('#order-form').parsley({
			errorsWrapper: '<ul class="parsley-errors-cart"></ul>'
		});
	});

	setOrderTotalResult();

});

$('.js-orderQuantity').on('change keyup', function(event){
	var $key = $(this).attr('data-key');
	var $quantity = $(this).val();
	if ($quantity < 1) {
		$quantity = 1;
		$(this).val(1);
	}
	var $rowResult = $quantity * $(this).attr('data-point');
	$('.js-orderRowResult'+$key).text(setNumComma($rowResult)).attr('data-result', $rowResult);
	setOrderTotalResult();
	//$('[name=onlyPay][value=cashOnlyPay]').prop('checked',true);
	//$('[name=onlyPay][value=pointOnlyPay]').prop('checked',false);
	//$('[name=resultPoint]').val(0);

});

$('.js-orderDelete').click(function(){
	var $key = $(this).attr('data-key');
	$('.js-orderRow'+$key).addClass('removing').children('td').wrapInner('<div />').children().slideUp();
	setTimeout(function(){$('.js-orderRow'+$key).remove();},500);
	setOrderTotalResult();
	return false;
});

$('.js-orderQuantity').focus(function(){
	this.select();
});

$('.js-newAddress').click(function(){
	initAddress();
	return false;
});

function initAddress(){
	var $target = $('.js-addressWrap input[type=text]');
	$target.val('');
	setLabel('.js-addressWrap input[type=text]');
	$('.js-defaultAddress').prop('checked','');
}

function setOrderTotalResult(){
	var $totalResult = 0;
	var $shipping = parseInt($('.js-shipping').val());
	$('.js-orderRowResult').each(function(index,item){
		//console.log(item);
		if ($(item).parents('tr.removing').size() == 0)
			$totalResult = $totalResult +  parseInt($(item).attr('data-result'));
	});
	$totalResult += $shipping;
	$('.js-totalResult').text(setNumComma($totalResult));
	$('.js-totalResultInp').val($totalResult);

	var $resultPoint = parseInt($('.js-totalResultPoint').val());		// 현금값이 입력되면 숫자로 형변환 후에 대입
	// alert($totalResult+' '+$resultPoint);
	var $mbPoint = parseInt($('.js-mbPoint').val());
	var $payType = $('[name=onlyPay]:checked').val();

	if($payType == 'pointOnlyPay' && $totalResult <= $mbPoint) {
		$resultPoint = $totalResult;
	}

	
	// console.log($totalResult < $mbPoint);
	// if($resultCash >= 0) {
	if($payType == 'cashOnlyPay') {
		$('.js-totalResultPoint').val(0);
		$('.js-totalResultCash, .js-goodMny').val($totalResult);
	} else if($payType == 'pointOnlyPay') { 
		if($totalResult <= $mbPoint ){ // 포인트로만 살수 있을때
			$('.js-totalResultPoint').val($totalResult);
		
			var $resultCash = (($totalResult-$resultPoint) > 0)?$totalResult-$resultPoint:0;
			$('.js-totalResultCash, .js-goodMny').val($resultCash);
		
		}else{ //포인트로만 살수 없을때
			//총 결제 금액 - 보유중인 포인트가 0이하면 0으로 교체
			var $resultCash = (($totalResult-$mbPoint) > 0)?$totalResult-$mbPoint:0;

			$('.js-totalResultPoint').val($mbPoint);
			$('.js-totalResultCash, .js-goodMny').val($resultCash);
		}	

	}

	//현금결제액이 0원이면 현금결제 관련 요소들이 사라지게
	if($resultCash == 0){
		$('.js-payCashComponent').hide();
	}else{
		$('.js-payCashComponent').show();
	}
};

$('.js-totalResultCash').on('change', function(event){
	// if($('.js-totalResultCash').val().length >= $('.js-totalResultInp').val().length) {
	// if($('.js-totalResultCash').val().length >= 3) {
		var $resultCash = parseInt($('.js-totalResultCash').val());		// 현금값이 입력되면 숫자로 형변환 후에 대입
		var $totalPoint = parseInt($('.js-totalResultInp').val());		// 해당 변수의 값을 가져와 형변환 후 대입
		var $mbPoint = parseInt($('.js-mbPoint').val());

		if ($totalPoint > $mbPoint) {
			if (!$resultCash || $resultCash < 0) {
			// if ($resultCash < 0) {
				$('.js-totalResultCash').val($totalPoint-$mbPoint);
				$resultCash = $totalPoint-$mbPoint;
			} else if($resultCash < $totalPoint-$mbPoint) {
				$('.js-totalResultCash').val($totalPoint-$mbPoint);
				$resultCash = $totalPoint-$mbPoint;		
			} else if($resultCash > $totalPoint) {
				$('.js-totalResultCash').val($totalPoint);
				$resultCash = $totalPoint;
			}

			
		} else {
			if (!$resultCash || $resultCash < 0) {
			// if ($resultCash < 0) {
				$('.js-totalResultCash').val(0);
				$resultCash = 0;
			} else if($resultCash > $totalPoint) {
				$('.js-totalResultCash').val($totalPoint);
				$resultCash = $totalPoint;
			}


		}
		var $resultPoint = $totalPoint-$resultCash;
		if($resultPoint > 0) $('[name=onlyPay][value=pointOnlyPay]').prop('checked',true);
		$('.js-totalResultPoint').val($resultPoint);
		$('.js-goodMny').val($resultCash);

		if($resultCash == 0){
			$('.js-payCashComponent').hide();
		}else{
			$('.js-payCashComponent').show();
		}
		//$('[name=onlyPay][value=cashOnlyPay]').prop('checked',false);
	// }
});

$('.js-totalResultPoint').on('change', function(event) {
	// if($('.js-totalResultPoint').val().length >= $('.js-totalResultInp').val().length) {
		var $chPoint = parseInt($('.js-totalResultPoint').val());
		var $chInp = parseInt($('.js-totalResultInp').val());
		var $chmbPoint = parseInt($('.js-mbPoint').val());
		if ($chInp > $chmbPoint) {
			if (!$chPoint || $chPoint < 0) {
			// if ($chPoint < 0) {
				$('.js-totalResultPoint').val(0);
				$chPoint = 0;
			} else if($chPoint > $chmbPoint) {
				$('.js-totalResultPoint').val($chmbPoint);
				$chPoint = $chmbPoint;		
			}

			$chCash = $chInp - $chPoint;
			$('.js-totalResultCash').val($chCash);
			$('.js-goodMny').val($chCash);
		} else {

			if (!$chPoint || $chPoint < 0) {
			// if ($chPoint < 0) {
				$('.js-totalResultPoint').val(0);
				$chPoint = 0;
			} else if($chPoint > $chInp) {
				$('.js-totalResultPoint').val($chInp);
				$chPoint = $chInp;		
			}

			$chCash = $chInp - $chPoint;
			$('.js-totalResultCash').val($chCash);
			$('.js-goodMny').val($chCash);
		}
	$('[name=onlyPay][value=pointOnlyPay]').prop('checked',true);


	if($chCash == 0){
		$('.js-payCashComponent').hide();
	}else{
		$('.js-payCashComponent').show();
	}
	// }
});
$('.js-defaultPoint').on('change', function(event) {
	var $mbPoint = parseInt($('.js-mbPoint').val());	

	$(this).val($mbPoint);


});


$('[name=onlyPay]').change(function(){
	var $val = $(this).val();
	var $totalPoint = parseInt($('.js-totalResultInp').val());
	var $mbPoint = parseInt($('.js-mbPoint').val());	

	if($val == 'pointOnlyPay'){ // 포인로만 결제
		
		if($totalPoint <= $mbPoint){
			
			$('[name=resultPoint]').val($totalPoint);
			$('[name=resultCash], .js-goodMny').val(0);	

		}else if($totalPoint > $mbPoint){ // 본인포인트로만 결제 할수 없을때 	
			
			$('[name=resultPoint]').val($mbPoint); // 한계를 본인 포인트까지			
			$('[name=resultCash], .js-goodMny').val($totalPoint-$mbPoint); // 그외에는 캐쉬로		

		}

	}else if($val == 'cashOnlyPay'){ // 캐쉬로만 결제
		$('[name=resultPoint]').val(0);
		$('[name=resultCash]').val($totalPoint);
		$('.js-goodMny').val($totalPoint);

	}

	if($('.js-goodMny').val() == 0){
		$('.js-payCashComponent').hide();
	}else{
		$('.js-payCashComponent').show();
	}

});

