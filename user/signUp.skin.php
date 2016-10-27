<div class="wrap login-wrap">
	<?php if($isSnsLogin == false) :?>
	<div class="row-group">
		<button class="login-btn-kakao js-kakaoLogin">
			<div class="login-btn-ico-kakao">
			</div><div class="login-btn-cont">
				카카오톡 아이디로 회원가입
			</div>
		</button>
		<button class="login-btn-naver js-naverLogin">
			<div class="login-btn-ico-naver">
			</div><div class="login-btn-cont">
				네이버 아이디로 회원가입
			</div>
		</button>
		<!--a class="login-btn-fb" href="">
			<div class="login-btn-ico-fb">
			</div><div class="login-btn-cont">
				페이스북 아이디로 회원가입
			</div>
		</a-->
	</div>
	<?php endif?>

	<form id="login-form" method="post" action="./signUpUpdate.php">
		<input type="hidden" name="token" value="<?=createToken()?>"/>
		<input type="hidden" name="returnURL" value="<?=$signupReturnURL?>"/>

		<section class="row-group">
			<div class="row">
				<label class="inp-radio">
					<input type="checkbox" name="agreePrivacyInfo" value="1" data-parsley-required/>
					<div class="inp-radio-btn"></div>
					<span class="inp-radio-label">개인정보수집/이용동의</span>
					<div class="inp-radio-chk"></div>
				</label>
				<a class="agree-btn js-layerViewToggle" target="layerView" href="./agreePrivacyInfo.php">
					보기
				</a>
			</div>
		</section>

		<?php if($isSnsLogin == false) :?>
		<section class="row-group">
			<div class="row">
				<div class="col-tit">
					이메일
				</div><div class="col-cont-wrap">
					<label class="col-inp-txt" id="asd">
						<input type="email" name="mbEmail" class="inp-block" data-parsley-required data-parsley-type="email" required>
					</label>
				</div>
			</div>
			<div class="row">
				<div class="col-tit">
					비밀번호
				</div><div class="col-cont-wrap">
					<label class="col-inp-txt">
						<input type="password" name="mbPw" class="inp-block" name="pw" id="signupPw" data-parsley-minlength="8" data-parsley-required required>
					</label>
				</div>
			</div>
			<div class="row">
				<div class="col-tit multiple-line">
					비밀번호<br/>확인
				</div><div class="col-cont-wrap">
					<label class="col-inp-txt">
						<input type="password" name="mbPwCheck" class="inp-block" name="pw-check" data-parsley-minlength="8" data-parsley-required required data-parsley-equalto="#signupPw">
					</label>
				</div>
			</div>
		</section>
		<?php endif?>

		<section class="row-group">
			<div class="row">
				<div class="col-tit">
					성함
				</div><div class="col-cont-wrap">
					<label class="col-inp-txt">
						<input type="text" name="mbName" class="inp-block" data-parsley-required required>
					</label>
				</div>
			</div>
			<div class="row">
				<div class="col-tit">
					휴대폰번호
				</div><div class="col-cont-wrap">
					<label class="col-inp-txt">
						<input type="tel" name="mbPhone" class="inp-block" data-parsley-required data-parsley-pattern="^01[0 1 6]-?\d{3,4}-?\d{4}$" required>
					</label>
				</div>
			</div>
		</section>
		<div class="row row-group">
			<label class="col-inp-btn">
				<input type="submit" class="btn-row" value="가입완료">
			</label>
		</div>
	</form>
</div>

<?php
	echo $naver->getLoginScript();
	echo $kakao->getLoginScript();
?>