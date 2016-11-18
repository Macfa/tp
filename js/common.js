document.createElement('header');
document.createElement('section');
document.createElement('article');
document.createElement('aside');
document.createElement('nav');
document.createElement('main');
document.createElement('footer');
document.createElement('figure');

//모바일/태블릿 감지 $isMobileTablet 로 감지
$isMobileTablet = false;
$isMobileTablet = (function(a,b){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blacberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))){return true;}return false})(navigator.userAgent||navigator.vendor||window.opera);
if ($isMobileTablet == false)
	$('html').addClass('pc');
else
	$('html').addClass('mobile');

var $cache = {};

$(document).ready(function() {

	if($('.nav-device-wrap').size() > 0 && $('.nav-device-wrap').hasScrollBar('horizontal'))
		$('.nav-device-wrap').addClass('has-horizontal-scroll');

	if ($('[data-editor]').size() > 0) $('[data-editor]').editable({inlineMode: false, minHeight: '300px'});

	if ($(".js-scroll-paging-next").size() > 0) {
		ajax_paging($(".js-scroll-paging-next"));
	}

	$(window).scroll(function(){
		if ($isMobileTablet === true){
			$('.contact-consult-mobile, .contact-tel-mobile, .contact-kakao-mobile, .contact-toggle-btn').removeClass('active');
		}
	});

	function ajax_paging($this) {
		var $current = $this.attr('scroll-page');
		var $target = $this.parents('.js-scroll-paging-wrap');
		var $next = ($current*1+1);
		var $key = $this.attr('scroll-key');
		var $no = $this.attr($key);
		var $url = $this.attr('scroll-url');
		var $data = _ajax('get', $url, $key+'='+$no+'&page='+$next);
		$target.append($data);
		$target.append($this);
		$this.attr('scroll-page', $next);
	}
	$(".js-openable").hide();

	$('textarea[data-auto-height]').keypress();

	require([ 
		'jquery.lazyload'
	], function (lazyload) {
		$('img[data-original]:not(.js-giftDetail img)').lazyload({
			effect : "fadeIn"
		});
	});

	$(".js-openable-toggle").click(function(){
		$(this).next(".js-openable").slideToggle("500");
	});

	$("#allCheck").click(function() {
		$(".js-check").prop('checked', this.checked);
	});

	$(".js-scroll-paging-next").click(function(){
		ajax_paging($(this));
	});
	
	$('.js-layerViewToggle, .js-layerViewClose, .js-telReserve').on('click',function(){
		if ($('.js-layerView').hasClass('active')){
			$('[name=layerView]').attr('src','');
		}
		$('.js-layerView').toggleClass('active');
		$('body').toggleClass('disabled');
	});	

	$('.layer-view-wrap').click(function(){
		$('.js-layerView').removeClass('active');
		$('body').removeClass('disabled');
	});
	$('.js-layerViewIframe').load(function(){
		$(this).css('background','white');
	});

	$('.contact-toggle-btn').on('click',function(){
		$('.contact-consult-mobile').toggleClass('active');
		$('.contact-tel-mobile').toggleClass('active');
		$('.contact-kakao-mobile').toggleClass('active');
		$('.contact-toggle-btn').toggleClass('active');
		return false;
	});

	$('body').on('click', function(){
		$('.contact-consult-mobile, .contact-tel-mobile, .contact-kakao-mobile, .contact-toggle-btn').removeClass('active');
	});

	$('.js-fullPopupClose').click(function(){
		$(this).parent().parent().remove();
		$('html,body').css('overflow','auto');
	});

	//formaction 크로스 브라우징
	$( 'form [formaction]' ).click(function() {
		$(this).parents('form').attr('action', $(this).attr('formaction')).submit();
		return false;
	});
	$(".js-menuToggler").unbind('click').bind('click', function (e) {
		$(".js-menu").slideToggle("500");
	});

	$('#link-gnb-bookmark').on('click', function(e) {
		var bookmarkURL = window.location.href;
		var bookmarkTitle = document.title;
		var triggerDefault = false;

		if (window.sidebar && window.sidebar.addPanel) {
			// Firefox version < 23
			window.sidebar.addPanel(bookmarkTitle, bookmarkURL, '');
		} else if ((window.sidebar && (navigator.userAgent.toLowerCase().indexOf('firefox') > -1)) || (window.opera && window.print)) {
			// Firefox version >= 23 and Opera Hotlist
			var $this = $(this);
			$this.attr('href', bookmarkURL);
			$this.attr('title', bookmarkTitle);
			$this.attr('rel', 'sidebar');
			$this.off(e);
			triggerDefault = true;
		} else if (window.external && ('AddFavorite' in window.external)) {
			// IE Favorite
			window.external.AddFavorite(bookmarkURL, bookmarkTitle);
		} else {
			// WebKit - Safari/Chrome
			alert((navigator.userAgent.toLowerCase().indexOf('mac') != -1 ? 'Cmd' : 'Ctrl') + '+D 키를 눌러 즐겨찾기에 등록하실 수 있습니다.');
		}

		return triggerDefault;
	});

	$(document).on("touchmove", 'body', function(event) {
		if($isMobileTablet == true && $('body').hasClass('disabled') && $('.js-layerView').hasClass('active')) {
			event.preventDefault();
			event.stopPropagation();
		}
	});

	$('.inp-txt, .inp-num, .inp-search').each(function(index,item){
		setLabel(item);
	});

	$('.inp-txt, .inp-num, .inp-search').on('change', function(){
		console.log(1);
		setLabel(this);
	});

	$('.js-navMobileBtn').click(function() {
		$('.js-navMobile').addClass('active');
		$('body').addClass('disabled');
	});

	$('.js-navMobileCloseBtn').click(function() {
		$('.js-navMobile').removeClass('active');
		$('body').removeClass('disabled');
	});
});


