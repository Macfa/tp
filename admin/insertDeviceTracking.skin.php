<div class="wrap">
<h1>송장번호 입력</h1>
	<form action="insertDeviceTrackingAction.php" method="post">		
		<textarea style="width:600px; height:500px; background-color:white; font-size:0.8em; padding:auto; overflow:scroll; " name="pvDeviceTracking"></textarea>
		<br/><br/>
		<input class="js-convert" type="submit" value="등록">
		
	</form>
</div>

<Script>
$('.js-convert').click(function(){
	var $text = $('[name=pvDeviceTracking]').val();
	console.log($text);
	$('[name=pvDeviceTracking]').val(replaceAll('\t','||',$text));
});
</script>