$(function(){

	$('.nav-device-wrap, .nav-sub-wrap').addClass('active');
	deviceNav();
});

$(window).scroll(function(){
	deviceNav();
});

function deviceNav(){
	var $val = $('.js-devicelist').position().top;
	if ($(document).scrollTop() < $val) {
		$('.nav-device-wrap').addClass('active');
	}else{
		$('.nav-device-wrap').removeClass('active');
	}
}