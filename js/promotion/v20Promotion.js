function scroll_smooth() { 
	$("a[href^='#']").click(function(event){
		event.preventDefault();                                           //기본으로 실행되는 기능을 막고,
		$('body').animate({scrollTop:$(this.hash).offset().top}, 500);    //jquery animate로 스크롤 이동
	});
}

$(function(){
	$('.js-processCarrier').trigger('change');
	$('.js-showGift').trigger('click');
	scroll_smooth();
});

var $initialBottomOfDetailView = $('.js-showDetailToggle')[0].style.bottom;
$('.js-showDetailToggle').click(function(){
	var $this = $(this);
	var $target = $($(this).attr('data-target'));
	if($target.hasClass('active')) {

		$target.animate({
			'height': 0,
			'margin-top': 0
			}, 1000, function() {
				$target.hide().removeClass('active');
			}
		);

		setTimeout(function(){
			$this.removeClass('active');
			$this.animate({
				'margin-bottom': $initialBottomOfDetailView
				}, 1000, function() {}
			);
		}, 250);
		

	}else{
		$target.show().addClass('active');
		$target.animate({
			'height': '100%',
			'margin-top': '-50px'
			}, 1000, function() {$target.css('height','auto');}
		);

		setTimeout(function(){
			$this.addClass('active');
			$this.animate({
				'margin-bottom': '-50px'
				}, 1000, function() {}
			);
		}, 250);
	}
});

$(window).resize(function(){
	$initialBottomOfDetailView = $('.js-showDetailToggle')[0].style.bottom;
});

$('.js-processCarrier').change(function(){
	var $carrier = $('.js-processCarrier:checked').val();

	$('.js-skProcess, .js-ktProcess, .js-lguplusProcess').hide();
	$('.js-'+$carrier+'Process').show();
});

$('.js-showGiftSection input[type=radio]').change(function(){
	var $isAutoShow = ($('.js-showGiftText').text())?true:false;
	if($isAutoShow == true) {
		$('.js-showGift').trigger('click');
	}
});

$('.js-showGift').click(function(){
	var $carrier = $('[name=carrier]:checked').val();
	var $applyType = $('[name=type]:checked').val();
	var $output;

	if($carrier == 'kt' && $applyType == '2') {
	    $output = 'ASUS 노트북 E502SA-XX015';
	} else if(($carrier == 'kt' && $applyType == '6') || ($carrier == 'sk' && $applyType == '2')) {
	    $output = '엠피지오 듀오+케이스키보드';
	} else {
	    $output = '레전드 와이드 태블릿';
	}

	if ($carrier && $applyType) {
		$('.js-showGiftWrap').show();
		$('.js-showGiftText').text($output);
	}else {
		$('.js-showGiftWrap').hide();
	}
});

var lastScrollTop = 0;
$(window).scroll(function(){
	var $current = $(this).scrollTop();
	var $topCutline = parseInt($('main').height())*0.4;
	var $maxBottom = ($('html').hasClass('mobile'))?400:550;
	var $cutline = 650;
	var $unit = $cutline / 100;
	var $laptop = $('.intro-laptop');
	var $currentBottom = parseInt($laptop.css('bottom'));
	var $scrollDirection;
	var $laptopTopIsSmaller = false;

	var st = window.pageYOffset || document.documentElement.scrollTop; // Credits: "https://github.com/qeremy/so/blob/master/so.dom.js#L426"
	if (st > lastScrollTop){
	   $scrollDirection = 'down';
	} else {
	  	$scrollDirection = 'up';
	  	$unit = $unit*-1;
	}
	
	var $scrollGap = parseInt(st) - parseInt(lastScrollTop);

	$unit = ($scrollGap*$maxBottom)/$cutline;
	// console.log($topCutline+' '+$laptop.offset().top);
	var $resultBottom = $currentBottom + $unit;

	// if($topCutline > $laptop.offset().top) {
	// 	var $laptopTopIsSmaller = true;
	// 	$resultBottom = $resultBottom - ($topCutline-$laptop.offset().top);
	// }

	if($resultBottom <= 0 || $current >= $cutline || $resultBottom >= $maxBottom)
		return undefined;

	$laptop.animate({
		'bottom': $resultBottom
		}, 1, function() {}
	);
	lastScrollTop = st;
});
// $(window).resize(function(){
// 	$('.section-detail-wrap.active').css('height',$('.section-detail-wrap.active').prop('scrollHeight'));
// 	// console.log('5');
// });

 