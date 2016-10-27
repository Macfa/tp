<div class="wrap myspace-wrap">
	<h1 class="tit center">마이페이지</h1>
	<div class="mypoint-box">
		<h3 class="mypoint-tit center">현재 보유중인 포인트</h3>
		<h2 class="tit-sub center mypoint"><?php echo number_format($mb['mbPoint']) ?>별</h2>
	</div>
	<? if ($isV20ApplyExist === 1) : ?>
	<div class="myspace-preorder v20">
		<a href="preorderV20State.php" class="preorderLink">
			<h1 class="preoderTitle">V20 사전예약 신청현황</h1>
		</a>
	</div>
	<?endif?>
	<? if ($isApplyExist >= 1) : ?>
	<div class="myspace-preorder <?echo $deviceEngName?>">
		<a href="<?echo $applyUrl?>" class="preorderLink">
			<h1 class="preoderTitle"><?echo $applyTitle?></h1>
		</a>
	</div>
	<br/>
	<?endif?>
	<? if ($isExchangeRefundNote7Exist === 1) : ?>
	<div class="myspace-preorder note7">
		<a href="exchangeRefundNote7State.php" class="preorderLink">
			<h1 class="preoderTitle">갤럭시 노트7 <? echo $type[$isExchangeRefundNote7Exist['enApplyType']]?> 신청현황</h1>
		</a>
	</div>
	<br/>
	<?endif?>
			<ul class="myspace-list-group">
				<li class="myspace-list-wrap"><a href="/cart" class="myspace-list">장바구니</a></li>
				<li class="myspace-list-wrap"><a href="orderList.php" class="myspace-list">주문내역</a></li>
				<li class="myspace-list-wrap"><a href="editMyInfo.php" class="myspace-list">내 정보수정</a></li>
				<li class="myspace-list-wrap"><a href="pointHistory.php" class="myspace-list">포인트 조회</a></li>
			</ul>
	<div class="clear"></div>



	

</div>