$(function(){
	require([ 
		'validate'
	], function (chart) {
		$('#order-form').parsley({
			errorsWrapper: '<ul class="parsley-errors-cart"></ul>'
		});
	});

});

$('.js-orderQuantity').on('change keyup', function(event){
	var $key = $(this).attr('data-key');
	var $quantity = $(this).val();
	if ($quantity < 1) {
		$quantity = 1;
		$(this).val(1);
	}
	var $rowResult = $quantity * $(this).attr('data-point');
	$('.js-orderRowResult'+$key).text(setNumComma($rowResult)).attr('data-result', $rowResult);
	setOrderTotalResult();
});

$('.js-orderDelete').click(function(){
	var $key = $(this).attr('data-key');
	$('.js-orderRow'+$key).addClass('removing').children('td').wrapInner('<div />').children().slideUp();
	setTimeout(function(){$('.js-orderRow'+$key).remove();},500);
	return false;
});

$('.js-orderQuantity').focus(function(){
	this.select();
});

$('.js-newAddress').click(function(){
	initAddress();
	return false;
});

function initAddress(){
	var $target = $('.js-addressWrap input[type=text]');
	$target.val('');
	setLabel('.js-addressWrap input[type=text]');
	$('.js-defaultAddress').prop('checked','');
}

function setOrderTotalResult(){
	var $totalResult = 0;
	$('.js-orderRowResult').each(function(index,item){
		$totalResult = $totalResult +  parseInt($(item).attr('data-result'));
	});
	$('.js-totalResult').text(setNumComma($totalResult));
	$('.js-totalResultInp').val($totalResult);
};