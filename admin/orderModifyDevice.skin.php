<div class="wrap">
	<form method="POST" action="orderModifyDeviceUpdate.php">
		<div class="tit-sub">
			상세 카테고리(sk,kt,삼성 등)의 순서도 아래 순서를 참고하여 변경됨
		</div>
		<ul id="sortable">
			<?php foreach($arrResult as $device) :?>
			<li class="ui-state-default">
			<?php echo $device['dvTit']?>
			<input type="hidden" value="<?php echo $device['dvKey']?>" name="listDevice[]"/>
		  </li> 
		  <?php endforeach; ?>
		</ul>
		<br/>
		<input type="submit" value="완료"/>
	</form>
</div>
<script>
$(function() {
	require([ 
		'jquery-ui.min'
	], function (jqueryui) {
		$("#sortable").sortable();
		$("#sortable").disableSelection();
	});
});
</script>