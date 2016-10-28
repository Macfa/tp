<div class="nav-wrap">
	<nav class="js-gnb">
		<div class="wrap">
			<a id="logo" href="<?=$cfg['url']?>">
				<img src="<?=PATH_IMG?>/logo.png" alt="트라움플랜잇" class="logo_big">
				<img src="<?=PATH_IMG?>/logo-small.png" alt="트라움플랜잇" class="logo_small">
			</a><ul class="gnb js-menu">
			<li class="gnb-tit-wrap normal">
				<a href="/page/about.php" class="gnb-tit" id="link-gnb-about">
					<span>소개</span>	
				</a>
			</li><li class="gnb-tit-wrap normal <?=$isGnbSkActive?>">
				<a href="/sk" class="gnb-tit" id="link-gnb-sk">
					<span>SK</span>	
				</a>
			</li><li class="gnb-tit-wrap normal <?=$isGnbKtActive?>">
				<a href="/kt" class="gnb-tit" id="link-gnb-kt">
					<span>KT</span>
				</a>
			</li><li class="gnb-tit-wrap normal <?=$isGnbLguplusActive?>">
				<a href="/lguplus" class="gnb-tit" id="link-gnb-lguplus">
					<span>LGU+</span>
				</a>
			</li>

			

			<li class="gnb-tit-wrap normal divide <?=$isGnbSamsungActive?>">
				<a href="/samsung" class="gnb-tit" id="link-gnb-samsung">
					<span>삼성</span>	
				</a>
			</li><li class="gnb-tit-wrap normal <?=$isGnbAppleActive?>">
				<a href="/apple" class="gnb-tit" id="link-gnb-apple">
					<span>애플</span>	
				</a>
			</li><li class="gnb-tit-wrap normal <?=$isGnbLgActive?>">
				<a href="/lg" class="gnb-tit" id="link-gnb-lg">
					<span>LG</span>	
				</a>
			</li>
			
			<li class="gnb-tit-wrap divide pocketfi <?=$isGnbPocketfiActive?>">
				<a href="/pocketfi" class="gnb-tit" id="link-gnb-pocketfi">
					<span>휴대용와이파이</span>	
				</a>
			</li><li class="gnb-tit-wrap five-char <?=$isGnbWatchActive?>">
				<a href="/watch" class="gnb-tit" id="link-gnb-watch">
					<span>스마트워치</span>	
				</a>
			</li><li class="gnb-tit-wrap big <?=$isGnbKidsActive?>">
				<a href="/kids" class="gnb-tit" id="link-gnb-kids">
					<span>키즈폰</span>	
				</a>
			</li>

			<li class="gnb-tit-func-wrap divide" id="link-gnb-mall">
				<a href="<?php echo $cfg['url']?>/gifts" class="gnb-tit-func" id="link-gnb-logout">
					<span>포인트몰</span>	
				</a>
			</li>
			<?php if($isLogged === TRUE) :?>
			<li class="gnb-tit-func-wrap" id="link-gnb-mall">
				<a href="<?php echo $cfg['url']?>/cart" class="gnb-tit-func" id="link-gnb-logout">
					<span>장바구니</span>	
				</a>
			</li>
			<li class="gnb-tit-func-wrap" id="link-gnb-log">
				<a href="<?php echo $cfg['url']?>/user/logout.php?returnURL=<?php echo $cfg['current_url']?>" class="gnb-tit-func" id="link-gnb-logout">
					<span>로그아웃</span>	
				</a>
			</li><li class="gnb-tit-func-wrap five-char">
				<a href="<?=$cfg['url']?>/user/mySpace.php" class="gnb-tit-func" id="link-gnb-mypage">
					<span>마이페이지</span>	
				</a>
			</li>
			<?php else :?>
			<li class="gnb-tit-func-wrap">
				<a href="<?php echo $cfg['url']?>/user/login.php?returnURL=<?php echo $cfg['current_url']?>" class="gnb-tit-func" id="link-gnb-login">
					<span>로그인</span>	
				</a>
			</li><li class="gnb-tit-func-wrap">
				<a href="<?=$cfg['url']?>/user/signUp.php" class="gnb-tit-func"  id="link-gnb-signUp">
					<span>회원가입</span>	
				</a>
			</li>
			<?php endif?>
			<!--
			<?php if($isAdmin === TRUE) : ?>
			<li class="gnb-tit-func-wrap five-char">
				<a href="<?=$cfg['url']?>/admin" class="gnb-tit-func" id="link-gnb-admin">
					<span>어드민</span>	
				</a>
			</li>			
			<?php endif?>
			-->
			<!--<li class="gnb-tit-func-wrap  bookmark">
				<a href="#" class="gnb-tit-func"  id="link-gnb-bookmark">
					<span>즐겨찾기</span>	
				</a>
			</li>
			-->
			<li class="nav-mobile-btn-wrap">
				<button class="nav-mobile-btn js-navMobileBtn">
					메뉴
				</button>
			</li>
			</ul>
		</div>
	</nav>

	<?php if($isShowManufSubNav)	require_once("headManufSub.skin.php"); ?>

	<?php if($isShowDeviceNav)	require_once("headDeviceNav.skin.php"); ?>

