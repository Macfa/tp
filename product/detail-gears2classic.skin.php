<div class="wrap">
	
	<h2 class="tit center">		
		<div class="tit-affix">하늘에서 내려온 호갱구세주!</div>
		티플이 드리는 미친 사은품
		<i class="detail-ico-gift-list"></i>
	</h2>
	<div class="tit-sub center">프리미엄 사은품 택1</div>
	<?php
		$additialWhere = "WHERE (gfKey = 3 or gfKey = 24)"; 
		$selectionList = TRUE;
		include("./giftList.inc.php");
	?>
	<div class="tit-sub center">+<BR/>추가 사은품 택1</div>
	<?php
		$additialWhere = "WHERE (gfKey = 7 or gfKey = 5 or gfkey = 10)"; 
		$selectionList = TRUE;
		include("./giftList.inc.php");
	?>

<section class="katalk-friend">
	<div class="check"></div>
	<span class="katalk-friend-txt">카톡 친구를 맺고 메세지를 보내주시면<br>정책이 오를 때 알려드리겠습니다!</span>
	<a href="http://plus.kakao.com/home/lzsdhrk5" target="_blank" class="katalk-friend-a">
		<i class="katalk-friend-ico"></i>
	</a>
</section>

</div>