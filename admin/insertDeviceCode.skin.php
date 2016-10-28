<div class="wrap">
	<form action="insertDeviceCodeAction.php" method="post">		
		기기Key<input type="text" name="dvKey"/>	
		<br/><br/>
		<!--요금제 
		<select name="spPlan">
			<? foreach ($plan as $key => $row) :?>
			<option value=<? echo $key ?>><? echo $row ?></option>
			<? endforeach ?>
		</select>
		<br/>
		-->
		<fieldset class="inp-group">
			통신사 <br/>
			<label class="inp-chk">
				<input type="radio" name="cdCarrier" value="sk"/>
				<div class="inp-chk-box"></div>
				SKT
			</label>
			<label class="inp-chk">
				<input type="radio" name="cdCarrier" value="kt"/>
				<div class="inp-chk-box"></div>
				KT
			</label>
		</fieldset>
		<br/>
		<fieldset class="inp-group">
			가입유형 <br/>
			<label class="inp-chk">
				<input type="radio" name="cdType" value="1"/>
				<div class="inp-chk-box"></div>
				신규
			</label>
			<label class="inp-chk">
				<input type="radio" name="cdType" value="6"/>
				<div class="inp-chk-box"></div>
				기기변경
			</label>
			<label class="inp-chk">
				<input type="radio" name="cdType" value="2"/>
				<div class="inp-chk-box"></div>
				번호이동
			</label>
		</fieldset>

		<Br/>
		URL <input type="text" name="cdCode" size="60">
		<br/><br/>
		<input type="submit" value="등록">
	</form>
</div>