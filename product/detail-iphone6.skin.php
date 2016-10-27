<div class="wrap">
	
	<h2 class="tit center">		
		<div class="tit-affix">하늘에서 내려온 호갱구세주!</div>
		티플이 드리는 미친 사은품
		<i class="detail-ico-gift-list"></i>		
	</h2>
	<div class="center">
		<div class="plan-info btn">
			<span class="plan-info-txt">번호이동(전 요금제 대상)</span>
		</div>
	</div>
	<div class="tit-sub center">프리미엄 사은품</div>
	<div class="tit-sub center">모두 드립니다!</div>
	<?php
		$additialWhere = "WHERE (gfKey = 4 or gfKey = 24 or gfKey = 26)";		
		include("./giftList.inc.php");
	?>

	<div class="center">
		<div class="plan-info btn">
			<span class="plan-info-txt">기기변경(59이상)</span>
		</div>
	</div>
	<div class="tit-sub center">프리미엄 사은품</div>
	<div class="tit-sub center">모두 드립니다!</div>
	<?php
		$additialWhere = "WHERE (gfKey = 4 or gfKey = 24)";		
		include("./giftList.inc.php");
	?>
	<div class="center">
		<div class="plan-info btn">
			<span class="plan-info-txt">기기변경(59미만)</span>
		</div>
	</div>
	<div class="tit-sub center">선택 사은품 택1</div>
		<?php
		$additialWhere = "WHERE (gfKey = 26 or gfKey = 4 or gfKey = 24)";
		$selectionList = TRUE;
		include("./giftList.inc.php");
	?>


	<div class="tit-sub-select">선택4</div>
	<?php
		$additialWhere = "WHERE (gfKey = 10 or gfKey = 5 or gfkey = 2 or gfkey = 11)"; 
		include("./giftList.inc.php");
	?>


</div>