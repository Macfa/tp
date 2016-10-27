var $defGiftPanelScrollTop = 0;
$(function(){
	if ($('.gift-panel-wrap').offset()) 
		$defGiftPanelScrollTop = $('.gift-view-inner-wrap').position().top;
});
$(document).click('.js-giftView.active', function(e){
	if($(e.target)[0] != $('.js-giftDetail')[0] && !$(e.target).parents('.js-giftDetail').length) {
		$('.js-giftView').removeClass('active');
		$('body').removeClass('disabled');  
		if ($(e.target)[0] == $('.js-giftView')[0]){
			window.history.back();
		}
	}
});

$(document).on('click', '.js-closeGiftDetail', function(){
	$('.js-giftView').removeClass('active');
	$('body').removeClass('disabled')
	window.history.back();
});

$('#js-giftsForm').submit(function(e){
	getGiftList();
	e.preventDefault();
	return false;
});

$('.js-category').change(function(){
	getGiftList();
});

$(document).on('click','.js-giftViewToggle',function(){
	var $giftId = $(this).attr('data-key');
	var $giftData = {id : $(this).attr('data-key')	};
	var $giftTarget = $('.js-giftDetail');
	$giftTarget.html('');
	$.ajax({
		url:'/product/dev-giftDetail.php',
		type:'post',
		async:false,
		data:$giftData,
		success:function(data){
			history.pushState(data, $giftId,'/gift/'+$giftId);
			setGiftDetail(data);
			$('.js-giftView img[data-original]').lazyload({ 
				effect: "fadeIn",
				container: $(".js-giftView")
			});
		}
	});
	return false;
});

$(window).on("popstate", function(event) {
	if (event.originalEvent.state) {
		setGiftDetail(event.originalEvent.state);
	} else {
		$('.js-giftView').removeClass('active');
		$('body').removeClass('disabled');
	}
});

$('.js-giftView').scroll(function(){
	followScrolling();
});

$(window).resize(function(){
	followScrolling();
});

$(document).on('click', '.js-doCart', function(){
	var $giftId = $(this).attr('data-key');
	$.ajax({
		url:'/product/giftDoCart.php',
		type:'post',
		async:false,
		data:{'gfKey' : $giftId},
		success:function(data){
			setTimeout(function(){$('.js-doCart').addClass('active')}, 80);
			setTimeout(function(){$('.js-doCart').removeClass('active')}, 2000);
		}
	});

});

function getGiftList(){
	var $searchCategory = '';
	$('.js-category').each(function(index,item){
		if(item.checked) {
			if($searchCategory != '') $searchCategory += ',';
			$searchCategory += $(item).val(); 
		}
	});
	var $searchData = {
		searchStr : $('[name=giftsSearch]').val(),
		searchCategory : $searchCategory
	};
	$.ajax({
		url:'/product/giftsGetResult.php',
		type:'post',
		async:false,
		data:$searchData,
		success:function(data){
			$('.js-giftList').html(data);
			$('.js-giftList img[data-original]').lazyload({ 
				effect: "fadeIn",
				container: $(".js-giftList")
			});
		}
	});
}

function setGiftDetail($data){
	$('.js-giftDetail').html($data);
	$('.js-giftView').scrollTop(0);
	$('.js-giftView').addClass('active');
	$('body').addClass('disabled');
	followScrolling();
}

function followScrolling(){
	if ($(document).width() < 900) {
		$('.js-giftPanel').removeClass('scrolling');
		return false;
	}
	if ($defGiftPanelScrollTop == 0) 
		$defGiftPanelScrollTop = $('.gift-view-inner-wrap').position().top;

	var parentTop = $('.js-giftView').scrollTop(); // returns number
	
	//console.log('stickyTop : ' +$defGiftPanelScrollTop);
	//console.log('parentTop  : ' +parentTop);
				  
	if ($defGiftPanelScrollTop < parentTop){
		$('.js-giftPanel').addClass('scrolling').css("top", parentTop-$defGiftPanelScrollTop);
	}
	else {
		$('.js-giftPanel').removeClass('scrolling');
	}
}

