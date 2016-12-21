<div class="wrap">
	<h1 class="center">정보글 업로드</h1>
	<form method="post" action="addNewsAction.php" enctype="multipart/form-data">
		<section class="row-group">
			<div class="row">
				<div class="col-tit">
					타이틀제목
				</div><div class="col-cont-wrap">
					<label class="col-inp-txt">
						<input type="text" name="neTit" class="inp-txt" required>
					</label>
				</div>
			</div>
			<div class="row">
				<div class="col-tit">
					서브카피
				</div><div class="col-cont-wrap">
					<label class="col-inp-txt">
						<input type="text" name="neSubTit" class="inp-txt">
					</label>
				</div>
			</div>
			<div class="row">
				<div class="col-tit">
					연결URL
				</div><div class="col-cont-wrap">
					<label class="col-inp-txt">
						<input type="text" name="neUrl" class="inp-txt" required>
					</label>
				</div>
			</div>
			<div class="row">
				<div class="col-tit multiple-line">
					썸네일
				</div><div class="col-cont-wrap">
					<input type="file" multiple name="neThumb">			
				</div>
			</div>
			<div class="row">
				<div class="col-tit multiple-line">
					카테고리 기기
				</div><div class="col-cont-wrap">	
				<select name="ncDevice" class="js-device">
					<option value="">기기선택</option>
					<? foreach ($deviceDisplay as $val) : ?>	
						<option value="<?echo $val['dvId']?>"><?echo $val['dvTit']?></option>
					<?endforeach?>
				</select>
				</div>				
			</div>
			<div class="row js-devicewrap" style="display : none; height:auto;">
				<div class="col-tit multiple-line" style="height:auto;">					
				선택기기
				</div><div class="col-cont-wrap js-deviceList" style="height:auto;">
				</div>
			</div>			
			<div class="row">
				<div class="col-tit multiple-line">
					카테고리
				</div><div class="col-cont-wrap">				
					<label class="inp-chk">
						<input type="checkbox" name="ncCategory[]" value="sk" class="js-carrier">
						<div class="inp-chk-box"></div>
						SK
					</label>
					<label class="inp-chk">
						<input type="checkbox" name="ncCategory[]" value="kt" class="js-carrier">
						<div class="inp-chk-box"></div>
						KT
					</label>
					<label class="inp-chk">
						<input type="checkbox" name="ncCategory[]" value="lguplus" class="js-carrier">
						<div class="inp-chk-box"></div>
						LG
					</label>
					<label class="inp-chk">
						<input type="checkbox" class="js-all">
						<div class="inp-chk-box"></div>
						모든통신사
					</label>			
				</div>
			</div>
			<div class="row">
				<div class="col-tit multiple-line">
					<input type="reset" value="다시선택" class="js-reset">
				</div><div class="col-cont-wrap">				
					<label class="inp-chk">
						<input type="checkbox" name="ncCategory[]" value="pocketfi">
						<div class="inp-chk-box"></div>
						휴대용와이파이
					</label>
					<label class="inp-chk">
						<input type="checkbox" name="ncCategory[]" value="watch">
						<div class="inp-chk-box"></div>
						스마트워치
					</label>
					<label class="inp-chk">
						<input type="checkbox" name="ncCategory[]" value="kids">
						<div class="inp-chk-box"></div>
						키즈폰
					</label>			
				</div>
			</div>
			<div class="row">
				<div class="col-tit multiple-line">					
				</div><div class="col-cont-wrap">				
					<label class="inp-chk">
						<input type="checkbox" name="ncCategory[]" value="samsung">
						<div class="inp-chk-box"></div>
						samsung
					</label>
					<label class="inp-chk">
						<input type="checkbox" name="ncCategory[]" value="apple">
						<div class="inp-chk-box"></div>
						apple
					</label>
					<label class="inp-chk">
						<input type="checkbox" name="ncCategory[]" value="lg">
						<div class="inp-chk-box"></div>
						lg
					</label>
					<label class="inp-chk">
						<input type="checkbox" name="ncCategory[]" value="etc">
						<div class="inp-chk-box"></div>
						기타
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

<script>

$('.js-all').change(function(){
	$('.js-carrier').prop("checked", this.checked);
	$('.js-carrier').trigger('change');

});

$('.js-device').change(function(){

	$('.js-devicewrap').show();

	var $dvId = $(this).val();
	var $dvTit = $(this).children("option:selected").text();

	if($('input[value='+$dvId+']').size() == 0){
		
		$('.js-deviceList').append('<label class="inp-chk"><input type="checkbox" name="ncDeviceList[]" value='+$dvId+' class="js-deviceInput"><div class="inp-chk-box"></div>'+$dvTit+'</label>');	
		$('.js-deviceInput').prop('checked',true);
	}

	$('.js-reset').click(function(){
		$('.js-deviceInput').prop('checked',false);
		$('.js-deviceList').children('label').remove();
		$('.js-devicewrap').hide();			
	});


});
	
	
</script>