function decodeHtml(html) {
    var txt = document.createElement("textarea");
    txt.innerHTML = html;
    return txt.value;
}

function getResultTemplate($template,$data){
	var $result = $template;
	//console.log($result);
	for (var key in $data) {
		$result = replaceAll('{'+key+'}', $data[key], $result);
	}
	//console.log($result);
	return $result;
}

function replaceAll(searchStr, replaceStr, str) {
	//console.log(searchStr);
	if (str == undefined)
		return false;
    return str.split(searchStr).join(replaceStr);
}

function triggerEvent(element, eventName) {
	var event;
	if (document.createEvent) {
		event = document.createEvent("HTMLEvents");
		event.initEvent(eventName, true, true);
	} else {
		event = document.createEventObject();
		event.eventType = eventName;
	}

	event.eventName = eventName;
	if (document.createEvent)
		element.dispatchEvent(event);
	else {
		if (eventName==="resize") {
			var savedWidth=document.documentElement.style.width;
			document.documentElement.style.width="99.999999%";
			setTimeout(function() { document.documentElement.style.width=savedWidth }, 50);
		} else
			element.fireEvent("on" + event.eventType, event);
	}
}

function setPriceComma($input){
	$input = String($input);
    return $input.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,');
}

function setNumComma($input){
	return setPriceComma($input);
}

function isMobile(){
	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
		return true;
	}
}

function resizeMain(){
	var $height = $(this).height();
	var $width = $(this).width();
	$('#main').css({'height':$height,'width':$width});
}

function popup_open (url, subject) {
	var cw=screen.availWidth;     //화면 넓이
	var ch=screen.availHeight;    //화면 높이

	var sw=800;    //띄울 창의 넓이
	var sh=800;    //띄울 창의 높이

	var ml=(cw-sw)/2;        //가운데 띄우기위한 창의 x위치
	var mt=(ch-sh)/2;         //가운데 띄우기위한 창의 y위치

	var win = window.open(url, subject, 'width='+sw+',height='+sh+',top='+mt+',left='+ml+',resizable=yes,scrollbars=yes,location=no,directories=no');
	win.focus();
}

function isPopup() {
	if(opener)
		return true;
	else
		return false;
}

