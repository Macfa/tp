var $postcodeSearchWrap = document.getElementById('postcode-search-wrap');

$(function(){
	var daumPostcodeScript = document.createElement("script");
	daumPostcodeScript.src= "http://dmaps.daum.net/map_js_init/postcode.v2.js?autoload=false";
	$('body').append(daumPostcodeScript);	
});

$('.js-postcode, .js-address').focus(function(){
	openDaumPostcode(this);
});

$('.js-addressRow').click(function(){
	$.ajax({
		url:'/user/getAddressDetail.php',
		type:'post',
		async:false,
		data:{key : $(this).attr('data-key')},
		success:function(data){
			var $addressData = $.parseJSON(data);
			$('.js-arKey').val($addressData['arKey']);
			$('.js-tit').val($addressData['arTit']);
			$('.js-name').val($addressData['arName']);
			$('.js-phone').val($addressData['arPhone']);
			$('.js-tel').val($addressData['arTel']);
			$('.js-postcode').val($addressData['arPostcode']);
			$('.js-address').val($addressData['arAddress']);
			$('.js-subAddress').val($addressData['arSubAddress']);
			setLabel('.js-addressWrap input[type=text]');
			$('.js-addressDetail, .js-addressDetailAction').addClass('active');
			$('.js-addressList, .js-addressListAction').removeClass('active');
		}
	});
});

$('.js-newAddress').click(function(){
	$('.js-addressDetail, .js-addressDetailAction').addClass('active');
	$('.js-addressList, .js-addressListAction').removeClass('active');
	$('.js-addressWrap input[type=text], .js-arKey').val('');
	setLabel('.js-addressWrap input[type=text]');
	return false;
});

$('.js-addressDelete').click(function(){
	var $key = $(this).attr('data-key');
	$.ajax({
		url:'/user/addressDelete.php',
		type:'get',
		async:false,
		data:{id : $key},
		success:function(){
			$('.js-addressRow'+$key).addClass('removing').children('td').wrapInner('<div />').children().slideUp();
		}
	});
	return false;
});


$('.js-otherAddress').click(function(){
	$('.js-addressDetail, .js-addressDetailAction').removeClass('active');
	$('.js-addressList, .js-addressListAction').addClass('active');
	return false;
});

$('.js-editDone').click(function(){
	$('.js-addressDetail, .js-addressDetailAction').removeClass('active');
	$('.js-addressList, .js-addressListAction').addClass('active');
	return false;
});

$(document).click(function(e){
	if($(e.target)[0] != $('.js-postcodeSearchWrap.active')[0] && !$(e.target).parents('.js-postcodeSearchWrap.active').length) {
		$('.js-postcodeSearchWrap').removeClass('active');
	}
});

function openDaumPostcode(target) {
	var $currentScroll = Math.max(document.body.scrollTop, document.documentElement.scrollTop);
	var $targetOffset = $(target).offset().top;
	var $togglePadding = 13;
	if ($(target).parents('section').size() > 0)
		var $parentOffset = $(target).parents('section').offset().top;
	//console.log($targetOffset);
	daum.postcode.load(function(){
        new daum.Postcode({
            oncomplete: function(data) {
				$('.js-postcodeSearchWrap').removeClass('active')
                var $fullAddr = ''; // 최종 주소 변수
                var $extraAddr = ''; // 조합형 주소 변수

                // 사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
                if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                    $fullAddr = data.roadAddress;

                } else { // 사용자가 지번 주소를 선택했을 경우(J)
                    $fullAddr = data.jibunAddress;
                }

                // 사용자가 선택한 주소가 도로명 타입일때 조합한다.
                if(data.userSelectedType === 'R'){
                    //법정동명이 있을 경우 추가한다.
                    if(data.bname !== ''){
                        $extraAddr += data.bname;
                    }
                    // 건물명이 있을 경우 추가한다.
                    if(data.buildingName !== ''){
                        $extraAddr += ($extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                    }
                    // 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
                    $fullAddr += ($extraAddr !== '' ? ' ('+ $extraAddr +')' : '');
                }

                // 우편번호와 주소 정보를 해당 필드에 넣는다.
                $('.js-postcode').val(data.zonecode); //5자리 새우편번호 사용
                $('.js-address').val($fullAddr);
				setLabel('.js-postcode, .js-address');

                // 커서를 상세주소 필드로 이동한다.
                $('.js-subAddress').focus();
            },
			width : '100%',
			height: '100%'
        }).embed($postcodeSearchWrap);
    });
	$('.js-postcodeSearchWrap').addClass('active').css({top:$targetOffset-$parentOffset+$togglePadding});
}
