<div class="wrap mypageList-wrap center">
	<h1 class="center tit">내 정보 수정</h1>
	<form method="post" action="editMyInfoAction.php">	
		<section class="section txt-left">
			<label class="inp-wrap">
				<input type="password" class="inp-txt" name="mbPw"/>
				<div class="inp-label">새 비밀번호</div>
				<span class="inp-hint"></span>
			</label>
			<br/>
			<label class="inp-wrap">
				<input type="password" class="inp-txt" name="mbPwCheck"/>
				<div class="inp-label">새 비밀번호 확인</div>
				<span class="inp-hint"></span>
			</label>
			<Br/>
			<label class="inp-wrap">
				<input type="text" class="inp-txt" name="mbName" value="<?php echo $mb['mbName']?>"/>
				<div class="inp-label">성함</div>
			</label>
			<br/>
			<label class="inp-wrap">
				<input type="text" class="inp-txt" name="mbPhone" value="<?php echo $mb['mbPhone']?>"/>
				<div class="inp-label">휴대폰 번호</div>
				<span class="inp-hint"></span>
			</label>
		</section>
		<input type="submit" class="apply-submit btn-filled js-trackLink" target="_blank" id="link-detail-plan-apply" value="수정 완료"/>
	</form>
</div>