function showObj(obj) {
	var str = "";
	for(key in obj) {
		str += key+"="+obj[key]+"\n";
	}
	alert(str);
	return;
}

//파일 확장자 확인
function isValidExt($file,$whitelist){
	var $arrWhitelist = $whitelist.split(',');
	var $arrTmp = $file.split('.');
	var $fileExt = $arrTmp[parseInt($arrTmp.length-1)];

	if ($arrWhitelist.indexOf($fileExt) != -1)
		return true;
}

//존재하는 날짜인지 확인
function isValidDate(year, month, day) {    
	var m = parseInt(month,10) - 1; 
	var d = parseInt(day,10);
	var end = new Array(31,28,31,30,31,30,31,31,30,31,30,31); 
	if ((year % 4 == 0 && year % 100 != 0) || year % 400 == 0) { 
	  end[1] = 29; 
	}
	return (d >= 1 && d <= end[m]);
}

// 년/월 별로 마지막 날짜를 구함
function getLastDay($year, $month) {    
	var m = parseInt($month,10) - 1; 
	var $last = new Array(31,28,31,30,31,30,31,31,30,31,30,31); 
	if (($year % 4 == 0 && $year % 100 != 0) || $year % 400 == 0) { 
	  $last[1] = 29; 
	}
	return $last[m];
}

$(document).on('click', '.js-dropdown-toggler', function(){
			$(".js-dropdown-list-wrap").slideToggle('fast');
});
$(document).on('click', function(e){
	var $clicked = $(e.target);
	if (!$clicked.parents().hasClass("js-dropdown-wrap")) $(".js-dropdown-list-wrap").hide();
});

function insertAjaxResult(target, type, url, params) {
	$html = _ajax (type, url, params);
	$(target).html($html);
}

function print_r(arr){ 
	for(var i in arr){ 
		$('footer').text("["+i+"] => " + arr[i] + " <br/>"); 
	} 
} 
function json2array(json){
    var result = [];
    var keys = Object.keys(json);
    keys.forEach(function(key){
        result.push(json[key]);
    });
    return result;
}

function _ajax (type, url, params) {
	$.ajax({
		type: type
		, url: url
		, data: encodeURI(params)
		, async: false
		, success: function(data)
		{
			$html = data;
		}
		, error: function() {
			$html = '서버와의 통신이 실패했습니다.';
		}
		, complete: function() {}
	});

	return $html;
}

// 선택된 엘리먼트의 자식의 태그와 내용만 가져오는 html()과 달리 자신까지 담아오는 ie의 outerhtml()을 구현
function getOuterHtml($target) {
	return $target.clone().wrap('<p>').parent().html();
}

function setLabel(item){
	var $target = $(item).siblings('.inp-label');
	
	if($(item)[0].nodeName == 'INPUT')
		var $value = $(item).val();
	else 
		var $value = $(item).text();

	console.log($(item)[0].nodeName);

	if($target.size() && $value) {
		$target.addClass('active');
	}else{
		$target.removeClass('active');
	}
}

// req 약자는 request 와 혼동이 될수 있으므로 풀네임을 사용
// 인풋이 data-parsley-required 속성이 있는지 확인후 설정
// parsley.js 의존성
function setNotRequired($target) {
	if (($target.is('[data-parsley-required]') == true || $target.attr('data-parsley-required') == 'true') && $target.attr('data-parsley-required') != 'false')
		$target.attr('data-parsley-required', false);
}

function setRequired($target) {
	if ($target.attr('data-parsley-required') == 'false' && $target.attr('data-parsley-required') != 'true')
		$target.attr('data-parsley-required', true);
}

function toggleRequired($target) {
	if (($target.is('[data-parsley-required]') == true || $target.attr('data-parsley-required') == 'true') && $target.attr('data-parsley-required') != 'false')
		$target.attr('data-parsley-required', false);
	else if ($target.attr('data-parsley-required') == 'false' && $target.attr('data-parsley-required') != 'true')
		$target.attr('data-parsley-required', true);
}

