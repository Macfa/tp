<div class="wrap">
	<h2>실가입 URL입력/수정 </h2>
	<form action="insertDeviceCodeAction.php" method="post">
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
		<fieldset class="inp-group">	
			기기선택<br/>
			<div class="sktDeviceWrap">
				<select name="dvKey" class="js-skKey">
					<option value="">선택</option>
					<? foreach ($sktDevice as $key => $val) : ?>				
						<option value="<?echo $key?>"><?echo $val?></option>
					<?endforeach?>
				</select>
			</div>
			<div class="ktDeviceWrap" style="display: none;">
				<select name="dvKey" class="js-ktKey">
					<option value="">선택</option>
					<? foreach ($ktDevice as $key => $val) : ?>				
						<option value="<?echo $key?>"><?echo $val?></option>
					<?endforeach?>
				</select>
			</div>
			<br/><br/>
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
<script>

	$('[name=cdCarrier]').change(function(){

		var $cdCarrier = $('[name=cdCarrier]:checked').val();				

		if($cdCarrier == 'sk'){
			$('.sktDeviceWrap').show();
			$('.ktDeviceWrap').hide();
			$('.js-ktKey').removeAttr('name');
			$('.js-skKey').attr('name','dvKey');

		}else if ($cdCarrier == 'kt'){
			$('.sktDeviceWrap').hide();
			$('.ktDeviceWrap').show();
			$('.js-skKey').removeAttr('name');
			$('.js-ktKey').attr('name','dvKey');

		}

		



		
	});	
	
</script>