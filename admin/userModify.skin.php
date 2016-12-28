<div class="wrap myspace-wrap">
	<h1 class="tit center">비밀번호/정보수정</h1>

	<form id="user-modify-form" method="post" action="./userModifyUpdate.php">
		<input type="hidden" name="token" value="<?=createToken()?>"/>
		<input type="hidden" name="returnURL" value="<?=$_GET['returnUrl']?>"/>

		<?php if ($mb['mbSns'] === '0') :?>
		<section class="row-group">
			<div class="row">
				<div class="col-tit">
					이메일
				</div><div class="col-cont-wrap">
					<div class="col-txt">
						<?php echo $mb['mbEmail']?>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-tit">
					기존 비밀번호
				</div><div class="col-cont-wrap">
					<label class="col-inp-txt">
						<input type="password" name="mbPw" class="inp-txt"data-parsley-minlength="8">
					</label>
				</div>
			</div>
			<div class="row">
				<div class="col-tit">
					새 비밀번호
				</div><div class="col-cont-wrap">
					<label class="col-inp-txt">
						<input type="password" name="newPw" class="inp-txt"  id="newPw" data-parsley-minlength="8">
					</label>
				</div>
			</div>
			<div class="row">
				<div class="col-tit multiple-line">
					새 비밀번호<br/>확인
				</div><div class="col-cont-wrap">
					<label class="col-inp-txt">
						<input type="password" name="newPwCheck" class="inp-txt" data-parsley-minlength="8" data-parsley-equalto="#newPw">
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
						<input type="text" name="mbName" class="inp-txt" value="<?php echo $mb['mbName']?>" data-parsley-required required>
					</label>
				</div>
			</div>
			<div class="row">
				<div class="col-tit">
					휴대폰번호
				</div><div class="col-cont-wrap">
					<label class="col-inp-txt">
						<input type="tel" name="mbPhone" class="inp-txt" value="<?php echo $mb['mbPhone']?>" data-parsley-required data-parsley-pattern="^01[0 1 6]-?\d{3,4}-?\d{4}$" required>
					</label>
				</div>
			</div>
		</section>
		<div class="row row-group">
			<label class="col-inp-btn">
				<input type="submit" class="btn-row" value="수정완료">
			</label>
		</div>
	</form>
</div>