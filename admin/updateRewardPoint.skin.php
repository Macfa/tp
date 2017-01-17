 <div class="wrap">
	<h2>마진 업로드</h2>
	<form action="updateRewardPointAjax.php" method="post" enctype="multipart/form-data">
		<fieldset class="inp-group">
			통신사 <br/>
			<label class="inp-chk">
				<input type="radio" name="chk_info" value="sk"/>
				<div class="inp-chk-box"></div>
				SK
			</label>
			<label class="inp-chk">
				<input type="radio" name="chk_info" value="kt"/>
				<div class="inp-chk-box"></div>
				KT
			</label>
		</fieldset>	
		<fieldset class="inp-group">	
			기기선택<br/>
			<div class="sktDeviceWrap">
				<input type="file" name="selectfile">
				<input type="submit" value="submit">
			</div>
		</fieldset>