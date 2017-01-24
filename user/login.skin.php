<div class="wrap login-wrap">
	<form id="login-form" action="loginCheck.php" method="POST">
	<input type="hidden" name="token" value="<?=createToken()?>"/>
	<input type="hidden" name="returnURL" value="<?=$_GET['returnURL']?>"/>
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
						<input type="password" name="mbPw" class="inp-block" name="pw" data-parsley-required required>
					</label>
				</div>
			</div>
			<div class="row no-border">
				<div class="col-2">
					<label class="col-btn">
						<input type="submit" class="btn-row" value="로그인">
					</label>
				</div><div class="col-2">
					<label class="col-btn">
						<a href="./signUp.php" class="btn-sub">회원가입</a>
					</label>
				</div>
			</div>
		
	</section>
	</form>
	<br/><br/>
	<div class="center"><i class="ico-caution-small"></i> 로그인이 안되시면 팝업차단 설정을 해제해주세요.</div>
	<section class="row-group">
		<button class="login-btn-kakao js-kakaoLogin">
			<div class="login-btn-ico-kakao">
			</div><div class="login-btn-cont">
				카카오톡 아이디로 로그인
			</div>
		</button>
		<button class="login-btn-naver js-naverLogin">
			<div class="login-btn-ico-naver">
			</div><div class="login-btn-cont">
				네이버 아이디로 로그인
			</div>
		</button>
		<!--a class="login-btn-fb" href="">
			<div class="login-btn-ico-fb">
			</div><div class="login-btn-cont">
				페이스북 아이디로 로그인
			</div>
		</a-->
	</section>
</div>

<?php echo $kakao->getLoginScript()?>
<?php echo $naver->getLoginScript()?>