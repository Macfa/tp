$('.js-SerialNumber').click(function(){		/* 일련번호 옆에 있는 추가 버튼을 클릭 시 추가 input 폼과 checkbox 폼이 리스트에 계속 붙는다 */
	var btn_input = '<tr><td class=buttonList_td><input type="text" class="js-SerialNumber-buttonList" name="serialNumber[]"> <input type="checkbox" class="js-SerialNumber-box" name="checkbox"> <input type="text" name="delivery[]" class="test" disabled></td></tr>';
	$('.buttonList').append(btn_input);
	$('.test').val();
	// $('.buttonList').append('<input type="text"></td></tr>');
});

// $('.js-goodReceipt-btn').one("click",function() {  /* 후에 입고처 추가 및 제거 를 위한 스크립트였으나 미루기로 함  온클릭으로 서브밋 했을때 리스트에 출력됨 */
// 	var btn_select = '<input type="text" id="goodReceipt_add"><input type="submit" value="submit" onclick="modifyList()">';
// 	$('.js-goodReceipt').append(btn_select);
// });

// $('.js-manuf-btn').one("click",function() {  /* 후에 제조사 추가 및 제거 를 위한 스크립트였으나 미루기로 함  온클릭으로 서브밋 했을때 리스트에 출력됨 */
// 	var btn_select = '<input type="text" id="manuf_add"><input type="submit" value="submit" onclick="modifyList()">';
// 	$('.js-manuf').append(btn_select);
// });

// $(document).on('change', '.js-SerialNumber-box', function(){		 //일련번호 checkbox 값이 변경될 시 출고처를 적는 부분의 disabled 속성 제거 
// 	$(this).siblings('.test').removeAttr("disabled");
// });


$('.checkbox_return').click(function(){
	var return_name = '<input type="text" name="returnName" class="returnName">';

	if($('.checkbox_return').is(':checked')) {
		$('.js-goodReceipt').append(return_name);
	} else {
		$('.returnName').remove();
	}
});


// $('.checkbox_carrier').click(function(){
// 	var carrier = $(this).val();	/* 체크된 값을 가져온다*/
// 	// console.log("'."+ carrier +"'");
// 	if($('.checkbox_carrier').is(':checked')) {	/* 해당 클래스에 checked 된것이 있다면*/
// 		$('.checkbox_carrier').prop('checked', false);	/* 클래스 에 포함된 모든것의 체크를 푼다*/
// 		$('.checkbox_carrier[name='+ carrier +']').prop('checked', true);	/* 가져온 값만 체크를 건다*/
// 	} else {	/* 체크된 것이 없다면 */
// 		$('.checkbox_carrier[name='+ carrier +']').prop('checked', true);	/* 바로 이전에 체크된 값에 다시 체크를 건다 */
// 	}
// 	$('.js-carrier').css('display', 'none');
// 	console.log($('.js-carrier[name='+ carrier +']'));
// 	$('.js-carrier[name='+ carrier +']').removeAttr("style");
// });

/* ajax - neKey 를 url 경로로 넘겨서 
계산을 하고 echo 로 받는 그 값(data) 을 배열로 해서 넣는다 
그전에 #color */
$('#modelCode').change(function(){
	var $neKey = $(this).val();
	
	$.ajax({
		url:'tplDeviceInColor.php',
		type:'post',
		async:false,
		data:{neKey : $neKey},
		success:function(data){
			var $colorList = $.parseJSON(data);
			$('#color').html('');

			$.each($colorList, function(key, value) {
				$colorList['key'] = value;
				var $result = getResultTemplate("<option>{key}</option>", $colorList);
				$('#color').append($result);
			});
		}
	});
});

/* $(document).ready(function(){ .... }); 줄임말 */
$(function(){
	$('#modelCode').trigger('change');
});


// $(document).on('change', '.js-SerialNumber-box', function(){
/* 일련번호 텍스트창에 값이 입력되면 */
$(document).on('keyup', '.js-SerialNumber-buttonList', function() {
	var $serial = $(this).val();	/* 해당 값을 저장한다 */
	var $current = $(this);

	$.ajax({	/* ajax 구문 */
		url:'tplDeviceSearch.php',	/* 이벤트 발생 시 해당 url 로 이동 */
		type:'post',	/* 타입은 포스트*/
		async:false,	/* 동기화? 란 뜻같은데 확실치 않음 */
		data:{serial : $serial},	/* 데이터 형식은 serial 이름으로 $serial 을 넘긴다 */
		success:function(data) {	/* 보내는게 성공하고 해당 url 에서 에러 없이 값이 처리되었다면 success 가 실행 */
			var $searchResult = $.parseJSON(data);	/* php -> JSON -> Javascript 로 변환 하기 위한 과정 */
			var $par = $current.siblings('.inp-chk-dense').find('.js-SerialNumber-box');	/* 버튼 리스트의 부모로 간다음 자식인 checkbox를 저장 */

			if($searchResult) {	/* php 에서 처리된 값이 true 라면 */
				$par.prop('checked', true);	/* checkbox 에 체크하고 그 우측에 있는 출고처기입란의 dsiable 해제 */
				$par.parent('.inp-chk-dense').siblings('.test').removeAttr("disabled");	
			} else {	/* 트루가 아니면 .. */
				$par.prop('checked', false);	/* 체크를 해제하고 우측 출고처기입란의 disable 설정 */
				$par.parent('.inp-chk-dense').siblings('.test').attr("disabled", true);
			}
		}
	});
});

/* 검색텍스트창에 값을 입력하면 */
$('#searchContent').keyup(function(){
	var $content = $(this).val();	/* 그 값이 저장되고 */

	if(!$content) {
		$('#modelCode>option').show();	
	} else {
		$('#modelCode>option').hide().removeAttr('selected');	/* 기존에 모델명들은 전부다 비운다 */
		$("#modelCode>option[data-name*="+$content+"]").show();
		$("#modelCode>option[data-name*="+$content+"]").first().attr('selected', 'selected');
	}
});

