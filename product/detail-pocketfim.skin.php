<div class="wrap">
	
	<h2 class="tit center">		
		<div class="tit-affix">하늘에서 내려온 호갱구세주!</div>
		티플이 드리는 미친 사은품
		<i class="detail-ico-gift-list"></i>
	</h2>
	</div>
	<div class="tit-sub center">선택A. 프리미엄 2종 중 택1</div>
	<div class="tit-sub center">프리미엄 사은품</div>
	<?php
		$additialWhere = "WHERE (gfKey = 4 or gfkey = 24)"; 
		$selectionList = TRUE;
		include("./giftList.inc.php");
	?>

	<center>

	<div class="tit-sub center">선택B. 프리미엄 2종 중 택1 + 추가사은품</div>
	<div class="tit-sub center">프리미엄 사은품</div>
	<?php
		$additialWhere = "WHERE (gfKey = 2 or gfkey = 3)"; 
		$selectionList = TRUE;
		include("./giftList.inc.php");
	?>
	<div class="tit-sub center">+ <br/> 추가 사은품중 택1</div>
	<?php
		$additialWhere = "WHERE (gfKey = 10 or gfkey = 7)"; 
		$selectionList = TRUE;
		include("./giftList.inc.php");
	?>

	<center>


</div>