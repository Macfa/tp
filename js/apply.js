toggleContactBtn();
var $arrPlanData = [];
var $isLoadedData = [];

$(function(){
	setCalcHeight();
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
	toggleContactBtn();
});

$(window).scroll(function(){
	toggleContactBtn();
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
}