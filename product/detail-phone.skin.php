<div class="wrap">
	<h2 class="tit center">
	
		<div class="tit-affix">하늘에서 내려온 호갱구세주!</div>
		티플이 드리는 미친 사은품
		<i class="detail-ico-gift-list"></i>

	</h2>
	<h2 class="tit center">번호이동시! (택1)</h2>
	<?php
		$additialWhere = "WHERE (gfKey = 1 or gfKey = 2 or gfKey = 3 or gfKey = 4)"; 
		$selectionList = TRUE;
		include("./giftList.inc.php");
	?>
	<div class="tit-sub-detail">+ 추가 사은품!</div>
	<?php
		$additialWhere = "WHERE gfKey = 6"; 
		$isBig = true;
		$isCentering = true;
		include("./giftList.inc.php");
	?>
	
	<h2 class="tit center">기기변경시! (51요금제 이상)</h2>
	<?php
		$additialWhere = "WHERE (gfKey = 1 or gfKey = 2 or gfKey = 3 or gfKey = 4 or gfKey = 6)"; 
		$selectionList = TRUE;
		include("./giftList.inc.php");
	?>

	<h2 class="tit center">기기변경시! (51요금제 미만)</h2>
	<?php
		$additialWhere = "WHERE (gfKey = 7 or gfKey = 5 or gfKey = 10)"; 
		$selectionList = TRUE;
		include("./giftList.inc.php");
	?>
	<div class="tit-sub-detail">+ 추가 사은품!</div>
	<?php
		$additialWhere = "WHERE gfKey = 11"; 
		$isBig = true;
		$isCentering = true;
		include("./giftList.inc.php");
	?>
</div>