$('textarea[data-auto-height]').on('keyup', function(){
	$(this).height('1px');
	$(this).height(20+$(this).prop("scrollHeight")+"px");
});

//스크롤 헤더
var didScroll;
var lastScrollTop = 0;
var delta = 5;
//var navbarHeight = $('.js-scroll-header').outerHeight() + 120;

$(window).scroll(function(event){
    didScroll = true;
});

setInterval(function() {
    if (didScroll) {
        hasScrolled('.js-gnb, .nav-sub-wrap, .detail-head-wrap');
        didScroll = false;
    }


}, 100);

function hasScrolled($target, $activeClass) {
	var $header = $($target);
	if ($header.size() < 1)
		return false;
	
	if ($activeClass == undefined)
		$activeClass = 'scrolling';

    var st = $(this).scrollTop();
	var $isScrollDown = false;
	var $isHeaderOut = false;
	var $inHeader = false;
	var $isShow = false;
    
    // Make sure they scroll more than delta
    if(Math.abs(lastScrollTop - st) <= delta)
        return;

	if (st > lastScrollTop)
		$isScrollDown = true;

	if (st > 150)
		$isHeaderOut = true;

	if ($header.hasClass($activeClass))
		$isShow = true;

	if ($isHeaderOut) {
		$header.addClass($activeClass);
	}else{
		$header.removeClass($activeClass);
	}

    lastScrollTop = st;
}

function isIE(){
	var agent = navigator.userAgent.toLowerCase();
	if(agent.indexOf("msie") != -1)
		return true;
}


var trackOutboundLink = function(url, label, isBlank) {
	if (label === undefined) {
		label = 'outbound';
	}
	ga('send', 'event', label, 'click', url, {
		'transport': 'beacon',
		'hitCallback': function(){
			alert(1);
			if (isBlank !== undefined) {
				window.open(url, '_blank');
			}else {
				document.location = url;
			}
		}
	});
}

$('.js-trackLink[href]').click(function(event){
	event.preventDefault();
	var $url = $(this).attr(href);
	trackOutboundLink($url, '가입신청', '_blank'); 
});


//쿠키를 생성하는 함수 설정

function setCookie(cookieName, value, exdays){
    var exdate = new Date();
    exdate.setDate(exdate.getDate() + exdays);
    var cookieValue = escape(value) + ((exdays==null) ? "" : "; expires=" + exdate.toGMTString());
    document.cookie = md5(cookieName) + "=" + base64.encode(cookieValue);
}
// 쿠키명 (cname), 쿠키 값(cvalue), 쿠키 만료 날짜(exdays)

//생성한 쿠키 반환
function getCookie(cookieName) {
    cookieName = md5(cookieName) + '=';
    var cookieData = document.cookie;
    var start = cookieData.indexOf(cookieName);
    var cookieValue = '';
    if(start != -1){
        start += cookieName.length;
        var end = cookieData.indexOf(';', start);
        if(end == -1)end = cookieData.length;
        cookieValue = cookieData.substring(start, end);
    }
    return unescape(base64.decode(cookieValue));
}

jQuery.fn.hasScrollBar = function(direction)	{
	if (direction == 'vertical'){
		return this.get(0).scrollHeight > this.innerHeight();
	}
	else if (direction == 'horizontal')	{
		return this.get(0).scrollWidth > this.innerWidth();
	}
	return false;
}

