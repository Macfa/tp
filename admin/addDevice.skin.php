<div class="wrap">
<form method="post" action="addDeviceUpdate.php">
<section class="row-group">
	<div class="row">
		<div class="col-tit">
			기기식별자 (개발자에게문의)
		</div><div class="col-cont-wrap">
			<label class="col-inp-txt" id="asd">
				<input type="text" name="gfTit" class="inp-txt" data-parsley-required data-parsley-type="email" required>
			</label>
		</div>
	</div>
	<div class="row">
		<div class="col-tit">
			기기명
		</div><div class="col-cont-wrap">
			<label class="col-inp-txt">
				<input type="password" name="gfSubtit" class="inp-txt" data-parsley-required required>
			</label>
		</div>
	</div>
	<div class="row">
		<div class="col-tit">
			제조사
		</div><div class="col-cont-wrap">
			<div class="col-inp-4 radio">
				<label class="inp-radio">
					<input type="radio" name="dvManuf" value="ss"/>
					<div class="inp-radio-btn"></div>
					<span class="inp-radio-label">삼성</span>
					<div class="inp-radio-chk"></div>
				</label>
			</div><div class="col-inp-4 radio">
				<label class="inp-radio">
					<input type="radio" name="dvManuf" value="ap"/>
					<div class="inp-radio-btn"></div>
					<span class="inp-radio-label">애플</span>
					<div class="inp-radio-chk"></div>
				</label>
			</div><div class="col-inp-4 radio">
				<label class="inp-radio">
					<input type="radio" name="dvManuf" value="lg"/>
					<div class="inp-radio-btn"></div>
					<span class="inp-radio-label">LG</span>
					<div class="inp-radio-chk"></div>
				</label>
			</div><div class="col-inp-4 radio">
				<label class="inp-radio">
					<input type="radio" name="dvManuf" value="etc"/>
					<div class="inp-radio-btn"></div>
					<span class="inp-radio-label">기타 제조사</span>
					<div class="inp-radio-chk"></div>
				</label>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-tit multiple-line">
			썸네일
		</div><div class="col-cont-wrap">
			<input type="file" name="dvThumb">
		</div>
	</div>
	<div class="row">
		<div class="col-tit">
			출고가
		</div><div class="col-cont-wrap">
			<label class="col-inp-txt">
				<input type="int" name="dvRetailPrice" class="inp-txt"  data-parsley-required required>
			</label>
		</div>
	</div>
</section>
<div class="row row-group">
	<label class="col-inp-btn">
		<input type="submit" class="btn-row" value="등록하기">
	</label>
</div>
</form>
</div>