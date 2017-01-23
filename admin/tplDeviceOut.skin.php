<div class="wrap-dense">
	<h1>티플 단말기 현황 - 출고등록</h1>

	<a href="tplDeviceIn.php" class="btn-filled-primary-dense">입고등록</a>
	<a href="tplDeviceOut.php" class="btn-filled-primary-dense">출고등록</a>
	<br/><br/>
	<div class="wrap_list_input">
		<form class="js-erpForm" action="tplDeviceOutAction.php" method="post">
			<section class="section txt-left">			
				<label class="inp-wrap">
					<i class="ico-calendar-small"></i>
					<input type="text" class="inp-txt" name="outDate" value="<?php echo $cfg['time_ymd']?>" />
					<div class="inp-label">
						출고처고일 <span class="inp-required">필수</span>
					</div>
					<span class="inp-hint">19921015식으로 입력</span>
				</label>
				<h2 class="tit-sub">출고될 일련번호</h2>		
				<div class="js-serialListWrap">
				</div>
				<Br/>
				<button type="button" class="js-SerialNumber btn-filled-sub-dense">추가</button>
			</section>

			<span><i class="ico-caution-small"></i> 등록시 오류가 나면 다른 정상적인 일련번호도 등록되지 않습니다.</span>
			<Br/>
			<input type="submit" value="출고등록" class="btn-filled-primary-dense">
		</form>
	</div>
</div>
<script id="js-serialWrapTemplate" type="text/x-template">
	<div class="js-serialWrap">
		<input type="text" class="js-SerialNumber-buttonList" name="serialNumber[]" style="height:40px;width:300px" placeholder="일련번호" value=<?php echo (isExist($_GET['serial']))? $_GET['serial']:"" ?>>		<!-- serial이 GET 형식으로 온다면 값 출력 -->
		<input type="text" class="test js-to" tabindex="-1" name="delivery[]" disabled placeholder="출고처"><span>
		<button type="button" tabindex="-1" class="btn-delete js-deleteSerialInput" style="vertical-align: middle;"><i></i></button>

	</div>
</script>