var base64 = {

	// private property
	_keyStr : "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",

	// public method for encoding
	encode : function (input) {
		var output = "";
		var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
		var i = 0;

		while (i < input.length) {

		  chr1 = input.charCodeAt(i++);
		  chr2 = input.charCodeAt(i++);
		  chr3 = input.charCodeAt(i++);

		  enc1 = chr1 >> 2;
		  enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
		  enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
		  enc4 = chr3 & 63;

		  if (isNaN(chr2)) {
			  enc3 = enc4 = 64;
		  } else if (isNaN(chr3)) {
			  enc4 = 64;
		  }

		  output = output +
			  this._keyStr.charAt(enc1) + this._keyStr.charAt(enc2) +
			  this._keyStr.charAt(enc3) + this._keyStr.charAt(enc4);

		}

		return output;
	},

	// public method for decoding
	decode : function (input)
	{
	    var output = "";
	    var chr1, chr2, chr3;
	    var enc1, enc2, enc3, enc4;
	    var i = 0;

	    input = input.replace(/[^A-Za-z0-9+/=]/g, "");

	    while (i < input.length)
	    {
	        enc1 = this._keyStr.indexOf(input.charAt(i++));
	        enc2 = this._keyStr.indexOf(input.charAt(i++));
	        enc3 = this._keyStr.indexOf(input.charAt(i++));
	        enc4 = this._keyStr.indexOf(input.charAt(i++));

	        chr1 = (enc1 << 2) | (enc2 >> 4);
	        chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
	        chr3 = ((enc3 & 3) << 6) | enc4;

	        output = output + String.fromCharCode(chr1);

	        if (enc3 != 64) {
	            output = output + String.fromCharCode(chr2);
	        }
	        if (enc4 != 64) {
	            output = output + String.fromCharCode(chr3);
	        }
	    }

	    return output;
	}
}


