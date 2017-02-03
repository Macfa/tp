<div class="wrap">
	<h2>실가입 URL입력/수정 </h2>
	<form action="insertDeviceCodeAction.php" method="post">
		<fieldset class="inp-group">
			채널 <br/>
			<?php foreach($arrChannel as $row) :?>
			<label class="inp-chk">
				<input type="radio" name="chKey" value="<?php echo $row['chKey']?>"/>
				<div class="inp-chk-box"></div>
				<?php echo $row['chName'] .'('. strtoupper($row['chCarrier']) .')'; ?>
			</label>
			<?php endforeach?>
		</fieldset>	
		<fieldset class="inp-group">	
			기기선택<br/>
			<div class="sktDeviceWrap">
				<select name="dvKey">
					<option value="">선택</option>
					<? foreach ($device as $key => $row) : ?>				
						<option value="<?echo $key?>"><?php echo $row['model']?> (<?php echo $row['id']?>)</option>
					<? endforeach?>
				</select>
			</div>
		</fieldset>
		<fieldset class="inp-group">
			모드 (요금제별) 
			<label class="inp-chk">
				<input type="radio" name="dvCate" value="phone"/>
				<div class="inp-chk-box"></div>
				PHONE
			</label>
			<label class="inp-chk">
				<input type="radio" name="dvCate" value="pocketfi"/>
				<div class="inp-chk-box"></div>
				pocketfi
			</label>
			<label class="inp-chk">
				<input type="radio" name="dvCate" value="watch"/>
				<div class="inp-chk-box"></div>
				watch
			</label>
			<label class="inp-chk">
				<input type="radio" name="dvCate" value="kids"/>
				<div class="inp-chk-box"></div>
				kids
			</label>
		<Br/><Br/>
		</fieldset>
		<Br/>
		신규 URL <input type="text" name="cdCode_01" size="60"><br/>
		번호이동 URL <input type="text" name="cdCode_02" size="60"><br/>
		기기변경 URL <input type="text" name="cdCode_06" size="60">
		<br/><br/>
	
		<input type="submit" value="등록">
	</form>
</div>