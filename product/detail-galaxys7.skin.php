<div class="wrap">
	
	<h2 class="tit center">		
		<div class="tit-affix">하늘에서 내려온 호갱구세주!</div>
		티플이 드리는 미친 사은품
		<i class="detail-ico-gift-list"></i>
		<h3 class="sub center">프리미엄 정품사은품 3종 중 택1 선택</h3>
	</h2>
	<?php
		$additialWhere = "WHERE (gfKey = 4 or gfKey = 1 or gfKey = 3)"; 
		$selectionList = TRUE;
		include("./giftList.inc.php");
	?>
	<div class="tit-sub center">+ <br/> 고객감사 사은품 3종 중 택2 선택</div>
	<?php
		$additialWhere = "WHERE (gfKey = 5 or gfkey = 10 or gfKey = 7)"; 
		include("./giftList.inc.php");
	?>
	<div class="tit-sub center">기본증정 사은품</div>
	<?php
		$additialWhere = "WHERE (gfKey = 21 or gfKey = 22)"; 
		include("./giftList.inc.php");
	?>
<section class="katalk-friend">
	<div class="check"></div>
	<span class="katalk-friend-txt">번호이동 고객님은 사은품 별도 문의 부탁드립니다</span>	
</section>
</div>