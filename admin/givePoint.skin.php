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
		포인트 <input type="text" name="gpPoint" size="30">
		<br/><br/>
		<i class="ico-caution-small"></i> 차감할때는 - 붙여서 하면 됩니다 ex) -100
		<br/><br/>		
		컨텐츠 <input type="text" name="gpCont" size="30" >
		<br/><br/>	
		<i class="ico-caution-small"></i> 포인트 지급/차감 목적을 간단하게 적어주세요
		<br/><br/>			

		<input type="submit" value="적용">
	</form>
</div>