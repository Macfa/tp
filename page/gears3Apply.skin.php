

<h1 class="tit">기어S3 신청</h1>
<BR/><BR/><BR/>
<div class="preorder-wrap">
	<?php echo $planCalculator->create();?>
	<Br/><br/>
	<?php if($isLogged == false) :?>
	<section class="section">
		<h3 class="tit-sub center">로그인후 구매신청이 가능합니다.</h3>
		<a href="<?php echo $cfg['login_url']?>" class="btn-filled-sub">로그인/회원가입</a>
	</section>
	<?php endif?>
	<form action="preorderV20ApplyAction.php" method="post">
		<input type="hidden" name="pvKey" value="<?php echo $preorder['pvKey']?>">
		<section class="section txt-left">
			<h2 class="tit-sub">기어S3 신청하기</h2>
			<i class="ico-person-small"></i>예약자명 <Br/> <span><?php echo $mb['mbName']?></span><br/><br/>
			<label class="inp-wrap">
				<i class="ico-email-small"></i>
				<input type="text" class="inp-txt" name="V20Email" value="<?php echo ($validEmail)?$validEmail:''; ?>" />
				<div class="inp-label">이메일</div>
			</label>
			<br>
			<label class="inp-wrap">
				<i class="ico-tel-small"></i>
				<input type="text" class="inp-txt" name="V20Phone" value="<?php echo ($validPhone)?$validPhone:''; ?>" />
				<div class="inp-label">전화번호</div>
			</label>
			<br>
			<label class="inp-wrap">
				<i class="ico-calendar-small"></i> 
				<input type="text" class="inp-txt" name="V20Birth" value="<?php echo str_replace('-','',$preorder['pvBirth']); ?>" />
				<div class="inp-label">생년월일</div>
				<span class="inp-hint">19701015 형식으로 입력</span>
			</label>
		</section>
	</form>
	<?php if($isLogged === true) :?>
	<a href="http://online.olleh.com/index.jsp?prdcID=A75A0356-FF52-466D-AA88-796E0693E0F9" target="_blank" class="btn-filled-primary-dense">신청하기</a>
	<?php endif?>

</div>
