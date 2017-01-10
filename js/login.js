$(function(){

	require([ 
		'parsley.min'
	], function (parsley) {
		$('#login-form').parsley();
		
		window.Parsley.on('field:error', function() {
			var $label = this.$element.parent('label');
			if ($label.hasClass('parsley-success')){
				$label.removeClass('parsley-success');
			}
			$label.addClass('parsley-error');
		});

		window.Parsley.on('field:success', function() {
			var $label = this.$element.parent('label');
			if ($label.hasClass('parsley-error')){
				$label.removeClass('parsley-error');
			}
			$label.addClass('parsley-success');
		});
	});

});