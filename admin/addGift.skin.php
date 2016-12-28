<div class="wrap">
<form method="post" action="addGiftUpdate.php" enctype="multipart/form-data">
<section class="row-group">
	<div class="row">
		<div class="col-tit">
			사은품 제품명
		</div><div class="col-cont-wrap">
			<label class="col-inp-txt">
				<input type="text" name="gfTit" class="inp-txt" data-parsley-required required>
			</label>
		</div>
	</div>
	<div class="row">
		<div class="col-tit">
			서브카피
		</div><div class="col-cont-wrap">
			<label class="col-inp-txt">
				<input type="text" name="gfSubtit" class="inp-txt">
			</label>
		</div>
	</div>
	<div class="row">
		<div class="col-tit">
			포인트 (포인트몰사용시)
		</div><div class="col-cont-wrap">
			<label class="col-inp-txt">
				<input type="number" name="gfPoint" class="inp-txt" data-parsley-required required>
			</label>
		</div>
	</div>
	<div class="row">
		<div class="col-tit multiple-line">
			썸네일
		</div><div class="col-cont-wrap">
			<input type="file" multiple name="gfThumb">			
		</div>
	</div>
	<div class="row">
		<div class="col-tit multiple-line">
			상세설명
		</div><div class="col-cont-wrap">
			<input type="file" multiple name="gfCont[]">
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