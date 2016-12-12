
var $arrPlanData = [];
var $isLoadedData = [];

$(function(){
	
	$('.inp-txt, .inp-num').each(function(index,item){
		setLabel(item);
	});
});


$('.js-goGiftSelect').click(function(){
	$('html, body').animate({
		scrollTop: $($(this).attr('href')).offset().top
	}, 800, 'swing');
	return false;
});

$(window).resize(function(){
	
});

$(window).scroll(function(){
	
});

$(document).on('focus', '.js-applyCartQuantity', function(){
	this.select();
});

$(document).on('click', '.js-applyCartDelete', function(){
	var $key = $(this).attr('data-key');
	var $target = $('.js-applyCartRow'+$key);
	if ($('.js-applyCartRow').size() == 1) $('.js-applyCartList').removeClass('active');
	$target.addClass('removing').children('td').wrapInner('<div />').children().slideUp();
	setTimeout(function(){
		$target.remove();
		setApplyTotalResult();
	},500);
	return false;
});


$(document).on('change keyup', '.js-applyCartQuantity', function(event){
	var $key = $(this).attr('data-key');
	var $quantity = $(this).val();
	if ($quantity < 1) {
		$quantity = 1;
		$(this).val(1);
	}
	var $rowResult = $quantity * $(this).attr('data-point');
	$('.js-applyCartRowResult'+$key).text(setNumComma($rowResult)).attr('data-result', $rowResult);
	setApplyTotalResult();
	// console.log($rowResult);
});

$(document).on('click', '.js-doSelect', function(){
	var $applyCartRowTemplate = $('#js-applyCartRowTemplate').html();
	var $giftData = {
		id : $(this).attr('data-key')
	}
	var $result = '';
	$.ajax({
		url:'/product/giftGetData.php',
		type:'get',
		async:false,
		data:$giftData,
		success:function(data){
			setTimeout(function(){$('.js-doSelect').addClass('active')}, 80);
			setTimeout(function(){$('.js-doSelect').removeClass('active')}, 2000);
			var $data = JSON.parse(decodeURIComponent(data));
			if ($('.js-applyCartRow'+$data.gfKey).size() > 0) {
				var $targetInp = $('.js-applyCartQuantity[data-key='+$data.gfKey+']');
				$targetInp.val(parseInt($targetInp.val()) + parseInt(1));
				var $quantity = $targetInp.val();
			} else {
				$result = getResultTemplate($applyCartRowTemplate,$data);
				$('.js-applyCartWrap').append($result);
				var $quantity = 1;
			}
			$('.js-applyCartList').addClass('active');
			var $rowResult = parseInt($quantity) * $data.gfPoint;
			$('.js-applyCartRowResult'+$data.gfKey).text(setNumComma($rowResult)).attr('data-result', $rowResult);
			setApplyTotalResult();
		}
	});
});


function toggleContactBtn(){
	var $hideHeight = $('.js-hideContactBtn').position().top;
	var $showHeight = $('.js-showContactBtn').position().top;
	if ($hideHeight < $(document).scrollTop() && $(document).scrollTop() < $showHeight) {
		$('.contact-mobile-wrap').addClass('hide');
	}else if ($(document).scrollTop()>$showHeight) {
		$('.contact-mobile-wrap').removeClass('hide');
	}else{
		$('.contact-mobile-wrap').removeClass('hide');
	}
}

function setApplyTotalResult(){
	var $totalResult = 0;
	$('.js-applyCartRowResult').each(function(index,item){
		$totalResult = $totalResult +  parseInt($(item).attr('data-result'));
	});
	$('.js-totalResult').text(setNumComma($totalResult));
	$('.js-totalResultInp').val($totalResult);
	$('.js-totalResultCash').val($totalResult);
	var $resultCash = parseInt($('.js-totalResultCash').val());		// 현금값이 입력되면 숫자로 형변환 후에 대입
	var $resultPoint = $totalResult - $resultCash;
	$('.js-totalResultPoint').val($resultPoint);
}


$('.js-totalResultCash').focus(function(event){
	this.select();
});

$('.js-totalResultPoint').focus(function(event){
	this.select();
});



$('.js-totalResultCash').on('change keyup', function(event){
	// if($('.js-totalResultCash').val().length >= 2) {
		var $resultCash = parseInt($('.js-totalResultCash').val());		// 현금값이 입력되면 숫자로 형변환 후에 대입
		var $resultInp = parseInt($('.js-totalResultInp').val());		// 해당 변수의 값을 가져와 형변환 후 대입
		var $mbPoint = parseInt($('.js-mbPoint').val());
		var $subPoint = $resultInp-$mbPoint;

		console.log($resultInp);
		console.log($mbPoint);
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
		console.log($chmbPoint);
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

