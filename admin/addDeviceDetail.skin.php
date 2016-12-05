<div class="wrap">
	<h1 class="center tit">기기 상세페이지 추가</h1>	
	<form method="post" action="addDeviceDetailAction.php" enctype="multipart/form-data">
		<section class="row-group">
			<div class="row">
				<div class="col-tit">
					기기
				</div><div class="col-cont-wrap">
					<label class="col-inp-txt">
						<select name="dvKey">
					<? foreach ($result as $val) : ?>				
						<option value="<?echo $val['dvKey']?>"><?echo $val['dvTit']?></option>
					<?endforeach?>
				</select>
					</label>
				</div>
			</div>
			
			<div class="row">
				<div class="col-tit multiple-line">
					상세페이지추가
				</div><div class="col-cont-wrap">
					<input type="file" multiple name="dvDetail[]">
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