</div>
<div class="nav-mobile-wrap js-navMobile blur-exc">
	<ul class="nav-mobile js-menu">
	<li class="nav-mobile-item-wrap">
		<a href="/page/about.php" class="nav-mobile-item" id="link-gnb-about">
			<span>소개</span>	
		</a>
	</li><li class="nav-mobile-item-wrap">
		<a href="/sk" class="nav-mobile-item <?=$isGnbSkActive?>" id="link-gnb-sk">
			<span>SK</span>	
		</a>
	</li><li class="nav-mobile-item-wrap">
		<a href="/kt" class="nav-mobile-item <?=$isGnbKtActive?>" id="link-gnb-kt">
			<span>KT</span>
		</a>
	</li>
	<li class="nav-mobile-item-wrap">
		<a href="/lguplus" class="nav-mobile-item <?=$isGnbLguplusActive?>" id="link-gnb-lguplus">
			<span>LGU+</span>
		</a>
	</li>
	
	<li class="nav-mobile-item-wrap divide">
		<a href="/samsung" class="nav-mobile-item <?=$isGnbSamsungActive?>"  id="link-gnb-samsung">
			<span>삼성</span>	
		</a>
	</li><li class="nav-mobile-item-wrap">
		<a href="/apple" class="nav-mobile-item <?=$isGnbAppleActive?>"  id="link-gnb-apple">
			<span>애플</span>	
		</a>
	</li><li class="nav-mobile-item-wrap">
		<a href="/lg" class="nav-mobile-item <?=$isGnbLgActive?>"  id="link-gnb-lg">
			<span>LG</span>	
		</a>
	</li>
	
	<li class="nav-mobile-item-wrap divide">
		<a href="/pocketfi" class="nav-mobile-item <?=$isGnbPocketfiActive?>"  id="link-gnb-pocketfi">
			<span>휴대용와이파이</span>	
		</a>
	</li><li class="nav-mobile-item-wrap">
		<a href="/watch" class="nav-mobile-item <?=$isGnbWatchActive?>"  id="link-gnb-watch">
			<span>스마트워치</span>	
		</a>
	</li><li class="nav-mobile-item-wrap">
		<a href="/kids" class="nav-mobile-item <?=$isGnbKidsActive?>" id="link-gnb-kids">
			<span>키즈폰</span>	
		</a>
	</li>

	<?php if($isLogged === TRUE) :?>
	<li class="nav-mobile-item-wrap nav-mobile-func divide" id="link-gnb-mall">
		<a href="<?php echo $cfg['url']?>/gifts" class="nav-mobile-item" id="link-gnb-logout">
			<span>포인트몰</span>	
		</a>
	</li>
	<li class="nav-mobile-item-wrap nav-mobile-func" id="link-gnb-mall">
		<a href="<?php echo $cfg['url']?>/cart" class="nav-mobile-item" id="link-gnb-logout">
			<span>장바구니</span>	
		</a>
	</li>
	<li class="nav-mobile-item-wrap nav-mobile-func divide">
		<a href="<?=$cfg['url']?>/user/mySpace.php" class="nav-mobile-item"  id="link-gnb-mypage">
			<span>마이페이지</span>	
		</a>
	</li><li class="nav-mobile-item-wrap nav-mobile-func">
		<a href="<?=$cfg['url']?>/user/logout.php" class="nav-mobile-item"  id="link-gnb-logout">
			<span>로그아웃</span>	
		</a>
	</li> 
	<?php else :?>
	<li class="nav-mobile-item-wrap divide nav-mobile-func">
		<a href="<?=$cfg['url']?>/user/signUp.php" class="nav-mobile-item"  id="link-gnb-signUp">
			<span>회원가입</span>	
		</a>
	</li><li class="nav-mobile-item-wrap nav-mobile-func">
		<a href="<?=$cfg['url']?>/user/login.php" class="nav-mobile-item"  id="link-gnb-login">
			<span>로그인</span>	
		</a>
	</li>
	<?php endif?>
	<li class="nav-mobile-close-wrap">
		<button class="nav-mobile-close js-navMobileCloseBtn">
			Ⅹ
		</button>
	</li>
	</ul>
</div>
<div class="<?=$containerClassPrefix?>container">