var md5 = function (string) {

   function RotateLeft(lValue, iShiftBits) {
           return (lValue<<iShiftBits) | (lValue>>>(32-iShiftBits));
   }

   function AddUnsigned(lX,lY) {
           var lX4,lY4,lX8,lY8,lResult;
           lX8 = (lX & 0x80000000);
           lY8 = (lY & 0x80000000);
           lX4 = (lX & 0x40000000);
           lY4 = (lY & 0x40000000);
           lResult = (lX & 0x3FFFFFFF)+(lY & 0x3FFFFFFF);
           if (lX4 & lY4) {
                   return (lResult ^ 0x80000000 ^ lX8 ^ lY8);
           }
           if (lX4 | lY4) {
                   if (lResult & 0x40000000) {
                           return (lResult ^ 0xC0000000 ^ lX8 ^ lY8);
                   } else {
                           return (lResult ^ 0x40000000 ^ lX8 ^ lY8);
                   }
           } else {
                   return (lResult ^ lX8 ^ lY8);
           }
   }

   function F(x,y,z) { return (x & y) | ((~x) & z); }
   function G(x,y,z) { return (x & z) | (y & (~z)); }
   function H(x,y,z) { return (x ^ y ^ z); }
   function I(x,y,z) { return (y ^ (x | (~z))); }

   function FF(a,b,c,d,x,s,ac) {
           a = AddUnsigned(a, AddUnsigned(AddUnsigned(F(b, c, d), x), ac));
           return AddUnsigned(RotateLeft(a, s), b);
   };

   function GG(a,b,c,d,x,s,ac) {
           a = AddUnsigned(a, AddUnsigned(AddUnsigned(G(b, c, d), x), ac));
           return AddUnsigned(RotateLeft(a, s), b);
   };

   function HH(a,b,c,d,x,s,ac) {
           a = AddUnsigned(a, AddUnsigned(AddUnsigned(H(b, c, d), x), ac));
           return AddUnsigned(RotateLeft(a, s), b);
   };

   function II(a,b,c,d,x,s,ac) {
           a = AddUnsigned(a, AddUnsigned(AddUnsigned(I(b, c, d), x), ac));
           return AddUnsigned(RotateLeft(a, s), b);
   };

   function ConvertToWordArray(string) {
           var lWordCount;
           var lMessageLength = string.length;
           var lNumberOfWords_temp1=lMessageLength + 8;
           var lNumberOfWords_temp2=(lNumberOfWords_temp1-(lNumberOfWords_temp1 % 64))/64;
           var lNumberOfWords = (lNumberOfWords_temp2+1)*16;
           var lWordArray=Array(lNumberOfWords-1);
           var lBytePosition = 0;
           var lByteCount = 0;
           while ( lByteCount < lMessageLength ) {
                   lWordCount = (lByteCount-(lByteCount % 4))/4;
                   lBytePosition = (lByteCount % 4)*8;
                   lWordArray[lWordCount] = (lWordArray[lWordCount] | (string.charCodeAt(lByteCount)<<lBytePosition));
                   lByteCount++;
           }
           lWordCount = (lByteCount-(lByteCount % 4))/4;
           lBytePosition = (lByteCount % 4)*8;
           lWordArray[lWordCount] = lWordArray[lWordCount] | (0x80<<lBytePosition);
           lWordArray[lNumberOfWords-2] = lMessageLength<<3;
           lWordArray[lNumberOfWords-1] = lMessageLength>>>29;
           return lWordArray;
   };

   function WordToHex(lValue) {
           var WordToHexValue="",WordToHexValue_temp="",lByte,lCount;
           for (lCount = 0;lCount<=3;lCount++) {
                   lByte = (lValue>>>(lCount*8)) & 255;
                   WordToHexValue_temp = "0" + lByte.toString(16);
                   WordToHexValue = WordToHexValue + WordToHexValue_temp.substr(WordToHexValue_temp.length-2,2);
           }
           return WordToHexValue;
   };

   function Utf8Encode(string) {
           string = string.replace(/\r\n/g,"\n");
           var utftext = "";

           for (var n = 0; n < string.length; n++) {

                   var c = string.charCodeAt(n);

                   if (c < 128) {
                           utftext += String.fromCharCode(c);
                   }
                   else if((c > 127) && (c < 2048)) {
                           utftext += String.fromCharCode((c >> 6) | 192);
                           utftext += String.fromCharCode((c & 63) | 128);
                   }
                   else {
                           utftext += String.fromCharCode((c >> 12) | 224);
                           utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                           utftext += String.fromCharCode((c & 63) | 128);
                   }

           }

           return utftext;
   };

   var x=Array();
   var k,AA,BB,CC,DD,a,b,c,d;
   var S11=7, S12=12, S13=17, S14=22;
   var S21=5, S22=9 , S23=14, S24=20;
   var S31=4, S32=11, S33=16, S34=23;
   var S41=6, S42=10, S43=15, S44=21;

   string = Utf8Encode(string);

   x = ConvertToWordArray(string);

   a = 0x67452301; b = 0xEFCDAB89; c = 0x98BADCFE; d = 0x10325476;

   for (k=0;k<x.length;k+=16) {
           AA=a; BB=b; CC=c; DD=d;
           a=FF(a,b,c,d,x[k+0], S11,0xD76AA478);
           d=FF(d,a,b,c,x[k+1], S12,0xE8C7B756);
           c=FF(c,d,a,b,x[k+2], S13,0x242070DB);
           b=FF(b,c,d,a,x[k+3], S14,0xC1BDCEEE);
           a=FF(a,b,c,d,x[k+4], S11,0xF57C0FAF);
           d=FF(d,a,b,c,x[k+5], S12,0x4787C62A);
           c=FF(c,d,a,b,x[k+6], S13,0xA8304613);
           b=FF(b,c,d,a,x[k+7], S14,0xFD469501);
           a=FF(a,b,c,d,x[k+8], S11,0x698098D8);
           d=FF(d,a,b,c,x[k+9], S12,0x8B44F7AF);
           c=FF(c,d,a,b,x[k+10],S13,0xFFFF5BB1);
           b=FF(b,c,d,a,x[k+11],S14,0x895CD7BE);
           a=FF(a,b,c,d,x[k+12],S11,0x6B901122);
           d=FF(d,a,b,c,x[k+13],S12,0xFD987193);
           c=FF(c,d,a,b,x[k+14],S13,0xA679438E);
           b=FF(b,c,d,a,x[k+15],S14,0x49B40821);
           a=GG(a,b,c,d,x[k+1], S21,0xF61E2562);
           d=GG(d,a,b,c,x[k+6], S22,0xC040B340);
           c=GG(c,d,a,b,x[k+11],S23,0x265E5A51);
           b=GG(b,c,d,a,x[k+0], S24,0xE9B6C7AA);
           a=GG(a,b,c,d,x[k+5], S21,0xD62F105D);
           d=GG(d,a,b,c,x[k+10],S22,0x2441453);
           c=GG(c,d,a,b,x[k+15],S23,0xD8A1E681);
           b=GG(b,c,d,a,x[k+4], S24,0xE7D3FBC8);
           a=GG(a,b,c,d,x[k+9], S21,0x21E1CDE6);
           d=GG(d,a,b,c,x[k+14],S22,0xC33707D6);
           c=GG(c,d,a,b,x[k+3], S23,0xF4D50D87);
           b=GG(b,c,d,a,x[k+8], S24,0x455A14ED);
           a=GG(a,b,c,d,x[k+13],S21,0xA9E3E905);
           d=GG(d,a,b,c,x[k+2], S22,0xFCEFA3F8);
           c=GG(c,d,a,b,x[k+7], S23,0x676F02D9);
           b=GG(b,c,d,a,x[k+12],S24,0x8D2A4C8A);
           a=HH(a,b,c,d,x[k+5], S31,0xFFFA3942);
           d=HH(d,a,b,c,x[k+8], S32,0x8771F681);
           c=HH(c,d,a,b,x[k+11],S33,0x6D9D6122);
           b=HH(b,c,d,a,x[k+14],S34,0xFDE5380C);
           a=HH(a,b,c,d,x[k+1], S31,0xA4BEEA44);
           d=HH(d,a,b,c,x[k+4], S32,0x4BDECFA9);
           c=HH(c,d,a,b,x[k+7], S33,0xF6BB4B60);
           b=HH(b,c,d,a,x[k+10],S34,0xBEBFBC70);
           a=HH(a,b,c,d,x[k+13],S31,0x289B7EC6);
           d=HH(d,a,b,c,x[k+0], S32,0xEAA127FA);
           c=HH(c,d,a,b,x[k+3], S33,0xD4EF3085);
           b=HH(b,c,d,a,x[k+6], S34,0x4881D05);
           a=HH(a,b,c,d,x[k+9], S31,0xD9D4D039);
           d=HH(d,a,b,c,x[k+12],S32,0xE6DB99E5);
           c=HH(c,d,a,b,x[k+15],S33,0x1FA27CF8);
           b=HH(b,c,d,a,x[k+2], S34,0xC4AC5665);
           a=II(a,b,c,d,x[k+0], S41,0xF4292244);
           d=II(d,a,b,c,x[k+7], S42,0x432AFF97);
           c=II(c,d,a,b,x[k+14],S43,0xAB9423A7);
           b=II(b,c,d,a,x[k+5], S44,0xFC93A039);
           a=II(a,b,c,d,x[k+12],S41,0x655B59C3);
           d=II(d,a,b,c,x[k+3], S42,0x8F0CCC92);
           c=II(c,d,a,b,x[k+10],S43,0xFFEFF47D);
           b=II(b,c,d,a,x[k+1], S44,0x85845DD1);
           a=II(a,b,c,d,x[k+8], S41,0x6FA87E4F);
           d=II(d,a,b,c,x[k+15],S42,0xFE2CE6E0);
           c=II(c,d,a,b,x[k+6], S43,0xA3014314);
           b=II(b,c,d,a,x[k+13],S44,0x4E0811A1);
           a=II(a,b,c,d,x[k+4], S41,0xF7537E82);
           d=II(d,a,b,c,x[k+11],S42,0xBD3AF235);
           c=II(c,d,a,b,x[k+2], S43,0x2AD7D2BB);
           b=II(b,c,d,a,x[k+9], S44,0xEB86D391);
           a=AddUnsigned(a,AA);
           b=AddUnsigned(b,BB);
           c=AddUnsigned(c,CC);
           d=AddUnsigned(d,DD);
   		}

   	var temp = WordToHex(a)+WordToHex(b)+WordToHex(c)+WordToHex(d);

   	return temp.toLowerCase();
}