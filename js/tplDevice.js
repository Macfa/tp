$('.js-SerialNumber').click(function(){		/* 일련번호 옆에 있는 추가 버튼을 클릭 시 추가 input 폼과 checkbox 폼이 리스트에 계속 붙는다 */
	var btn_input = '<tr><td><input type="text" class="js-SerialNumber-buttonList" name="serialNumber[]"> <input type="checkbox" class="js-SerialNumber-box" name="checkbox"> <input type="text" name="delivery[]" class="test" disabled></td></tr>';
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

$(document).on('change', '.js-SerialNumber-box', function(){		/* 일련번호 checkbox 값이 변경될 시 출고처를 적는 부분의 disabled 속성 제거 */
	$(this).siblings('.test').removeAttr("disabled");
	
});

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
	$neKey = $(this).val();
	
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

$(function(){
	$('#modelCode').trigger('change');
});