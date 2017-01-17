$('.js-giftMoreToggler').click(function(){
	if($('.js-giftMoreWrap').hasClass('active')) {

		$('.js-giftMoreWrap').animate({
			'height': 0
			}, 500, function() {
				$('.js-giftMoreWrap').hide().removeClass('active');
		});

	}else{
		$('.js-giftMoreWrap').show().addClass('active').animate({
			'height': $('.js-giftMoreWrap').prop('scrollHeight')+150
			}, 500, function() {}
		);

	}
})

function scroll_smooth() { 
	$("a[href^='#']").click(function(event){
		event.preventDefault();                                           //기본으로 실행되는 기능을 막고,
		$('body').animate({scrollTop:$(this.hash).offset().top}, 500);    //jquery animate로 스크롤 이동
	});
}
$(function() {    //문서 로딩이 끝나면 실행
    scroll_smooth();
});
