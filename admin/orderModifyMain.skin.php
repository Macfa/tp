<div class="wrap">
	<form method="POST" action="orderModifyMainUpdate.php">
		<div class="tit">
			노란색 부분이 메인에 노출되는 부분
		</div>
		<ul class="sortable-grid sortable-main">
			<?php $i = 1;foreach($arrResult as $device) :?>
			<li class="ui-state-default">
			<?php echo $device['dvTit']?>
			<input type="hidden" value="<?php echo $device['dvKey']?>" name="mainDevice[]"/>
		  </li> 
		  <?php  $i++; endforeach; ?>
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
		$(".sortable-grid").sortable();
		$(".sortable-grid").disableSelection();
	});
});
</script>