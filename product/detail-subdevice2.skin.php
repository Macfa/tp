<div class="wrap">
	<h2 class="tit center">		
		<div class="tit-affix">하늘에서 내려온 호갱구세주!</div>
		티플이 드리는 미친 사은품
		<i class="detail-ico-gift-list"></i>
		<h3 class="sub center">프리미엄 정품사은품 3종 중 택1 선택</h3>
	</h2>
	<?php
		$additialWhere = "WHERE (gfKey = 1 or gfKey = 3)"; 
		$selectionList = TRUE;
		include("./giftList.inc.php");
	?>
	<div class="tit-sub-select">선택3</div>
	<?php
		$additialWhere = "WHERE (gfKey = 7 or gfKey = 5 or gfkey = 10)"; 
		include("./giftList.inc.php");
	?>
	<div class="tit-sub center">+ <br/> 기본제공</div>
	<?php
		$additialWhere = "WHERE (gfKey = 21 )"; 
		$isCentering = true;
		include("./giftList.inc.php");
	?>

</div>