$(function(){
	require([ 
		'validate'
	], function (chart) {
		$('#cart-form').parsley({
			errorsWrapper: '<ul class="parsley-errors-cart"></ul>'
		});
	});
});

$('.js-tableChk').change(function(){
	if (this.checked == true)
		$(this).parents('tr').addClass('active');
	else
		$(this).parents('tr').removeClass('active');

	setTotalResult();
});

$('.js-tableAllChk').change(function(){
	$('.js-tableChk').prop("checked", this.checked);
	$('.js-tableChk').trigger('change');
	if (this.checked == true)
		$('.js-tableChk').parents('tr').addClass('active');
	else
		$('.js-tableChk').parents('tr').removeClass('active');
	setTotalResult();

});

$('.js-cartQuantity').on('change keyup', function(event){
	var $key = $(this).attr('data-key');	
	var $quantity = $(this).val();	
	if ($quantity < 1) {
		$quantity = 1;
		$(this).val(1);
	}
	var $rowResult = $quantity * $(this).attr('data-point');
	$('.js-cartRowResult'+$key).text(setNumComma($rowResult));
	$('.js-cartRow'+$key).find('.js-tableChk').attr('data-result', $rowResult)
	setTotalResult();
	$.ajax({
		url:'/user/cartQuantityUpdate.php',
		type:'get',
		async:false,
		data:{id : $key, quantity : $quantity},
		success:function(){}
	});
});

$('.js-cartQuantity').focus(function(){
	this.select();
});

$('.js-cartDelete').click(function(){
	var $key = $(this).attr('data-key');
	$.ajax({
		url:'/user/cartDelete.php',
		type:'get',
		async:false,
		data:{id : $key},
		success:function(){
			$('.js-cartRow'+$key).addClass('removing').children('td').wrapInner('<div />').children().slideUp();
		}
	});
	return false;
});

function setTotalResult(){
	var $totalResult = 0;
	$('.js-tableChk:checked').each(function(index,item){
		$totalResult = $totalResult +  parseInt($(item).attr('data-result'));
	});
	$('.js-totalResult').text(setNumComma($totalResult));
	$('.js-totalResultInp').val($totalResult);
};