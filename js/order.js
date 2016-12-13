$(function(){
	require([ 
		'validate'
	], function (chart) {
		$('#order-form').parsley({
			errorsWrapper: '<ul class="parsley-errors-cart"></ul>'
		});
	});

});

$('.js-goodMny').val($('.js-totalResultCash').val());

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
	$('.js-orderRowResult').each(function(index,item){
		console.log(item);
		if ($(item).parents('tr.removing').size() == 0)
			$totalResult = $totalResult +  parseInt($(item).attr('data-result'));
	});
	$('.js-totalResult').text(setNumComma($totalResult));
	$('.js-totalResultInp').val($totalResult);
	var $resultPoint = parseInt($('.js-totalResultPoint').val());		// 현금값이 입력되면 숫자로 형변환 후에 대입
	var $resultCash = $totalResult - $resultPoint;
	$('.js-totalResultCash').val($resultCash);
	$('.js-goodMny').val($resultCash);
	// $('.js-totalResultCash').val(0);
};

$('.js-totalResultCash').focus(function(event){
	this.select();
});

$('.js-totalResultPoint').focus(function(event){
	this.select();
});



$('.js-totalResultCash').on('change keyup', function(event){
	// if($('.js-totalResultCash').val().length >= $('.js-totalResultInp').val().length) {
	// if($('.js-totalResultCash').val().length >= 3) {
		var $resultCash = parseInt($('.js-totalResultCash').val());		// 현금값이 입력되면 숫자로 형변환 후에 대입
		var $resultInp = parseInt($('.js-totalResultInp').val());		// 해당 변수의 값을 가져와 형변환 후 대입
		var $mbPoint = parseInt($('.js-mbPoint').val());

		if ($resultInp > $mbPoint) {
			if (!$resultCash || $resultCash < 0) {
			// if ($resultCash < 0) {
				$('.js-totalResultCash').val($resultInp-$mbPoint);
				$resultCash = $resultInp-$mbPoint;
			} else if($resultCash < $resultInp-$mbPoint) {
				$('.js-totalResultCash').val($resultInp-$mbPoint);
				$resultCash = $resultInp-$mbPoint;		
			} else if($resultCash > $resultInp) {
				$('.js-totalResultCash').val($resultInp);
				$resultCash = $resultInp;
			}

			var $resultPoint = $resultInp-$resultCash;


			$('.js-totalResultPoint').val($resultPoint);
			$('.js-goodMny').val($resultCash);
		} else {
			if (!$resultCash || $resultCash < 0) {
			// if ($resultCash < 0) {
				$('.js-totalResultCash').val(0);
				$resultCash = 0;
			} else if($resultCash > $resultInp) {
				$('.js-totalResultCash').val($resultInp);
				$resultCash = $resultInp;
			}

			var $resultPoint = $resultInp-$resultCash;
			$('.js-totalResultPoint').val($resultPoint);
			$('.js-goodMny').val($resultCash);
		}
	// }
});

$('.js-totalResultPoint').on('change keyup', function(event) {
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
	// }
});


