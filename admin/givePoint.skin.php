<div class="wrap">
	<h1>포인트 지급 / 차감</h1>	
	<form action="givePointAction.php" method="post">		
		아이디
		<?php if(isExist($_GET['mbEmail']) === True) : ?>
			<span style="color:#FFA000"><? echo $_GET['mbEmail']; ?></span>
			<input type="hidden" name="gpEmail" size="30" value="<? echo $_GET['mbEmail']; ?>">
		<br/><br/>
	  	현재포인트 <span style="color:#FFA000"><?echo $memberPoint." 포인트" ?></span>
		<? endif ?>
		<?php if(isExist($_GET['mbEmail']) === false) : ?>
			<input type="text" name="gpEmail" size="30">
		<?endif?>
		<br/><br/>
		포인트 <input type="text" name="gpPoint" size="30" value="" onchange="myFunction(this.value)">
		<br/><br/>
		<i class="ico-caution-small"></i> 차감할때는 - 붙여서 하면 됩니다 ex) -100
		<br/><br/>		
		컨텐츠 <input type="text" name="gpCont" size="30" >
		<br/><br/>	
		<i class="ico-caution-small"></i> 포인트 지급/차감 목적을 간단하게 적어주세요
		<br/><br/>

		<?php if(isExist($prParentEmail)) :?>
			<hr/>
			추천인 ID - 
			<span><? echo $prParentEmail; ?></span>
			<input type="hidden" name="prParentEmail" size="30" value="<? echo $prParentEmail; ?>">
			<br/>	<br/>
			포인트 <input type="text" name="prParentPoint" size="30" class="prParentPoint"><br/>
			컨텐츠 <input type="text" name="prParentCont" size="30" value="추천포인트지급">
			<br/><br/>	
		<?endif?>
		<?php if(isExist($prGrandEmail)) :?>			
			GRAND 추천인 ID - 
			<span><? echo $prGrandEmail; ?></span>
			<input type="hidden" name="prGrandEmail" size="30" value="<? echo $prGrandEmail; ?>">
			<br/><br/>
			포인트 <input type="text" name="prGrandPoint" size="30" class="prGrandPoint"><br/>
			컨텐츠 <input type="text" name="prGrandCont" size="30" value="3단계추천포인트지급">	
			<br/><br/>		
		 <?endif?>

		<input type="submit" value="적용">
	</form>
</div>
<script>
function myFunction(val) {
	var $val = val;
	$parentPoint = $val*0.05;
	$grandPoint = $val*0.05;
	$('.prParentPoint').val($parentPoint);
	$('.prGrandPoint').val($grandPoint);
}
</script>