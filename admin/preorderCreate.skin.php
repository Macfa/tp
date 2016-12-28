<div class="wrap">
	<h1>사전예약 생성 페이지</h1>
	<form action="preorderCreateAction.php" method="post">		
		기기이름 <input type="text" name="poDeviceName" size="30">
		<br/><br/>
		랜딩페이지주소 <input type="text" name="poLandingPage" size="60">
		<br/><br/>
		신청페이지주소 <input type="text" name="poApplyPage" size="60">
		<br/><br/>
		<fieldset class="inp-group">
			디스플레이 <br/>
			<label class="inp-chk">
				<input type="radio" name="poDisplay" value="1"/>
				<div class="inp-chk-box"></div>
				보임
			</label>
			<label class="inp-chk">
				<input type="radio" name="poDisplay" value="0"/>
				<div class="inp-chk-box"></div>
				안보임
			</label>
		</fieldset>
		
		<input type="submit" value="등록">
	</form>
</div>