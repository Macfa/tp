$(function(){
	
});


$('.inp-txt').load(function(){
	setLabel(this);
});

$("form [data-action]").click(function(){
	var $form = $(this).parents('form');
	var $action = $(this).attr('data-action');
	$form.attr('action', $action);
	$form.submit();
	return false;
});

$('.inp-txtarea').on('keyup change',function(){
	$(this).css("height","1px").css("height",(20+$(this).prop("scrollHeight"))+"px");
	setLabel(this);
});


$('.js-fileInput').change(function(){
	var $fileName = getFileName($(this).val());
	var $allowed = $(this).attr('data-allowed');
	if ($allowed) {
		var $arrAllowed = $allowed.split(',');
		if(isAllowedExtension($fileName, $arrAllowed) == false){
			alert($allowed+'확장자만 업로드 가능합니다.');
			return false;
		}
	}
	$('.js-fileName').text($fileName);
	setLabel(this);
});

function getFileName($val){
    var tmpStr = $val;
    
    var cnt = 0;
    while(true){
        cnt = tmpStr.indexOf("/");
        if(cnt == -1) break;
        tmpStr = tmpStr.substring(cnt+1);
    }
    while(true){
        cnt = tmpStr.indexOf("\\");
        if(cnt == -1) break;
        tmpStr = tmpStr.substring(cnt+1);
    }
    
    return tmpStr;
}

$(function() {
	$('[data-default]').each(function(){		
		//console.log($(this).attr('data-default'));		
		if($(this).find('input[type=radio]').size() > 0 || $(this).find('input[type=checkbox]').size() > 0){
			var $mutipleValue = $(this).attr('data-default').split(',');
			var $target = $(this);
			$.each($mutipleValue, function(index, value){
				console.log();
				$target.find('[value='+value+']').prop('checked', true);				
			});
		} else 
			$(this).val($(this).attr('data-default'));		
	});	
});
