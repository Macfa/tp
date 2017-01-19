<div class="wrap">
	
	<h2 class="tit center">		
		<div class="tit-affix">하늘에서 내려온 호갱구세주!</div>
		티플이 드리는 미친 사은품
		<i class="detail-ico-gift-list"></i>
		<h3 class="sub center">프리미엄 정품사은품 4종 중 택1 선택</h3>
	</h2>
	<?php
		$additialWhere = "WHERE (gfKey = 1 or gfKey = 2 or gfKey = 3)"; 
		$selectionList = TRUE;
		include("./giftList.inc.php");
	?>
	<h3 class="tit-sub-select center">선택4</h3>
	<?php
		$additialWhere = "WHERE (gfKey = 7 or gfKey = 5 or gfkey = 10)"; 
		include("./giftList.inc.php");
	?>
</div>