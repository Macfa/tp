<div class="wrap">
	
	<h2 class="tit center">		
		<div class="tit-affix">하늘에서 내려온 호갱구세주!</div>
		티플이 드리는 미친 사은품
		<i class="detail-ico-gift-list"></i>
	</h2>
	<h3 class="tit-sub center">선택A. 백화점 5만원 상품권</h3>
	<div class="center">
	<?php
		$additialWhere = "WHERE (gfKey = 14)"; 
		include("./giftList.inc.php");
	?>
	</div>
	<h3 class="tit-sub center">선택B. 3종 실속 사은품</h3>
	<?php
		$additialWhere = "WHERE (gfKey = 7 or gfKey = 5 or gfkey = 10)"; 
		include("./giftList.inc.php");
	?>

<section class="katalk-friend">
	<div class="check"></div>
	<span class="katalk-friend-txt">번호이동 고객님은 사은품 별도 문의 부탁드립니다</span>	
</section>

</div>